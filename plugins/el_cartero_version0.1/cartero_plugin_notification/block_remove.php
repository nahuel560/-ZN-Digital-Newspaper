
    <b><?php print $cro_remove_title; ?></b>
    <br /><?php print $cro_remove_desc; ?><br />

<?php
if ($removeEmailChecked) {    
	print $cro_remove_list;

	foreach ($_POST['removeEmail'] as $removeAddress) {
		$query = "DELETE FROM `cartero_list` WHERE mail = '$removeAddress'";
    $res = mysql_query($query) or print mysql_error();	
  	print "<i>$removeAddress</i><br />";
    }

	}

else {
	$sql = "SELECT * FROM `cartero_list`";
	
	$result = mysql_query($sql);
	
	if (!$result) {
	   print $cro_sql_error. mysql_error();
	   exit;
	}
	
	if (mysql_num_rows($result) == 0) {
	   print $cro_notfound;
	   exit;
	}
	?>
	
	<form method="post" action="options-general.php?page=cartero_plugin_notification/index.php&action=remove_email">

	<table width="600">
	<tr class="">
	  <td width="20"><b>&nbsp;</b></td>
	  <td width="200"><b><?php print $cro_list_email;?></b></td>
	  <td width="125"><b><?php print $cro_list_active;?></b></td>
	  <td width="255"><b><?php print $cro_list_regdate;?></b></td>
	</tr>
	
	<?php
	
	while ($row = mysql_fetch_assoc($result)) {
	  $email_addr = $row['mail'];
	  $activa = $row['activa'];
	  $date_subscribed = $row['fecha'];
	
	  if ($activa == "1"){ $activa = $cro_yes; }
	  else { $activa = $cro_no; }
	
	  echo "<tr>";
	  echo "<td><input type=\"checkbox\" name=\"removeEmail[]\" value=\"$email_addr\" /></td>";
	  echo "<td>$email_addr</td>";
	  echo "<td>$activa</td>";
	  echo "<td>$date_subscribed</td>";
	  echo "</tr>";
		}
	?>
	
	</table>
	<br />
	<input type="submit" name="removeEmailChecked" value="<?php print $cro_remove_button; ?>">
	</form> 

<?php 
mysql_free_result($result);  // Free the memory 
} 
?>
