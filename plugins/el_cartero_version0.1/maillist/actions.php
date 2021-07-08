<?php
#------------------------------------------------------#
# INFO                                                 #
#------------------------------------------------------#
# Title: Cartero 2.0                                   # 
# Authors: theNinjaBunny (www.theninjabunny.com)       #
#          Daniel Semper (www.vectorice.com)           #
# Date: December, 2006                                 #
# Version: 0.1                                         #
#                                                      #
#------------------------------------------------------#

// Los includes
include ("cartero_conf.php");
include ("cartero_language.php");



//Recogemos las variablesen plan guay
if(!isset($_GET['action'])) {
	$action = "noaction";
} else {
	$action = $_GET['action'];
};

if(!isset($_GET['mail'])) {
	$email = "nomail";
} else {
	$email = $_GET['mail'];
};

if(!isset($_GET['shoebox'])) {
	$shoebox = 0;
} else {
	$shoebox = $_GET['shoebox'];
};

if ($_POST['email']) {
    $action = "sub";
    $email = $_POST['email'];
}



// Nos conectamos
$conn = mysql_connect("$db_server", "$db_user", "$db_password");
mysql_select_db("$db_database", $conn);




// Recogemos la configuracion
$sql = "SELECT * FROM `cartero_conf` WHERE id = '1'";
$result = mysql_query($sql) or print mysql_error();
$row = mysql_fetch_array($result);

$blog_name = $row['blog_name'];
$site_url = $row['site_url'];
$blog_url = $row['blog_url'];
$from_email = $row['from_email'];
$admin_email = $row['admin_email'];


$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$headers .= "From: \"$site_name\" <$from_email>\n";
$headers .= "Reply-To: '$from_email'\r\n"; 



?>

<div id="content"><br /><br /><br />
<?php


//Si no hay nada...
if ($action == "noaction") { print $cro_noaction; exit; }



// Si nos queremos agregar a la lista...
if ($action == "sub") {

	$rcon = rand(1000000,10000000);
	
	$fechoria=date("d/m/Y - H:i");
	$row=mysql_fetch_array(mysql_query("SELECT * FROM `cartero_list` WHERE mail='$email'"));

	if($row['activa']=="") {

		$query=mysql_query("INSERT INTO `mailsender` (mail,fecha,confi) values ('$email','$fechoria','$rcon')");
			

		$subject = parsetext($cro_sub_subject_email,$email,$shoebox);
		$body = parsetext($cro_sub_email,$email,$shoebox);

		mail($email, $subject, $body ,$headers);
		
		print parsetext($cro_sub_web);

	} else if($row['activa']==0) {
		print $cro_sub_error_exists;
	} else  {
		print $cro_sub_error_confirm;
	};
    
	
	print parsetext($cro_go_back,$email,$shoebox);

    

} elseif ($action == "delete") {

    
	$result=mysql_fetch_array(mysql_query("SELECT * FROM `cartero_list` WHERE mail='$email'"));
	
	if (mysql_affected_rows() > 0) {

		$rcon=$result['confi'];
		$id=$result['id'];
		if($rcon==$shoebox) { 
			mysql_query("DELETE FROM `cartero_list` WHERE id=$id");
			
			mail($admin_email, parsetext($cro_delete_subject_admin_email,$email,$shoebox), parsetext($cro_delete_admin_email,$email,$shoebox), $headers);
			mail($email, parsetext($cro_delete_subject_email,$email,$shoebox), parsetext($cro_delete_email,$email,$shoebox), $headers);

			print parsetext($cro_delete_web,$email,$shoebox);

		} else { 
			
			print $cro_general_error;
		};


	} else {
		print $cro_general_error;
	};

	print parsetext($cro_go_back,$email,$shoebox);


} elseif ($action == "conf") {
    

	$result=mysql_fetch_array(mysql_query("SELECT * FROM `cartero_list` WHERE mail='$email'"));

	$rcon=$result['confi'];
	$id=$result['id'];
	if($rcon==$shoebox) { 
		$cantidad=1;
		mysql_query("UPDATE `cartero_list` SET activa=$cantidad WHERE id=$id");
		print $cro_conf_web;

		mail($admin_email, parsetext($cro_conf_subject_admin_email,$email,$shoebox), parsetext($cro_conf_admin_email,$email,$shoebox),$headers);

	} else { 

		print $cro_general_error; 
	};
	
	print parsetext($cro_go_back,$email,$shoebox);

} else {
    print $cro_noaction;
}



function parsetext($text,$email,$shoebox) {
$conn = mysql_connect("$db_server", "$db_user", "$db_password");
mysql_select_db("$db_database", $conn);




// Recogemos la configuracion
$sql = "SELECT * FROM `cartero_conf` WHERE id = '1'";
$result = mysql_query($sql) or print mysql_error();
$row = mysql_fetch_array($result);

$blog_name = $row['blog_name'];
$site_url = $row['site_url'];
$blog_url = $row['blog_url'];
$from_email = $row['from_email'];
$admin_email = $row['admin_email'];


$t1 = str_replace('@@shoebox',$shoebox,$text);
$t1 = str_replace('@@site_name',$site_name,$t1);
$t1 = str_replace('@@site_url',$site_url,$t1);
$t1 = str_replace('@@blog_url',$blog_url,$t1);
$t1 = str_replace('@@email',$email,$t1);

	
return $t1;

};


?>
</div>
