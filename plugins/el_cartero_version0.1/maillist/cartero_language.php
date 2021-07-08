<?php


// Messages that will receive another human beings

$cro_sub_subject_email = "Subscription to this sweet Blog: '$site_name'";

$cro_sub_email = "You are receiving this confirmation e-mail to confirm your subscription of new posts of: '@@site_name', if you didn't ask for this service and you have received this e-mail, we are really sorry.<br><br>";
$cro_sub_email .= "<b>You need to click in the following link to confirm your subscription:</b><br> ";
// This is an important line, respect the vars!
$cro_sub_email .= "<a href=\"'@@blog_url'/cartero/actions.php?mail=@@email$action=conf&shoebox=@@shoebox&DummyText=Ar9834FT5d5td%dxtsev7\">CONFIRM MY SUBSCRIPTION</a>";
$cro_sub_email .= "<br><br>Your e-mail never will be given to third parties nor used for spam or any unwanted publicity. It will be used only for the notifications of new posts.";

$cro_sub_web = " A confirmation e-mail has been sent. Thanks for your preference."; 


$cro_delete_web = "<b>'@@email' has been deleted correctly</b> from our Data Base. You can subscribe again at any time in the future, you will just need to repeat the same steps. Thanks.";

$cro_delete_email = "<b>'@@email' has been deleted correctly</b> from our Data Base. You can subscribe again at any time in the future, you will just need to repeat the same steps. Thanks."; 

$cro_delete_admin_email = "<b>'@@email' has been deleted correctly</b> from our Data Base."; 

$cro_delete_subject_email = "You ha been deleted from the maillist of '@@site_name'";
$cro_delete_subject_admin_email = "'$email' has been deleted from the maillist of '@@site_name'";



$cro_conf_web = "<b>'@@email' has been added correctly</b> to our Data Base. ";

$cro_conf_admin_email = "<b>'@@email' has been added correctly</b> to our Data Base. ";

$cro_conf_subject_admin_email = "Someone has subscribed";




// MISC MSG
$cro_go_back = "<br/><br/><a href=\"@@blog_url\"  >Return to blog</a><br/><br/>";
$cro_yes = "Yes!";
$cro_no = "No, never, ever!";

$cro_op_sitename = "Site's name";
$cro_op_siteurl = "Site's URL";
$cro_op_blogurl = "Blog's URL";
$cro_op_fromemail = "Sender's E-mail";
$cro_op_adminemail = "Admin's E-mail";
$cro_op_fullpost = "Show all the content";
$cro_op_html = "Send the html";
$cro_op_defaultvalue = "Send by default";

$cro_subject = "Subject";
$cro_message = "Message";
$cro_send_note = "[This e-mail will be sent in plain text]";
$cro_sumit = "Send";
$cro_reset = "Delete Form";

$cro_new_entry = "New Entry";


// CARTERO ERROR's
$cro_noaction = "Ther isn´t any action specified";

$cro_sub_error_exists = "ERROR, this e-mail already exists in the Data Base";

$cro_sub_error_confirm = "ERROR, thi se-mail was already validated";


$cro_general_error = "Hey, you are doing something illegal";

$cro_sql_error = "There was an error while processing the SQL: ";

$cro_notfound = "No registers were found"; 

//PANEL MSGs

$cro_user_denied = "You need at least to be a level 8 user to use this tool";

$cro_export_email = "Export e-mails";
$cro_remove_email = "Delete an e-mail";
$cro_email_list = "Send a message to the list";
$cro_update_settings = "Change the configuration";

$cro_index_msg = "Choose one option from the menu";

$cro_export_title = "Export the mailing list";
$cro_export_desc = "Description of this option";

$cro_remove_title = "Delete stuff from the mailing list";
$cro_remove_desc = "Description of this option";
$cro_remove_list = "The following e-mails were deleted:<br />";
$cro_list_email = "E-mail address";
$cro_list_active = "Active?";
$cro_list_regdate = "Register date";
$cro_remove_button = "Delete the chosen ones";

$cro_send_title = "Send Spam to the mailing list";
$cro_send_desc = "Description of this option";

$cro_update_title = "hange the configuration";
$cro_update_desc = "Description of this option";
$cro_update_msg = "If you want to update your Data Base settings, you can either re-run maillist/install.php or edit the maillist/cartero_conf.php file directly.";
$cro_update_button = "Update now!";

$cro_notify_subscribers = "Inform to the subscribers?";


// EMAIL TEMPLATES (or similar)
$cro_send_person = "Message sent to @@number person. <br /><br />";
$cro_send_people = "Message sent to @@number persons. <br /><br />";




//plain text signature
$cro_msg_plain_signature =  "\n\n------------------------------------------------------\n";
$cro_msg_plain_signature .= "You are subscribed to receive this notifications. \n\n";
$cro_msg_plain_signature .= "If you don´t want to receive this anymore:\n";
$cro_msg_plain_signature .= "@@blog_urlmaillist/actions.php?action=delete&email=@@to_addr&shoebox=@@shoebox\n";


//html email signature
$cro_email_html_signature = "You are subscribed to receive this notifications. <br /><br />";
$cro_email_html_signature .= "If you don´t want to receive this anymore:<br />";
$cro_email_html_signature .= "<a href=\"".$blog_url."maillist/index.php?action=delete&email=@@to_addr&shoebox=@@shoebox\">Unsubscribe me /a><br />";

//html short message signature
$cro_read_more = "<a href=\"@@permalink\">...Read More</a><br />";


?>
