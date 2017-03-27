<?php
/**
 * Plugin Name:     Awesome Speech Bubble
 * Plugin URI:      https://awe-some.net
 * Description:     This enable you to use speech bubble easily.
 * Author:          keisuke funatsu
 * Author URI:      https://awe-some.net
 * Text Domain:     awesome-speech-bubble
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Awesome_Speech_Bubble
 */


/**
 * Make short code to use speech bubble easily.
 */

$awesome_speech_bubble = new AwesomeSpeechBubble();
$awesome_speech_bubble->register();

class AwesomeSpeechBubble
{
	/**
	* Register function
	*
	* @param  none
	* @return none
	*/
	public function register(){
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_shortcode('awesome-speech-bubble', array( $this, 'handle_shortcode' ) );
	}

	/**
 	* Fires on plugins_loaded hook.
 	*
 	* @param  none
 	* @return none
 	*/
	public function plugins_loaded() {
		add_action( 'wp_enqueue_scripts', array( $this, 'asb_wp_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'asb_admin_enqueue_scripts' ) );
	}

	public function asb_wp_enqueue_scripts() {
		if ( is_singular() ) {
			wp_enqueue_script(
				'awesome-speech-bubble-script',
				plugins_url( 'js/awesome-speech-bubble.js', __FILE__ ),
				array( 'jquery' ),
				filemtime(dirname(__FILE__) . '/js/awesome-speech-bubble.js')
			);
		}
	}
	public function asb_admin_enqueue_scripts() {
		if ( is_singular() ) {
			wp_enqueue_script(
				'admin-awesome-speech-bubble-script',
				plugins_url( 'js/admin-awesome-speech-bubble.js', __FILE__ ),
				array( 'jquery' ),
				filemtime(dirname(__FILE__) . '/js/admin-awesome-speech-bubble.js')
			);
		}
	}
	public function handle_shortcode(){

	}
}
