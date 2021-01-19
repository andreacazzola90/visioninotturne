<?php

class Dp_Portfolio_Posts_Pro_Utils {

	public static function ajax_get_posts_data() {
		$posts_data = array();
		if ( isset( $_POST['props'] ) && isset( $_POST['module'] ) ) {
			$props      = $_POST['props'];
			$module     = $_POST['module'];
			$posts_data = self::get_posts_data( $props, $module );
		} else {
			$posts_data['error'] = __( 'Missing module data on ajax request.', 'dpppp-dp-portfolio-posts-pro' );
		}
		echo json_encode( $posts_data );
		wp_die();
	}

	public static function get_posts_data( $props, $module ) {
		$posts_data = array();
		$query      = new WP_Query( self::get_query_arguments( $props, $module ) );
		if ( $query->have_posts() ) {
			switch ( $module ) {
				case 'blog':
					$pagination               = sprintf( '<div class="clearfix"></div>%1$s', self::dp_pagination( $props, intval( $query->max_num_pages ) ) );
					$posts_data['pagination'] = apply_filters( 'dp_ppp_blog_custom_pagination', $pagination, $props, $query );
					break;
				case 'filterable':
					$count_offset = 0;
					if ( $props['show_pagination'] === 'on' ) {
						$count_offset = $props['offset_number'];
					}
					$categories_with_post = array();
					$all_terms_found      = array();
					$post_categories      = array();
					if ( ! empty( $props['include_categories'] ) ) {
						foreach ( self::process_comma_separate_list( $props['include_categories'] ) as $value ) {
							$post_categories[] = $value;
						}
					}
					break;
				case 'full':
					$props['show_more']      = '';
					$props['show_more_text'] = '';
					break;
			}
			/*
			 * Turn off popup if lightbox active
			 */
			if ( $props['lightbox'] === "on" ) {
				$props['popup'] = "off";
			}
			/*
			 * Image size filters
			 */
			if ( $module === 'full' ) {
				$width           = 510;
				$height          = 382;
				$main_post_class = 'et_pb_portfolio_item et_pb_grid_item';
			} else {
				$wxh_size = $props['thumbnail_size'];
				if ( $wxh_size === ( "400x284" ) ) {
					//For backward compatibility
					$width  = ( $props['fullwidth'] === 'on' ) ? 1080 : 400;
					$height = ( $props['fullwidth'] === 'on' ) ? 9999 : 284;
				} else if ( $wxh_size === "dpp_full" ) {
					$width  = 9999;
					$height = 9999;
				} else {
					$wxh_size = explode( 'x', $wxh_size );
					$width    = $wxh_size[0];
					$height   = $wxh_size[1];
				}
				/*
				 * Main Post class
				 */
				if ( $props['fullwidth'] === 'on' ) {
					$main_class = '';
				} elseif ( $props['fullwidth'] === 'off' ) {
					$main_class = ' et_pb_grid_item';
				} else {
					$main_class = ' dp_portfolio_list_item';
				}
				$main_post_class = sprintf( 'et_pb_portfolio_item%1$s', $main_class );
			}
			$posts_data['width']       = (int) apply_filters( 'et_pb_portfolio_image_width', $width, $props );
			$posts_data['height']      = (int) apply_filters( 'et_pb_portfolio_image_height', $height, $props );
			$posts_data['orientation'] = ( $posts_data['height'] > $posts_data['width'] ) ? 'portrait' : 'landscape';
			/*
			 * URL Open Tab
			 */
			if ( $props['url_new_window'] === 'on' ) {
				$posts_data['post_open_tab'] = 'target="_blank"';
			} else {
				$posts_data['post_open_tab'] = "";
			}
			/*
			 * Query
			 */
			while ( $query->have_posts() ) {
				$query->the_post();
				if ( $module === 'filterable' && $count_offset > 0 ) {
					$count_offset --;
					continue;
				}
				$post_data            = array();
				$post_id              = get_the_ID();
				$post_data['post_id'] = $post_id;
				$post_data['title']   = get_the_title();
				$post_type            = get_post_type();
				$taxonomy_to_filter   = self::get_taxonomy_of_post_type( $post_type );
				if ( $module !== 'filterable' ) {
					$post_data['classes'] = implode( ' ', get_post_class( $main_post_class ) );
				} else {
					$category_classes = array();
					if ( ! empty( $post_categories ) ) {
						foreach ( $post_categories as $value ) {
							$term = get_term( $value );
							if ( has_term( $term->term_id, $term->taxonomy ) ) {
								$category_classes[]             = 'project_category_' . $term->term_id;
								$categories_with_post[ $value ] = array(
									'term_id' => $term->term_id,
									'name'    => $term->name,
									'slug'    => $term->slug
								);
							}
						}
					} else {
						$post_terms = wp_get_post_terms( $post_id, $taxonomy_to_filter );
						foreach ( $post_terms as $term ) {
							$category_classes[]                               = 'project_category_' . $term->term_id;
							$categories_with_post[ "" . $term->term_id . "" ] = array(
								'term_id' => $term->term_id,
								'name'    => $term->name,
								'slug'    => $term->slug
							);
							if ( ! in_array( $term->term_id, $all_terms_found ) ) {
								$all_terms_found[] = $term->term_id;
							}
						}
					}
					$category_classes     = array_merge( get_post_class( $main_post_class ), $category_classes );
					$post_data['classes'] = implode( ' ', $category_classes );
				}
				/*
				 * Thumbnail
				 */
				if ( has_post_thumbnail() ) {
					$post_data['thumbnail']                = true;
					$post_data['thumbnail_image']          = get_the_post_thumbnail_url( $post_id, array(
						$posts_data['width'],
						$posts_data['height']
					) );
					$post_data['thumbnail_image_original'] = get_the_post_thumbnail_url( $post_id, 'full-sized' );
				} else {
					$post_data['thumbnail'] = false;
				}
				/*
				 * Custom URL
				 */
				$post_data['post_url'] = get_the_permalink();
				if ( ( $props['custom_url'] === 'on' ) && ( $props['custom_url_field_name'] !== '' ) ) {
					$cf_url = get_post_meta( $post_id, $props['custom_url_field_name'], true );
					if ( $cf_url != '' ) {
						$post_data['post_url'] = $cf_url;
					}
				}
				/*
				 * Ajax URL
				 */
				if ( $props['popup'] === 'on' ) {
					$post_data['ajax_url'] = esc_url( add_query_arg( 'dp_action', 'popup_fetch', $post_data['post_url'] ) );
				} else {
					$post_data['ajax_url'] = "";
				}
				/*
				 * Custom lightbox gallery
				 */
				$custom_field_images = array();
				if ( $props['gallery_cf_name'] !== "" ) {
					$custom_field_images = get_post_meta( $post_id, $props['gallery_cf_name'] );
				}
				$post_data['cf_lightbox_data'] = apply_filters( 'dp_ppp_custom_lightbox', $custom_field_images, $props );
				/*
				 * Post Meta
				 */
				$post_data['author_link'] = et_pb_get_the_author_posts_link();
				$post_data['date']        = get_the_date( $props['meta_date'] );
				$show_terms_of_taxonomies = explode( ",", $props['show_terms_taxonomy'] );
				$post_data['term_list']   = "";
				foreach ( $show_terms_of_taxonomies as $tax ) {
					$terms_list = get_the_term_list( $post_id, $tax, "", ", " );
					if ( $terms_list && ! is_wp_error( $terms_list ) ) {
						$post_data['term_list'] .= $terms_list . ", ";
					}
				}
				if ( ! empty( $post_data['term_list'] ) ) {
					$post_data['term_list'] = substr( $post_data['term_list'], 0, strlen( $post_data['term_list'] ) - 2 );
				}
				$post_data['term_list_clean'] = wp_strip_all_tags( $post_data['term_list'] );
				$post_data['comments_count']  = sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'dpppp-dp-portfolio-posts-pro' ) ), number_format_i18n( get_comments_number() ) );
				/*
				 * Custom fields
				 */
				if ( ( $props['custom_fields'] === 'on' ) && isset( $props['custom_field_names'] ) && ( $props['custom_field_names'] != '' ) ) {
					$custom_fields_array = explode( ",", $props['custom_field_names'] );
					if ( isset( $props['custom_field_labels'] ) && $props['custom_field_labels'] != '' ) {
						$custom_fields_display = explode( ",", $props['custom_field_labels'] );
						if ( count( $custom_fields_array ) === count( $custom_fields_display ) ) {
							$post_data['post_custom_fields'] = self::get_keyed_custom_fields( $custom_fields_array, $custom_fields_display, $post_id, $props );
						} else {
							$post_data['post_custom_fields'] = self::get_custom_fields( $custom_fields_array, $post_id, $props );
						}
					} else {
						$post_data['post_custom_fields'] = self::get_custom_fields( $custom_fields_array, $post_id, $props );
					}
				} else {
					$post_data['post_custom_fields'] = array();
				}
				/*
				 * Excerpt
				 */
				$post_data['excerpt']   = self::get_the_excerpt_max_charlength( $props, $post_data['ajax_url'], $post_data['post_url'], $posts_data['post_open_tab'] );
				$post_data['read_more'] = self::get_read_more_link( $props, $post_data['ajax_url'], $post_data['post_url'], $posts_data['post_open_tab'] );
				/*
				 * Custom content
				 */
				$post_data['custom_content'] = apply_filters( 'dp_ppp_custom_content', "", $props );
				$posts_data['posts'][]       = $post_data;
			}
			if ( $module === 'filterable' ) {
				/*
				 * Filters
				 */
				$category_filters = '<ul class="clearfix">';
				$category_filters .= sprintf( '<li class="et_pb_portfolio_filter et_pb_portfolio_filter_all" %2$s><a href="#" class="active ppp_filterable_link" data-category-slug="all">%1$s</a></li>', ( $props['all_text'] !== "" ) ? $props['all_text'] : __( 'All', 'dpppp-dp-portfolio-posts-pro' ), ( $props['hide_all'] === 'on' ) ? 'style="display: none !important;"' : "" );
				if ( empty( $post_categories ) ) {
					$post_categories = $all_terms_found;
				}
				if ( $props['filters_sort'] === 'properties' && count( $categories_with_post ) > 1 ) {
					$terms_args['orderby'] = $props['filters_by'];
					if ( 'term_group' !== $props['filters_by'] ) {
						/*
						 * Ignore order define by plugin Category Order and Taxonomy Terms Order
						 * https://wordpress.org/plugins/taxonomy-terms-order/
						 */
						add_filter( 'to/get_terms_orderby/ignore', function () {
							return true;
						} );
						$terms_args['order'] = $props['filters_order'];
					}
					if ( is_array( $post_categories ) && ! empty( $post_categories ) ) {
						$terms_args['include'] = $post_categories;
					}
					foreach ( get_terms( $terms_args ) as $term ) {
						$terms_ordered[] = $term->term_id;
					}
					$post_categories = $terms_ordered;
				} else if ( $props['filters_sort'] === 'custom' && ! empty( $props['filters_custom'] ) ) {
					$custom_filters_tabs  = array();
					$filters_custom_array = explode( ',', $props['filters_custom'] );
					foreach ( $filters_custom_array as $value ) {
						foreach ( $categories_with_post as $cat ) {
							if ( trim( $value ) === $cat['name'] ) {
								$custom_filters_tabs[] = $cat['term_id'];
							}
						}
					}
					$post_categories = $custom_filters_tabs;
				}
				$categories_with_post = array_unique( $categories_with_post, SORT_REGULAR );
				if ( ! empty( $post_categories ) ) {
					foreach ( $post_categories as $value ) {
						if ( array_key_exists( $value, $categories_with_post ) ) {
							$category_filters .= sprintf( '<li class="et_pb_portfolio_filter"><a href="#" class="ppp_filterable_link" data-category-slug="%2$s" data-category-filter="%3$s" >%1$s</a></li>', esc_html( $categories_with_post[ $value ]['name'] ), $categories_with_post[ $value ]['term_id'], $categories_with_post[ $value ]['slug'] );
						}
					}
				}
				$category_filters      .= '</ul>';
				$posts_data['filters'] = $category_filters;
			}
		} else {
			ob_start();
			get_template_part( 'includes/no-results', 'index' );
			$posts_data['no_results'] = ob_get_clean();
		}
		wp_reset_postdata();

		return $posts_data;
	}

	public static function get_query_arguments( $props, $module ) {
		if ( $props['custom_query'] === 'on' ) {
			$args = apply_filters( 'dp_ppp_custom_query_args', array(
				'posts_per_page' => 12,
				'post_type'      => 'post',
				'post_status'    => 'publish'
			), $props );
		} else {
			/*
			 * Post type
			 */
			if ( ! empty( $props['custom_post_types'] ) ) {
				$args['post_type'] = self::process_comma_separate_list( $props['custom_post_types'] );
			}
			/*
			 * Post status
			 */
			if ( is_user_logged_in() ) {
				$args['post_status'] = array( 'publish', 'private' );
			} else {
				$args['post_status'] = array( 'publish' );
			}
			/*
			 * Order / Order by / Sticky Posts
			 */
			$args['order']   = $props['order'];
			$args['orderby'] = $props['orderby'];
			if ( $props['orderby'] === "meta_value" && $props['meta_key'] !== "" ) {
				$args['meta_key']  = $props['meta_key'];
				$args['meta_type'] = $props['meta_type'];
			}
			if ( 'on' === $props['sticky_posts'] ) {
				$args['ignore_sticky_posts'] = 1;
			}
			/*
			 * Taxonomy
			 */
			$tax_query = array();
			if ( ! empty( $props['include_categories'] ) ) {
				$taxonomies_terms = self::get_taxonomies_terms_array( self::process_comma_separate_list( $props['include_categories'] ) );
				foreach ( $taxonomies_terms as $tax => $terms ) {
					$tax_query[] = array(
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'IN'
					);
				}
				if ( count( $tax_query ) >= 2 ) {
					$tax_query['relation'] = 'OR';
				}
			}
			$taxonomy_tags = 'post_tag';
			if ( isset( $props['taxonomy_tags'] ) && taxonomy_exists( $props['taxonomy_tags'] ) ) {
				$taxonomy_tags = $props['taxonomy_tags'];
			}
			$tag_query = array();
			if ( ! empty( $props['include_tags'] ) ) {
				$tag_query[] = array(
					'taxonomy' => $taxonomy_tags,
					'field'    => 'term_id',
					'terms'    => explode( ',', $props['include_tags'] ),
					'operator' => 'IN'
				);
			}
			if ( ! empty( $props['exclude_tags'] ) ) {
				$tag_query[] = array(
					'taxonomy' => $taxonomy_tags,
					'field'    => 'term_id',
					'terms'    => explode( ',', $props['exclude_tags'] ),
					'operator' => 'NOT IN'
				);
			}
			if ( count( $tag_query ) >= 2 ) {
				$tag_query['relation'] = 'AND';
			}
			if ( ! empty( $tax_query ) && empty( $tag_query ) ) {
				$args['tax_query'] = $tax_query;
			} else if ( empty( $tax_query ) && ! empty( $tag_query ) ) {
				$args['tax_query'] = $tag_query;
			} else if ( ! empty( $tax_query ) && ! empty( $tag_query ) ) {
				$args['tax_query'][]           = $tax_query;
				$args['tax_query'][]           = $tag_query;
				$args['tax_query']['relation'] = 'AND';
			}
			/*
			 * Pagination / Post per page / Offset
			 */
			$args['posts_per_page'] = intval( $props['posts_number'] );
			if ( isset( $props['show_pagination'] ) && $props['show_pagination'] === 'on' ) {
				if ( $module === 'filterable' ) {
					$args['nopaging'] = true;
				}
				$paged         = self::get_current_page();
				$args['paged'] = $paged;
				if ( ! empty( $props['offset_number'] ) ) {
					$args['offset'] = ( $props['posts_number'] * ( $paged - 1 ) ) + intval( $props['offset_number'] );
				}
			} else {
				if ( ! empty( $props['offset_number'] ) ) {
					$args['offset'] = intval( $props['offset_number'] );
				}
			}
			/*
			 * Remove current post
			 */
			if ( $props['remove_current_post'] === 'on' && ( is_single() || is_singular( 'page' ) ) ) {
				$args['post__not_in'] = array( get_the_ID() );
			}
		}

		return $args;
	}

	public static function get_current_page() {
		$paged = 1;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		}

		return $paged;
	}

	public static function process_comma_separate_list( $list ) {
		$array = explode( ',', $list );
		if ( is_array( $array ) ) {
			foreach ( $array as $key => $value ) {
				$array[ $key ] = trim( $value );
			}
		}

		return $array;
	}

	public static function get_taxonomies_terms_array( $terms ) {
		$taxonomies_terms = array();
		foreach ( $terms as $term_id ) {
			$taxonomy = get_term( $term_id )->taxonomy;
			if ( ! isset( $taxonomies_terms[ $taxonomy ] ) ) {
				$taxonomies_terms[ $taxonomy ] = array();
				array_push( $taxonomies_terms[ $taxonomy ], $term_id );
			} else {
				array_push( $taxonomies_terms[ $taxonomy ], $term_id );
			}
		}

		return $taxonomies_terms;
	}

	public static function dp_pagination( $props, $pages ) {
		$paged     = self::get_current_page();
		$prev_link = "";
		$next_link = "";
		if ( $pages > 1 ) {
			if ( $paged === 1 ) {
				$next_link = sprintf( '<div class="nav-next"><a href="%1$s">%2$s</a></div>', get_pagenum_link( $paged + 1 ), $props['pagination_next_text'] );
			} else if ( $paged === $pages ) {
				$prev_link = sprintf( '<div class="nav-previous"><a href="%1$s">%2$s</a></div>', get_pagenum_link( $paged - 1 ), $props['pagination_older_text'] );
			} else {
				$prev_link = sprintf( '<div class="nav-previous"><a href="%1$s">%2$s</a></div>', get_pagenum_link( $paged - 1 ), $props['pagination_older_text'] );
				$next_link = sprintf( '<div class="nav-next"><a href="%1$s">%2$s</a></div>', get_pagenum_link( $paged + 1 ), $props['pagination_next_text'] );
			}

			return sprintf( '<nav class="navigation posts-navigation" role="navigation"><div class="nav-links">%1$s%2$s</div></nav>', $prev_link, $next_link );
		} else {
			return "";
		}
	}

	public static function get_taxonomy_of_post_type( $post_type ) {
		$hierarchical_taxonomy = '';
		foreach ( get_object_taxonomies( $post_type ) as $tax ) {
			if ( is_taxonomy_hierarchical( $tax ) ) {
				$hierarchical_taxonomy = $tax;
			}
		}

		return $hierarchical_taxonomy;
	}

	public static function get_keyed_custom_fields( $custom_fields_array, $custom_fields_display, $post_id, $props ) {
		foreach ( $custom_fields_array as $key => $field_value ) {
			$custom_field = trim( $field_value );
			if ( $custom_field !== "" ) {
				$post_custom_fields[] = self::get_cf_value( $custom_field, $post_id, $custom_fields_display[ $key ], $props );
			}
		}

		return $post_custom_fields;
	}

	public static function get_custom_fields( $custom_fields_array, $post_id, $props ) {
		foreach ( $custom_fields_array as $field_display ) {
			$custom_field  = trim( $field_display );
			$field_display = ucfirst( str_replace( '_', ' ', ltrim( $field_display ) ) );
			$field_display .= ' - ';
			if ( $custom_field !== "" ) {
				$post_custom_fields[] = self::get_cf_value( $custom_field, $post_id, $field_display, $props );
			}
		}

		return $post_custom_fields;
	}

	public static function get_cf_value( $custom_field, $post_id, $label, $props ) {
		$value = '';
		if ( class_exists( 'ACF' ) ) {
			$field_object = get_field_object( $custom_field );
			$field_value  = get_field( $custom_field, $post_id, true );
			if ( $field_object && $field_value ) {
				$type     = $field_object['type'];
				$r_format = isset( $field_object['return_format'] ) ? $field_object['return_format'] : false;
				switch ( $type ) {
					case 'select':
					case 'checkbox':
						$values = get_field( $custom_field, $post_id, true );
						if ( $r_format === 'array' && ! empty( $field_value ) ) {
							$options = array();
							foreach ( $values as $value ) {
								$options[] = $value['label'];
							}
							$value = implode( ', ', $options );
						} else {
							$value = implode( ', ', $field_value );
						}
						break;
					case 'image':
						if ( $r_format === 'array' ) {
							$value = sprintf( '<img src="%1$s">', $field_value['url'] );
						} elseif ( $field_object['return_format'] === 'id' ) {
							$value = sprintf( '<img src="%1$s">', wp_get_attachment_url( $field_value ) );
						} else {
							$value = sprintf( '<img src="%1$s">', $field_value );
						}
						break;
					case 'email':
						$value = sprintf( '<a href="mailto:%1$s">%1$s</a>', $field_value );
						break;
					case 'url':
						$value = sprintf( '<a href="%1$s">%1$s</a>', $field_value );
						break;
					default:
						if ( is_array( $field_value ) ) {
							$value = 'ACF field type unsupported';
						} else {
							$value = $field_value;
						}
						break;
				}
			}
		} else {
			$value = get_post_meta( $post_id, $custom_field, true );
		}

		return apply_filters( 'dp_ppp_custom_field_output', array(
			'label' => $label,
			'value' => $value
		), $custom_field, $props );
	}

	public static function get_the_excerpt_max_charlength( $props, $ajax_url, $post_url, $post_open_tab ) {
		$excerpt = apply_filters( 'dp_ppp_custom_excerpt', self::get_the_post_excerpt( $props ), $props );
		if ( $props['show_more'] === 'on' ) {
			$excerpt .= self::get_read_more_link( $props, $ajax_url, $post_url, $post_open_tab );
		}

		return $excerpt;
	}

	public static function get_read_more_link( $props, $ajax_url, $post_url, $post_open_tab ) {
		if ( ! empty( $ajax_url ) ) {
			$more_link = sprintf( ' <a href="" class="more-link et_pb_lightbox_post_popup" data-ajaxurl="%1$s" >%2$s</a>', $ajax_url, $props['show_more_text'] );
		} else {
			$more_link = sprintf( ' <a href="%1$s" class="more-link" %3$s>%2$s</a>', $post_url, $props['show_more_text'], $post_open_tab );
		}

		return $more_link;
	}

	public static function get_the_post_excerpt( $props ) {
		if ( 'off' === $props['show_excerpt'] ) {
			return '';
		} else {
			if ( 'excerpt' === $props['content_length'] ) {
				if ( has_excerpt() ) {
					if ( 'on' === $props['strip_html'] ) {
						$post_content = wp_strip_all_tags( get_the_excerpt() );
					} else {
						$post_content = get_the_excerpt();
					}
					if ( 'on' === $props['truncate_excerpt'] && intval( $props['excerpt_limit'] ) ) {
						return self::truncate_content( $post_content, $props['excerpt_limit'] );
					} else {
						return $post_content;
					}
				} else {
					if ( 'on' === $props['strip_html'] ) {
						$post_content = wp_strip_all_tags( get_the_content() );
					} else {
						$post_content = get_the_content();
					}
					if ( function_exists( 'et_builder_strip_dynamic_content' ) ) {
						$post_content = strip_shortcodes( et_builder_strip_dynamic_content( et_strip_shortcodes( $post_content ) ) );
					} else {
						$post_content = strip_shortcodes( et_strip_shortcodes( $post_content ) );
					}
					if ( isset( $props['excerpt_limit'] ) && intval( $props['excerpt_limit'] ) ) {
						return self::truncate_content( $post_content, $props['excerpt_limit'] );
					} else {
						return $post_content;
					}
				}
			} else {
				return do_shortcode( get_the_content() );
			}
		}
	}

	public static function truncate_content( $excerpt, $excerpt_limit ) {
		$charlength = $excerpt_limit;
		$charlength ++;
		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				return mb_substr( $subex, 0, $excut ) . '...';
			} else {
				return $subex;
			}
		} else {
			return $excerpt;
		}
	}

	public static function get_popup_container() {
		$loader = apply_filters( 'dp_ppp_custom_loader', '<div class="et_pb_loader_img"><img src="' . DPPPP_URL . 'public/img/popup_loading.gif' . '" alt="loader"/></div>' );
		ob_start();
		?>
        <!-- Start Popup html -->
        <div class="modal_overlay dp_ppp_modal_overlay">
            <div class="modal dp_ppp_modal">
				<?php echo $loader; ?>
                <button class="pop_up_close_btn" type="button" title="Close (Esc)">
                    x
                </button>
                <div id="modal_inner" class="modal_inner">
                    <div class="modal_header"></div>
                    <iframe id="dp_iframe" class="dp_iframe"
                            onload="jQuery('.et_pb_loader_img').hide();"></iframe>
                    <div class="modal_footer"></div>
                </div>
            </div>
            <style>/* Start CSS for show post in popup */
                body.dp_popup_body {
                    position: fixed;
                    left: 0;
                    right: 0;
                }

                .dp_ppp_modal {
                    height: 80%;
                    left: 50%;
                    max-width: 850px;
                    position: fixed;
                    top: 50%;
                    width: 100%;
                    z-index: 100001;
                    transform: translate(-50%, -50%);
                    -webkit-transform: translate(-50%, -50%);
                    -moz-transform: translate(-50%, -50%);
                    -o-transform: translate(-50%, -50%);
                    -ms-transform: translate(-50%, -50%);
                    display: none;
                    background: #fff;
                    border-radius: 8px;
                    overflow-x: visible;
                }

                .dp_ppp_modal .modal_inner {
                    height: 100%;
                    padding-top: 35px;
                    padding-bottom: 10px;
                    overflow-y: hidden;
                }

                .dp_ppp_modal .modal_inner.ios {
                    position: fixed;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    top: 0;
                    -webkit-overflow-scrolling: touch;
                    overflow-y: scroll;
                }

                .dp_ppp_modal.active .modal_inner {
                    opacity: 1;
                }

                .dp_ppp_modal.modal_header {
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                    background: #fff;
                    padding: 10px 8px;
                    position: relative;
                }

                .dp_ppp_modal.modal_footer {
                    border-bottom-left-radius: 8px;
                    border-bottom-right-radius: 8px;
                    background: #fff;
                    padding: 10px 8px;
                }

                .dp_ppp_modal.modal_body {
                    background: #fff;
                    padding: 10px 8px;
                }

                .dp_ppp_modal#modal-content .container:before {
                    display: none;
                }

                #modal_inner iframe#dp_iframe {
                    width: 100%;
                    height: 100%;
                }

                .dp_ppp_modal_overlay {
                    width: 100%;
                    height: 100%;
                    position: fixed;
                    background: rgba(0, 0, 0, 0.6);
                    top: 0;
                    left: 0;
                    z-index: 100000;
                    display: none;
                }

                .dp_ppp_modal_overlay .pop_up_close_btn {
                    -moz-user-select: none;
                }

                .dp_ppp_modal_overlay .pop_up_close_btn {
                    color: black;
                    font-family: Arial, Baskerville, monospace;
                    font-size: 28px;
                    font-style: normal;
                    height: 44px;
                    line-height: 44px;
                    opacity: 0.65;
                    padding: 0 0 18px 10px;
                    position: absolute;
                    right: 0;
                    text-align: center;
                    text-decoration: none;
                    top: 0;
                    width: 44px;
                }

                button.pop_up_close_btn {
                    background: transparent none repeat scroll 0 0;
                    border: 0 none;
                    box-shadow: none;
                    cursor: pointer;
                    display: block;
                    outline: medium none;
                    overflow: visible;
                    padding: 0;
                    z-index: 1046;
                }

                .et_pb_portfolio_item .pop_up_close_btn {
                    color: white;
                    padding-right: 6px;
                    right: -6px;
                    text-align: right;
                    width: 100%;
                }

                .et_pb_portfolio_item .pop_up_close_btn {
                    font-family: "Open Sans", Arial, sans-serif;
                    font-size: 64px;
                    font-weight: 200;
                    opacity: 0.2;
                    top: -45px;
                }

                .et_pb_portfolio_item .pop_up_close_btn:hover {
                    opacity: 1;
                }

                .et_pb_portfolio_item .pop_up_close_btn {
                    cursor: zoom-out;
                }

                .modal_footer .popup-post-content .et_pb_row {
                    width: 100%;
                }

                .modal_footer .popup-post-content p {
                    text-align: justify !important;
                }

                .et_pb_loader_img {
                    left: 50%;
                    max-width: 200px;
                    position: absolute;
                    top: 50%;
                    display: none;
                    transform: translateX(-50%) translateY(-50%);
                    -webkit-transform: translateX(-50%) translateY(-50%);
                    z-index: 1;
                    width: 128px;
                    height: 128px;
                }

                .modal_inner .modal_header img {
                    width: 100%;
                }

                .et_pb_fullwidth_portfolio .et_pb_portfolio_image .popup-post-content img {
                    max-width: 100%;
                    height: auto !important;
                }

                .popup_post_date {
                    text-align: left !important;
                }

                /* Ends CSS for show post in popup */</style>
        </div>
        <!-- Ends Popup html -->
		<?php
		return ob_get_clean();
	}

	public static function ajax_get_cpt() {
		$html_output = '<form id="dp-ppp-cpt-form">';
		$html_output .= sprintf( '<p>%1$s</p>', __( 'Select one or more post types below. Use CTRL or SHIFT to select multiple.', 'dpppp-dp-portfolio-posts-pro' ) );
		$html_output .= '<select class="dp-ppp-vb-select" name="dp-ppp-vb-select" multiple size="6">';
		foreach ( self::get_cpt() as $key => $cpt ) {
			$html_output .= sprintf( '<option value="%1$s">%2$s</option>', $key, $cpt );
		}
		$html_output .= '</select>';
		$html_output .= self::vb_modal_actions();
		$html_output .= '</form';
		echo $html_output;
		wp_die();
	}

	public static function get_cpt() {
		$options           = array();
		$default_post_type = apply_filters( 'dpppp_default_post_types', array( 'post' => get_post_type_object( 'post' ) ) );
		$post_types        = array_merge( $default_post_type, get_post_types( array(
			'_builtin' => false,
			'public'   => true
		), 'objects' ) );
		foreach ( $post_types as $pt ) {
			$options[ $pt->name ] = $pt->label;
		}

		return $options;
	}

	public static function vb_modal_actions() {
		$html_output = '<div class="dp-ppp-vb-actions">';
		$html_output .= sprintf( '<input class="dp-ppp-vb-submit" type="button" value="%1$s" />', __( 'Set Values', 'dpppp-dp-portfolio-posts-pro' ) );
		$html_output .= sprintf( '<input class="dp-ppp-vb-clean" type="button" value="%1$s" />', __( 'Clean Values', 'dpppp-dp-portfolio-posts-pro' ) );
		$html_output .= sprintf( '<input class="dp-ppp-vb-finish" type="button" value="%1$s" />', __( 'Exit', 'dpppp-dp-portfolio-posts-pro' ) );
		$html_output .= '</div>';

		return $html_output;
	}

	public static function ajax_get_taxonomies() {
		$cpt_array = array( 'post' );
		if ( isset( $_POST['cpt'] ) ) {
			if ( substr_count( $_POST['cpt'], ',' ) > 0 ) {
				$cpt_array = self::process_comma_separate_list( $_POST['cpt'] );
			} else {
				$cpt_array = array( $_POST['cpt'] );
			}
		}
		$html_output = '<form id="dp-ppp-tax-form">';
		$html_output .= sprintf( '<p>%1$s</p>', __( 'Select one or more taxonomies below. Use CTRL or SHIFT to select multiple.', 'dpppp-dp-portfolio-posts-pro' ) );
		$html_output .= '<select class="dp-ppp-vb-select" name="dp-ppp-vb-select" multiple size="6">';
		foreach ( self::get_taxonomies( $cpt_array ) as $key => $tax ) {
			$html_output .= sprintf( '<option value="%1$s">%2$s</option>', $key, $tax );
		}
		$html_output .= '</select>';
		$html_output .= self::vb_modal_actions();
		$html_output .= '</form';
		echo $html_output;
		wp_die();
	}

	public static function get_taxonomies( $cpt ) {
		$options                = array();
		$blacklisted_taxonomies = apply_filters( 'dpppp_blacklisted_taxonomies', array(
			'layout_category',
			'layout_pack',
			'layout_type',
			'scope',
			'module_width',
			'post_format'
		) );
		$taxonomies             = array_diff( get_taxonomies( array(
			'public'    => true,
			'query_var' => true
		) ), $blacklisted_taxonomies );
		if ( $cpt[0] === 'all' ) {
			foreach ( $taxonomies as $tax ) {
				$tax_obj         = get_taxonomy( $tax );
				$options[ $tax ] = $tax_obj->label;
			}
		} else {
			foreach ( $taxonomies as $tax ) {
				$tax_obj  = get_taxonomy( $tax );
				$is_there = array_intersect( $cpt, $tax_obj->object_type );
				if ( ! empty( $is_there ) ) {
					$options[ $tax ] = $tax_obj->label;
				}
			}
		}

		return $options;
	}

	public static function ajax_get_taxonomies_terms() {
		$tax_array = array( 'category' );
		if ( isset( $_POST['tax'] ) ) {
			if ( substr_count( $_POST['tax'], ',' ) > 0 ) {
				$tax_array = self::process_comma_separate_list( $_POST['tax'] );
			} else {
				$tax_array = array( $_POST['tax'] );
			}
		}
		$cpt_array = array( 'post' );
		if ( isset( $_POST['cpt'] ) ) {
			if ( substr_count( $_POST['cpt'], ',' ) > 0 ) {
				$cpt_array = self::process_comma_separate_list( $_POST['cpt'] );
			} else {
				$cpt_array = array( $_POST['cpt'] );
			}
		}
		$html_output = '<form id="dp-ppp-terms-form">';
		$html_output .= sprintf( '<p>%1$s</p>', __( 'Select one or more terms below. Use CTRL or SHIFT to select multiple.', 'dpppp-dp-portfolio-posts-pro' ) );
		$html_output .= '<select class="dp-ppp-vb-select" name="dp-ppp-vb-select" multiple size="12">';
		foreach ( self::get_taxonomies_terms( $tax_array, $cpt_array ) as $tax => $terms ) {
			$html_output .= '<optgroup label="' . esc_html( $tax ) . '">';
			$html_output .= self::show_taxonomy_hierarchy( '', $terms );
			$html_output .= '</optgroup>';
		}
		$html_output .= '</select>';
		$html_output .= self::vb_modal_actions();
		$html_output .= '</form>';
		echo $html_output;
		wp_die();
	}

	public static function show_taxonomy_hierarchy( $html_output, $terms, $level = 0 ) {
		foreach ( $terms as $term ) {
			$html_output .= sprintf( '<option value="%1$s">%3$s %2$s</option>', esc_html( $term->term_id ), esc_html( $term->name ) . ' (' . $term->count . ')', str_repeat( '-', $level ) );
			if ( ! empty( $term->children ) ) {
				$html_output .= self::show_taxonomy_hierarchy( '', $term->children, ( $level + 1 ) );
			}
		}

		return $html_output;
	}

	public static function get_taxonomy_hierarchy( $taxonomy, $parent = 0 ) {
		$terms    = get_terms( $taxonomy, array(
			'parent'     => $parent,
			'hide_empty' => false
		) );
		$children = array();
		foreach ( $terms as $term ) {
			$term->children             = self::get_taxonomy_hierarchy( $taxonomy, $term->term_id );
			$children[ $term->term_id ] = $term;
		}

		return $children;
	}

	public static function get_taxonomies_terms( $tax, $cpt ) {
		$options            = array();
		$all_cpt_taxonomies = self::get_taxonomies( $cpt );
		foreach ( $all_cpt_taxonomies as $tax_name => $tax_label ) {
			if ( 'all' === $tax[0] || in_array( $tax_name, $tax, true ) ) {
				$terms = self::get_taxonomy_hierarchy( $tax_name );
				if ( ! empty( $terms ) ) {
					$options[ $tax_label . ' (' . $tax_name . ')' ] = $terms;
				}
			}
		}

		return $options;
	}

	public static function get_registered_thumbnail_sizes() {
		$options = array();
		global $_wp_additional_image_sizes;
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array(
				'thumbnail',
				'medium',
				'medium_large',
				'large'
			) ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				);
			}
			$wxh_size             = $sizes[ $_size ]['width'] . "x" . $sizes[ $_size ]['height'];
			$options['dpp_full']  = __( "Original Image Uploaded", 'dpppp-dp-portfolio-posts-pro' );
			$options[ $wxh_size ] = "(" . $sizes[ $_size ]['width'] . "x" . $sizes[ $_size ]['height'] . ")";
		}

		return $options;
	}

	/**
	 * Register our custom action to request the builder function on ajax.
	 *
	 * @since  4.0
	 */
	public function add_our_custom_action( $actions ) {
		return array_merge( $actions, array( 'dpppp_get_posts_data_action' ) );
	}

	/**
	 * Enqueue and localize the script that handles the cpt, taxonomies and terms selection
	 *
	 * @since 4.0
	 */
	public static function enqueue_and_localize_cpt_modal_script() {
		wp_enqueue_style( 'dp-portfolio-posts-pro-admin-cpt-modal', DPPPP_URL . 'admin/css/dp-portfolio-posts-pro-admin.min.css', array(), DPPPP_VERSION, 'all' );
		wp_enqueue_script( 'dp-portfolio-posts-pro-admin-cpt-modal', DPPPP_URL . 'admin/js/dp-portfolio-posts-pro-admin.min.js', array(
			'jquery'
		), DPPPP_VERSION, true );
		wp_localize_script(
			'dp-portfolio-posts-pro-admin-cpt-modal',
			'dpppp',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
		);
	}

}
