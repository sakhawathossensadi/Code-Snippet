<?php
 // https://developer.wordpress.org/reference/classes/wp_query/ 

add_action(	'pre_get_posts', [$this,'shop_order_column_meta_field_sortable_orderby'] );

public function shop_order_column_meta_field_sortable_orderby($query){
		global $pagenow;

		if ( 'edit.php' === $pagenow && isset($_GET['post_type']) && 'shop_order' === $_GET['post_type'] ){
			if(isset($_GET['orderby']) && $_GET['orderby'] === '_chamak_credit_amount'){
				$query->set('meta_key', '_chamak_credit_amount');
				$query->set('orderby', 'meta_value_num');
				$query->set('type ', 'UNSIGNED');
				$query->set('order', $_GET['order']);
			}
		}
	}