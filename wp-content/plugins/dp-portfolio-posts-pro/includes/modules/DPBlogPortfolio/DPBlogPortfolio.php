<?php

class ET_Builder_Module_DP_Blog_Portfolio extends ET_Builder_Module {

	public $vb_support = 'on';
	public $slug = 'et_pb_dpblog_portfolio';
	protected $module_credits = array(
		'module_uri' => 'https://diviplugins.com/downloads/portfolio-posts-pro/',
		'author'     => 'DiviPlugins',
		'author_uri' => 'http://diviplugins.com',
	);

	public function init() {
		$this->name             = __( 'DP Blog Portfolio', 'dpppp-dp-portfolio-posts-pro' );
		$this->main_css_element = '%%order_class%%';
	}

	public function get_settings_modal_toggles() {
		return array(
			'general'  => array(
				'toggles' => array(
					'content'      => __( 'Query Arguments', 'dpppp-dp-portfolio-posts-pro' ),
					'elements'     => __( 'Posts Elements', 'dpppp-dp-portfolio-posts-pro' ),
					'thumb_action' => __( 'Thumbnail Action', 'dpppp-dp-portfolio-posts-pro' ),
					'pagination'   => __( 'Pagination', 'dpppp-dp-portfolio-posts-pro' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'layout'  => array(
						'title'    => __( 'Layout', 'dpppp-dp-portfolio-posts-pro' ),
						'priority' => 1,
					),
					'overlay' => array(
						'title'    => __( 'Overlay', 'dpppp-dp-portfolio-posts-pro' ),
						'priority' => 2,
					),
					'text'    => array(
						'title'    => __( 'Text', 'dpppp-dp-portfolio-posts-pro' ),
						'priority' => 3,
					),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'      => array(
				'title'             => array(
					'label'        => __( 'Title', 'dpppp-dp-portfolio-posts-pro' ),
					'css'          => array(
						'main'      => "%%order_class%% .entry-title, %%order_class%% .entry-title a",
						'important' => 'all',
					),
					"line_height"  => array( "default" => "1.0em", ),
					"font_size"    => array( "default" => "18px", ),
					'header_level' => true
				),
				'caption'           => array(
					'label'       => __( 'Post Meta', 'dpppp-dp-portfolio-posts-pro' ),
					'css'         => array(
						'main' => "%%order_class%% .post-meta, %%order_class%% .post-meta a",
					),
					"line_height" => array( "default" => "1.7em", ),
					"font_size"   => array( "default" => "14px", ),
				),
				'excerpt'           => array(
					'label'       => __( 'Excerpt', 'dpppp-dp-portfolio-posts-pro' ),
					'css'         => array(
						'main' => "%%order_class%% .dp-post-excerpt",
					),
					"line_height" => array( "default" => "1.2em", ),
					"font_size"   => array( "default" => "14px", ),
				),
				'excerpt_more_link' => array(
					'label'           => __( 'Read More', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "%%order_class%% a.more-link",
					),
					'line_height'     => array( 'default' => '1em', ),
					'font_size'       => array( 'default' => '14px', ),
					'hide_text_align' => true,
				),
				'cf_label'          => array(
					'label'           => __( 'Custom Field Label', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "%%order_class%% .dp-custom-field-name",
					),
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
					'hide_text_align' => true,
				),
				'cf_value'          => array(
					'label'           => __( 'Custom Field Value', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "%%order_class%% .dp-custom-field-value",
					),
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
					'hide_text_align' => true,
				),
				'pagination_links'  => array(
					'label'           => __( 'Pagination Links', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "%%order_class%% .nav-links a",
					),
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
					'hide_text_align' => true,
				),
			),
			'borders'    => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'        => "%%order_class%% .et_pb_portfolio_item",
							'border_styles'       => "%%order_class%% .et_pb_portfolio_item",
							'border_styles_hover' => "%%order_class%% .et_pb_portfolio_item:hover",
						)
					),
				),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => "%%order_class%% .et_pb_portfolio_item",
					),
				),
			),
			'filters'    => false
		);
	}

	public function get_custom_css_fields_config() {
		return array(
			'portfolio_item'         => array(
				'label'    => __( 'Portfolio Item Container', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item',
			),
			'portfolio_image'        => array(
				'label'    => __( 'Portfolio Image', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .et_portfolio_image img',
			),
			'overlay'                => array(
				'label'    => __( 'Overlay', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .et_overlay',
			),
			'overlay_icon'           => array(
				'label'    => __( 'Overlay Icon', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .et_overlay:before',
			),
			'portfolio_title'        => array(
				'label'    => __( 'Portfolio Title', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .entry-title',
			),
			'portfolio_post_meta'    => array(
				'label'    => __( 'Portfolio Post Meta', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .post-meta',
			),
			'portfolio_custom_field' => array(
				'label'    => __( 'Custom Field Container', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .dp-custom-field',
			),
			'portfolio_cf_name'      => array(
				'label'    => __( 'Custom Field Label', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .dp-custom-field-name',
			),
			'portfolio_cf_label'     => array(
				'label'    => __( 'Custom Field Value', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .dp-custom-field-value',
			),
			'portfolio_excerpt'      => array(
				'label'    => __( 'Portfolio Excerpt', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item .dp-post-excerpt',
			),
			'portfolio_readmore'     => array(
				'label'    => __( 'Portfolio Read More', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% .et_pb_portfolio_item a.more-link',
			),
			'portfolio_pag_next'     => array(
				'label'    => __( 'Portfolio Pagination Next', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% div.nav-next a',
			),
			'portfolio_pag_prev'     => array(
				'label'    => __( 'Portfolio Pagination Prev', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '%%order_class%% div.nav-previous a',
			)
		);
	}

	public function get_fields() {
		return array(
			'custom_query'                  => array(
				'label'           => __( 'Custom Query', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Turn this option on if you want to create a custom query that is not possible using the options below. Once this option is turned on, all Content options below will be ignored and the module will load the 10 most recent blog posts by default. You can override this query using the following filter in your child theme\'s functions.php file: <strong>dp_ppp_custom_query_args</strong>. For more information and to see an example, see demo at <a href="https://www.diviplugins.com/divi-custom-queries/" target="_blank">Divi Plugins</a>  ', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'posts_number'                  => array(
				'label'           => __( 'Posts Number', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '12',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'Define the number of projects that should be displayed per page.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'offset_number'                 => array(
				'label'           => __( 'Offset number', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '0',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Choose how many posts you would like to offset by', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'orderby'                       => array(
				'label'           => __( 'Order By', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'date'          => __( 'Date', 'dpppp-dp-portfolio-posts-pro' ),
					'title'         => __( 'Title', 'dpppp-dp-portfolio-posts-pro' ),
					'name'          => __( 'Slug', 'dpppp-dp-portfolio-posts-pro' ),
					'rand'          => __( 'Random', 'dpppp-dp-portfolio-posts-pro' ),
					'menu_order'    => __( 'Menu Order', 'dpppp-dp-portfolio-posts-pro' ),
					'modified'      => __( 'Last Modified Date', 'dpppp-dp-portfolio-posts-pro' ),
					'comment_count' => __( 'Comments Count', 'dpppp-dp-portfolio-posts-pro' ),
					'parent'        => __( 'Parent ID', 'dpppp-dp-portfolio-posts-pro' ),
					'type'          => __( 'Post Type', 'dpppp-dp-portfolio-posts-pro' ),
					'author'        => __( 'Author', 'dpppp-dp-portfolio-posts-pro' ),
					'meta_value'    => __( 'Custom Field', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'date',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'Choose how to sort posts', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'meta_key'                      => array(
				'label'           => __( 'Custom Field Name', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '',
				'show_if'         => array(
					'custom_query' => 'off',
					'orderby'      => array( 'meta_value' )
				),
				'description'     => __( 'Enter the custom field name.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'meta_type'                     => array(
				'label'           => __( 'Custom Field Type', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'NUMERIC',
					'BINARY',
					'CHAR',
					'DATE',
					'DATETIME',
					'DECIMAL',
					'SIGNED',
					'TIME',
					'UNSIGNED'
				),
				'default'         => 'CHAR',
				'show_if'         => array(
					'custom_query' => 'off',
					'orderby'      => array( 'meta_value' )
				),
				'description'     => __( 'Enter the custom field type.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'order'                         => array(
				'label'           => __( 'Order', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'ASC'  => __( 'Asc', 'dpppp-dp-portfolio-posts-pro' ),
					'DESC' => __( 'Desc', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'DESC',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'Choose which order to display posts', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'remove_current_post'           => array(
				'label'           => __( 'Remove Current Post', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Turn on if you want to remove the current post. Useful if you want to show related content.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'sticky_posts'                  => array(
				'label'           => __( 'Ignore Sticky Posts', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'show_if'         => array( 'custom_query' => 'off' ),
				'description'     => __( 'Turn this option on to ignore sticky posts.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'custom_post_types'             => array(
				'label'           => __( 'Custom Post Type Name', 'dpppp-dp-portfolio-posts-pro' ),
				'option_category' => 'basic_option',
				'type'            => 'text',
				'default'         => 'post',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Check which posts types you would like to include in the layout', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'include_categories'            => array(
				'label'           => __( 'Categories', 'dpppp-dp-portfolio-posts-pro' ),
				'option_category' => 'basic_option',
				'type'            => 'text',
				'show_if'         => array( 'custom_query' => 'off' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Check which categories you would like to include in the layout', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'taxonomy_tags'                 => array(
				'label'       => __( 'Include/Exclude Taxonomy', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content',
				'default'     => 'post_tag',
				'show_if'     => array( 'custom_query' => 'off' ),
				'description' => __( 'Here you can control which taxonomy the include/exclude terms apply to. Leave empty for posts. For other CPTs, enter the taxonomy name above. Example: For projects, the tags taxonomy name is project_tag', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'include_tags'                  => array(
				'label'       => __( 'Include Terms', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content',
				'show_if'     => array( 'custom_query' => 'off' ),
				'description' => __( 'Enter a single term id or a comma separated list of terms ids. All posts in the categories above AND WITH these terms will load. Leave empty if you only want to filter using the categories above.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'exclude_tags'                  => array(
				'label'       => __( 'Exclude Terms', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'show_if'     => array( 'custom_query' => 'off' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'content',
				'description' => __( 'Enter a single term id or a comma separated list of terms ids. All posts in the categories above AND WITHOUT these terms will load. Leave empty if you only want to filter using the categories above.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			/*
			 * Elements
			 */
			'show_thumbnail'                => array(
				'label'           => __( 'Show Featured Image', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'This will turn thumbnails on and off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'thumbnail_size'                => array(
				'label'           => __( 'Featured Image Size', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => Dp_Portfolio_Posts_Pro_Utils::get_registered_thumbnail_sizes(),
				'default'         => '400x284',
				'show_if'         => array( 'show_thumbnail' => 'on' ),
				'description'     => __( 'Select the thumbnail size.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_title'                    => array(
				'label'           => __( 'Show Title', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Turn project titles on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_author'                   => array(
				'label'           => __( 'Show Author', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn the author link on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'author_prefix_text'            => array(
				'label'           => __( 'Author Prefix', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array( 'show_author' => 'on' ),
				'default'         => __( 'by ', 'dpppp-dp-portfolio-posts-pro' ),
				'description'     => __( 'Custom prefix displayed before author name.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_categories'               => array(
				'label'           => __( 'Show Categories', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Turn the category links on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_terms_taxonomy'           => array(
				'label'           => __( 'Category Taxonomy', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'category',
				'show_if'         => array( 'show_categories' => 'on' ),
				'description'     => __( 'Show terms of specific taxonomies.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_date'                     => array(
				'label'           => __( 'Show Date', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn the date display on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'meta_date'                     => array(
				'label'           => __( 'Date Format', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array( 'show_date' => 'on' ),
				'default'         => 'M j, Y',
				'description'     => __( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_comments'                 => array(
				'label'           => __( 'Show Comment Count', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn comment count on and off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_fields'                 => array(
				'label'           => __( 'Show Custom Fields', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Displays custom fields set in each post.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_field_names'            => array(
				'label'       => __( 'Custom Field Names', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'default'     => '',
				'show_if'     => array( 'custom_fields' => 'on' ),
				'description' => __( 'Enter a single custom field name or a comma separated list of names.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'custom_field_labels'           => array(
				'label'       => __( 'Custom Field Labels', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'default'     => '',
				'show_if'     => array( 'custom_fields' => 'on' ),
				'description' => __( 'Enter custom field label (including separator and spaces) or a comma separated list of labels in the same order as the names above. The number of labels must equal the number of names above, otherwise the name above will be used as the label for each custom field. For more information, see demo at <a href="http://www.diviplugins.com/portfolio-posts-pro-plugin/">Divi Plugins</a>', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'show_excerpt'                  => array(
				'label'           => __( 'Show Content', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn the excerpt display on or off', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'content_length'                => array(
				'label'           => __( 'Content Length', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'excerpt' => __( 'Show Excerpt', 'dpppp-dp-portfolio-posts-pro' ),
					'full'    => __( 'Show Full Content', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'excerpt',
				'show_if'         => array( 'show_excerpt' => 'on' ),
				'description'     => __( 'Show excerpt or full post content.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'excerpt_limit'                 => array(
				'label'       => __( 'Excerpt Limit', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'show_if'     => array(
					'content_length' => 'excerpt',
					'show_excerpt'   => 'on'
				),
				'default'     => 140,
				'description' => __( 'Enter number of characters to limit excerpt.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'truncate_excerpt'              => array(
				'label'           => __( 'Limit Manually Added Excerpts', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'show_if'         => array(
					'show_excerpt'   => 'on',
					'content_length' => 'excerpt'
				),
				'default'         => 'off',
				'description'     => __( 'Turn on to limit manually added excerpts to the number of characters entered above. Leave this option off to display the full excerpts for posts that have an excerpt defined.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'strip_html'                    => array(
				'label'           => __( 'Strip HTML', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'show_if'         => array(
					'show_excerpt'   => 'on',
					'content_length' => 'excerpt'
				),
				'default'         => 'on',
				'description'     => __( 'Remove HTML tags from excerpt. Turning this option off can break the grid layout if the excerpt is truncated in the middle of an HTML tag.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_more'                     => array(
				'label'           => __( 'Read More Button', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'Off', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'On', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Here you can define whether to show "read more" link after the excerpts or not.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_more_text'                => array(
				'label'           => __( 'Read More Text', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array( 'show_more' => 'on' ),
				'default'         => __( 'read more', 'dpppp-dp-portfolio-posts-pro' ),
				'description'     => __( 'Leave blank will show "read more" by default.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_custom_content'           => array(
				'label'           => __( 'Show Custom Content', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'Off', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'On', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Show or hide custom content via dp_ppp_custom_content filter.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_url'                    => array(
				'label'           => __( 'Use Custom URLs', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Changes the URL to a custom field value set in each post.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_url_field_name'         => array(
				'label'       => __( 'Custom Field for URL', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'show_if'     => array( 'custom_url' => 'on' ),
				'description' => __( 'Enter custom field name (NOT the URL). The URL value needs to be set in each post using the custom field you input here. If no value is set, defaults to post URL.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'url_new_window'                => array(
				'label'           => __( 'Url Opens', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'In The Same Window', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'In The New Tab', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Here you can choose whether or not your link opens in a new window', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			/*
			 * Thumbnail Action
			 */
			'popup'                         => array(
				'label'       => __( 'Open Post in Popup', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'     => 'off',
				'description' => __( 'Posts open in popup instead of opening blog post.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'thumb_action',
			),
			'lightbox'                      => array(
				'label'       => __( 'Open Image in Lightbox', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'     => 'off',
				'show_if'     => array( 'show_thumbnail' => 'on' ),
				'description' => __( 'Image opens in lightbox instead of opening blog post.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'thumb_action',
			),
			'lightbox_gallery'              => array(
				'label'           => __( 'Lightbox Gallery', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'show_if'         => array(
					'show_thumbnail' => 'on',
					'lightbox'       => 'on'
				),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'thumb_action',
				'description'     => __( 'Turn this option on if you want the lightbox to display all images from the items in a gallery. Leave this option off if you only want the clicked image to display in the lightbox.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'gallery_cf'                    => array(
				'label'           => __( 'Open Custom Lightbox Gallery', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'show_if'         => array( 'show_thumbnail' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'thumb_action',
				'description'     => __( 'Turn this option on to display a custom lightbox gallery of images when the featured image is clicked. Enter the custom field name below containing the image or array of images to load for each post. You can also provide an image or array of images using the <a href="https://diviplugins.com/documentation/portfolio-posts-pro/custom-lightbox/">Custom Lightbox filter</a>.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'gallery_cf_name'               => array(
				'label'           => __( 'Custom Field Name for Images', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => '',
				'show_if'         => array(
					'show_thumbnail' => 'on',
					'gallery_cf'     => 'on'
				),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'thumb_action',
				'description'     => __( 'Enter the custom field name containing the image or array of images you would like to load in the custom lightbox gallery. Leave this empty to use the <a href="https://diviplugins.com/documentation/portfolio-posts-pro/custom-lightbox/">Custom Lightbox filter</a>.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			/*
			 * Pagination
			 */
			'show_pagination'               => array(
				'label'           => __( 'Show Pagination', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Enable or disable pagination for this feed.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'pagination',
			),
			'pagination_older_text'         => array(
				'label'           => __( 'Pagination Previous Text', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => __( 'Previous Entries', 'dpppp-dp-portfolio-posts-pro' ),
				'show_if'         => array( 'show_pagination' => 'on' ),
				'description'     => __( 'Leave blank will show "Previous Entries" by default.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'pagination',
			),
			'pagination_next_text'          => array(
				'label'           => __( 'Pagination Next Text', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => __( 'Next Entries', 'dpppp-dp-portfolio-posts-pro' ),
				'show_if'         => array( 'show_pagination' => 'on' ),
				'description'     => __( 'Leave blank will show "Next Entries" by default.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'pagination',
			),
			/*
			 * Text
			 */
			'background_layout'             => array(
				'label'           => __( 'Text Color', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'light' => __( 'Dark', 'dpppp-dp-portfolio-posts-pro' ),
					'dark'  => __( 'Light', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'light',
				'description'     => __( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
			),
			/*
			 * Overlay
			 */
			'use_overlay'                   => array(
				'label'       => __( 'Featured Image Overlay', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => __( 'On', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'Off', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'     => 'on',
				'description' => __( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the featured image of a post.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'overlay',
			),
			'hover_icon'                    => array(
				'label'           => __( 'Hover Icon Picker', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select_icon',
				'option_category' => 'configuration',
				'show_if'         => array( 'use_overlay' => 'on' ),
				'class'           => array( 'et-pb-font-icon' ),
				'default'         => "%%200%%",
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
			),
			'zoom_icon_color'               => array(
				'label'        => __( 'Zoom Icon Color', 'dpppp-dp-portfolio-posts-pro' ),
				'type'         => 'color-alpha',
				'show_if'      => array( 'use_overlay' => 'on' ),
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'overlay',
			),
			'hover_overlay_color'           => array(
				'label'        => __( 'Hover Overlay Color', 'dpppp-dp-portfolio-posts-pro' ),
				'type'         => 'color-alpha',
				'show_if'      => array( 'use_overlay' => 'on' ),
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'overlay',
			),
			/*
			 * Background
			 */
			'masonry_tile_background_color' => array(
				'label'        => __( 'Items Background Color', 'dpppp-dp-portfolio-posts-pro' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'general',
				'toggle_slug'  => 'background',
			),
			/*
			 * Layout
			 */
			'fullwidth'                     => array(
				'label'           => __( 'Layout', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => array(
					'on'   => __( 'Fullwidth', 'dpppp-dp-portfolio-posts-pro' ),
					'off'  => __( 'Grid', 'dpppp-dp-portfolio-posts-pro' ),
					'list' => __( 'List', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Choose your desired portfolio layout style.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout',
			),
		);
	}

	public function before_render() {
		parent::before_render();
		wp_enqueue_script( "dp-portfolio-posts-pro-frontend-bundle" );
		wp_localize_script( "dp-portfolio-posts-pro-frontend-bundle", 'dp_ppp', array( 'dp_popup' => Dp_Portfolio_Posts_Pro_Utils::get_popup_container() ) );
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$props        = $this->props;
		$module_class = ET_Builder_Element::add_module_order_class( $props['module_class'], $render_slug );
		/*
		 * Custom styles for list and grid layout
		 */
		if ( '' !== $props['masonry_tile_background_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_portfolio_item',
				'declaration' => sprintf(
					'background-color: %1$s;', esc_html( $props['masonry_tile_background_color'] )
				),
			) );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_grid_item > *:not(a)',
				'declaration' => 'padding: 0px 8px;'
			) );
		}
		/*
		 * Custom icon and overlay colors
		 */
		if ( $props['show_thumbnail'] === 'on' && $props['use_overlay'] === 'on' ) {
			if ( '' !== $props['zoom_icon_color'] ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf( 'color: %1$s !important;', esc_html( $props['zoom_icon_color'] ) ),
				) );
			}
			if ( '' !== $props['hover_overlay_color'] ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf( 'background-color: %1$s; border-color: %1$s;', esc_html( $props['hover_overlay_color'] ) ),
				) );
			}
			$data_icon      = ( '' !== $props['hover_icon'] ) ? sprintf( ' data-icon="%1$s"', esc_attr( et_pb_process_font_icon( $props['hover_icon'] ) ) ) : '';
			$overlay_output = sprintf( '<span class="et_overlay%1$s"%2$s></span>', ( '' !== $props['hover_icon'] ? ' et_pb_inline_icon' : '' ), $data_icon );
		}
		$gallery_images = 0;
		/*
		 * Init blog portfolio output
		 */
		ob_start();
		$posts_data = Dp_Portfolio_Posts_Pro_Utils::get_posts_data( $props, 'blog' );
		if ( ! isset( $posts_data['no_results'] ) ) {
			foreach ( $posts_data['posts'] as $post_data ) {
				echo sprintf( '<div id="post-%1$s" class="%2$s">', $post_data['post_id'], $post_data['classes'] );
				/*
				 * If list item open left div
				 */
				if ( $props['fullwidth'] === 'list' ) {
					echo '<div class="dp_portfolio_item_left">';
				}
				/*
				 * Show thumbnail image
				 */
				if ( $props['show_thumbnail'] === 'on' && $post_data['thumbnail'] ) {
					$link = "";
					if ( $props['lightbox'] === 'on' ) {
						$link = sprintf( '<a href="%1$s" class="dp_ppp_lightbox_image">', $post_data['thumbnail_image_original'] );
					} else if ( $props['popup'] === 'on' ) {
						$link = sprintf( '<a href="" class="et_pb_lightbox_post_popup" data-rel="%1$s" data-showtitle="%2$s" data-showdate="%3$s" data-ajaxurl="%4$s">', $post_data['post_id'], $props['show_title'], $props['show_date'], $post_data['ajax_url'] );
					} else if ( $props['gallery_cf'] === "on" ) {
						if ( count( $post_data['cf_lightbox_data'] ) > 0 ) {
							$link = sprintf( '<a href="#" class="dp_ppp_gallery_cf" data-images="%1$s">', implode( "||", $post_data['cf_lightbox_data'] ) );
						}
					} else {
						$link = sprintf( '<a href="%1$s" %2$s>', $post_data['post_url'], $posts_data['post_open_tab'] );
					}
					echo sprintf( '%9$s<span class="et_portfolio_image"><img class="dp_ppp_post_thumb %7$s" src="%1$s" alt="%2$s" width="%3$s" height="%4$s" data-lightbox-gallery="%5$s" data-gallery-image="%6$s">%8$s</span></a>', $post_data['thumbnail_image'], $post_data['title'], $posts_data['width'], $posts_data['height'], ( $props['lightbox_gallery'] === 'on' ) ? 'on' : 'off', $gallery_images ++, ( $props['fullwidth'] === 'on' ) ? 'et_pb_post_main_image' : '', ( 'on' === $props['use_overlay'] ) ? $overlay_output : "", $link );
				}
				/*
				 * If list item close left div and open right div
				 */
				if ( $props['fullwidth'] === 'list' ) {
					echo '</div><div class="dp_portfolio_item_right">';
				}
				/*
				 * Show post title
				 */
				if ( 'on' === $props['show_title'] ) {
					if ( $props['popup'] === 'on' ) {
						echo sprintf( '<%6$s class="entry-title"><a href="" class="et_pb_lightbox_post_popup" data-rel="%2$s" data-showtitle="%3$s" data-showdate="%4$s" data-ajaxurl="%5$s">%1$s</a></%6$s>', $post_data['title'], $post_data['post_id'], $props['show_title'], $props['show_date'], $post_data['ajax_url'], $props['title_level'] );
					} else if ( $props['lightbox'] === 'on' ) {
						echo sprintf( '<%2$s class="entry-title">%1$s</%2$s>', $post_data['title'], $props['title_level'] );
					} else {
						echo sprintf( '<%4$s class="entry-title"><a href="%2$s" %3$s>%1$s</a></%4$s>', $post_data['title'], $post_data['post_url'], $posts_data['post_open_tab'], $props['title_level'] );
					}
				}
				/*
				 * Show post meta
				 */
				if ( $props['show_author'] === 'on' || $props['show_categories'] === 'on' || $props['show_date'] === 'on' || $props['show_comments'] === 'on' ) {
					$post_autor    = '';
					$post_terms    = '';
					$post_date     = '';
					$post_comments = '';
					if ( 'on' === $props['show_author'] ) {
						$post_autor = sprintf( '<span class="ppp-blog-post-author">%3$s%1$s%2$s</span>', $post_data['author_link'], ( $props['show_categories'] === 'on' || $props['show_date'] === 'on' || $props['show_comments'] === 'on' ) ? ' | ' : '', $props['author_prefix_text'] );
					}
					if ( 'on' === $props['show_date'] ) {
						$post_date = sprintf( '<span class="ppp-blog-post-date">%1$s%2$s</span>', $post_data['date'], ( $props['show_categories'] === 'on' || $props['show_comments'] === 'on' ) ? ' | ' : '' );
					}
					if ( 'on' === $props['show_categories'] ) {
						$post_terms = sprintf( '<span class="ppp-blog-post-categories">%1$s%2$s</span>', $post_data['term_list'], ( $props['show_comments'] === 'on' ) ? ' | ' : '' );
					}
					if ( 'on' === $props['show_comments'] ) {
						$post_comments = sprintf( '<span class="ppp-blog-post-comments">%1$s</span>', $post_data['comments_count'] );
					}
					echo sprintf( '<p class="post-meta">%1$s%2$s%3$s%4$s</p>', $post_autor, $post_date, $post_terms, $post_comments );
				}
				/*
				 * Show custom fields
				 */
				if ( ! empty( $post_data['post_custom_fields'] ) ) {
					foreach ( $post_data['post_custom_fields'] as $cf ) {
						if ( $cf['value'] != '' ) {
							echo sprintf( '<p class="dp-custom-field"><span class="dp-custom-field-name">%1$s</span><span class="dp-custom-field-value">%2$s</span></p>', $cf['label'], $cf['value'] );
						}
					}
				}
				/*
				 * Show excerpt / read more button
				 */
				if ( $props['show_excerpt'] === 'on' ) {
					echo sprintf( '<p class="dp-post-excerpt">%1$s</p>', $post_data['excerpt'] );
				} elseif ( $props['show_more'] === 'on' ) {
					echo $post_data['read_more'];
				}
				/*
				 * Custom content
				 */
				if ( $props['show_custom_content'] === 'on' ) {
					echo $post_data['custom_content'];
				}
				/*
				 * Close list right div if enable
				 */
				if ( $props['fullwidth'] === 'list' ) {
					echo '</div>';
				}
				/*
				 * Close blog portfolio item
				 */
				echo '</div> <!-- .dp_blog_portfolio_item -->';
			}
			if ( $props['show_pagination'] === 'on' && ! is_search() ) {
				echo $posts_data['pagination'];
			}
		} else {
			echo $posts_data['no_results'];
		}
		wp_reset_query();
		/*
		 * Get portfolio items html
		 */
		$posts = ob_get_clean();
		/*
		 * Add classnames
		 */
		if ( $props['fullwidth'] === 'on' ) {
			$layout_class = 'et_pb_portfolio';
		} elseif ( $props['fullwidth'] === 'off' ) {
			$layout_class = 'et_pb_portfolio_grid clearfix';
		} else {
			$layout_class = 'et_pb_portfolio_list';
		}
		$this->add_classname( array(
			"dp_ppp_module",
			$layout_class,
			"et_pb_bg_layout_{$props['background_layout']}",
			$this->get_text_orientation_classname()
		) );

		return sprintf( '%1$s', $posts );
	}

}

new ET_Builder_Module_DP_Blog_Portfolio;
