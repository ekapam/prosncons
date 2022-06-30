<?php

class ProsNcons {

	static function prosncons_shortcode( $atts ) {
		extract( shortcode_atts( array('id' => 803,), $atts ) );
		$pros = get_post_meta($id, 'prosArr', TRUE);
		$cons = get_post_meta($id, 'consArr', TRUE);
		$output = '';
		$output .= '<div class="grid-container">';
		if ($pros != "") {
			$output .= '<div class="pros"><div class="title">Pros:</div><div class="row"><ul>';
			foreach ($pros as $pro) {
				$output .= '<li><i class="fa fa-check-circle"></i>'.$pro.'</li>';
			}
			$output .= '</ul></div></div>';
		}
		if ($cons != "") {
			$output .= '<div class="cons"><div class="title">Cons</div><div class="row"><ul>';
			foreach ($cons as $con) {
				$output .= '<li><i class="fa fa-times-circle"></i>'.$con.'</li>';
			}
			$output.= '</ul></div></div>';
		}
		$output .= '</div>';
		return $output;
	}

	static function public_resources() {
		wp_enqueue_style('prosncons');
		wp_register_style('prosncons', plugin_dir_url( __DIR__ ) . 'assets/css/prosncons.css', array(), '1.1', 'all');
		wp_enqueue_style('font-awesome','//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css', false, false, 'all');
	}

	static function admin_resources() {
		wp_enqueue_style('prosncons');
		wp_register_style('prosncons', plugin_dir_url( __DIR__ ) . 'assets/css/prosncons.css', array(), '1.1', 'all');
		wp_enqueue_script('prosncons');
		wp_register_script('prosncons', plugin_dir_url( __DIR__ ) . 'assets/js/prosncons.js', array( 'jquery' ), '1.1', true);
		wp_enqueue_style('font-awesome','//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css');
	}

	static function register() {
		add_shortcode( 'prosncons_shortcode', 'ProsNcons::prosncons_shortcode' );
		add_action( 'add_meta_boxes', 'ProsNcons::add_metabox' );
		add_action( 'save_post', 'ProsNcons::save' );
		add_action( 'admin_enqueue_scripts', 'ProsNcons::admin_resources' );
		add_action( 'wp_enqueue_scripts', 'ProsNcons::public_resources' );
	}

	static function addMetabox() {
		global $post;
		$itemTemplate = '<tr><td><span>%s</span><input type="hidden" name="%s" value="%s" /></td><td><button data-target="%s" class="button button-secondary remove" onclick="event.preventDefault(); Product.removeItem($(this));"><i class="fa fa-minus-circle"></i></button></td></tr>';
		$pros = get_post_meta($post->ID, 'prosArr', TRUE);
		$prosPlaceholder = '<tr class="itemPlaceholder"><td>There are no pros registered.</td></tr>';
		if(is_array($pros) && count($pros) > 0) {
			$prosDOMBody = '';
			foreach($pros as $pro){
				$prosDOMBody .= sprintf($itemTemplate,
					$pro,
					'prosArr[]',
					$pro,
					'pros'
				);
			}
		}
		else {
			$prosDOMBody = $prosPlaceholder;
		}

		$cons = get_post_meta($post->ID, 'consArr', TRUE);
		$consPlaceholder = '<tr class="itemPlaceholder"><td>There are no cons registered.</td></tr>';
		if(is_array($cons) && count($cons) > 0) {
			$consDOMBody = '';
			foreach($cons as $con) {
				$consDOMBody .= sprintf($itemTemplate,
					$con,
					'consArr[]',
					$con,
					'cons'
				);
			}
		}
		else {
			$consDOMBody = $consPlaceholder;
		}

		wp_nonce_field( 'meta_box', 'noncename_prosncons' );
		require_once plugin_dir_path(__DIR__) . 'views/view-prosncons.php';
	}

	static function add_metabox() {
		// If the category is not business related
		// if(in_category("blog")) return;
		
		// Register metabox into WP Admin
		add_meta_box(
			'prosncons', 
			'ProsNcons',
			'ProsNcons::addMetabox',
			'post',
			'normal',
			'core' );
	}

	static function save( $post_id ) {
		// Autosave fallback
		if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;

		// If changes are not detected
		if(empty($_POST)) return;
		
		// Check taxonomy
		if('post' != $_POST['post_type']) return;

		// Verify correct security nonce
		if(!isset($_POST['noncename_prosncons']) || !wp_verify_nonce($_POST['noncename_prosncons'], 'meta_box')) return;

		// If the category is not business related
		// if(in_category("blog")) return;

		$pros_data = (!is_null($_POST['prosArr'])) ? array_values($_POST['prosArr']) : null;
		$cons_data = (!is_null($_POST['consArr'])) ? array_values($_POST['consArr']) : null;

		update_post_meta($post_id,"prosArr", $pros_data);
		update_post_meta($post_id,"consArr", $cons_data);
	}
}