    <b><?php print $cro_export_title; ?></b>
    <br /><?php print $cro_export_desc; ?><br />

<?php

$sql = "SELECT * FROM `cartero_list` WHERE activa = 1";

$result = mysql_query($sql);

if (!$result) {
   print $cro_sql_error. mysql_error();
   exit;
}

if (mysql_num_rows($result) == 0) {
   print $cro_notfound;
   exit;
}

while ($row = mysql_fetch_assoc($result)) {
  $email_addr = $row['mail'];

  print "$email_addr<br />";
}

mysql_free_result($result);  

?>
