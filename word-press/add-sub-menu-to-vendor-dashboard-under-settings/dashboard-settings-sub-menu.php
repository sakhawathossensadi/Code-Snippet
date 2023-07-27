<?php

class Menu {
    public function __construct() {
        add_filter( 'dokan_get_dashboard_settings_nav', [ $this, 'add_api_settings_tab' ] );
        add_filter( 'dokan_dashboard_settings_heading_title', [ $this, 'set_api_settings_tab_title' ], 10, 2 );
        add_filter( 'dokan_dashboard_settings_helper_text', [ $this, 'set_api_settings_tab_help_text' ], 10, 2 );
        add_action( 'dokan_render_settings_content', [ $this, 'show_api_settings_tab_content' ] );
    }

    public function show_api_settings_tab_content( $query_vars ) {
        if ( empty( $query_vars ) || ! ( 'api-settings' === $query_vars['settings'] ) ) {
            return;
	    }

        require_once COVETABLE_TEMPLATE_DIR . '/api-settings.php';
    }

    public function set_api_settings_tab_help_text( $help_text, $tab ) {
        if ( $tab === 'api-settings' ) {
            $help_text = __( 'Vendor API settings', 'covetable' );
	    }

        return $help_text;
    }

    public function set_api_settings_tab_title( $title, $tab ) {
        if ( $tab === 'api-settings' ) {
            $title = 'API Settings';
	    }

        return $title;
    }

    public function add_api_settings_tab( $menu_items ) {
        $menu_items['api-settings'] = [
            'title'      => __( 'API Settings', 'covetable' ),
            'icon'       => '<i class="fas fa-cog"></i>',
            'url'        => dokan_get_navigation_url( 'settings/api-settings' ),
            'pos'        => 90,
            'permission' => 'dokan_view_store_settings_menu',
        ];

        return $menu_items;
    }
}