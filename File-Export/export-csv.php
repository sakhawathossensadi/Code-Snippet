<?php

class ExportAdminOrder
{
    public function __construct()
    {
        add_action( 'manage_posts_extra_tablenav', [$this, 'order_export_button_on_admin_order_list_top_bar'], 20, 1 );
        add_action('wp_ajax_export_order_from_admin', [$this, 'export_order_from_admin']);
    }

    public function export_order_from_admin() {
        $query_args = [
            'limit'     => 10000000,
            'return'    => 'ids',
        ];

        $filterData = $_POST;
        $filter = '';
        $leap_year = 'no';
        $year = '';
        $start = '';
        $end = '';

        if(array_key_exists('filter', $filterData)) {
            $filter = $filterData['filter'];
            $user_id = $filterData['customerId'];
            $m = $filterData['m'];
        }
        if(!empty($user_id)){
            $query_args['customer_id'] = $user_id;
        }

        if($m != '0') {
            $year = substr($m, 0, 4);
            $month = substr($m, -2);

            if($month == '01' || $month == '03' || $month == '05' || $month == '07' || $month == '08' || $month == '10' || $month == '12'){
                $start = '01';
                $end = '31';
            } elseif($month == '04' || $month == '06' || $month == '09' || $month == '11') {
                $start = '01';
                $end = '30';
            } else {
                $start = '01';
                $end = '28';
                $year = intval($year);
    
                if(($year%400 == 0) || ($year%4 == 0 && $year%100 != 0)) {
                    $leap_year = 'yes';
                }
    
                if($leap_year == 'yes'){
                    $end = "29";
                }
            }

            $from = $year."-".$month."-".$start;
            $to = $year."-".$month."-".$end;

            $date = [
                'from' => $from,
                'to' => $to,
            ];

            $status = 'all';

            $query_args['status'] = $status;
            $query_args['date'] = $date;
        }
        
        $orders = dokan()->order->all($query_args);

        $filename = 'Orders-' . time();
        header( 'Content-Type: application/csv; charset=' . get_option( 'blog_charset' ) );
        header( "Content-Disposition: attachment; filename=$filename.csv" );

        $this->admin_order_csv_export($orders);

        exit();
    }

    private function admin_order_csv_export( $orders, $file = null) {
        // $exportOrder = new ExportOrder();
        $headers  = $this->dokan_order_csv_headers();
        $statuses = wc_get_order_statuses();
        $data = [];

        $resource = ( $file === null ) ? 'php://output' : $file;
        $output   = fopen( $resource, 'w' ); // phpcs:ignore
    
        fputcsv( $output, $headers );

        foreach ( $orders as $the_order ) {
            $line      = [];
            $the_order = wc_get_order( $the_order );
            if ( ! $the_order ) {
                continue;
            }
    
            foreach ( $headers as $row_key => $label ) {
                switch ( $row_key ) {
                    case 'order_id':
                        $line[ $row_key ] = $the_order->get_id();
                        break;
                    case 'order_items':
                        $line[ $row_key ] = dokan_get_product_list_by_order( $the_order, '; ' );
                        break;
                    case 'order_shipping':
                        $line[ $row_key ] = $the_order->get_shipping_method();
                        break;
                    case 'order_shipping_cost':
                        $line[ $row_key ] = $the_order->get_total_shipping();
                        break;
                    case 'order_payment_method':
                        $line[ $row_key ] = $the_order->get_payment_method_title();
                        break;
                    case 'order_total':
                        $line[ $row_key ] = $the_order->get_total();
                        break;
                    case 'earnings':
                        $line[ $row_key ] = dokan()->commission->get_earning_by_order( $the_order );
                        break;
                    case 'order_status':
                        $line[ $row_key ] = $statuses[ 'wc-' . dokan_get_prop( $the_order, 'status' ) ];
                        break;
                    case 'order_date':
                        $line[ $row_key ] = dokan_get_date_created( $the_order );
                        break;
    
                    // billing details
                    case 'billing_company':
                        $line[ $row_key ] = $the_order->get_billing_company();
                        break;
                    case 'billing_first_name':
                        $line[ $row_key ] = $the_order->get_billing_first_name();
                        break;
                    case 'billing_last_name':
                        $line[ $row_key ] = $the_order->get_billing_last_name();
                        break;
                    case 'billing_full_name':
                        $line[ $row_key ] = $the_order->get_formatted_billing_full_name();
                        break;
                    case 'billing_email':
                        $line[ $row_key ] = $the_order->get_billing_email();
                        break;
                    case 'billing_phone':
                        $line[ $row_key ] = $the_order->get_billing_phone();
                        break;
                    case 'billing_address_1':
                        $line[ $row_key ] = $the_order->get_billing_address_1();
                        break;
                    case 'billing_address_2':
                        $line[ $row_key ] = $the_order->get_billing_address_2();
                        break;
                    case 'billing_city':
                        $line[ $row_key ] = $the_order->get_billing_city();
                        break;
                    case 'billing_state':
                        $line[ $row_key ] = $the_order->get_billing_state();
                        break;
                    case 'billing_postcode':
                        $line[ $row_key ] = $the_order->get_billing_postcode();
                        break;
                    case 'billing_country':
                        $line[ $row_key ] = $the_order->get_billing_country();
                        break;
    
                    // shipping details
                    case 'shipping_company':
                        $line[ $row_key ] = $the_order->get_shipping_company();
                        break;
                    case 'shipping_first_name':
                        $line[ $row_key ] = $the_order->get_shipping_first_name();
                        break;
                    case 'shipping_last_name':
                        $line[ $row_key ] = $the_order->get_shipping_last_name();
                        break;
                    case 'shipping_full_name':
                        $line[ $row_key ] = $the_order->get_formatted_shipping_full_name();
                        break;
                    case 'shipping_address_1':
                        $line[ $row_key ] = $the_order->get_shipping_address_1();
                        break;
                    case 'shipping_address_2':
                        $line[ $row_key ] = $the_order->get_shipping_address_2();
                        break;
                    case 'shipping_city':
                        $line[ $row_key ] = $the_order->get_shipping_city();
                        break;
                    case 'shipping_state':
                        $line[ $row_key ] = $the_order->get_shipping_state();
                        break;
                    case 'shipping_postcode':
                        $line[ $row_key ] = $the_order->get_shipping_postcode();
                        break;
                    case 'shipping_country':
                        $line[ $row_key ] = $the_order->get_shipping_country();
                        break;
    
                    // custom details
                    case 'customer_ip':
                        $line[ $row_key ] = $the_order->get_customer_ip_address();
                        break;
                    case 'customer_note':
                        $line[ $row_key ] = $the_order->get_customer_note();
                        break;
    
                    default:
                        $line[ $row_key ] = '';
                        break;
                }
            }

            fputcsv( $output, $line );
    
            $line_item_headers = $this->dokan_order_csv_headers_for_product_info();

            fputcsv( $output, $line_item_headers );
            
            $order_items = $the_order->get_items();

            foreach($order_items as $item_id => $order_item){
                $item_data = $order_item->get_data();
                $product_id = $item_data['product_id'];
                $product_quantity = $item_data['quantity'];
                $product_name = $item_data['name'];
                $product_sku = get_post_meta($product_id, '_sku', true);
    
                $product_data = [];
    
                foreach ( $line_item_headers as $row_key => $label ) {
                    switch ( $row_key ) {
                        case 'sku':
                            $product_data[ $row_key ] = $product_sku;
                            break;
                        case 'item_name':
                            $product_data[ $row_key ] = $product_name;
                            break;
                        case 'quantity':
                            $product_data[ $row_key ] = $product_quantity;
                            break;
                        default:
                        $product_data[ $row_key ] = '';
                            break;
                    }
                }
    
                fputcsv( $output, $product_data );
            }
        }

        fclose( $output ); // phpcs:ignore
    }

    public function order_export_button_on_admin_order_list_top_bar( $which ) {
        global $pagenow, $typenow;

        include_once SHIPMYPLANTS_TEMPLATES_DIR .'/admin/order_export.php';
    }

    public function dokan_order_csv_headers_for_product_info(){
        return [
            'sku'                  => __('SKU', 'shipmyplants'),
            'item_name'            => __('Item Name', 'shipmyplants'),
            'quantity'             => __('Quantity', 'shipmyplants'),
        ];
    }

    public function dokan_order_csv_headers() {
        return apply_filters(
            'dokan_csv_export_headers', [
                'order_id'             => __( 'Order No', 'shipmyplants' ),
                'order_items'          => __( 'Order Items', 'shipmyplants' ),
                'order_shipping'       => __( 'Shipping method', 'shipmyplants' ),
                'order_shipping_cost'  => __( 'Shipping Cost', 'shipmyplants' ),
                'order_payment_method' => __( 'Payment method', 'shipmyplants' ),
                'order_total'          => __( 'Order Total', 'shipmyplants' ),
                'earnings'             => __( 'Earnings', 'shipmyplants' ),
                'order_status'         => __( 'Order Status', 'shipmyplants' ),
                'order_date'           => __( 'Order Date', 'shipmyplants' ),
                'billing_company'      => __( 'Billing Company', 'shipmyplants' ),
                'billing_first_name'   => __( 'Billing First Name', 'shipmyplants' ),
                'billing_last_name'    => __( 'Billing Last Name', 'shipmyplants' ),
                'billing_full_name'    => __( 'Billing Full Name', 'shipmyplants' ),
                'billing_email'        => __( 'Billing Email', 'shipmyplants' ),
                'billing_phone'        => __( 'Billing Phone', 'shipmyplants' ),
                'billing_address_1'    => __( 'Billing Address 1', 'shipmyplants' ),
                'billing_address_2'    => __( 'Billing Address 2', 'shipmyplants' ),
                'billing_city'         => __( 'Billing City', 'shipmyplants' ),
                'billing_state'        => __( 'Billing State', 'shipmyplants' ),
                'billing_postcode'     => __( 'Billing Postcode', 'shipmyplants' ),
                'billing_country'      => __( 'Billing Country', 'shipmyplants' ),
                'shipping_company'     => __( 'Shipping Company', 'shipmyplants' ),
                'shipping_first_name'  => __( 'Shipping First Name', 'shipmyplants' ),
                'shipping_last_name'   => __( 'Shipping Last Name', 'shipmyplants' ),
                'shipping_full_name'   => __( 'Shipping Full Name', 'shipmyplants' ),
                'shipping_address_1'   => __( 'Shipping Address 1', 'shipmyplants' ),
                'shipping_address_2'   => __( 'Shipping Address 2', 'shipmyplants' ),
                'shipping_city'        => __( 'Shipping City', 'shipmyplants' ),
                'shipping_state'       => __( 'Shipping State', 'shipmyplants' ),
                'shipping_postcode'    => __( 'Shipping Postcode', 'shipmyplants' ),
                'shipping_country'     => __( 'Shipping Country', 'shipmyplants' ),
                'customer_ip'          => __( 'Customer IP', 'shipmyplants' ),
                'customer_note'        => __( 'Customer Note', 'shipmyplants' ),
            ]
        );
    }
}