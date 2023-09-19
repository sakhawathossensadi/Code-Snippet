<?php
// dokan-pro/modules/paypal-marketplace/includes/Order/OrderManager.php -> line 70
// after $total_discount = $order->get_total_discount() + static::get_lot_discount( $order ) + static::get_minimum_order_discount( $order ); -> line

$calculated_total = wc_format_decimal($subtotal, 2)
			+ wc_format_decimal($tax_total, 2)
			+ wc_format_decimal($shipping_total, 2)
			- wc_format_decimal($total_discount, 2);
		
$order_total = wc_format_decimal($order->get_total(), 2);
$precision = $calculated_total - $order_total;

if (wc_format_decimal($precision, 2) !== '0.00' ) {
    if($precision < 0) {
        $subtotal = $subtotal - (wc_format_decimal($precision, 2));
        
        for($i = 0; $i < count($product_items) ; $i++){
            $product_item = $product_items[$i];
            $value = $product_item['unit_amount']['value'];

            if($value > wc_format_decimal($precision, 2)){
                $value = $value - (wc_format_decimal($precision, 2));
                $value = "{$value}";
                $product_items[$i]['unit_amount']['value'] = $value;
                break;
            }
        }
    } 
    if($precision > 0) {
        $subtotal = $subtotal - $precision;

        for($i = 0; $i < count($product_items) ; $i++){
            $product_item = $product_items[$i];
            $value = $product_item['unit_amount']['value'];

            if($value > wc_format_decimal($precision, 2)){
                $value = $value - $precision;
                $value = "{$value}";
                $product_items[$i]['unit_amount']['value'] = $value;
                break;
            }
        }
    }
}
