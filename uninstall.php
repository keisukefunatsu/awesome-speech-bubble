<?php



/**
 * Delete options when uninstalled.
 */

if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();

$awesome_speech_bubble_options = array(
  'awesome_speech_bubble_data'
);

foreach ( $awesome_speech_bubble_options as $option_name ) {
  delete_option( $option_name );
}
