<?php
$vendor_id = get_current_user_id();

if ( isset( $_POST['submit_api_settings'] ) ) {
    $amazon_vendor_id   = sanitize_text_field( isset( $_POST['amazon_vendor_id'] ) ? wp_unslash( $_POST['amazon_vendor_id'] ) : '' );
    $amazon_api_key     = sanitize_text_field( isset( $_POST['amazon_api_key'] ) ? wp_unslash( $_POST['amazon_api_key'] ) : '' );
    $amazon_secret_key  = sanitize_text_field( isset( $_POST['amazon_secret_key'] ) ? wp_unslash( $_POST['amazon_secret_key'] ) : '' );

    $ebay_vendor_id     = sanitize_text_field( isset( $_POST['ebay_vendor_id'] ) ? wp_unslash( $_POST['ebay_vendor_id'] ) : '' );
    $ebay_api_key       = sanitize_text_field( isset( $_POST['ebay_api_key'] ) ? wp_unslash( $_POST['ebay_api_key'] ) : '' );
    $ebay_secret_key    = sanitize_text_field( isset( $_POST['ebay_secret_key'] ) ? wp_unslash( $_POST['ebay_secret_key'] ) : '' );

    $etsy_vendor_id     = sanitize_text_field( isset( $_POST['etsy_vendor_id'] ) ? wp_unslash( $_POST['etsy_vendor_id'] ) : '' );
    $etsy_api_key       = sanitize_text_field( isset( $_POST['etsy_api_key'] ) ? wp_unslash( $_POST['etsy_api_key'] ) : '' );
    $etsy_secret_key    = sanitize_text_field( isset( $_POST['etsy_secret_key'] ) ? wp_unslash( $_POST['etsy_secret_key'] ) : '' );

    update_user_meta( $vendor_id, 'amazon_vendor_id', $amazon_vendor_id );
    update_user_meta( $vendor_id, 'amazon_api_key', $amazon_api_key );
    update_user_meta( $vendor_id, 'amazon_secret_key', $amazon_secret_key );

    update_user_meta( $vendor_id, 'ebay_vendor_id', $ebay_vendor_id );
    update_user_meta( $vendor_id, 'ebay_api_key', $ebay_api_key );
    update_user_meta( $vendor_id, 'ebay_secret_key', $ebay_secret_key );

    update_user_meta( $vendor_id, 'etsy_vendor_id', $etsy_vendor_id );
    update_user_meta( $vendor_id, 'etsy_api_key', $etsy_api_key );
    update_user_meta( $vendor_id, 'etsy_secret_key', $etsy_secret_key );
}

$vendor_amazon_id          = get_user_meta( $vendor_id, 'amazon_vendor_id', true );
$vendor_amazon_api_key     = get_user_meta( $vendor_id, 'amazon_api_key', true );
$vendor_amazon_secret_key  = get_user_meta( $vendor_id, 'amazon_secret_key', true );

$vendor_ebay_id            = get_user_meta( $vendor_id, 'ebay_vendor_id', true );
$vendor_ebay_api_key       = get_user_meta( $vendor_id, 'ebay_api_key', true );
$vendor_ebay_secret_key    = get_user_meta( $vendor_id, 'ebay_secret_key', true );

$vendor_etsy_id            = get_user_meta( $vendor_id, 'etsy_vendor_id', true );
$vendor_etsy_api_key       = get_user_meta( $vendor_id, 'etsy_api_key', true );
$vendor_etsy_secret_key    = get_user_meta( $vendor_id, 'etsy_secret_key', true );

?>

<div>
    <form action="" method="POST" class="dokan-form-horizontal">
        <div>
            <div class="api-settings">
                <div class="api-settings-header dokan-form-group" style="">
                    <label class="dokan-w3 dokan-control-label" for="amazon_api_settings" style="text-align: left; padding-left: 10px;"><?php esc_html_e( 'Amazon', 'covetable' ); ?></label>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="amazon_vendor_id"><?php esc_html_e( 'Vendor ID', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="amazon_vendor_id"  value="<?php echo esc_attr( $vendor_amazon_id ); ?>" name="amazon_vendor_id" placeholder="Enter Vendor ID" class="dokan-form-control" type="text">
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="amazon_api_key"><?php esc_html_e( 'API Access Key', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="amazon_api_key"  value="<?php echo esc_attr( $vendor_amazon_api_key ); ?>" name="amazon_api_key" placeholder="Enter API Access" class="dokan-form-control" type="text">
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="amazon_secret_key"><?php esc_html_e( 'API Secret Key', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="amazon_secret_key"  value="<?php echo esc_attr( $vendor_amazon_secret_key ); ?>" name="amazon_secret_key" placeholder="Enter Secret Key" class="dokan-form-control" type="text">
                    </div>
                </div>
            </div>

            <div class="api-settings">
                <div class="api-settings-header dokan-form-group" style="">
                    <label class="dokan-w3 dokan-control-label" for="ebay_api_settings" style="text-align: left; padding-left: 10px;"><?php esc_html_e( 'eBay', 'covetable' ); ?></label>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ebay_vendor_id"><?php esc_html_e( 'Vendor ID', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="ebay_vendor_id"  value="<?php echo esc_attr( $vendor_ebay_id ); ?>" name="ebay_vendor_id" placeholder="Enter Vendor ID" class="dokan-form-control" type="text">
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ebay_api_key"><?php esc_html_e( 'API Access Key', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="ebay_api_key"  value="<?php echo esc_attr( $vendor_ebay_api_key ); ?>" name="ebay_api_key" placeholder="Enter API Access" class="dokan-form-control" type="text">
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ebay_secret_key"><?php esc_html_e( 'API Secret Key', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="ebay_secret_key"  value="<?php echo esc_attr( $vendor_ebay_secret_key ); ?>" name="ebay_secret_key" placeholder="Enter Secret Key" class="dokan-form-control" type="text">
                    </div>
                </div>
            </div>

            <div class="api-settings">
                <div class="api-settings-header dokan-form-group" style="">
                    <label class="dokan-w3 dokan-control-label" for="etst_api_settings" style="text-align: left; padding-left: 10px;"><?php esc_html_e( 'Etsy', 'covetable' ); ?></label>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="etsy_vendor_id"><?php esc_html_e( 'Vendor ID', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="etsy_vendor_id"  value="<?php echo esc_attr( $vendor_etsy_id ); ?>" name="etsy_vendor_id" placeholder="Enter Vendor ID" class="dokan-form-control" type="text">
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="etsy_api_key"><?php esc_html_e( 'API Access Key', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="etsy_api_key"  value="<?php echo esc_attr( $vendor_etsy_api_key ); ?>" name="etsy_api_key" placeholder="Enter API Access" class="dokan-form-control" type="text">
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="etsy_secret_key"><?php esc_html_e( 'API Secret Key', 'covetable' ); ?></label>

                    <div class="dokan-w4 dokan-text-left">
                        <input id="etsy_secret_key"  value="<?php echo esc_attr( $vendor_etsy_secret_key ); ?>" name="etsy_secret_key" placeholder="Enter Secret Key" class="dokan-form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="dokan-form-group">
			<div class="dokan-w6 dokan-text-left" style="margin-left:55%;">
				<input type="submit" name="submit_api_settings" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Update Settings', 'covetable' ); ?>">
			</div>
		</div>
        </div>
    </form>
</div>

<style>
    .api-settings{
        max-height: 400px;
        max-width: 750px;
        border: 1px solid #EDEDED;
        margin-bottom: 20px;
    }
    .api-settings-header{
        background-color: #EDEDED;
        text-align: left;
    }
</style>
