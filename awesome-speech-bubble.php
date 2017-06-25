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
 * Prepare option when plugin activated
 */

register_activation_hook( __FILE__, array( 'AwesomeSpeechBubble', 'install' ) );

$awesome_speech_bubble = new AwesomeSpeechBubble();
$awesome_speech_bubble->register();

class AwesomeSpeechBubble
{

	static function install() {
		// add_option( 'awesome_speech_bubble_data', '' );
	}

	public function register(){
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		// add_shortcode('awesome_speech_bubble', array( $this, 'handle_shortcode' ) );
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
		add_action( 'edit_form_after_title', array( $this, 'display_app' ));
		add_action( 'wp_ajax_awesome_speech_bubble', array( $this, 'wp_ajax_awesome_speech_bubble' ));
		add_action( 'wp_ajax_nopriv_awesome_speech_bubble', array( $this, 'wp_ajax_awesome_speech_bubble' ));
	}

	/**
	* Enqueue user script for post page
	*
	* @param  none
	* @return none
	*/
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

	/**
	* Enqueue admin script for edit page
	*
	* @param  none
	* @return none
	*/
	public function display_app() {
		echo '<div id="app"></div>';
	}
	public function asb_admin_enqueue_scripts() {
			wp_enqueue_script(
				'admin-awesome-speech-bubble-script',
				plugins_url( 'js/admin-awesome-speech-bubble.js', __FILE__ ),
				array( 'jquery' ),
				filemtime(dirname(__FILE__) . '/js/admin-awesome-speech-bubble.js')
			);
			wp_enqueue_media();
			wp_enqueue_script(
				'awesome-speech-bubble-vue',
				plugins_url( 'js/build.js', __FILE__ ),
				'',
				filemtime(dirname(__FILE__) . '/js/build.js')
			);

			$ajax_url = admin_url('admin-ajax.php');
			$awesome_nonce = wp_create_nonce('awesome_speech_bubble');
			$awesome_args = array(
				'action' => 'awesome_speech_bubble',
				'nonce' => $awesome_nonce,
				);
			?>
			<script type="text/javascript">
				var awesome_speech_bubble_uri = '<?php echo esc_url($ajax_url); ?>';
				var awesome_speech_bubble_args = <?php echo json_encode($awesome_args); ?>;
			</script>
			<?php

	}

	/**
	* Ajax function to update
	*
	* @param  none
	* @return none
	*/
	public function wp_ajax_awesome_speech_bubble() {
		nocache_headers();
		// Do nothing when nonce does not match.
		if (! isset( $_GET['nonce'] ) || ! wp_verify_nonce( $_GET['nonce'], 'awesome_speech_bubble' ) ) {
			return;
		}

		if ( $_GET['init'] == true ) {
			echo json_encode( get_option( 'awesome_speech_bubble_data' ) );
			die();
		}

		if ( ! empty( $_GET['image_url'] ) && ! empty( $_GET['style_type'] ) && ! empty( $_GET['person_name'] ) ) {
			$image_url = esc_url( $_GET['image_url'] );
			$style_type = sanitize_text_field( $_GET['style_type'] );
			$person_name = sanitize_text_field( $_GET['person_name'] );
			$id = mt_rand();

			$new_args = array(
				$id => array(
					'image_url' => $image_url,
					'style_type' => $style_type,
					'person_name' => $person_name,
				)
			);
			if ( ! empty( get_option( 'awesome_speech_bubble_data' ) ) ) {
				$present_args = get_option( 'awesome_speech_bubble_data' );
				$merged_args = array_merge( $new_args, $present_args );
				update_option( 'awesome_speech_bubble_data', $merged_args ) ;
			}
			else {
				update_option( 'awesome_speech_bubble_data', $new_args );
			}
			// delete_option('awesome_speech_bubble_data');
			echo json_encode( get_option( 'awesome_speech_bubble_data' ) );

		}
		else{
			print_r( 'Please fill in all params' );
		}
		die();
	}
}
