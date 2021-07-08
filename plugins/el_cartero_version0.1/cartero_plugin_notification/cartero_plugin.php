<?php
/*
Plugin Name: Cartero Plugin Notification v0.1
Plugin URI: http://www.theninjabunny.com
Description: Da porculo a la gente cada vez que vomites un post
Author: theNinjaBunny ( www.theNinjaBunny.com ) & Daniel Semper ( www.vectorice.com )
Version: 0.1

*/ 





if(!isset($wpdb->posts)) {
   $wpdb->posts               = $table_prefix . 'posts';
   $wpdb->postmeta            = $table_prefix . 'postmeta';
   $wpdb->users               = $table_prefix . 'users';
  }

if(!isset($wpdb->email_list)) {
   $wpdb->email_list          = 'wp_email_list';
  }	



add_action('admin_menu', 'cartero_admin_menu');
function cartero_admin_menu() {
	 add_submenu_page('options-general.php', 'Cartero 2.0', 'Cartero 2.0', 8, 'cartero_plugin_notification/index.php');
}


add_action('edit_form_advanced', 'cartero_notify');
add_action('simple_edit_form', 'cartero_notify');
add_action('edit_page_form', 'cartero_notify');
function cartero_notify($notify) {
	include (ABSPATH."maillist/cartero_conf.php");  
include (ABSPATH."maillist/cartero_language.php");
	$pull_config = "SELECT default_send FROM `cartero_conf` WHERE id = '1'";
	$pull_config_result = mysql_query($pull_config);
	
	if (!$pull_config_result) { exit;	}
	if (mysql_num_rows($pull_config_result) == 0) { exit; }	
	
	while ($row = mysql_fetch_assoc($pull_config_result)) {
	
		$default_send = $row['default_send'];		
		
		switch($default_send){
			case "No":
				$sendN = "selected=\"selected\"";
				break;
			case "Yes":
				$sendY = "selected=\"selected\"";
				break;
			}	



		print "
		<fieldset id=\"email_notification\">
			<legend>$cro_notify_subscribers</legend> 
			<div>
				<select id=\"cro_notify\" name=\"cro_notify\" value=\"$default_send\" />
					<option $sendY>$cro_yes</option>
					<option $sendN>$cro_no</option>
				</select>
			</div>
		</fieldset>
		";			
	}
	
return $notify;
}

add_action('publish_post', 'cartero_send_post', 5);
function cartero_send_post($post_ID)  {
	include (ABSPATH."maillist/cartero_conf.php");  
include (ABSPATH."maillist/cartero_language.php");
	$sql = "SELECT * FROM `cartero_conf` WHERE id = '1'";
	$result = mysql_query($sql) or print mysql_error();
	$row = mysql_fetch_assoc($result);
		$from_email = $row['from_email'];
		$admin_email = $row['admin_email'];
		$show_content = $row['show_content'];
		$html_email = $row['html_email'];
		$html_template = ABSPATH."/wp-content/plugins/cartero_plugin_notification/email_template.html";
	

      $site_name = $row['site_name'];
      $site_url = $row['site_url'];
      $blog_url = $row['blog_url'];


      global $wpdb, $table_prefix;
      
      $wpdb->email_list_future = 'cartero_future';//$table_prefix . 'cartero_future';      
      $notify = $_POST['cro_notify'];


	$prev_status = $_POST['prev_status'];
	$post_status = $_POST['post_status'];

	if (isset($_POST['publish'])) $post_status = 'publish';

	if ($prev_status != 'publish' && $post_status == 'publish' && $notify == $cro_yes) {

			# Grab post date info
			$post_year = $_POST['aa'];
			$post_month = $_POST['mm'];
			$post_day = $_POST['jj'];
			$post_hour = $_POST['hh'];
			$post_minute = $_POST['mn'];

			# Add leading zeros to month
			if ($post_month == "1") { $post_month = "01"; }
			if ($post_month == "2") { $post_month = "02"; }
			if ($post_month == "3") { $post_month = "03"; }
			if ($post_month == "4") { $post_month = "04"; }
			if ($post_month == "5") { $post_month = "05"; }
			if ($post_month == "6") { $post_month = "06"; }
			if ($post_month == "7") { $post_month = "07"; }
			if ($post_month == "8") { $post_month = "08"; }
			if ($post_month == "9") { $post_month = "09"; }

			# Date diff calculation
			$post_date = "$post_year$post_month$post_day$post_hour$post_minute";
			$curr_date = date("YmdHi");

			$date_diff = $curr_date - $post_date + $cro_diff_date;
	
			# If post is future dated
	    if ($date_diff < 0){
	    	
	    	# Check for existing post
	    	$check_existing  = "SELECT post_ID ";
	    	$check_existing .= "FROM $wpdb->email_list_future ";
	    	$check_existing .= "WHERE post_ID = '$post_ID'";
	    	$check_existing_result = mysql_query($check_existing);
	    	$check_existing_nrows = mysql_num_rows($check_existing_result);
				
				# If it's an update
				if ($check_existing_nrows > 0) {
					$update_future  = "UPDATE `cartero_future` ";
					$update_future .= "SET ";
					$update_future .= "post_date = '$post_date' ";
					$update_future .= "WHERE post_ID = '$post_ID'";
					$update_future_result = mysql_query($update_future);		
				} 
				
				else {	
	    		# If it's a new record
					$insert_future = "INSERT INTO `cartero_future` (post_ID, post_date, notification_sent) VALUES ('$post_ID', '$post_date', 'n')";		
					$insert_future_result = mysql_query($insert_future);
				}
				
	    } 
	    
	    # Not future dated so mail it
	    else {	    
	    
	    //--------------------------------------------------------//
	    //               SELECT POSTS FROM WP FUNCTIONS
	    //--------------------------------------------------------//
	    
			$posts = & query_posts("p=$post_ID");			
			the_post();
			
			$post_content = get_the_content();
			$post_title = get_the_title();
			$post_author = get_the_author();
			
			cartero_manager($post_ID,$post_title,$post_content,$post_author,$post_date);
		};
	}
}



add_action('publish_post', 'cartero_future_send_post');
function cartero_future_send_post()  {
	include (ABSPATH."maillist/cartero_conf.php");  
include (ABSPATH."maillist/cartero_language.php");
  # Set Globals
  global $wpdb, $table_prefix;  
  $wpdb->email_list_future = $table_prefix . 'email_list_future';
  $wpdb->posts = $table_prefix . 'posts';
	
	# Date diff calculation
	$curr_date = date("YmdHi");
	
	# Check the DB for posts that need to be sent
	$check_existing  = "SELECT * ";
	$check_existing .= "FROM `cartero_future` ";
//	$check_existing .= "WHERE post_date < '$curr_date' ";
//	$check_existing .= "AND notification_sent = 'n' ";
	$check_existing .= "WHERE notificaction_sent = 'n' ";
	$check_existing_result = mysql_query($check_existing);
	$check_existing_nrows = mysql_num_rows($check_existing_result);	
	
	# Don't process unless there are entries that need to be e-mailed
	while ($future_row = mysql_fetch_assoc($check_existing_result)) {		
		
		$send_post_ID = $future_row['post_ID'];

		# GET CONFIG INFO #		
		$query_config = "select * from `cartero_conf` where id = '1'";
		$res_config = mysql_query($query_config) or print mysql_error();
		$config_row = mysql_fetch_assoc($res_config);
	
		$from_email = $config_row['from_email'];
		$admin_email = $config_row['admin_email'];
		$show_content = $config_row['show_content'];
		$html_email = $config_row['html_email'];
		$html_template = ABSPATH."/wp-content/plugins/cartero_plugin_notification/email_template.html";
	
	  # Site Information
	  $site_name = $config_row['site_name'];
	  $site_url = $config_row['site_url'];
	  $blog_url = $config_row['blog_url'];		
	
		# Select the post from the DB
		$select_post  = "SELECT * ";
		$select_post .= "FROM $wpdb->posts ";
		$select_post .= "WHERE ID = '$send_post_ID' ";
		$select_post_result = mysql_query($select_post);
	
		# Grab the post...
		while ($post_row = mysql_fetch_assoc($select_post_result)) {
			$post_url = $post_row[guid];
			$post_content = $post_row[post_content];
			$post_content_filtered = $post_row[post_content_filtered];						
			$post_title = $post_row[post_title];	
			$post_author = $post_row[post_author];	
	
			$post_time = $post_row[post_date];			
			$string_date = strtotime("$post_time");
			cartero_manager($post_ID,$post_title,$post_content,$post_author,$post_time);
		};
	};
}



function cartero_manager($post_ID,$post_title,$post_content,$post_author,$post_date) {

//include (ABSPATH."maillist/cartero_conf.php");  
//include (ABSPATH."maillist/cartero_language.php");



$query_config = "select * from `cartero_conf` where id = '1'";
		$res_config = mysql_query($query_config) or print mysql_error();
		$config_row = mysql_fetch_assoc($res_config);
	
		$from_email = $config_row['from_email'];
		$admin_email = $config_row['admin_email'];
		$show_content = $config_row['show_content'];
		$fullpost = $show_content;
		$html_email = $config_row['html_email'];
		$html_template = ABSPATH."/wp-content/plugins/cartero_plugin_notification/email_template.html";
	
	  # Site Information
	  $site_name = $config_row['site_name'];
	  $site_url = $config_row['site_url'];
	  $blog_url = $config_row['blog_url'];		

	include (ABSPATH."maillist/cartero_conf.php");  
include (ABSPATH."maillist/cartero_language.php");

	    $post_content = stripslashes($post_content);
      $post_content = str_replace(array("â€œ","â€?","â€™","â€“","â€”","â€¦","&nbsp;"), array('"','"','´','–','—','...',' '), $post_content);
      $post_content = utf8_decode($post_content);			
			
			$post_filtered = apply_filters('the_content', $post_content);
			$post_filtered = str_replace(']]>', ']]&gt;', $post_filtered);
			
			$post_title = stripslashes($post_title);
      $post_title = str_replace(array("â€œ","â€?","â€™","â€“","â€”","â€¦"), array('"','"','´','–','—','...'), $post_title);
      $post_title = utf8_decode($post_title);			
			
			$post_time = get_the_time( ' F jS, Y' );
	  
			// Replace entities
      if ($html_email != 'Yes'){
        $post_content = str_replace(array("<ul>","</ul>","<ol>","</ol>","<li>","</li>"), array('','','','','* ',''), $post_content);
        $post_content = strip_tags($post_content);
        }
      
      else {
				$post_content = $post_content . "\n"; // just to make things a little easier, pad the end
				$post_content = preg_replace('|<br />\s*<br />|', "\n\n", $post_content);
				$post_content = preg_replace('!(<(?:table|ul|ol|li|pre|form|blockquote|h[1-6])[^>]*>)!', "\n$1", $post_content); // Space things out a little
				$post_content = preg_replace('!(</(?:table|ul|ol|li|pre|form|blockquote|h[1-6])>)!', "$1\n", $post_content); // Space things out a little
				$post_content = preg_replace("/(\r\n|\r)/", "\n", $post_content); // cross-platform newlines
				$post_content = preg_replace("/\n\n+/", "\n\n", $post_content); // take care of duplicates
				$post_content = preg_replace('/\n?(.+?)(?:\n\s*\n|\z)/s', "\t<p>$1</p>\n", $post_content); // make paragraphs, including one at the end
				$post_content = preg_replace('|<p>\s*?</p>|', '', $post_content); // under certain strange conditions it could create a P of entirely whitespace
				$post_content = preg_replace("|<p>(<li.+?)</p>|", "$1", $post_content); // problem with nested lists
				$post_content = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $post_content);
				$post_content = str_replace('</blockquote></p>', '</p></blockquote>', $post_content);
				$post_content = preg_replace('!<p>\s*(</?(?:table|tr|td|th|div|ul|ol|li|pre|select|form|blockquote|p|h[1-6])[^>]*>)!', "$1", $post_content);
				$post_content = preg_replace('!(</?(?:table|tr|td|th|div|ul|ol|li|pre|select|form|blockquote|p|h[1-6])[^>]*>)\s*</p>!', "$1", $post_content);
				$post_content = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $post_content); // optionally make line breaks
				$post_content = preg_replace('!(</?(?:table|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|blockquote|p|h[1-6])[^>]*>)\s*<br />!', "$1", $post_content);
				$post_content = preg_replace('!<br />(\s*</?(?:p|li|div|th|pre|td|ul|ol)>)!', '$1', $post_content);
				$post_content = preg_replace('/&([^#])(?![a-z]{1,8};)/', '&#038;$1', $post_content);
      	}

	    //--------------------------------------------------------//
	    //                      BUILD URL
	    //--------------------------------------------------------//

	    $url = get_permalink($post_ID);


				if ($html_email == 'Yes'){
					
					$msg = ""; // initialize variable
					
					if ($html_template != "" ) {
						$msg = file_get_contents($html_template);
						}
					if($fullpost!="Yes") {
						$post_filtered = substr ($post_filtered, 0,215).''.$cro_read_more; 
						$post_filtered = str_replace('@@permalink',$url,$post_filtered);
					};

					$msg = str_replace('@@title',$post_title,$msg);
					$msg = str_replace('@@site',$site_name,$msg);
					$msg = str_replace('@@permalink',$url,$msg);
					$msg = str_replace('@@content',$post_filtered,$msg);
					$msg = str_replace('@@author',$post_author,$msg);
					$msg = str_replace('@@time',$post_time,$msg);
					$msg = str_replace('@@date',$post_date,$msg);
							
				
					$msg = str_replace('@@subscriptionDetails',$cro_email_html_signature,$msg);
					}

        //--------------------------------------------------------//
        //                 TEXT VERSION OF MESSAGE
        //--------------------------------------------------------//

        else {
					
  	        }

        //--------------------------------------------------------//
        //                     EMAIL HEADER
        //--------------------------------------------------------//
            $header  = "MIME-Version: 1.0\r\n";

            if ($html_email == 'Yes'){
             $header .= "Content-Type: text/html; charset=\"" . get_settings('blog_charset') . "\"\r\n";
              }

            else {
              $header .= "Content-Type: text/plain; charset=\"" . get_settings('blog_charset') . "\"\r\n";
              }

  					$header .= "From: \"$site_name\" <$from_email>\n";
            $header .= "Reply-To: $from_email\n";
            $header .= "Return-Path: $from_email\n";

        //--------------------------------------------------------//
        //                        SUBJECT
        //--------------------------------------------------------//
  					if ($post_title != ''){
              $subject = "$site_name: $post_title";
              }

  					else {
  					  $subject = "$site_name: ".$cro_new_entry;
  						}

	    //--------------------------------------------------------//
	    //             SELECT USERS TO EMAIL FROM DB
	    //--------------------------------------------------------//

	    $query = "SELECT mail,confi FROM `cartero_list` WHERE activa = 1";
	    $res = mysql_query($query);
				
			// Mail it
	    while ($row = mysql_fetch_assoc($res)) {
	      $addr = $row['mail'];
	      $shoebox = $row['confi'];
				$msgFinal = str_replace('@@to_addr',$addr,$msg);
				$msgFinal = str_replace('@@shoebox',$shoebox,$msgFinal);
				Mail($addr, $subject, $msgFinal, $header);
	    	}

    return $post_ID;  // It may be buggy otherwise.
   	
  
};







//add_action('publish_post', 'email_notification_future_send');

?>
