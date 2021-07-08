<?php
/**
 * The template for displaying author pages
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

	<div <?php tie_content_column_attr(); ?>>

		<?php if ( have_posts() ) : ?>

			<header class="entry-header-outer container-wrapper">
				<?php

					do_action( 'TieLabs/before_archive_title' );

					the_archive_title( '<h1 class="page-title">', '</h1>' );

					// Author bio
					if( tie_get_option( 'author_bio' ) ){
						tie_author_box();
					}

					do_action( 'TieLabs/after_archive_title' );
				?>
			</header><!-- .entry-header-outer /-->

			<?php

			// Get the layout template part
			TIELABS_HELPER::get_template_part( 'templates/archives', '', array(
				'layout'          => tie_get_option( 'author_layout', 'excerpt' ),
				'excerpt_length'  => tie_get_option( 'author_excerpt_length' ),
			));

			// Page Pagination
			TIELABS_PAGINATION::show( array( 'type' => tie_get_option( 'author_pagination' ) ) );

		// If no content, include the "No posts found" template
		else :
			TIELABS_HELPER::get_template_part( 'templates/not-found' );

		endif;

		?>

	</div><!-- .main-content /-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
