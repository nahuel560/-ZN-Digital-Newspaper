    <b><?php print $cro_send_title; ?></b>
    <br /><?php print $cro_send_desc; ?><br />

<?php
$act = $_GET['act'];
	if ($act!=1) {
?>
	<form method="post" action="options-general.php?page=cartero_plugin_notification/index.php&action=email_subscribers&act=1">


    <b><?php print $cro_subject; ?></b><br />
    <input name="subject" type="text" size="50" class="commentBox"><br /><br />

    <b><?php print $cro_message; ?></b><br />
    <textarea name="message" cols="50" rows="6" class="commentBox"></textarea>

    <br /><br />
    <?php print $cro_send_note; ?>
    <br /><br />
    
    <input type="submit" name="emailList" value="<?php print $cro_sumit; ?>" class="commentButton">
    <input type="reset" name="Reset" value="<?php print $cro_reset; ?>" class="commentButton">
    
	</form>
    
<?php

	}
	
	else {    
  $message = $_POST['message'];
  $subject = $_POST['subject'];
 
	
	$number = "0";
	
	$sql_config = "SELECT * FROM `cartero_conf` WHERE id = 1";
	$result_config = mysql_query($sql_config);
	
	if (!$result_config) {
	   print $cro_sql_error. mysql_error();
	   exit;
	}
	
	if (mysql_num_rows($result_config) == 0) {
	   print $cro_notfound;
	   exit;
	}

	while ($row_config = mysql_fetch_assoc($result_config)) {
			$site_name = $row_config['site_name'];
			$site_url = $row_config['site_url'];
			$blog_url = $row_config['blog_url'];
			$from_email = $row_config['from_email'];
		}
  

	$sql_email_list = "SELECT * FROM `cartero_list` WHERE activa = 1";	
	$result_email_list = mysql_query($sql_email_list);
	
	if (!$result_email_list) {
	   print $cro_sql_error. mysql_error();
	   exit;
	}
	
	if (mysql_num_rows($result_email_list) == 0) {
	   print $cro_notfound;
	   exit;
	}
	
	while ($row = mysql_fetch_array($result_email_list)) {
	  $email_addr = $row['mail'];
	  $shoebox = $row['confi'];
   
    $header = "From: \"" . $site_name . "\" <$from_email>\n";
    $subject = stripslashes($subject);
 
 		$msg = $message;
		$msg .= $cro_msg_plain_signature;
    		
		$msg = str_replace('@@blog_url',$blog_url,$msg);
		$msg = str_replace('@@shoebox',$shoebox,$msg);
		$msg = str_replace('@@to_addr',$email_addr,$msg);
		
		
		    $msg = stripslashes($msg);
 
		Mail($email_addr, $subject, $msg, $header);
		$number++;
	}
	
	mysql_free_result($result_config);  // Free the memory
	mysql_free_result($result_email_list);  // Free the memory
	
	if ($number == "1") {
		print str_replace('@@number',$number,$cro_send_person);
	
	} else {	
		print str_replace('@@number',$number,$cro_send_people);
	}
		
	}
?>		
