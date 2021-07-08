IMPORT
<br /><br />

<?php

if (isset($import)){
  $import_array = explode("\n",$import);

  $x = 0;
  while ($x < count($import_array)) {

	  // Set Variables //
    $email_addr = "$import_array[$x]";
    $email_addr = trim($email_addr); 
    $gets_mail = 1;
    $last_modified = date("Y-m-d H:i:s");
    $date_subscribed = date("Y-m-d H:i:s");

    //*************************************/
    //*    Check database for duplicates  */
    //*************************************/

    $query = "select id, email_addr from wp_email_list where email_addr = '$email_addr'";

    $result = mysql_query($query);
		
		if (!$result) {
		   $message  = "DB Query Error!";
		   die($message);
		}

    else {
						
			while ($row = mysql_fetch_assoc($result)) {
	   		$dupe = "yes";
	   		break;	   		   			
	  		}
	  		
  		}

		if ($dupe == "yes") {
			echo "$email_addr is already subscribed <br />";	
			$dupe = "";	
			}
		
		else {
			
			if ($email_addr != ""){
	      //*************************************/
	      //*    Insert entry into database     */
	      //*************************************/
	
	  	  // Build table //
	  		$query = " INSERT wp_email_list ";
	  		$query .= "(email_addr, gets_mail, last_modified, date_subscribed)";
	
	  	  // Insert values into table //
	  		$query .= " VALUES ";
	  		$query .= "('$email_addr', '$gets_mail', '$last_modified', '$date_subscribed')";
	
	  		$rs = mysql_query($query);
	
	  		echo "$email_addr subscribed<br />";		
	  		}
	  		
	  	else {
	  		echo "Blank line <br />"; 
	  		}
  			
			}
		
    $x++;
    echo "<hr />";
    }
  }

?>