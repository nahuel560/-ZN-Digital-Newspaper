<?php
/**
 * Mega Menu Featured Post Layout
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-mega-menu-featured.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<div <?php tie_post_class( 'mega-recent-post' ) ?>>

	<?php

		if( has_post_thumbnail() ){ ?>

			<div class="post-thumbnail">
				<a class="post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

					<?php tie_post_format_icon( $media_icon ); ?>
					<?php tie_the_trending_icon( 'trending-lg' ); ?>
					<?php the_post_thumbnail( TIELABS_THEME_SLUG.'-image-post' ) ?>

				</a>
			</div><!-- .post-thumbnail /-->
			<?php
		}

		tie_the_post_meta();

	?>

	<h3 class="post-box-title">
		<a class="mega-menu-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h3>

</div><!-- mega-recent-post -->
