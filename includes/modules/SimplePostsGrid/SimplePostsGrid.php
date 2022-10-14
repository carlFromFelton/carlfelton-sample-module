<?php

class CFSM_SimplePostsGrid extends ET_Builder_Module {

	public $slug = 'cfsm_posts_grid';
	public $vb_support = 'on';
	public $icon = '4';

	protected $module_credits = array(
		'module_uri' => 'https://google.com',
		'author'     => 'Carl Felton',
		'author_uri' => 'https://google.com',
	);

	public function init() {
		$this->name             = esc_html__( 'Sample Posts Grid', 'cfsm-carlfelton-sample-module' );
		$this->main_css_element = "%%order_class%%";
		$this->fields_defaults  = array(
			'columns_last_edited' => array(
				'on|desktop',
				'add_default_setting',
			),
			'columns_phone'       => array( 1, 'add_default_setting' ),
			'columns_tablet'      => array( 2, 'add_default_setting' ),
			'gaps_last_edited'    => array(
				'on|desktop',
				'add_default_setting',
			),
			'gaps_phone'          => array( '10px', 'add_default_setting' ),
			'gaps_tablet'         => array( '20px', 'add_default_setting' ),
		);
	}

	public function get_settings_modal_toggles() {
		return array(
			'general'  => array(
				'toggles' => array(
					'main_content' => array(
						'title'    => __( 'Content', 'cfsm-carlfelton-sample-module' ),
						'priority' => 1,
					),
					'elements'     => array(
						'title'    => __( 'Elements', 'cfsm-carlfelton-sample-module' ),
						'priority' => 2,
					),
				)
			),
			'advanced' => array(
				'toggles' => array(
					'layout' => array(
						'title' => __( 'Layout', 'cfsm-carlfelton-sample-module' )
					),
				)
			)
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'text'       => false,
			'filters'    => false,
			'fonts'      => array(
				'title'   => array(
					'label'        => __( 'Title', 'cfsm-carlfelton-sample-module' ),
					'css'          => array(
						'main' => "$this->main_css_element h1.cfsm-item-title, $this->main_css_element h2.cfsm-item-title, $this->main_css_element h3.cfsm-item-title, $this->main_css_element h4.cfsm-item-title, $this->main_css_element h5.cfsm-item-title, $this->main_css_element h6.cfsm-item-title",
					),
					'header_level' => array(
						'default' => 'h3'
					),
					'font_size'    => array( 'default' => '18px' ),
					'line_height'  => array( 'default' => '1.2em' ),
				),
				'excerpt' => array(
					'label'       => __( 'Excerpt', 'cfsm-carlfelton-sample-module' ),
					'css'         => array(
						'main' => "{$this->main_css_element} .cfsm-item-excerpt",
					),
					'line_height' => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
				),
			),
			'button'     => array(
				'read_more' => array(
					'label'         => __( 'Read More Button', 'cfsm-carlfelton-sample-module' ),
					'use_alignment' => true,
					'box_shadow'    => false,
					'css'           => array(
						'main'        => "$this->main_css_element .cfsm-read-more",
						'plugin_main' => "$this->main_css_element .cfsm-read-more",
						'alignment'   => "$this->main_css_element .et_pb_button_wrapper",
						'important'   => 'all'
					),
				),
			),
			'borders'    => array(
				'default' => array(
					'css'      => array(
						'main' => array(
							'border_radii'        => "$this->main_css_element .cfsm-item",
							'border_styles'       => "$this->main_css_element .cfsm-item",
							'border_styles_hover' => "$this->main_css_element .cfsm-item:hover",
						),
					),
					'defaults' => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '1px',
							'color' => '#d3d3d3',
							'style' => 'solid',
						),
					),
				)
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => "$this->main_css_element .cfsm-item",
					),
				),
			)
		);
	}

	public function before_render() {
		add_filter( 'et_late_global_assets_list', array(
			'CFSM_CarlfeltonSampleModule',
			'et_global_assets_list'
		), 10, 3 );
	}

	public function get_fields() {
		return array(
			'post_type'      => array(
				'label'           => __( 'Posts Types', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( '...', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'post'    => __( 'Posts', 'cfsm-carlfelton-sample-module' ),
					'project' => __( 'Projects', 'cfsm-carlfelton-sample-module' ),
					'page'    => __( 'Pages', 'cfsm-carlfelton-sample-module' ),
					'product' => __( 'Products', 'cfsm-carlfelton-sample-module' ),
				),
				'default'         => 'on|',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'posts_per_page' => array(
				'label'           => __( 'Post Number', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'text',
				'default'         => 12,
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'order'          => array(
				'label'           => __( 'Order', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( 'Choose to order posts in ascending or descending order.', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'select',
				'options'         => array(
					'ASC'  => __( 'Ascending', 'cfsm-carlfelton-sample-module' ),
					'DESC' => __( 'Descending', 'cfsm-carlfelton-sample-module' ),
				),
				'default'         => 'DESC',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'orderby'        => array(
				'label'           => __( 'Order By', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( 'Choose a parameter to apply the order to.', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'select',
				'options'         => array(
					'date'  => __( 'Date', 'cfsm-carlfelton-sample-module' ),
					'title' => __( 'Title', 'cfsm-carlfelton-sample-module' ),
					'name'  => __( 'Slug', 'cfsm-carlfelton-sample-module' ),
					'rand'  => __( 'Random', 'cfsm-carlfelton-sample-module' ),
				),
				'default'         => 'date',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			// Elements
			'show_image'     => array(
				'label'           => __( 'Show Feature Image', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => __( 'Yes', 'cfsm-carlfelton-sample-module' ),
					'off' => __( 'No', 'cfsm-carlfelton-sample-module' ),
				),
				'default'         => 'on',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'elements',
			),
			'show_title'     => array(
				'label'           => __( 'Show Title', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( '...', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => __( 'Yes', 'cfsm-carlfelton-sample-module' ),
					'off' => __( 'No', 'cfsm-carlfelton-sample-module' ),
				),
				'default'         => 'on',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'elements',
			),
			'show_excerpt'   => array(
				'label'           => __( 'Show Excerpt', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( '...', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => __( 'Yes', 'cfsm-carlfelton-sample-module' ),
					'off' => __( 'No', 'cfsm-carlfelton-sample-module' ),
				),
				'default'         => 'on',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'elements',
			),
			'show_read_more' => array(
				'label'           => __( 'Show Read More', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( '...', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => __( 'Yes', 'cfsm-carlfelton-sample-module' ),
					'off' => __( 'No', 'cfsm-carlfelton-sample-module' ),
				),
				'default'         => 'on',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'elements',
			),
			// Layout
			'columns'        => array(
				'label'           => __( 'Columns', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( '...', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '20',
					'step' => '1',
				),
				'mobile_options'  => true,
				'default'         => '3',
				'default_unit'    => '',
				'validate_unit'   => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout'
			),
			'gaps'           => array(
				'label'           => __( 'Space Between', 'cfsm-carlfelton-sample-module' ),
				'description'     => __( '...', 'cfsm-carlfelton-sample-module' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '200',
					'step' => '1',
				),
				'mobile_options'  => true,
				'default'         => '30px',
				'default_unit'    => 'px',
				'validate_unit'   => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout'
			),
		);
	}

	public function render( $attrs, $content, $render_slug ) {
		$props      = $this->props;
		$posts_data = CFSM_CarlfeltonSampleModule::get_posts_data( $props );
		$output     = '';

		if ( isset( $posts_data['no_results'] ) ) {
			$output = sprintf( '<p class="cfsm-no-results">%1$s<p>', $posts_data['no_results'] );
		} else {
			foreach ( $posts_data as $post_data ) {
				$image_html   = $props['show_image'] === 'on' && ! empty( $post_data['image'] ) ? sprintf( '<div class="cfsm-item-image">%1$s</div>', $post_data['image'] ) : '';
				$title_html   = $props['show_title'] === 'on' ? sprintf( '<h2 class="cfsm-item-title">%1$s</h2>', $post_data['title'] ) : '';
				$excerpt_html = $props['show_excerpt'] === 'on' ? sprintf( '<div class="cfsm-item-excerpt">%1$s</div>', $post_data['excerpt'] ) : '';
				$button_html  = $props['show_read_more'] === 'on' ? $this->render_button( array(
					'button_classname'    => array( 'cfsm-read-more' ),
					'button_custom'       => $props['custom_read_more'],
					'button_rel'          => $props['read_more_rel'],
					'button_text'         => __( 'Read More', 'cfsm-carlfelton-sample-module' ),
					'button_text_escaped' => true,
					'button_url'          => $post_data['permalink'],
					'custom_icon'         => $props['read_more_icon'],
					'custom_icon_tablet'  => $props['read_more_icon_tablet'],
					'custom_icon_phone'   => $props['read_more_icon_phone'],
				) ) : '';
				$output       .= sprintf( '<div class="cfsm-item">%1$s</div>', $image_html . $title_html . $excerpt_html . $button_html );
			}
		}

		$this->props['columns']        = str_repeat( '1fr ', intval( $props['columns'] ) );
		$this->props['columns_tablet'] = str_repeat( '1fr ', intval( $props['columns_tablet'] ) );
		$this->props['columns_phone']  = str_repeat( '1fr ', intval( $props['columns_phone'] ) );
		$this->generate_styles(
			array(
				'render_slug'    => $render_slug,
				'base_attr_name' => 'columns',
				'selector'       => '%%order_class%% .cfsm-main-container',
				'css_property'   => 'grid-template-columns'
			)
		);
		$this->generate_styles(
			array(
				'render_slug'    => $render_slug,
				'base_attr_name' => 'gaps',
				'selector'       => '%%order_class%% .cfsm-main-container',
				'css_property'   => 'grid-gap'
			)
		);

		return sprintf( '<div class="cfsm-main-container">%1$s</div>', $output );
	}
}

new CFSM_SimplePostsGrid;
