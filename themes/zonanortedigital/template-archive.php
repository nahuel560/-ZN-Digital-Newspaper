<?php
/**
 * Template Name: Archive Page
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


add_action( 'TieLabs/after_post_content', 'tie_template_archive', 4 );

TIELABS_HELPER::get_template_part( 'page' );
