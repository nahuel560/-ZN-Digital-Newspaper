<?php
/**
 * Block / Archives Layout - Full Thumb
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-full-thumb.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  4.5.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<li <?php tie_post_class( 'post-item' ); ?>>

	<?php

		// Get the post thumbnail
		if ( has_post_thumbnail() && empty( $block['thumb_all'] ) ){

			$image_size = ! empty( $block['is_full'] ) ? 'full' : TIELABS_THEME_SLUG.'-image-post';
			tie_post_thumbnail( $image_size, 'large', true, true, $block['media_overlay'] );
		}

		// Get the Post Meta info
		if( ! empty( $block['post_meta'] )){
			tie_the_post_meta();
		}
	?>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>

	<?php

		if( ! empty( $block['excerpt'] )){ ?>
			<p class="post-excerpt"><?php tie_the_excerpt( $block['excerpt_length'] ) ?></p>
			<?php
		}

		if( ! empty( $block['read_more'] )){
			tie_the_more_button();
		}
	?>
</li>
