<?php


class TemplateOverwrite {
	public function __construct() {
		add_filter( 'dokan_locate_template', array( $this, 'get_template' ), 99, 3 );
	}

	public function get_template( $template, $template_name, $template_path ) {
		if ( strpos( $template, 'follow-store/views/vendor-dashboard.php' ) ) {
			return ATRAXA_TEMPLATE_DIR . '/vendor-dashboard.php';
		}

		return $template;
	}
}