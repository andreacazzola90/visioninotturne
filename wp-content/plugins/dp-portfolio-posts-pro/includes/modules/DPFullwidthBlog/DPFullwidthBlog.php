<?php

class ET_Builder_Module_DP_Fullwidth_Blog extends ET_Builder_Module {

	public $vb_support = 'partial';
	public $slug = 'et_pb_dpfullwidth_blog';

	public function init() {
		$this->name             = __( 'DP Fullwidth Blog', 'dpppp-dp-portfolio-posts-pro' );
		$this->fullwidth        = true;
		$this->main_css_element = '%%order_class%%';
	}

	public function get_settings_modal_toggles() {
		return array(
			'general'  => array(
				'toggles' => array(
					'content'      => __( 'Query Arguments', 'dpppp-dp-portfolio-posts-pro' ),
					'elements'     => __( 'Posts Elements', 'dpppp-dp-portfolio-posts-pro' ),
					'thumb_action' => __( 'Thumbnail Action', 'dpppp-dp-portfolio-posts-pro' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'layout'  => array(
						'title'    => __( 'Layout', 'dpppp-dp-portfolio-posts-pro' ),
						'priority' => 2,
					),
					'overlay' => array(
						'title'    => __( 'Overlay', 'dpppp-dp-portfolio-posts-pro' ),
						'priority' => 3,
					),
					'text'    => array(
						'title'    => __( 'Text', 'dpppp-dp-portfolio-posts-pro' ),
						'priority' => 1,
					),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts'   => array(
				'portfolio_title' => array(
					'label'       => __( 'Portfolio Title', 'dpppp-dp-portfolio-posts-pro' ),
					'css'         => array(
						'main'      => "{$this->main_css_element} h2",
						'important' => 'all',
					),
					"line_height" => array( "default" => "1.0em", ),
					"font_size"   => array( "default" => "18px", ),
				),
				'title'           => array(
					'label'           => __( 'Post Title', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main'      => "{$this->main_css_element} h3",
						'important' => 'all',
					),
					'hide_text_align' => true,
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
				),
				'caption'         => array(
					'label'           => __( 'Post Meta', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .post-meta, {$this->main_css_element} .post-meta a",
					),
					'hide_text_align' => true,
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
				),
				'excerpt'         => array(
					'label'           => __( 'Post Excerpt', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dp-post-excerpt",
					),
					'hide_text_align' => true,
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
				),
				'cf_label'        => array(
					'label'           => __( 'Custom Field Label', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dp-custom-field-name",
					),
					'hide_text_align' => true,
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
				),
				'cf_value'        => array(
					'label'           => __( 'Custom Field Value', 'dpppp-dp-portfolio-posts-pro' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dp-custom-field-value",
					),
					'hide_text_align' => true,
					"line_height"     => array( "default" => "1.7em", ),
					"font_size"       => array( "default" => "14px", ),
				),
			),
			'filters' => false,
		);
	}

	public function get_custom_css_fields_config() {
		return array(
			'portfolio_title'        => array(
				'label'    => __( 'Portfolio Title', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '> h2',
			),
			'portfolio_item'         => array(
				'label'    => __( 'Portfolio Item', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '.et_pb_portfolio_item',
			),
			'portfolio_overlay'      => array(
				'label'    => __( 'Item Overlay', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => 'span.et_overlay',
			),
			'portfolio_item_title'   => array(
				'label'    => __( 'Item Title', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '.meta h3',
			),
			'portfolio_meta'         => array(
				'label'    => __( 'Meta', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '.meta p',
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
			'portfolio_arrows'       => array(
				'label'    => __( 'Navigation Arrows', 'dpppp-dp-portfolio-posts-pro' ),
				'selector' => '.et-pb-slider-arrows a',
			),
		);
	}

	public function get_fields() {
		return array(
			'title'                 => array(
				'label'           => __( 'Portfolio Title', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'description'     => __( 'Title displayed above the portfolio.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'custom_query'          => array(
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
			'posts_number'          => array(
				'label'           => __( 'Posts Number', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '12',
				'description'     => __( 'Define the number of posts that should be displayed per page.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'offset_number'         => array(
				'label'           => __( 'Offset number', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '0',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Choose how many posts you would like to offset by', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'orderby'               => array(
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
			'meta_key'              => array(
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
			'meta_type'             => array(
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
			'order'                 => array(
				'label'           => __( 'Order', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'ASC'  => __( 'Asc', 'dpppp-dp-portfolio-posts-pro' ),
					'DESC' => __( 'Desc', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'DESC',
				'description'     => __( 'Choose which order to display posts', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
			),
			'remove_current_post'   => array(
				'label'           => __( 'Remove Current Post', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Turn on if you want to remove the current post. Useful if you want to show related content.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'sticky_posts'          => array(
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
			'custom_post_types'     => array(
				'label'           => __( 'Custom Post Type Name', 'dpppp-dp-portfolio-posts-pro' ),
				'option_category' => 'configuration',
				'type'            => 'text',
				'default'         => 'post',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Check which posts types you would like to include in the layout', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'include_categories'    => array(
				'label'           => __( 'Categories', 'dpppp-dp-portfolio-posts-pro' ),
				'option_category' => 'basic_option',
				'type'            => 'text',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content',
				'description'     => __( 'Check which categories you would like to include in the layout', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'taxonomy_tags'         => array(
				'label'       => __( 'Include/Exclude Taxonomy', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'default'     => 'post_tag',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content',
				'description' => __( 'Here you can control which taxonomy the include/exclude tags apply to. Leave empty for posts. For other CPTs, enter the tag name above. For projects, the tag name is project_tag', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'include_tags'          => array(
				'label'       => __( 'Include Tags', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content',
				'description' => __( 'Enter a single tag slug or a comma separated list of tag slugs. All posts in the categories above AND WITH these tags will load. Leave empty if you only want to filter using the categories above.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'exclude_tags'          => array(
				'label'       => __( 'Exclude Tags', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content',
				'description' => __( 'Enter a single tag slug or a comma separated list of tag slugs. All posts in the categories above AND WITHOUT these tags will load. Leave empty if you only want to filter using the categories above.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			/*
			 * Elements
			 */
			'show_title'            => array(
				'label'           => __( 'Show Title', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Turn post titles on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_date'             => array(
				'label'           => __( 'Show Date', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Turn the date display on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'meta_date'             => array(
				'label'           => __( 'Meta Date Format', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array( 'show_date' => 'on' ),
				'default'         => 'M j, Y',
				'description'     => __( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_categories'       => array(
				'label'           => __( 'Show Categories', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'description'     => __( 'Turn the category links on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_terms_taxonomy'   => array(
				'label'           => __( 'Category Taxonomy', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'category',
				'show_if'         => array( 'show_categories' => 'on' ),
				'description'     => __( 'Show terms of specific taxonomies.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'custom_fields'         => array(
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
			'custom_field_names'    => array(
				'label'       => __( 'Custom Field Names', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'show_if'     => array( 'custom_fields' => 'on' ),
				'description' => __( 'Enter a single custom field name or a comma separated list of names.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'custom_field_labels'   => array(
				'label'       => __( 'Custom Field Labels', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'show_if'     => array( 'custom_fields' => 'on' ),
				'description' => __( 'Enter custom field label (including separator and spaces) or a comma separated list of labels in the same order as the names above. The number of labels must equal the number of names above, otherwise the name above will be used as the label for each custom field. For more information, see demo at <a href="http://www.diviplugins.com/portfolio-posts-pro-plugin/">Divi Plugins</a>', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'show_date'             => array(
				'label'           => __( 'Show Date', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Turn the date display on or off.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'meta_date'             => array(
				'label'           => __( 'Meta Date Format', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array( 'show_date' => 'on' ),
				'default'         => 'M j, Y',
				'description'     => __( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_excerpt'          => array(
				'label'           => __( 'Show Excerpt', 'dpppp-dp-portfolio-posts-pro' ),
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
			'excerpt_limit'         => array(
				'label'       => __( 'Excerpt Limit', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'show_if'     => array( 'show_excerpt' => 'on' ),
				'default'     => 140,
				'description' => __( 'Enter number of characters to limit excerpt.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'truncate_excerpt'      => array(
				'label'           => __( 'Limit Manually Added Excerpts', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'show_if'         => array(
					'show_excerpt' => 'on'
				),
				'default'         => 'off',
				'description'     => __( 'Turn on to limit manually added excerpts to the number of characters entered above. Leave this option off to display the full excerpts for posts that have an excerpt defined.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'strip_html'            => array(
				'label'           => __( 'Strip HTML', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'show_if'         => array(
					'show_excerpt' => 'on'
				),
				'default'         => 'on',
				'description'     => __( 'Remove HTML tags from excerpt. Turning this option off can break the grid layout if the excerpt is truncated in the middle of an HTML tag.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'elements',
			),
			'show_custom_content'   => array(
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
			'custom_url'            => array(
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
			'custom_url_field_name' => array(
				'label'       => __( 'Custom Field for URL', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'text',
				'show_if'     => array( 'custom_url' => 'on' ),
				'description' => __( 'Enter custom field name (NOT the URL). The URL value needs to be set in each post using the custom field you input here. If no value is set, defaults to post URL.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'elements',
			),
			'url_new_window'        => array(
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
			 * Thumbnail Actions
			 */
			'lightbox'              => array(
				'label'       => __( 'Open Image in Lightbox', 'dpppp-dp-portfolio-posts-pro' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'     => 'off',
				'description' => __( 'Image opens in lightbox instead of opening blog post.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'thumb_action',
			),
			'lightbox_gallery'      => array(
				'label'           => __( 'Lightbox Gallery', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'show_if'         => array( 'lightbox' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'thumb_action',
				'description'     => __( 'Turn this option on if you want the lightbox to display all images from the items in a gallery. Leave this option off if you only want the clicked image to display in the lightbox.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'popup'                 => array(
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
			'gallery_cf'            => array(
				'label'           => __( 'Open Custom Lightbox Gallery', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'thumb_action',
				'description'     => __( 'Turn this option on to display a custom lightbox gallery of images when the featured image is clicked. Enter the custom field name below containing the image or array of images to load for each post. You can also provide an image or array of images using the <a href="https://diviplugins.com/documentation/portfolio-posts-pro/custom-lightbox/">Custom Lightbox filter</a>.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			'gallery_cf_name'       => array(
				'label'           => __( 'Custom Field Name for Images', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'No', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'Yes', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => '',
				'show_if'         => array( 'gallery_cf' => 'on' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'thumb_action',
				'description'     => __( 'Enter the custom field name containing the image or array of images you would like to load in the custom lightbox gallery. Leave this empty to use the <a href="https://diviplugins.com/documentation/portfolio-posts-pro/custom-lightbox/">Custom Lightbox filter</a>.', 'dpppp-dp-portfolio-posts-pro' ),
			),
			/*
			 * Layout
			 */
			'fullwidth'             => array(
				'label'           => __( 'Layout', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => __( 'Carousel', 'dpppp-dp-portfolio-posts-pro' ),
					'off' => __( 'Grid', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'description'     => __( 'Choose your desired portfolio layout style.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout',
			),
			'arrow_placement'       => array(
				'label'           => __( 'Arrow Placement', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'on'    => __( 'Default', 'dpppp-dp-portfolio-posts-pro' ),
					'top'   => __( 'Top', 'dpppp-dp-portfolio-posts-pro' ),
					'sides' => __( 'Push to left/right', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'show_if'         => array( 'fullwidth' => 'on' ),
				'description'     => __( 'Choose your desired location of left and right carousel arrows.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout',
			),
			'auto'                  => array(
				'label'           => __( 'Automatic Carousel Rotation', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => __( 'Off', 'dpppp-dp-portfolio-posts-pro' ),
					'on'  => __( 'On', 'dpppp-dp-portfolio-posts-pro' ),
				),
				'default'         => 'on',
				'show_if'         => array( 'fullwidth' => 'on' ),
				'description'     => __( 'If you the carousel layout option is chosen and you would like the carousel to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout',
			),
			'auto_speed'            => array(
				'label'           => __( 'Automatic Carousel Rotation Speed (in ms)', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'show_if'         => array( 'fullwidth' => 'on', 'auto' => 'on' ),
				'default'         => '7000',
				'description'     => __( "Here you can designate how fast the carousel rotates, if 'Automatic Carousel Rotation' option is enabled above. The higher the number the longer the pause between each rotation. (Ex. 1000 = 1 sec)", 'dpppp-dp-portfolio-posts-pro' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'layout',
			),
			'hover_icon'            => array(
				'label'           => __( 'Hover Icon Picker', 'dpppp-dp-portfolio-posts-pro' ),
				'type'            => 'select_icon',
				'option_category' => 'configuration',
				'class'           => array( 'et-pb-font-icon' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
			),
			/*
			 * Overlay
			 */
			'zoom_icon_color'       => array(
				'label'        => __( 'Zoom Icon Color', 'dpppp-dp-portfolio-posts-pro' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'overlay',
			),
			'hover_overlay_color'   => array(
				'label'        => __( 'Hover Overlay Color', 'dpppp-dp-portfolio-posts-pro' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'overlay',
			),
			/*
			 * Text
			 */
			'background_layout'     => array(
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
		);
	}

	public function before_render() {
		parent::before_render();
		wp_enqueue_script( "dp-portfolio-posts-pro-frontend-bundle" );
		wp_localize_script( "dp-portfolio-posts-pro-frontend-bundle", 'dp_ppp', array( 'dp_popup' => Dp_Portfolio_Posts_Pro_Utils::get_popup_container() ) );
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$props                   = $this->props;
		$props['content_length'] = 'excerpt';
		$module_class            = ET_Builder_Element::add_module_order_class( $this->props['module_class'], $render_slug );
		/*
		 * Set styles of overlay feature
		 */
		if ( '' !== $props['zoom_icon_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_overlay:before',
				'declaration' => sprintf( 'color: %1$s !important;', esc_html( $props['zoom_icon_color'] ) ),
			) );
		}
		if ( '' !== $props['hover_overlay_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_overlay',
				'declaration' => sprintf( 'background-color: %1$s;', esc_html( $props['hover_overlay_color'] ) ),
			) );
		}
		$data_icon      = '' !== $props['hover_icon'] ? sprintf( ' data-icon="%1$s"', esc_attr( et_pb_process_font_icon( $props['hover_icon'] ) ) ) : '';
		$overlay_output = sprintf( '<span class="et_overlay%1$s"%2$s></span>', ( '' !== $props['hover_icon'] ? ' et_pb_inline_icon' : '' ), $data_icon );
		$gallery_images = 0;
		/*
		 * Init module output
		 */
		ob_start();
		$posts_data = Dp_Portfolio_Posts_Pro_Utils::get_posts_data( $props, 'full' );
		if ( ! isset( $posts_data['no_results'] ) ) {
			foreach ( $posts_data['posts'] as $post_data ) {
				/*
				 * Init blog portfolio item div
				 */
				echo sprintf( '<div id="post-%1$s" class="%2$s">', $post_data['post_id'], $post_data['classes'] );
				/*
				 * Link Start
				 */
				echo sprintf( '<div class="et_pb_portfolio_image %1$s%2$s">', esc_attr( $posts_data['orientation'] ), ( 'on' === $props['show_excerpt'] ) ? ' show_excerpt' : '' );
				if ( $props['lightbox'] === 'on' ) {
					echo sprintf( '<a href="%1$s" class="dp_ppp_lightbox_image">', isset( $post_data['thumbnail_image_original'] ) ? $post_data['thumbnail_image_original'] : '_self' );
				} else if ( $props['popup'] === 'on' ) {
					echo sprintf( '<a href="" class="et_pb_lightbox_post_popup" data-rel="%1$s" data-showtitle="%2$s" data-showdate="%3$s" data-ajaxurl="%4$s">', $post_data['post_id'], $props['show_title'], $props['show_date'], $post_data['ajax_url'] );
				} else if ( $props['gallery_cf'] === "on" ) {
					if ( count( $post_data['cf_lightbox_data'] ) > 0 ) {
						echo sprintf( '<a href="#" class="dp_ppp_gallery_cf" data-images="%1$s">', implode( "||", $post_data['cf_lightbox_data'] ) );
					}
				} else {
					echo sprintf( '<a href="%1$s" %2$s>', $post_data['post_url'], $posts_data['post_open_tab'] );
				}
				/*
				 * Thumbnail
				 */
				if ( isset( $post_data['thumbnail_image'] ) ) {
					echo sprintf( '<img class="dp_ppp_post_thumb" src="%1$s" alt="%2$s" data-lightbox-gallery="%3$s" data-gallery-image="%4$s">', $post_data['thumbnail_image'], $post_data['title'], ( $props['lightbox_gallery'] === 'on' ) ? 'on' : 'off', $gallery_images ++ );
				}
				/*
				 * Post Meta
				 */
				echo '<div class="meta">';
				echo $overlay_output;
				/*
				 * Show post title
				 */
				if ( 'on' === $props['show_title'] ) {
					echo sprintf( '<h3>%1$s</h3>', $post_data['title'] );
				}
				/*
				 * Show post meta
				 */
				if ( $props['show_date'] === 'on' || $props['show_categories'] === "on" ) {
					$separator = ( $props['show_date'] === 'on' && $props['show_categories'] === "on" ) ? " | " : "";
					if ( $props['show_categories'] === "on" ) {
						$categories = $post_data['term_list_clean'];
					} else {
						$categories = "";
					}
					if ( $props['show_date'] === 'on' ) {
						$date = $post_data['date'];
					} else {
						$date = "";
					}
					echo sprintf( '<p class="post-meta">%1$s%2$s%3$s</p>', $date, $separator, $categories );
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
				 * Show excerpt
				 */
				if ( 'on' === $props['show_excerpt'] ) {
					echo sprintf( '<p class="dp-post-excerpt">%1$s</p>', $post_data['excerpt'] );
				}
				/*
				 * Custom content
				 */
				if ( $props['show_custom_content'] === 'on' ) {
					echo apply_filters( 'dp_ppp_custom_content', "", $props );
				}
				echo '</div>';
				echo '</a>';
				echo '</div>';
				echo '</div>';
			}
		} else {
			echo sprintf( '<div class="et_pb_row et_pb_no_results">%1$s</div>', $posts_data['no_results'] );
		}
		wp_reset_postdata();
		/*
		 * Get posts output and clean buffer
		 */
		$posts_output = ob_get_clean();
		/*
		 * Module classes
		 */
		$this->add_classname(
			array(
				"dp_ppp_module",
				"et_pb_fullwidth_portfolio",
				( $props['fullwidth'] === 'on' ? 'et_pb_fullwidth_portfolio_carousel' : 'et_pb_fullwidth_portfolio_grid clearfix' ),
				( $props['arrow_placement'] !== 'on' ? ( $props['arrow_placement'] === 'top' ? ' carousel_arrow_top ' : ' carousel_arrow_sides ' ) : '' ),
				"et_pb_bg_layout_{$props['background_layout']}",
				$this->get_text_orientation_classname()
			)
		);
		/*
		 * Module output
		 */
		$output = sprintf( '%2$s<div class="et_pb_portfolio_items clearfix" data-portfolio-columns="" data-auto-rotate="%3$s" data-auto-rotate-speed="%4$s">%1$s</div></div>',
			$posts_output,
			( '' !== $props['title'] ? sprintf( '<h2>%s</h2>', esc_html( $props['title'] ) ) : '' ),
			esc_attr( $props['auto'] ),
			( '' !== $props['auto_speed'] && is_numeric( $props['auto_speed'] ) ? esc_attr( $props['auto_speed'] ) : '7000' ) );

		return $this->_render_module_wrapper( $output, $render_slug );
	}

}

new ET_Builder_Module_DP_Fullwidth_Blog;
