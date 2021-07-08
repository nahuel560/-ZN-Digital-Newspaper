<?php
/**
 * Wrap for allow to call a simple function from Wordpress envirorment
 *
 * @package         wp-bannerize
 * @subpackage      wp-bannerize_functions
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright © 2008-2011 Saidmade Srl
 *
 */

/**
 * Comodity function for Show banner list
 * 
 * @return 
 * @param object $args[optional]
 * @see WPBANNERIZE_FRONTEND
 */
function wp_bannerize( $args = '' ) {
	global $wp_bannerize_frontend;
	$wp_bannerize_frontend->bannerize( $args );
}
?>