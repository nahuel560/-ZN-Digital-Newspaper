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


1.-INSTALL INSTRUCTIONS
2.-ALLOW PEOPLE TO SUBSCRIBE
3.-HOW TO CHANGE TEMPLATES OR LANGUAGE
4.-NOTES


---------------------------------------------------

1.-INSTALL INSTRUCTIONS

-First-

Copy the "maillist" folder to your Blog's root path (ie. www.yourdomain.com/yourblog/maillist/)

Copy the "cartero_plugin_notification" folder to your WordPress Plugin Folder 
(ie. www.yourdomain.com/yourblog/wp-content/plugins/cartero_plugin_notification/)

-Second-
Run the Install script (maillist/install.php) via your browser :
http://www.yourdomain.com/yourblog/maillist/install.php

Follow the steps of the installation

-Third-
Go to your WP Admin Panel and activate the plugin

-Fourth-
Go to "Options" >> "Cartero 2.0" To change the options

-Fifth-
Write a post, a new options will be added, a little combobox with something similar to "Notify the subscribers? Yes|No"

End of Story, simple and easy to use.


---------------------------------------------------

2.-ALLOW PEOPLE TO SUBSCRIBE

Create a simple form to enter theemail address, and as "action" put "yourblog/maillist/actions.php"

For example something like this : 

<p>Subscribe Here!</p>
<form id="newsletter_form" action="http://www.yourdomain.com/yourblog/maillist/actions.php" method="post">
<p><label style="display: none;" for="newsletter_input" id="newsletter_label">Put your e-mail</label></p>
<p><input value="Put your e-mail" style="background-color: rgb(255, 255, 160);" name="email" id="newsletter_input" type="text"></p>
<p><button type="submit">Send</button></p>
</form>


---------------------------------------------------


3.-HOW TO CHANGE TEMPLATES OR LANGUAGE

Just modify the "maillist/cartero_language.php" To translate Cartero 2.0 Plugin to your own language. Menu options and items are there too!

To modify the email template go to your_plugins_folder/cartero_plugin_notification/email_template.html
(Plain text template, and signatures are in maillist/cartero_language.php)





---------------------------------------------------



4.-NOTES

THINGS THAT DON'T WORK :
-Only HTML-notifications are sent
-There isn't import options (rigth now)
-Future post NOT TESTED


This plugin is based on "WP Email Notification" (http://watershedstudio.com/portfolio/software/wp-email-notification.html) which is annoying to change thhe language or personalize it. Some functionalities will be added soon. Thanks.