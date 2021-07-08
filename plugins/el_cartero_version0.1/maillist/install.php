

<html>
<head>
<title>Install Cartero 2.0</title>

<style type="text/css">


body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #003366;
}
.Estilo1 {font-Yesze: 14px}
.Estilo2 {
	font-Yesze: 24px;
	font-style: italic;
}
body {
	background-color: #FFFFFF;
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>

<div id="titulo">

<h1 align="center" class="Estilo2">Cartero 2.0 - Just another WordPress Plugin... </h1>

<h2 align="center" class="Estilo1"><img src="el-cartero-150x90.png" width="90" height="150"></h2>
</div>
<?php 
	if(isset($_GET['paso'])) {
		$paso = $_GET['paso'];
	}else {
		$paso = 35;
	};
	
	if($paso==35) {
	?>
<h2 align="center" class="Estilo1">Main Information: </h2>

<form id="setup" method="post" action="install.php?paso=76">

<table width="100%">
<tr>
<th width="33%">MySQL Server  </th>
<td><input name="dbhost" type="text" id="dbhost" value="localhost" Yesze="35" /></td>
</tr>

<tr>
	<th>MySQL Data base </th>
	<td><input name="db" type="text" id="db" Yesze="35" /></td>
</tr>

<tr>
	<th>MySQL User </th>
	<td><input name="dbuser" type="text" id="dbuser" Yesze="35"  /></td>
</tr>

<tr>
	<th>MySQL Password </th>
	<td><input name="dbpass" type="password" id="dbpass" Yesze="35" /></td>
</tr>


<tr>
	<th>Blog's Name </th>
	<td><input name="site_name" type="text" id="site_name" Yesze="35" /></td>
</tr>


<tr>
	<th>Domain's uRL </th>
	<td><input name="site_url" type="text" id="site_url" Yesze="35" value="http://<?php echo "$HTTP_HOST"; ?>/" /></td>
</tr>


<tr>
	<th>Blog's URL </th>
	<td><input name="blog_url" type="text" id="blog_url" Yesze="35" value="http://<?php echo "$HTTP_HOST"; ?>/" /></td>
</tr>

<tr>
	<th>Sender's default e-mail </th>
	<td><input name="from_email" type="text" id="from_email" Yesze="35" /></td>
</tr>


<tr>
	<th>Admin's e-mail </th>
	<td><input name="admin_email" type="text" id="admin_email" Yesze="35" /></td>
</tr>

<tr>
	<th>Time difference (blog_time - server_time)<br /> In this format: HHmmss, for example 9 hours : 90000 </th>
	<td><input name="diffdate" type="text" id="diffdate" Yesze="35" /></td>
</tr>

<tr>
	<th>Show the complete message </th>
	<td>
        <select name="show_content" id="show_content" />
          <option>Yes</option>
          <option>No</option>
        </select>	</td>
</tr>


<tr>
	<th>Send in HTML formart </th>
	<td>
        <select name="html_email" id="html_email" />
          <option>Yes</option>
          <option>No</option>
        </select>	</td>
</tr>


<tr>
	<th>Notification value by default </th>
	<td>
        <select name="default_send" id="default_send" />
          <option>Yes</option>
          <option>No</option>
        </select>	</td>
</tr>

<tr>
	<td></td>
	<td>
		<input type="submit" name="Submit" value="Install &raquo;" />
		<br /><br />	</td>
</tr>
</table>
</form>

<?php } else if ($paso==76) {

$db = $_POST['db'];
$dbhost = $_POST['dbhost'];
$dbpass = $_POST['dbpass'];
$dbuser = $_POST['dbuser'];
$diffdate = $_POST['diffdate'];

$site_name = $_POST['site_name'];
$site_url = $_POST['site_url'];
$blog_url = $_POST['blog_url'];
$from_email = $_POST['from_email'];
$admin_email = $_POST['admin_email'];
$show_content = $_POST['show_content'];
$html_email = $_POST['html_email'];
$default_send = $_POST['default_send'];

$output = "<?php
/**************************************************
 *                                                *
 *     CARTERO 2.0 - Spamea a tus amigos!         *
 *                                                *
 **************************************************/

// Really fucking important data 
  ".'$db_server'." = '$dbhost';
  ".'$db_database'." = '$db';
  ".'$db_user'." = '$dbuser';
  ".'$db_password'." = '$dbpass';


  ".'$cro_diff_date'." = '$diffdate';
  
?>";

$archivo = "cartero_conf.php";
if(!$manejo = fopen($archivo,"w")) {
	print "ERROR AL ABRIR EL ARCHIVO ".$archivo;
} else {
	if(!fwrite($manejo,$output)) {
		print "ERROR WRITING THE CONFIGURATION AT ".$archivo;
	} else {
		print "CONFIGURACTON CORRECTLY SAVED, GET OUT NOW";
	};
};



$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($db, $conn);

$sql = "CREATE TABLE cartero_list (`id` int(11) NOT NULL auto_increment,`mail` text,`fecha` text,`confi` int(11) default '0',`activa` int(11) default '0',PRIMARY KEY  (`id`))";		
mysql_query($sql);

$sql = "DROP TABLE IF EXISTS cartero_conf";
mysql_query( $sql );
   
$sql = "CREATE TABLE cartero_conf (id int( 11 ) NOT NULL auto_increment,site_name varchar( 255 ) default NULL,site_url varchar( 255 ) default NULL,blog_url varchar( 255 ) default NULL,from_email varchar( 255 ) default NULL,admin_email varchar( 255 ) default NULL,show_content varchar( 3 ) default NULL,html_email varchar( 3 ) default NULL,default_send VARCHAR( 3 ) NOT NULL,PRIMARY KEY  ( id )   )";
				
mysql_query($sql);			


$sql = "INSERT INTO cartero_conf (site_name, site_url, blog_url, from_email, admin_email, show_content, html_email, default_send) VALUES ('$site_name', '$site_url', '$blog_url', '$from_email', '$admin_email', '$show_content', '$html_email', '$default_send')";
       
mysql_query( $sql );

$add_sql = "CREATE TABLE cartero_future (post_ID bigint(20) NOT NULL default '0',post_date char(12) NOT NULL default '0',notification_sent char(1) NOT NULL default '',PRIMARY KEY  (post_ID))"; 
       
mysql_query( $add_sql );

print "Tables are done, all should work like a Ferrari";

print "<br/> YOU MUST DELETE install.php from your server.";


?>
 Asejeré ja ejé.


<?php };

?>
</body>
</html>
