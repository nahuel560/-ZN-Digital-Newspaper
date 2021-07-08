<?php 	   include (ABSPATH."maillist/cartero_conf.php");  
 	   include (ABSPATH."maillist/cartero_language.php");  ?>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:772px;
	top:20px;
	width:66px;
	height:77px;
	z-index:1;
}
-->
</style>
<div class="wrap"> 

	<h2>Cartero 2.0 Setup <img src="el-cartero-50x30.png" width="30" height="50" /></h2>

	<?php
	
	get_currentuserinfo();
	
	if ($user_level < 8) {
		die ($cro_user_denied);
	}

	?>
	
	<div id="menu">
		<a href="options-general.php?page=cartero_plugin_notification/index.php&action=export"><?php print $cro_export_email; ?></a> ::
		<a href="options-general.php?page=cartero_plugin_notification/index.php&action=remove_email"><?php print $cro_remove_email; ?></a> ::
		<a href="options-general.php?page=cartero_plugin_notification/index.php&action=email_subscribers"><?php print $cro_email_list; ?></a> ::
		<a href="options-general.php?page=cartero_plugin_notification/index.php&action=update_settings"><?php print $cro_update_settings; ?></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	(Plugin by <a href="http://www.theninjabunny.com">theNinjaBunny</a> &amp; <a href="http://www.vectorice.com">Daniel Semper</a> ) </div>
	
	<p>
	<?php
	
	if(!isset($_GET['action'])) {
		$action = "noaction";
	} else {
		$action=$_GET['action'];
	};
	


	$conn = mysql_connect($db_server, $db_user, $db_password);
	mysql_select_db($db_database, $conn);

	
	  if ($action == 'import'){ include ("block_import_form.php"); }
	
	  elseif ($action == 'import_insert'){ include ("block_import_insert.php"); }
	
	  elseif ($action == 'export'){ include ("block_export.php"); }

	  elseif ($action == 'remove_email'){ include ("block_remove.php"); }
	
	  elseif ($action == 'email_subscribers'){ include ("block_send_email.php"); }

	  elseif ($action == 'update_settings'){ include ("block_update_settings.php"); }
	  
	  else {
	  	print "<br /><br /><br />$cro_index_msg<br /><br />";
	  	}
	
	?>
	</p>
</div>
