<?php
/**
 * Instagram Above Footer
 *
 * This template can be overridden by copying it to your-child-theme/templates/footers/footer-instagram.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   4.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( tie_get_option( 'footer_instagram' ) && ! TIELABS_HELPER::is_mobile_and_hidden( 'footer_instagram' )){

	$args = array(
		'username' => tie_get_option( 'footer_instagram_username' ),
		'userid'   => tie_get_option( 'footer_instagram_userid' ),
		'number'   => tie_get_option( 'footer_instagram_rows' ) == 2 ? 12 : 6,
		'link'     => tie_get_option( 'footer_instagram_media_link', 'file' ),
	);

	?>

	<div id="footer-instagram" class="footer-instagram-section">
		<?php
			if( tie_get_option( 'footer_instagram_button' )){
				echo '<a id="instagram-link" target="_blank" rel="nofollow noopener" href="'. esc_url( tie_get_option( 'footer_instagram_button_url' ) ) .'"><span class="fa fa-instagram" aria-hidden="true"></span> '. tie_get_option( 'footer_instagram_button_text' ) .'</a>';
			}

			new TIELABS_INSTAGRAM( $args );
		?>
	</div>

	<?php
}
