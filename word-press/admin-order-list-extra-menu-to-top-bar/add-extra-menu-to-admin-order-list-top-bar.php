<?php

class ExportAdminOrder
{
	public function __construct()
    {
        add_action( 'manage_posts_extra_tablenav', [$this, 'order_export_button_on_admin_order_list_top_bar'], 20, 1 );
    }

    public function order_export_button_on_admin_order_list_top_bar( $which ) {
        global $pagenow, $typenow;

        include_once TEMPLATES_DIR .'/extra-menu.php';
    }
}