 === WP Bannerize ===
Contributors: Giovambattista Fazioli (see Thanks for contributors)
Donate link: http://www.saidmade.com/prodotti/wordpress/wp-bannerize/
Tags: Banner, Manage, Image, ADV, Random, Adobe Flash, Impressions, Click Counter
Requires at least: 2.9
Tested up to: 3.1
Stable tag: 2.7.6

WP Bannerize, banner-image manager.

== Description ==

WP Bannerize is an Amazing Banner Image Manager. In your template insert: `<?php if(function_exists( 'wp_bannerize' )) wp_bannerize(); ?>`, use new shortcode featured or set it like Widget

**FEATURES**

* Localized for Italian, English, Spanish, Portuguese, Belorussian, Dutch and Polish
* Create your list (group/key) Banners image/Adobe Flash movie
* Drag & Drop order
* Show your banners list by php code, **shortcode** or Widget
* Set random, limit and catories filters
* Standard Wordpress interface improvement
* "nofollow" attribute support
* Click Counter engine for stats
* Impressions and Max Impressions
* Date Time schedule
* Wordpress Admin Contextual HELP
* Wordpress MU compatible

**LAST IMPROVEMENT**

* Added Polish localization (Thanks to Krzysztof Bociurko)
* Added Adobe Flash Window Mode settings
* Added Link description settings (Thanks to [bsdezign](http://wordpress.org/support/profile/bsdezign) "bsdezign")
* Improved HTML/CSS documentation
* Fixed wrong date for blank text input (Thanks to Viktor Zozulyak)

**HOW TO**

When you insert a banner you can give a group (key) code. In this way you can "group" a block of banners. For examples if your theme is a 3 columns, you can put in left sidebar:

`<?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('group=left_sidebar'); ?>`

and put in right sidebar:

`<?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('group=right_sidebar'); ?>`

However WP Bannerize provides a filter by category, for example:

`<?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('group=right_sidebar&categories=13,14'); ?>`

The code above shows only banners in the categories 13 or 14, for the "right_sidebar" group key.

or (new from 2.6.0) in your post:

`[wp-bannerize group="adv" random="1" limit="3"]`


**params:**

`
* group               If '' show all groups, else show the selected group code (default '')
* container_before    Main tag container open (default <ul>)
* container_after     Main tag container close (default </ul>)
* before              Before tag banner open (default <li %alt%>) see alt_class below
* after               After tag banner close (default </li>) 
* random              Show random banner sequence (default '')
* categories          Category ID separated by commas. (default '')
* alt_class           class alternate for "before" TAG (use before param)
* link_class          Additional class for link TAG A
* limit               Limit rows number (default '' - show all rows) 
`

= Related Links =

* [Saidmade](http://www.saidmade.com/ "More Wordpress Plugins")
* [Undolog](http://www.undolog.com/ "Author's Web")
* [Saidmade Blog](http://www.saidmade.com/category/blog "Saidmade Blog")
* [Tutorial Video](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

For more information on the roadmap for future improvements please e-mail: g.fazioli@saidmade.com

== Screenshots ==

1. New Logo
2. New Administrator Menu
3. New Settings Menu Item
4. Added New Banner Pannel with Adobe FLash support and size autodetect
5. New List View Banner list with Wordress standard tools: pagination, filters, drag & drop features
6. Contextual Help
7. Widget support

* [Tutorial Video](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

== Changelog ==

= 2.7.5 =
* Fixed wrong date for blank text input (Thanks to Viktor Zozulyak)
* Added Polish localization (Thanks to Krzysztof Bociurko)
* Added Adobe Flash Window Mode settings
* Added Link description settings (Thanks to [bsdezign](http://wordpress.org/support/profile/bsdezign) "bsdezign")
* Improved HTML/CSS documentation

= 2.7.1.1 =
* Added Dutch localization (Thanks to [Rene](http://wpwebshop.com/premium-wordpress-themes/ "WordPress Webshop"))

= 2.7.1 =
* Fixed FancyBox image preview
* Fixed Combo Group on inline edit
* Fixed Open/Close inline edit
* Improved inline edit

= 2.7.0.6 =
* Fixed insert banner for on date start and date end

= 2.7.0.5 =
* Updated Adobe Flash output for XHTML 1.0 Transitional page validation (Thanks to Tihomir Lichev for suggestion)

= 2.7.0.4 =
* Updated Portuguese localization

= 2.7.0 =
* Added Settings section for Click Counter and Impressions switch on/off
* Added impressions
* Added **start date** and **end date** for each single banner
* Improved banner list view
* Improved response after any action
* Fixed several minor bugs
* Cleaned code

= 2.6.11 =
* Fixed bugs on combo menu in admin
* Fixed "Parse error: syntax error, unexpected T_OBJECT_OPERATOR"
* Updated Portuguese localization

= 2.6.9 =
* Fixed wrong use `alt class` in Widget setting [Detail](http://wordpress.org/support/topic/plugin-wp-bannerize-before-and-after-containers-not-working-properly?replies=6#post-1718323 "Detail")

= 2.6.8 =
* Fixed class attribute with `group` replace space with underscore

= 2.6.7 =
* Improved HTML output for W3C validation
* Fixed documentation

= 2.6.6 =
* Fixed online edit form for `clickcount`, `width` and `height` parameters
* Improved online edit form size for `clickcount`, `width` and `height` parameters

= 2.6.5 =
* Fixed wrong "height" value in edit online form
* Added `width`and `height` attributes in `img` tag
* `nofollow` and `_blank` settings as defaults

= 2.6.0 =
* Added shortcode [wp-bannerize]
* Added Spanish localization: thanks to [David Pérez](http://www.closemarketing.net/ "Closemarketing")
* Change access level to 'Editor'
* Fixed default value in database table

= 2.5.5 =
* Fixed "echo" on Widget output

= 2.5.4 =
* Fixed getimagesize() functions on url file

= 2.5.3 =
* Fixed getimagesize() functions

= 2.5.2 =
* Fixed italian localization

= 2.5.1 =
* Several fixes

= 2.5.0 =
* Improved Database table
* Added convertion tools for pre-2.5.0 release
* Improved User Interface
* Added Adobe Flash support
* Added footer text description
* Added "nofollow" rel attribute support
* Added "Click Counter" (only images)
* Revisioned code
* Fixed minor bugs

= 2.4.11 =
* Fixed Link on Plugins list page

= 2.4.9 =
* Change Menu Item position in Backend
* Improved styles and script loading
* Improved "edit" online styles and table views


= 2.4.7 =
* Fixed warning while checked previous version
* Cleaned code/comment

= 2.4.6 =
* Added Belorussian Localization; thanks to [Marcis G.](http://pc.de/ "Marcis G.")

= 2.4.5 =
* Added Secure Layer on Ajax Gateway

= 2.4.4 =
* Minor revisions on localization

= 2.4.3 =
* Fixed Widget Title Output
* Changed Adv Engine

= 2.4.1 =
* Fixed localization
* Fixed minor bugs

= 2.4.0 =
* Added localization
* Improved code restyle
* Cleaned code

= 2.3.9 =
* Fixed Widgets args

= 2.3.8 =
* Revisioned include script and style
* Minor revisions in path and code cleaned

= 2.3.5 =
* Revisioned Widget Class implement

= 2.3.4 =
* Revisioned readme.txt

= 2.3.3 =
* Split Widget code
* Fixed "random" select on Widget

= 2.3.2 =
* Added "alt" class in HTML output
* Added additional class for link TAG A
* Fixed Widget output

= 2.3.0 =
* Added Wordpress Categories Filter - Show Banner Group for Categories ID
* Improved admin

= 2.2.2 =
* Fixed minor bugs + prepare major release

= 2.2.1 =
* Fixed to Wordpress MU compatibilities
* Fixed minor bugs

= 2.2.0 =
* Added Widget support
* Fixed compatibility with Wordpress 2.8.6

= 2.1.0 =
* Added thickbox support for preview thumbnail
* Resized key field to 128 chars
* Minor Fixes

= 2.0.8 =
* Minor Fixes, improved admin

= 2.0.3 =
* Minor Fixes

= 2.0.2 =
* Added random option
* Fixed minor bugs

= 2.0.1 =
* Fixed bugs on varchar size in create table

= 2.0.0 =
* Added edit banner
* Combo menu for group/key and target
* Contextual HELP
* Icon
* Limit option
* Cleaned list and cleaned code!

= 1.4.3 =
* Fixed patch on old version database table

= 1.4.2 =
* Added screenshot

= 1.4.1 =
* Cleaned code

= 1.4.0 =
* Rev UI
* Changed database
* Fixed upload path server bug

= 1.3.2 =
* Fixed bug in sort order with Ajax call

= 1.3.1 =
* Updated jQuery to last version

= 1.3.0 =
* Improved class object structure

= 1.2.5 =
* Removed a conflict with a new class object structure

= 1.2 =
* Done doc :)

= 1.1 =
* Rev, Fixes and stable release

= 1.0 =
* First release


== Upgrade Notice ==

= 2.6.6 =
Fixed bugs. Upgrade immediately

= 2.4.1 =
Fixed localization. Upgrade immediately

= 2.4.0 =
Added localization/multilanguage support and improved code restyle. Upgrade immediately

= 2.2.0 =
Added Widget support and Fixed for Wordpress 2.8.6. Upgrade immediately

= 2.0.0 =
Major release improved. Upgrade immediately.

= 1.4.0 =
Major release improved. Upgrade immediately.

= 1.3.1 =
Upgrade to last jQuery release. Upgrade immediately.

= 1.0 =
Please download :)


== Installation ==

1. Upload the entire content of plugin archive to your `/wp-content/plugins/` directory, 
   so that everything will remain in a `/wp-content/plugins/wp-bannerize/` folder
2. Open the plugin configuration page, which is located under `Options -> wp-bannerize`
3. Activate the plugin through the 'Plugins' menu in WordPress (deactivate and reactivate if you're upgrading).
4. Insert in you template php `<?php wp_bannerize(); ?>` function
5. Done. Enjoy.

See [Tutorial Video](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

== Thanks ==

**Bugs report and beta testing**

* [Ivan](http://www.bobmarleymagazine.com/)
* [rotunda](http://wordpress.org/support/profile/2123029)
* [marsev](http://wordpress.org/support/profile/5368431 "marsev")
* [benstewart](http://wordpress.org/support/profile/5722257 "benstewart")
* [FTLSlacker](http://wordpress.org/support/profile/ftlslacker "FTLSlacker")
* [kwoodall](http://wordpress.org/support/profile/kwoodall "kwoodall")
* Viktor Zozulyak

**Suggestions and ideas**

* [Wasim Asif](http://www.infotales.com/ "wasimasif")
* Tihomir Lichev
* bsdezign

**Tutorial**

* [Troypoint](http://www.youtube.com/watch?v=sAZOyAwXu-U "Tutorial Video")

**Localization**

* [Fernando Lopes](http://www.fernandolopes.com.br/ "Fernando Lopes") (Portuguese localization)
* [Marcis G.](http://pc.de/ "Marcis G.") (Belorussian localization)
* [David Pérez](http://www.closemarketing.net/ "Closemarketing") (Spanish localization)
* [Rene](http://wpwebshop.com/premium-wordpress-themes/ "WordPress Webshop") (Dutch localization)
* Krzysztof Bociurko (Polish localization)

 ... and sorry for everyone that I forgot ... please, send me a mail for your credits

== Frequently Asked Questions == 

= Can I customize the HTML output? =

Yes, use the `args` for set "container" and "before" and "after" tagging.
For example the default output is:

`
<div class="wp_bannerize">
 <ul>
  <li><a href=".."><img src="..." /></a></li>
  <li><a href=".."><img src="..." /></a><br/><span class="description">[description]</span></li>
 ...
 </ul>
</div>`

If you use a group key named "network", for example:

`
<div class="wp_bannerize">
 <div class="wp_bannerize_network">
  <ul>
   <li><a href=".."><img src="..." /></a></li>
   <li><a href=".."><img src="..." /></a><br/><span class="description">[description]</span></li>
   ...
  </ul>
 </div>
</div>`

Using CSS style for layout your banner; side by side banner is very simple:

`
div.wp_bannerize ul li {
  display:inline;
  float:left;
}`


You can change `<ul>` (container) and `<li>` (before) 

`<?php if(function_exists( 'wp_bannerize' ))
        wp_bannerize('container_before=<div>&container_after=</div>&before=<span>&after=</span>'); ?>`

`
<div>
 <span><a href=".."><img src="..." /></a></span>
 <span><a href=".."><img src="..." /></a></span>
 ...
</div>`


= Can I customize the arguments TAG? =

Yes, you can customize alternate class on "before" TAG and class on link A:

`<?php if(function_exists( 'wp_bannerize' ))
           wp_bannerize('container_before=<div>&container_after=</div>&before=<span %alt%>&after=</span>&link_class=myclass'); ?>`

`
<div>
 <span><a href=".."><img src="..." /></a></span>
 <span class="alt"><a class="myclass" href=".."><img src="..." /></a></span>
 ...
</div>`

OR

`<?php if(function_exists( 'wp_bannerize' ))
          wp_bannerize('alt_class=pair&link_class=myclass'); ?>`

`
<ul>
 <li><a href=".."><img src="..." /></a></li>
 <li class="pair"><a class="myclass" href=".."><img src="..." /></a></li>
 ...
</ul>`