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

class AwesomeSpeechBubble {

    static function install() {
    }

    public function register() {
        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
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
        add_action( 'edit_form_after_title', array( $this, 'asb_display_app' ) );
        add_action( 'wp_ajax_awesome_speech_bubble', array( $this, 'wp_ajax_awesome_speech_bubble' ) );
        add_action( 'wp_ajax_nopriv_awesome_speech_bubble', array( $this, 'wp_ajax_awesome_speech_bubble' ) );
        add_action('media_buttons', array( $this, 'add_asb_modal_button' ) );
        add_shortcode( 'asp_sc', array( $this, 'asp_shortcode' ) );
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
                filemtime( dirname( __FILE__ ) . '/js/awesome-speech-bubble.js' )
            );
        }
        wp_enqueue_style(
            'awesome-speech-bubble-style',
            plugins_url( 'css/asp_dialog.css', __FILE__ ),
            array(),
            filemtime( dirname( __FILE__ ) . '/css/asp_dialog.css' )
        );
    }

    /**
     * Enqueue admin script for edit page
     *
     * @param  none
     * @return none
     */
    public function asb_display_app() {
        echo '<div id="app"></div>';
    }


    /**
     * Add Custom button
     *
     * @param  none
     * @return none
     */
    public function add_asb_modal_button() {
        echo '<a href="#" id="asb_modal" class="button asb_show_modal">Add Speech Bubble</a>';
    }

    public function asb_admin_enqueue_scripts() {
        wp_enqueue_script(
            'admin-awesome-speech-bubble-script',
            plugins_url( 'js/admin-awesome-speech-bubble.js', __FILE__ ),
            array( 'jquery' ),
            filemtime( dirname( __FILE__ ) . '/js/admin-awesome-speech-bubble.js' )
        );
        wp_enqueue_media();
        wp_enqueue_script(
            'awesome-speech-bubble-vue',
            plugins_url( 'js/build.js', __FILE__ ),
            '',
            filemtime( dirname( __FILE__ ) . '/js/build.js' )
        );

        $ajax_url = admin_url( 'admin-ajax.php' );
        $awesome_nonce = wp_create_nonce( 'awesome_speech_bubble' );
        $awesome_args = array(
            'action' => 'awesome_speech_bubble',
            'nonce' => $awesome_nonce,
        );
        ?>
        <script type="text/javascript">
            var awesome_speech_bubble_uri = '<?php echo esc_url( $ajax_url ); ?>';
            var awesome_speech_bubble_args = <?php echo json_encode( $awesome_args ); ?>;
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
        $input_get = filter_input_array( INPUT_GET, FILTER_SANITIZE_STRING );

        if ( ! isset( $input_get[ 'nonce' ] ) || ! wp_verify_nonce( $input_get[ 'nonce' ], 'awesome_speech_bubble' ) ) {
            return;
        }

        if ( input_get[ 'init' ] == true ) {
            $users = get_users();
            $user_info = array();
            foreach ( $users as $user ) {
                $name = array( 'name' => get_the_author_meta( 'display_name', $user->ID ) );
                $user_id = array( 'id' => $user->ID );
                array_push( $user_info, array_merge( $name, $user_id ) );
            }
            echo json_encode( $user_info );
            die();
        }
        die();
    }

    /**
     * return Speech Bubble HTML
     *
     * @return string HTML
     */
    public function asp_shortcode( array $attr ) {
        $user_id = $attr[ 'id' ];
        $message = $attr[ 'message' ];
        $position = $attr[ 'pos' ];
        $size = $attr[ 'size' ];
        $avatar = get_avatar( $user_id, $size );
        ?>
        <div class="asp_dialog_style">
            <div class="asp_dialog_<?php echo $position; ?>">
                <div class="asp_avatar">
                    <?php echo $avatar; ?>
                </div>
                <div class="asp_message_<?php echo $position; ?>">
                    <p><?php echo $message; ?></p>
                </div>
            </div>
        </div>


        <?php
    }


}
