<?php
if( !defined( 'ABSPATH' ) ) exit;

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}
$option_name = 'jtpp_share_buttons';
delete_option( $option_name );
delete_site_option( $option_name );
