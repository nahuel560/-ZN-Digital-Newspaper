<?php
/**
 * Client class for front-end
 *
 * @package         wp-bannerize
 * @subpackage      wp-bannerize_client
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright © 2008-2011 Saidmade Srl
 *
 */

class WPBANNERIZE_FRONTEND extends WPBANNERIZE_CLASS {

    function WPBANNERIZE_FRONTEND() {
		// super
        $this->WPBANNERIZE_CLASS();

		// Load configurations options
        $this->options = get_option( $this->options_key );

		//wp_enqueue_script ( 'wp_bannerize_frontend_js' , $this->uri . '/js/wp_bannerize_frontend.js' , array ( 'jquery' ) , '1.4' , true );

		wp_localize_script ( 'wp_bannerize_frontend_js',
							 'wpBannerizeMainL10n',
								array (
								'ajaxURL' => $this->ajax_clickcounter
								) );

		// Add shortcode; @since 2.6.0
		add_shortcode( "wp-bannerize", array(&$this, "bannerize" ) );
    }

    /**
     * Show banner
     *
     * @return
     * @param object $args
     *
     * group                If '' show all group, else code of group (default '')
     * container_before		Main tag container open (default <ul>)
     * container_after		Main tag container close (default </ul>)
     * before               Before tag banner open (default <li %alt%>)
     * after                After tag banner close (default </li>)
     * random               Show random banner sequence (default '')
     * categories           Category ID separated by commas. (default '')
     * limit                Limit rows number (default '' - show all rows)
     *
     */
	function bannerize($args = '') {
		global $wpdb;

		$default = array(
			'group' => '',
			'randcutom' => '',
			'container_before' => '<ul>',
			'container_after' => '</ul>',
			'before' => '<li %alt%>',
			'after' => '</li>',
			'random' => '',
			'categories' => '',
			'alt_class' => 'alt',
			'link_class' => '',
			'limit' => ''
		);

		$new_args = wp_parse_args($args, $default);

		/**
		 * Check for categories
		 *
		 * @since 2.3.0
		 */
		if ($new_args['categories'] != "") {
			$cat_ids = explode(",", $new_args['categories']);
			if (!is_category($cat_ids) && !in_category($cat_ids) ) return;
		}
		
		

		$q = "SELECT * FROM `" . $this->table_bannerize . "` WHERE `trash` = '0' AND " .
			 "(`maximpressions` = 0 OR `impressions` < `maximpressions`) AND " .
			 "( (`start_date` < NOW() OR `start_date` = '0000-00-00 00:00:00' ) AND (`end_date` > NOW() OR `end_date` = '0000-00-00 00:00:00') ) ";

		if ($new_args['group'] != "") $q .= " AND `group` = '" . $new_args['group'] . "'";

		/**
		 * Add random option
		 *
		 * @since 2.0.2
		 */
		$q .= ($new_args['random'] == '') ? " ORDER BY `sorter` ASC" : "ORDER BY RAND()";

		/**
		 * Limit rows number
		 *
		 * @since 2.0.0
		 */
		if ($new_args['limit'] != "") $q .= " LIMIT 0," . $new_args['limit'];

		$rows = $wpdb->get_results($q);

		//guardo todos los ids
		
		if ($new_args['randcutom'] == 1 && $new_args['group'] == 1 ) {
			
			$ids = array(); $idstesitn = array();
			
			foreach ($rows as $rowa) {
				array_push ( $ids, $rowa->id );
				array_push ( $idstesitn, $rowa->id );
			}
			
			$num = array_rand($ids);
			
			$idfinal = (int)$ids[$num];
			
			unset($ids); $ids = array();
			
			foreach ($rows as $rowa) {
				//echo $rowa->id."-";
				if( $idfinal != $rowa->id  ){
					array_push ( $ids, $rowa->id );	
				}
				
			}


			//delete_option('idsbanners');			
			//die();
			
			if (!get_option("idsbanners")) {
				
				add_option('idsbanners',json_encode($ids));
				
			}else if ( empty(json_decode(get_option("idsbanners"))) ){
				//echo "asdasd";
				//echo $idfinal;
				//var_dump($ids);
				//die();
				
				update_option('idsbanners',json_encode($ids));
				//var_dump(  json_decode(get_option("idsbanners")) );
				//die();
			}else{
				unset($restantesLast);
				$restantesLast = array();
				
				$restantes = json_decode(get_option("idsbanners"));			
				
				$num = array_rand($restantes);
				
				$idfinal = $restantes[$num];
								
				foreach ($restantes as $re) {
					
					if( $idfinal != $re ){
						array_push ( $restantesLast, $re );	
					}
					
				}				

				delete_option('idsbanners');
				add_option('idsbanners',json_encode($restantesLast));
				
			}			
			
			
			//echo $idfinal;
			//var_dump($restantes);
			//var_dump($idstesitn);
			
			//die();			
			
			
			$qe = "SELECT * FROM `" . $this->table_bannerize . "` WHERE `trash` = '0' AND " .
				 "(`maximpressions` = 0 OR `impressions` < `maximpressions`) AND " .
				 "( (`start_date` < NOW() OR `start_date` = '0000-00-00 00:00:00' ) AND (`end_date` > NOW() OR `end_date` = '0000-00-00 00:00:00') ) ";

			$qe .= " AND `id` = '".$idfinal."' ";

			$rowsq = $wpdb->get_results($qe);


			//var_dump($rowsq);die();

			//echo $idfinal;	
			
			if(count($rowsq) > 0) {
				$o = '<div class="wp_bannerize asdasdada">';
				if ($new_args['group'] != "") $o = sprintf( '<div class="bannerZND wp_bannerize_%s">', str_replace(" ", "_", $rowsq[0]->group) );
				$o .= $new_args['container_before'];
				
				if ($new_args['group'] == "3")
					$o .= "<ul class='owl-carousel owl-theme'>";

				$even_before = $odd_before = $alternate_class = "";
				$index = 0;

				$odd_before = str_replace("%alt%", "", $new_args['before']);
				$even_before = str_replace("%alt%", "", $new_args['before']);
				if ($new_args['alt_class'] != "") {
					$alternate_class = 'class="' . $new_args['alt_class'] . '"';
					$even_before = str_replace("%alt%", $alternate_class, $new_args['before']);
				}
				$new_link_class = ($new_args['link_class'] != "") ? ' class="' . $new_args['link_class'] . '"' : "";
				
				foreach ($rowsq as $row) {			
					
					
					// Impressions
					if($this->options['impressionsEnabled'] == "1") {
						$sql = "UPDATE `" . $this->table_bannerize. "` SET `impressions` = `impressions`+1 WHERE id = " . $row->id;
						$result = mysql_query($sql);
					}

					$target = ($row->target != "") ? 'target="' . $row->target . '"' : "";
					$o .= (($index % 2 == 0) ? $odd_before : $even_before);
					if($row->mime == "application/x-shockwave-flash") {
						// 2.7.0.5 - Thanks to Tihomir Lichev
						$flash = sprintf('<object data="%s" width="%s" height="%s" type="application/x-shockwave-flash">
						<param value="%s" name="movie" />
						<param value="%s" name="wmode" />
						</object>', $row->filename, $row->width, $row->height, $row->filename, $this->options['comboWindowModeFlash']);
						$o .= $flash;
					} else {
							$javascriptClickCounter = ( $this->options['clickCounterEnabled'] == '1') ? ' onclick="SMWPBannerizeJavascript.incrementClickCount(' . $row->id . ')" ' : '';
							$nofollow = ($row->nofollow == "1") ? ' rel="nofollow"' : "";
							
							if( $row->url != "" ){
								$o .= '<a' . $nofollow . $javascriptClickCounter . $new_link_class . ' ' . $target . ' href="' . $row->url . '">';
							}
							
							$o .= '<img alt="' . $row->description . '" src="'.$row->filename.'" />';
							
							if( $row->url != "" ){
								$o .='</a>';				
							}
						
						}

					if($row->use_description == "1") {
						if($this->options['linkDescription']) {
							$o .= '<br/><span class="description"><a' . $nofollow . $javascriptClickCounter . $new_link_class . ' ' . $target . ' href="' . $row->url . '">' . $row->description . '</a></span>';
						} else {
							$o .= '<br/><span class="description">'.$row->description.'</span>';
						}
					}
					$o .= $new_args['after'];
					$index++;
				}
				$o .= $new_args['container_after'];

				if($this->options['supportWPBannerize'] == "1") {
					$o .= '<a class="wp-bannerize-support" style="font-size:11px;text-align:center" href="http://www.saidmade.com/prodotti/wordpress/wp-bannerize/" target="_blank">Powered by WP Bannerize</a>';
				}

				$o .= '</div>';
				echo $o;
			}


			
		}else{
			

			if(count($rows) > 0) {
				$o = '<div class="wp_bannerize">';
				if ($new_args['group'] != "") $o = sprintf( '<div class="bannerZND wp_bannerize_%s">', str_replace(" ", "_", $rows[0]->group) );
				$o .= $new_args['container_before'];
				
				if ($new_args['group'] == "3")
					$o .= "<ul class='owl-carousel owl-theme'>";

				$even_before = $odd_before = $alternate_class = "";
				$index = 0;

				$odd_before = str_replace("%alt%", "", $new_args['before']);
				$even_before = str_replace("%alt%", "", $new_args['before']);
				if ($new_args['alt_class'] != "") {
					$alternate_class = 'class="' . $new_args['alt_class'] . '"';
					$even_before = str_replace("%alt%", $alternate_class, $new_args['before']);
				}
				$new_link_class = ($new_args['link_class'] != "") ? ' class="' . $new_args['link_class'] . '"' : "";
				
				foreach ($rows as $row) {			
					
					
					// Impressions
					if($this->options['impressionsEnabled'] == "1") {
						$sql = "UPDATE `" . $this->table_bannerize. "` SET `impressions` = `impressions`+1 WHERE id = " . $row->id;
						$result = mysql_query($sql);
					}

					$target = ($row->target != "") ? 'target="' . $row->target . '"' : "";
					$o .= (($index % 2 == 0) ? $odd_before : $even_before);
					if($row->mime == "application/x-shockwave-flash") {
						// 2.7.0.5 - Thanks to Tihomir Lichev
						$flash = sprintf('<object data="%s" width="%s" height="%s" type="application/x-shockwave-flash">
						<param value="%s" name="movie" />
						<param value="%s" name="wmode" />
						</object>', $row->filename, $row->width, $row->height, $row->filename, $this->options['comboWindowModeFlash']);
						$o .= $flash;
					} else {
							$javascriptClickCounter = ( $this->options['clickCounterEnabled'] == '1') ? ' onclick="SMWPBannerizeJavascript.incrementClickCount(' . $row->id . ')" ' : '';
							$nofollow = ($row->nofollow == "1") ? ' rel="nofollow"' : "";
							
							if( $row->url != "" ){
								$o .= '<a' . $nofollow . $javascriptClickCounter . $new_link_class . ' ' . $target . ' href="' . $row->url . '">';
							}
							
							$o .= '<img alt="' . $row->description . '" src="'.$row->filename.'" />';
							
							if( $row->url != "" ){
								$o .='</a>';				
							}
						
						}

					if($row->use_description == "1") {
						if($this->options['linkDescription']) {
							$o .= '<br/><span class="description"><a' . $nofollow . $javascriptClickCounter . $new_link_class . ' ' . $target . ' href="' . $row->url . '">' . $row->description . '</a></span>';
						} else {
							$o .= '<br/><span class="description">'.$row->description.'</span>';
						}
					}
					$o .= $new_args['after'];
					$index++;
				}
				$o .= $new_args['container_after'];

				if($this->options['supportWPBannerize'] == "1") {
					$o .= '<a class="wp-bannerize-support" style="font-size:11px;text-align:center" href="http://www.saidmade.com/prodotti/wordpress/wp-bannerize/" target="_blank">Powered by WP Bannerize</a>';
				}

				$o .= '</div>';
				echo $o;
			}
			
		}	
	}
} // end of class

?>