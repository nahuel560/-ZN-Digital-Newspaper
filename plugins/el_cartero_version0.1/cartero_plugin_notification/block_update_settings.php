    <b><?php print $cro_update_title; ?></b>
    <br /><?php print $cro_update_desc; ?><br />

<?php
	
$sql = "SELECT * FROM `cartero_conf` WHERE id = '1'";
$result = mysql_query($sql);

if (!$result) { 
	print $cro_sql_error.mysql_error(); 
	exit; 
};

if (mysql_num_rows($result) == 0) { 

	print $cro_notfound;
	exit;
};

$act = $_GET['act'];
if ($act==1){
	
$site_name = $_POST['site_name'];
$site_url = $_POST['site_url'];
$blog_url = $_POST['blog_url'];
$from_email = $_POST['from_email'];
$admin_email = $_POST['admin_email'];
$show_content = $_POST['show_content'];
$html_email = $_POST['html_email'];
$default_send = $_POST['default_send'];

		$update = " UPDATE `cartero_conf` ";
		$update .= "SET ";
		$update .= "site_name = '$site_name', ";
		$update .= "site_url = '$site_url', ";
		$update .= "blog_url = '$blog_url', ";
		$update .= "from_email = '$from_email', ";
		$update .= "admin_email = '$admin_email', ";
		$update .= "show_content = '$show_content', ";
		$update .= "html_email = '$html_email', ";
		$update .= "default_send = '$default_send' ";
		$update .= "WHERE id = '1'";

		$result_update = mysql_query($update);
		
		print "<b>$cro_op_sitename</b>: $site_name <br />";
		print "<b>$cro_op_siteurl</b>: $site_url <br />";
		print "<b>$cro_op_blogurl</b>: $blog_url <br />";
		print "<b>$cro_op_fromemail</b>: $from_email <br />";
		print "<b>$cro_op_adminemail</b>: $admin_email <br />";
		print "<b>$cro_op_fullpost</b>: $show_content <br />";
		print "<b>$cro_op_html</b>: $html_email <br />";
		print "<b>$cro_op_defaultvalue</b>: $default_send <br />";			
	}

else {

		while ($row = mysql_fetch_assoc($result)) {
		
			$site_name = $row['site_name'];
			$site_url = $row['site_url'];
			$blog_url = $row['blog_url'];
			$from_email = $row['from_email'];
			$admin_email = $row['admin_email'];
			$show_content = $row['show_content'];
			$html_email = $row['html_email'];
			$default_send = $row['default_send'];
		
			switch($show_content){
				case "No":
					$showN = "selected=\"selected\"";
					break;
				case "Yes":
					$showY = "selected=\"selected\"";
					break;
				}
				
			switch($html_email){
				case "No":
					$htmlN = "selected=\"selected\"";
					break;
				case "Yes":
					$htmlY = "selected=\"selected\"";
					break;
				}		
				
			switch($default_send){
				case "No":
					$sendN = "selected=\"selected\"";
					break;
				case "Yes":
					$sendY = "selected=\"selected\"";
					break;
				}					
		
		?>
		
		<style type="text/css">
		<!--
		th {text-align: right; padding-right: 10px; }
		-->
		</style>

		<p>
		<?php print $cro_update_msg; ?>
		</p>
			
		<form id="update" method="post" action="options-general.php?page=cartero_plugin_notification/index.php&action=update_settings&act=1">
		
		<table width="100%">
		
		<tr>
			<th width=200><?php print $cro_op_sitename; ?>:</th>
			<td><input name="site_name" type="text" id="site_name" size="35" value="<?php echo $site_name; ?>" /></td>
		</tr>
		
		
		<tr>
			<th><?php print $cro_op_siteurl; ?>:</th>
			<td><input name="site_url" type="text" id="site_url" size="35" value="<?php echo $site_url; ?>" /></td>
		</tr>
		
		
		<tr>
			<th><?php print $cro_op_blogurl; ?>:</th>
			<td><input name="blog_url" type="text" id="blog_url" size="35" value="<?php echo $blog_url; ?>" /></td>
		</tr>
		
		<tr>
			<th><?php print $cro_op_fromemail; ?>:</th>
			<td><input name="from_email" type="text" id="from_email" size="35" value="<?php echo $from_email; ?>" /></td>
		</tr>
		
		
		<tr>
			<th><?php print $cro_op_adminemail; ?>:</th>
			<td><input name="admin_email" type="text" id="admin_email" size="35" value="<?php echo $admin_email; ?>" /></td>
		</tr>
		
		
		
		<tr>
			<th><?php print $cro_op_fullpost; ?>:</th>
			<td>
		        <select name="show_content" value="<?php echo "$show_content"; ?>" />
		          <option <?php echo "$showN"; ?>>No</option>
		          <option <?php echo "$showY"; ?>>Yes</option>
		        </select>	
			</td>
		</tr>
		
		
		<tr>
			<th><?php print $cro_op_html; ?>:</th>
			<td>
		        <select name="html_email" value="<?php echo "$html_email"; ?>" />
		          <option <?php echo "$htmlN"; ?>>No</option>
		          <option <?php echo "$htmlY"; ?>>Yes</option>
		        </select>	
			</td>
		</tr>

		<tr>
			<th><?php print $cro_op_defaultvalue; ?>:</th>
			<td>
		        <select name="default_send" value="<?php echo "$default_send"; ?>" />
		          <option <?php echo "$sendN"; ?>>No</option>
		          <option <?php echo "$sendY"; ?>>Yes</option>
		        </select>	
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<input type="submit" name="updateSettings" value="<?php print $cro_update_button; ?>" />
				<br /><br />
			</td>
		</tr>
		
		</table>		
		
		</form>	
<?php	
	}
	mysql_free_result($result);  // Free the memory
}

?>
