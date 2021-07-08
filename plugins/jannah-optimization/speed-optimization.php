<?php
/**
 * Plugin Name: Jannah Speed Optimization
 * Plugin URI: https://tielabs.com
 * Description: Improve your speed score on GTmetrix, Pingdom Tools and Google PageSpeed Insights.
 * Version: 0.2
 * Author: TieLabs
 * Author URI: https://tielabs.com
 * License: GPL2
 **/

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/**
 * Load files
 */
include_once('inc/general.php');
include_once('inc/resources.php');
include_once('inc/options.php');
include_once('inc/styles.php');
include_once('inc/cache.php');
include_once('inc/lazyload.php');
include_once('inc/html-compression.php');
