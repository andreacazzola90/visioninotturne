<?php
/*
  Template Name:DP Popup
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
	<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<?php wp_head(); ?>
</head>

<?php $is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() ); ?>
<body <?php body_class();
if ( function_exists( 'et_theme_builder_overrides_layout' ) ) {
	$override_body = et_theme_builder_overrides_layout( ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE );
} else {
	$override_body = true;
}
?>>
<div id="modal-content">
	<?php if ( ! $is_page_builder_used ) : ?>
    <div class="container">
        <div id="modal-content-area" class="clearfix">
            <div id="modal-left-area">
				<?php
				endif;
				while ( have_posts() ) :
					the_post();
					if ( $override_body ):
						$layouts = et_theme_builder_get_template_layouts();
						et_theme_builder_frontend_render_body(
							$layouts[ ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE ]['id'],
							$layouts[ ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE ]['enabled'],
							$layouts[ ET_THEME_BUILDER_TEMPLATE_POST_TYPE ]
						);
					else:
						?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if ( ! $is_page_builder_used ) : ?>
                                <h1 class="entry-title main_title"><?php the_title(); ?></h1>
								<?php
								$thumb     = '';
								$width     = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
								$height    = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
								$classtext = 'et_featured_image';
								$titletext = get_the_title();
								$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
								$thumb     = $thumbnail['thumb'];
								if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb ) {
									print_thumbnail( $thumb, $thumbnail['use_timthumb'], $titletext, $width, $height );
								}
								?>
							<?php endif; ?>
                            <div class="entry-content">
								<?php
								the_content();
								if ( ! $is_page_builder_used ) {
									wp_link_pages(
										array(
											'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ),
											'after'  => '</div>',
										)
									);
								}
								?>
                            </div> <!-- .entry-content -->
							<?php
							if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) {
								comments_template( '', true );
							}
							?>
                        </article> <!-- .et_pb_post -->
					<?php
					endif;
				endwhile; ?>
				<?php if ( ! $is_page_builder_used ) : ?>
            </div> <!-- #left-area -->
			<?php //get_sidebar(); ?>
        </div> <!-- #content-area -->
    </div> <!-- .container -->
<?php endif; ?>
</div> <!-- #main-content -->
<?php wp_footer(); ?>
</body>
</html>
