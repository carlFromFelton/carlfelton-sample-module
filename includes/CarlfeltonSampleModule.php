<?php

class CFSM_CarlfeltonSampleModule extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'cfsm-carlfelton-sample-module';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'carlfelton-sample-module';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * CFSM_CarlfeltonSampleModule constructor.
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function __construct( $name = 'carlfelton-sample-module', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );
		add_action( 'wp_ajax_cfsm_get_posts_data_action', array( $this, 'ajax_get_posts_data' ) );
		add_action( 'wp_ajax_nopriv_cfsm_get_posts_data_action', array( $this, 'ajax_get_posts_data' ) );
		parent::__construct( $name, $args );
	}

	static function get_posts_data( $props ) {
		$posts_data     = array();
		$post_types     = array();
		$post_types_map = array( 'post', 'project', 'page', 'product' );
		foreach ( explode( '|', $props['post_type'] ) as $index => $checkbox_value ) {
			if ( 'on' === $checkbox_value ) {
				$post_types[] = $post_types_map[ $index ];
			}
		}
		$query_args = array(
			'post_type'      => $post_types,
			'post_status'    => 'publish',
			'posts_per_page' => $props['posts_per_page'],
			'order'          => $props['order'],
			'orderby'        => $props['orderby'],
		);
		$query      = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$id        = get_the_ID();
				$post_data = array(
					'id'        => $id,
					'image'     => get_the_post_thumbnail( $id ),
					'title'     => get_the_title(),
					'excerpt'   => get_the_excerpt(),
					'permalink' => get_the_permalink()
				);

				$posts_data[] = $post_data;
			}
		} else {
			$posts_data['no_results'] = __( 'No Results Found', 'cfsm-carlfelton-sample-module' );
		}

		return $posts_data;
	}

	function ajax_get_posts_data() {
		$props = json_decode( wp_kses_stripslashes( $_POST['props'] ), true );
		wp_send_json( self::get_posts_data( $props ) );
	}

	static function et_global_assets_list( $assets_list, $assets_args, $dynamic_assets ) {
		$assets_prefix = $assets_args['assets_prefix'];
		if ( ! ( isset( $assets_list['et_icons_all'] ) && isset( $assets_list['et_icons_fa'] ) ) ) {
			$assets_list['et_icons_all'] = array(
				'css' => "{$assets_prefix}/css/icons_all.css",
			);
			$assets_list['et_icons_fa']  = array(
				'css' => "{$assets_prefix}/css/icons_fa_all.css",
			);
		}

		return $assets_list;
	}

}

new CFSM_CarlfeltonSampleModule;
