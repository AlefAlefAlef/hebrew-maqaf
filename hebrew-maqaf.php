<?php
/**
 * Plugin Name:       The Hebrew Maqaf Plugin, by AlefAlefAlef.co.il
 * Plugin URI:        https://alefalefalef.co.il/hebrew-hebrew-maqaf
 * Description:       Adds a Hebrew Maqaf button to the WordPress Editor
 * Version:           1.0.1
 * Author:            Reuven Karasik
 * Author URI:        http://reuven.rocks
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hebrew-maqaf
 * Domain Path:       /languages
 */

class Hebrew_Maqaf {

	private $config;

	public function __construct() {
		$this->load_plugin_textdomain();
		add_filter( 'mce_external_plugins', array( $this, 'tiny_mce_add_buttons' ) );
		add_filter( 'mce_buttons_2', array( $this, 'tiny_mce_register_buttons' ) );
		add_action( 'admin_head', array( $this, 'localize_script' ) );

		$this->config = array(
			'maqaf'  => array(
				'add_button_text' => __( 'Add Maqaf', 'hebrew-maqaf' ),
				'character'       => '־',
				'blacklist'       => $this->get_maqaf_blacklist(),
			),
		);
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'hebrew-maqaf',
			false,
			'hebrew-maqaf/languages/'
		);

	}

	public function get_maqaf_blacklist() {
		return ( include 'includes/maqaf-blacklist.php' );
	}

	public function tiny_mce_add_buttons( $plugins ) {
		$plugins['maqaf_plugin'] = plugins_url( 'hebrew-maqaf' ) . '/tinymce-plugin.js';
		return $plugins;
	}

	public function tiny_mce_register_buttons( $buttons ) {
		$buttons[] = 'aaa_hebrew_maqaf';
		return $buttons;
	}

	public function localize_script() {

		global $current_screen;
		global $post;
		$type = $current_screen->post_type;

		if ( is_admin() && ( 'post' === $type || 'page' === $type ) ) {
			?>
			<script type="text/javascript">
				var AAAHT = <?php echo json_encode( $this->config ); ?>;
			</script>
			<?php
		}
	}

}

add_action( 'init', 'initialize_maqaf_plugin' );
function initialize_maqaf_plugin() {
	$maqaf_plugin = new Hebrew_Maqaf();
}
