<?php

function fifu_get_strings_settings() {
    $fifu = array();

    // php
    $fifu['php']['message']['wait'] = function() {
        return __("Please wait some seconds...", FIFU_SLUG);
    };

    // buttons
    $fifu['button']['submit'] = function() {
        _e("Submit", FIFU_SLUG);
    };
    $fifu['button']['ok'] = function() {
        _e("OK", FIFU_SLUG);
    };

    // details
    $fifu['detail']['important'] = function() {
        _e("Important", FIFU_SLUG);
    };
    $fifu['detail']['requirement'] = function() {
        _e("Requirement", FIFU_SLUG);
    };
    $fifu['detail']['tip'] = function() {
        _e("Tip", FIFU_SLUG);
    };
    $fifu['detail']['suggestion'] = function() {
        _e("Suggestion", FIFU_SLUG);
    };
    $fifu['detail']['example'] = function() {
        _e("Example", FIFU_SLUG);
    };
    $fifu['detail']['eg'] = function() {
        _e("e.g.:", FIFU_SLUG);
    };
    $fifu['detail']['result'] = function() {
        _e("Result", FIFU_SLUG);
    };

    // words
    $fifu['word']['attribute'] = function() {
        _e("attribute", FIFU_SLUG);
    };
    $fifu['word']['selector'] = function() {
        _e("selector", FIFU_SLUG);
    };
    $fifu['word']['cover'] = function() {
        _e("cover", FIFU_SLUG);
    };
    $fifu['word']['contain'] = function() {
        _e("contain", FIFU_SLUG);
    };
    $fifu['word']['fill'] = function() {
        _e("fill", FIFU_SLUG);
    };
    $fifu['word']['width'] = function() {
        _e("width", FIFU_SLUG);
    };
    $fifu['word']['color'] = function() {
        _e("color", FIFU_SLUG);
    };
    $fifu['word']['mode'] = function() {
        _e("mode", FIFU_SLUG);
    };
    $fifu['word']['inline'] = function() {
        _e("inline", FIFU_SLUG);
    };
    $fifu['word']['lightbox'] = function() {
        _e("lightbox", FIFU_SLUG);
    };
    $fifu['word']['zindex'] = function() {
        _e("z-index", FIFU_SLUG);
    };
    $fifu['word']['zoom'] = function() {
        _e("zoom", FIFU_SLUG);
    };

    // where
    $fifu['where']['page'] = function() {
        _e("on page", FIFU_SLUG);
    };
    $fifu['where']['post'] = function() {
        _e("on post ", FIFU_SLUG);
    };
    $fifu['where']['cpt'] = function() {
        _e("on custom post type", FIFU_SLUG);
    };
    $fifu['where']['home'] = function() {
        _e("on home (or shop)", FIFU_SLUG);
    };

    // player
    $fifu['player']['youtube'] = function() {
        _e("for YouTube videos", FIFU_SLUG);
    };
    $fifu['player']['vimeo'] = function() {
        _e("for Vimeo videos", FIFU_SLUG);
    };

    // chrome
    $fifu['chrome']['link'] = function() {
        _e("Chrome Extension available", FIFU_SLUG);
    };

    // messages
    $fifu['message']['wait'] = function() {
        _e("Please wait some seconds...", FIFU_SLUG);
    };

    // tabs
    $fifu['tab']['help'] = function() {
        _e("Help", FIFU_SLUG);
    };
    $fifu['tab']['admin'] = function() {
        _e("Admin", FIFU_SLUG);
    };
    $fifu['tab']['image'] = function() {
        _e("Featured image", FIFU_SLUG);
    };
    $fifu['tab']['content'] = function() {
        _e("Content URL", FIFU_SLUG);
    };
    $fifu['tab']['metadata'] = function() {
        _e("Metadata", FIFU_SLUG);
    };
    $fifu['tab']['performance'] = function() {
        _e("Performance", FIFU_SLUG);
    };
    $fifu['tab']['api'] = function() {
        _e("REST API", FIFU_SLUG);
    };
    $fifu['tab']['shortcode'] = function() {
        _e("Shortcode", FIFU_SLUG);
    };
    $fifu['tab']['slider'] = function() {
        _e("Slider", FIFU_SLUG);
    };
    $fifu['tab']['social'] = function() {
        _e("Social", FIFU_SLUG);
    };
    $fifu['tab']['text'] = function() {
        _e("Text", FIFU_SLUG);
    };
    $fifu['tab']['video'] = function() {
        _e("Video", FIFU_SLUG);
    };
    $fifu['tab']['woo'] = function() {
        _e("WooCommerce", FIFU_SLUG);
    };
    $fifu['tab']['wai'] = function() {
        _e("WP All Import", FIFU_SLUG);
    };
    $fifu['tab']['trouble'] = function() {
        _e("Troubleshooting", FIFU_SLUG);
    };
    $fifu['tab']['key'] = function() {
        _e("License key", FIFU_SLUG);
    };

    // titles
    $fifu['title']['support'] = function() {
        _e("Fast support", FIFU_SLUG);
    };
    $fifu['title']['start'] = function() {
        _e("Getting started", FIFU_SLUG);
    };
    $fifu['title']['dev'] = function() {
        _e("Integrate your plugin with FIFU", FIFU_SLUG);
    };
    $fifu['title']['column'] = function() {
        _e("FIFU Column", FIFU_SLUG);
    };
    $fifu['title']['fields'] = function() {
        _e("Gallery Fields", FIFU_SLUG);
    };
    $fifu['title']['library'] = function() {
        _e("Media Library", FIFU_SLUG);
    };
    $fifu['title']['reset'] = function() {
        _e("Reset Settings", FIFU_SLUG);
    };
    $fifu['title']['height'] = function() {
        _e("Same Height", FIFU_SLUG);
    };
    $fifu['title']['auto'] = function() {
        _e("Auto Set", FIFU_SLUG);
    };
    $fifu['title']['giphy'] = function() {
        _e("Giphy Search", FIFU_SLUG);
    };
    $fifu['title']['unsplash'] = function() {
        _e("Unsplash Image Size", FIFU_SLUG);
    };
    $fifu['title']['replace'] = function() {
        _e("Replace Not Found Image", FIFU_SLUG);
    };
    $fifu['title']['default'] = function() {
        _e("Default Featured Image", FIFU_SLUG);
    };
    $fifu['title']['content'] = function() {
        _e("Featured Image in Content", FIFU_SLUG);
    };
    $fifu['title']['hide'] = function() {
        _e("Hide Featured Media", FIFU_SLUG);
    };
    $fifu['title']['hover'] = function() {
        _e("Hover Effects", FIFU_SLUG);
    };
    $fifu['title']['validation'] = function() {
        _e("Image Validation", FIFU_SLUG);
    };
    $fifu['title']['configuration'] = function() {
        _e("Configuration", FIFU_SLUG);
    };
    $fifu['title']['all'] = function() {
        _e("All Posts", FIFU_SLUG);
    };
    $fifu['title']['metadata'] = function() {
        _e("Image Metadata", FIFU_SLUG);
    };
    $fifu['title']['clean'] = function() {
        _e("Clean Metadata", FIFU_SLUG);
    };
    $fifu['title']['dimensions'] = function() {
        _e("Save Image Dimensions", FIFU_SLUG);
    };
    $fifu['title']['schedule'] = function() {
        _e("Schedule Metadata Generation", FIFU_SLUG);
    };
    $fifu['title']['database'] = function() {
        _e("Database", FIFU_SLUG);
    };
    $fifu['title']['delete'] = function() {
        _e("Delete All URLs", FIFU_SLUG);
    };
    $fifu['title']['lazy'] = function() {
        _e("Lazy Load", FIFU_SLUG);
    };
    $fifu['title']['flickr'] = function() {
        _e("Flickr Thumbnails", FIFU_SLUG);
    };
    $fifu['title']['api'] = function() {
        _e("WP / WooCommerce REST API", FIFU_SLUG);
    };
    $fifu['title']['shortcode'] = function() {
        _e("Featured Shortcode", FIFU_SLUG);
    };
    $fifu['title']['slider'] = function() {
        _e("Featured Slider", FIFU_SLUG);
    };
    $fifu['title']['social'] = function() {
        _e("Social Tags", FIFU_SLUG);
    };
    $fifu['title']['rss'] = function() {
        _e("Media RSS Tags", FIFU_SLUG);
    };
    $fifu['title']['title'] = function() {
        _e("Auto Set Image Title", FIFU_SLUG);
    };
    $fifu['title']['video'] = function() {
        _e("Featured Video", FIFU_SLUG);
    };
    $fifu['title']['thumbnail'] = function() {
        _e("Video Thumbnail", FIFU_SLUG);
    };
    $fifu['title']['play'] = function() {
        _e("Play Button", FIFU_SLUG);
    };
    $fifu['title']['width'] = function() {
        _e("Minimum Width", FIFU_SLUG);
    };
    $fifu['title']['black'] = function() {
        _e("Black Background", FIFU_SLUG);
    };
    $fifu['title']['mouseover'] = function() {
        _e("Mouseover Autoplay", FIFU_SLUG);
    };
    $fifu['title']['autoplay'] = function() {
        _e("Autoplay", FIFU_SLUG);
    };
    $fifu['title']['loop'] = function() {
        _e("Loop", FIFU_SLUG);
    };
    $fifu['title']['mute'] = function() {
        _e("Mute", FIFU_SLUG);
    };
    $fifu['title']['background'] = function() {
        _e("Background Video", FIFU_SLUG);
    };
    $fifu['title']['related'] = function() {
        _e("Related Videos", FIFU_SLUG);
    };
    $fifu['title']['icon'] = function() {
        _e("Gallery Icon", FIFU_SLUG);
    };
    $fifu['title']['zoom'] = function() {
        _e("Lightbox and Zoom", FIFU_SLUG);
    };
    $fifu['title']['category'] = function() {
        _e("Auto Set Category Images", FIFU_SLUG);
    };
    $fifu['title']['grid'] = function() {
        _e("Category Image on Grid", FIFU_SLUG);
    };
    $fifu['title']['variable'] = function() {
        _e("Variable Product", FIFU_SLUG);
    };
    $fifu['title']['import'] = function() {
        _e("Import", FIFU_SLUG);
    };
    $fifu['title']['addon'] = function() {
        _e("Add-On", FIFU_SLUG);
    };
    $fifu['title']['key'] = function() {
        _e("License Key", FIFU_SLUG);
    };

    // support
    $fifu['support']['email'] = function() {
        _e("If you need help, you can refer to troubleshooting or send an email to", FIFU_SLUG);
    };
    $fifu['support']['with'] = function() {
        _e("with this", FIFU_SLUG);
    };
    $fifu['support']['status'] = function() {
        _e("status", FIFU_SLUG);
    };
    $fifu['support']['disappeared'] = function() {
        _e("All my images disappeared", FIFU_SLUG);
    };
    $fifu['support']['plugin'] = function() {
        _e("A famous plugin doesn't work with FIFU ", FIFU_SLUG);
    };
    $fifu['support']['style'] = function() {
        _e("I'm having style issues ", FIFU_SLUG);
    };
    $fifu['support']['facebook'] = function() {
        _e("Facebook doesn't share my images", FIFU_SLUG);
    };
    $fifu['support']['null'] = function() {
        _e("\"Nulled\" Premium doesn't work", FIFU_SLUG);
    };
    $fifu['support']['speed'] = function() {
        _e("PageSpeed and GTmetrix issues", FIFU_SLUG);
    };
    $fifu['support']['disappeared-desc'] = function() {
        _e("You were probably using a deprecated feature. Just do it: 1) access Metadata tab; 2) run Clean Metadata; 3) enable Image Metadata (~30,000 URLs/min).", FIFU_SLUG);
    };
    $fifu['support']['plugin-desc'] = function() {
        _e("Just send me an email. If you are available to discuss the details and the plugin is free and has more than 10,000 active installs, I should provide an integration very soon.", FIFU_SLUG);
    };
    $fifu['support']['style-desc'] = function() {
        _e("Some themes and plugins aren't responsive enough to work with external images. You may solve that running Metadata > Save Image Dimensions (~60 URLs/min).", FIFU_SLUG);
    };
    $fifu['support']['facebook-desc'] = function() {
        _e("You probably have a plugin or theme that sets a default image as the Facebook image (og:image tag). Just find and disable the option.", FIFU_SLUG);
    };
    $fifu['support']['null-desc'] = function() {
        _e("This plugin has NO nulled versions, but pirate versions. Don't install that. It's illegal and should ruin your site. Moreover, sales of the original premium version keep this project alive.", FIFU_SLUG);
    };
    $fifu['support']['speed-desc'] = function() {
        _e("You can solve that installing Jetpack plugin. Access its \"Settings\", \"Performance\" and enable \"Speed up image load times\". You'll have a free CDN + optimized external thumbnails.", FIFU_SLUG);
    };

    // start
    $fifu['start']['url']['external'] = function() {
        _e("Hi, I'm an EXTERNAL image!", FIFU_SLUG);
    };
    $fifu['start']['url']['not'] = function() {
        _e("It means I'm NOT in your media library and I'm NOT an attached plugin file too.", FIFU_SLUG);
    };
    $fifu['start']['url']['url'] = function() {
        _e("Don't you believe me? So why don't you check my Internet address (also known as URL)?", FIFU_SLUG);
    };
    $fifu['start']['url']['right'] = function() {
        _e("1) right click me now;", FIFU_SLUG);
    };
    $fifu['start']['url']['copy'] = function() {
        _e("2) select \"Copy image address\";", FIFU_SLUG);
    };
    $fifu['start']['url']['paste'] = function() {
        _e("3) paste it here:", FIFU_SLUG);
    };
    $fifu['start']['url']['drag'] = function() {
        _e("or just drag and drop me here", FIFU_SLUG);
    };
    $fifu['start']['url']['click'] = function() {
        _e("Right click me!", FIFU_SLUG);
    };
    $fifu['start']['post']['famous'] = function() {
        _e("Since now you have my address (also known as URL), how about making me famous?", FIFU_SLUG);
    };
    $fifu['start']['post']['create'] = function() {
        _e("You just need to create a post and use me as the featured image:", FIFU_SLUG);
    };
    $fifu['start']['post']['new'] = function() {
        _e("1) add a new post;", FIFU_SLUG);
    };
    $fifu['start']['post']['box'] = function() {
        _e("2) find the box", FIFU_SLUG);
    };
    $fifu['start']['post']['featured'] = function() {
        _e("Featured image", FIFU_SLUG);
    };
    $fifu['start']['post']['address'] = function() {
        _e("3) paste my address into \"Image URL\" field.", FIFU_SLUG);
    };
    $fifu['start']['post']['storage'] = function() {
        _e("And don't worry about storage. I will remain EXTERNAL. I WON'T be uploaded to your media library.", FIFU_SLUG);
    };

    // dev
    $fifu['dev']['function'] = function() {
        _e("Are you a WordPress developer? So now you can easily integrate your code with FIFU using the function below.", FIFU_SLUG);
    };
    $fifu['dev']['args'] = function() {
        _e("All you need is to inform the post id and the image url. And FIFU will set the custom fields and create the metadata.", FIFU_SLUG);
    };

    // column
    $fifu['column']['desc'] = function() {
        _e("The plugin adds a new column to your post list. Below you can choose the height (px) of the image in the column. To disable that, just uncheck \"FIFU\" in the Screen Options.", FIFU_SLUG);
    };

    // fields
    $fifu['fields']['desc'] = function() {
        _e("Choose the number of fields you have in the post editor.", FIFU_SLUG);
    };
    $fifu['fields']['image'] = function() {
        _e("WooCommerce image gallery", FIFU_SLUG);
    };
    $fifu['fields']['video'] = function() {
        _e("WooCommerce video gallery", FIFU_SLUG);
    };
    $fifu['fields']['slider'] = function() {
        _e("Featured slider", FIFU_SLUG);
    };

    // library
    $fifu['library']['desc'] = function() {
        _e("Show the external images in your media library.", FIFU_SLUG);
    };
    $fifu['library']['important'] = function() {
        _e("if some external image is not being shown in the media library, run Metadata > Save Image Dimensions.", FIFU_SLUG);
    };

    // reset
    $fifu['reset']['desc'] = function() {
        _e("Reset FIFU settings to the default configuration.", FIFU_SLUG);
    };
    $fifu['reset']['reset'] = function() {
        _e("reset settings", FIFU_SLUG);
    };

    // height
    $fifu['height']['desc'] = function() {
        _e("If you have different sizes of images on your home (or shop), enable the toggle below to show them in the same height. Depending on your theme, it may be necessary to use a selector to inform where is the group of images that you want to resize.", FIFU_SLUG);
    };
    $fifu['height']['tab']['height'] = function() {
        _e("Same height", FIFU_SLUG);
    };
    $fifu['height']['tab']['selector'] = function() {
        _e("Selector", FIFU_SLUG);
    };
    $fifu['height']['tab']['ratio'] = function() {
        _e("Size ratio", FIFU_SLUG);
    };
    $fifu['height']['tab']['fit'] = function() {
        _e("Object fit", FIFU_SLUG);
    };
    $fifu['height']['tab']['delay'] = function() {
        _e("Delay", FIFU_SLUG);
    };
    $fifu['height']['selector']['desc'] = function() {
        _e("Examples of selectors...", FIFU_SLUG);
    };
    $fifu['height']['height']['ratio'] = function() {
        _e("and you want a 4:3 size ratio", FIFU_SLUG);
    };
    $fifu['height']['ratio']['desc'] = function() {
        _e("Examples of valid size ratios", FIFU_SLUG);
    };
    $fifu['height']['fit']['cover'] = function() {
        _e("crops the images (the options center, top and bottom will be available in the post editor);", FIFU_SLUG);
    };
    $fifu['height']['fit']['contain'] = function() {
        _e("shows full images (in smaller sizes);", FIFU_SLUG);
    };
    $fifu['height']['fit']['fill'] = function() {
        _e("deforms the images.", FIFU_SLUG);
    };
    $fifu['height']['delay']['time'] = function() {
        _e("time (in ms)", FIFU_SLUG);
    };

    // auto set
    $fifu['auto']['desc'] = function() {
        _e("Set featured images automatically. FIFU will check every minute if there are post types without featured images and will perform web searches based on post titles to get the image URLs. The image searches happen in a FIFU cloud service connected to a search engine and, due the costs involved, for now it's limited to 1,000 posts a day, one search at a time, and available only for license keys purchased/renewed from a year ago.", FIFU_SLUG);
    };
    $fifu['auto']['tab']['auto'] = function() {
        _e("Auto set", FIFU_SLUG);
    };
    $fifu['auto']['tab']['filters'] = function() {
        _e("Filters", FIFU_SLUG);
    };
    $fifu['auto']['tab']['blocklist'] = function() {
        _e("Blocklist", FIFU_SLUG);
    };
    $fifu['auto']['filter']['width'] = function() {
        _e("minimum width (px)", FIFU_SLUG);
    };
    $fifu['auto']['filter']['height'] = function() {
        _e("minimum height (px)", FIFU_SLUG);
    };
    $fifu['auto']['filter']['blocklist'] = function() {
        _e("List of strings that shouldn't be in the image URL:", FIFU_SLUG);
    };

    // giphy
    $fifu['giphy']['desc'] = function() {
        _e("Enable keyword gif search at featured image box.", FIFU_SLUG);
    };

    // unsplash
    $fifu['unsplash']['desc'] = function() {
        _e("Choose the size of the Unsplash images (loaded randomly or via keywords search). Examples of valid sizes: 500x500, 300x400, 1920x1080... Or leave this field empty to get the original size.", FIFU_SLUG);
    };

    // replace
    $fifu['replace']['desc'] = function() {
        _e("Define the URL of an image to be shown in case of image not found error.", FIFU_SLUG);
    };

    // default
    $fifu['default']['desc'] = function() {
        _e("Define the URL of a default image to be shown when you create (or update) a post with no featured image.", FIFU_SLUG);
    };

    // content
    $fifu['content']['desc'] = function() {
        _e("Some themes don't show the featured image on posts (only on home). If that's is your case and you would like to show the featured image on posts, just enable the toggle. The featured image will appear at the beginning of the content, before the text.", FIFU_SLUG);
    };

    // hide
    $fifu['hide']['desc'] = function() {
        _e("Hide the featured media (image, video or slider) on posts but keeping its visibility on home.", FIFU_SLUG);
    };

    // hover
    $fifu['hover']['desc'] = function() {
        _e("Choose a hover effect to be applied to the featured images on home.", FIFU_SLUG);
    };
    $fifu['hover']['placeholder'] = function() {
        _e("CSS selectors (optional)", FIFU_SLUG);
    };
    $fifu['hover']['hover17'] = function() {
        _e("315 Degrees", FIFU_SLUG);
    };
    $fifu['hover']['hover02'] = function() {
        _e("360 Degrees", FIFU_SLUG);
    };
    $fifu['hover']['hover07'] = function() {
        _e("Blur", FIFU_SLUG);
    };
    $fifu['hover']['hover10'] = function() {
        _e("Blur Gray Scale", FIFU_SLUG);
    };
    $fifu['hover']['hover04'] = function() {
        _e("Brighten", FIFU_SLUG);
    };
    $fifu['hover']['hover15'] = function() {
        _e("Circle", FIFU_SLUG);
    };
    $fifu['hover']['hover13'] = function() {
        _e("Flashing", FIFU_SLUG);
    };
    $fifu['hover']['hover08'] = function() {
        _e("Gray Scale", FIFU_SLUG);
    };
    $fifu['hover']['hover16'] = function() {
        _e("Horizontal Rotation", FIFU_SLUG);
    };
    $fifu['hover']['hover12'] = function() {
        _e("Opacity Color", FIFU_SLUG);
    };
    $fifu['hover']['hover11'] = function() {
        _e("Opacity White", FIFU_SLUG);
    };
    $fifu['hover']['hover18'] = function() {
        _e("Rainbow", FIFU_SLUG);
    };
    $fifu['hover']['hover06'] = function() {
        _e("Rotate", FIFU_SLUG);
    };
    $fifu['hover']['hover09'] = function() {
        _e("Sepia", FIFU_SLUG);
    };
    $fifu['hover']['hover14'] = function() {
        _e("Shine", FIFU_SLUG);
    };
    $fifu['hover']['hover05'] = function() {
        _e("Vertical Rotation", FIFU_SLUG);
    };
    $fifu['hover']['hover01'] = function() {
        _e("Zoom In", FIFU_SLUG);
    };
    $fifu['hover']['hover03'] = function() {
        _e("Zoom Out", FIFU_SLUG);
    };

    // validation
    $fifu['validation']['desc'] = function() {
        _e("It checks images addresses and, when an image is not found, its URL is not saved. However, each validation can take some seconds. It is not integrated with Content URL or REST API features.", FIFU_SLUG);
    };

    // configuration
    $fifu['configuration']['desc'] = function() {
        _e("It reads the HTML of your post and use the 1st image (or video) URL found as featured image. It happens when you click on Publish (or Update) button.", FIFU_SLUG);
    };
    $fifu['configuration']['requirement'] = function() {
        _e("the images need to be in an \"img\" HTML tag and videos in an \"iframe\" tag. Contents provided by [shortcode] can't be read.", FIFU_SLUG);
    };
    $fifu['configuration']['position'] = function() {
        _e("image (or video) position", FIFU_SLUG);
    };
    $fifu['configuration']['first'] = function() {
        _e("use the 1st (or nth) image (or video) as featured image", FIFU_SLUG);
    };
    $fifu['configuration']['hide'] = function() {
        _e("hide the 1st (or nth) image (or video) from content", FIFU_SLUG);
    };
    $fifu['configuration']['query'] = function() {
        _e("remove query strings (whatever follows the question mark sign \"?\")", FIFU_SLUG);
    };
    $fifu['configuration']['overwrite'] = function() {
        _e("overwrite the existing featured image (or video)", FIFU_SLUG);
    };
    $fifu['configuration']['prioritize'] = function() {
        _e("prioritize video than image (if both exist)", FIFU_SLUG);
    };
    $fifu['configuration']['decode'] = function() {
        _e("decode HTML entities", FIFU_SLUG);
    };

    // all
    $fifu['all']['desc'] = function() {
        _e("Update all your posts applying the configuration above. To repeat the process enable the toggle again.", FIFU_SLUG);
    };
    $fifu['all']['important'] = function() {
        _e("this process can take several minutes and can't be undone, so make a backup.", FIFU_SLUG);
    };
    $fifu['all']['requirement'] = function() {
        _e("if you have thousands of posts, access wp-config.php and add \"set_time_limit(1800);\" before the \"Happy publishing\" line. This ensures the process won't be killed before 30 minutes (the default value is 30 seconds).", FIFU_SLUG);
    };
    $fifu['all']['tip'] = function() {
        _e("to schedule this process (hourly, daily etc), you can use the hook fifu_event with your favorite cron event plugin.", FIFU_SLUG);
    };
    $fifu['all']['ignore'] = function() {
        _e("ignore posts that already have a featured image (or video)", FIFU_SLUG);
    };
    $fifu['all']['update'] = function() {
        _e("update all your posts now", FIFU_SLUG);
    };

    // metadata
    $fifu['metadata']['desc'] = function() {
        _e("Generate the database registers that helps WordPress components to work with the external images.", FIFU_SLUG);
    };
    $fifu['metadata']['generate'] = function() {
        _e("generate the missing metadata now", FIFU_SLUG);
    };

    // clean
    $fifu['clean']['desc'] = function() {
        _e("Clean the Image Metadata generated by FIFU, but not the URLs. This option might be necessary if you intend to deactivate the plugin and use only internal featured images again.", FIFU_SLUG);
    };
    $fifu['clean']['disabled'] = function() {
        _e("it will be automatically disabled when finished", FIFU_SLUG);
    };

    // dimensions
    $fifu['dimensions']['desc'] = function() {
        _e("Some themes and plugins may not work correctly without image dimensions. This feature can get ~1 image dimension by second.", FIFU_SLUG);
    };
    $fifu['dimensions']['now'] = function() {
        _e("save the dimensions of all featured images now", FIFU_SLUG);
    };

    // schedule
    $fifu['schedule']['desc'] = function() {
        _e("If you are setting the image URLs in a nonstandard way, the images probably won't be shown at front-end because some extra metadata is required. Here you can schedule an event to run each N minutes and check if there is some image URL without metadata and create that. The FIFU keys are listed on WP All Import > Custom Fields.", FIFU_SLUG);
    };
    $fifu['schedule']['interval'] = function() {
        _e("Interval (minutes)", FIFU_SLUG);
    };

    // database
    $fifu['database']['desc'] = function() {
        _e("Limit of rows to UPDATE, INSERT or DELETE by query. Higher this number, faster the features Content URL > All Posts, Image Metadata and Clean Metadata. However, if you have too limited resources, don't increase this value too much, otherwise your database can bring down.", FIFU_SLUG);
    };
    $fifu['database']['limit'] = function() {
        _e("Rows limit", FIFU_SLUG);
    };

    // delete
    $fifu['delete']['important'] = function() {
        _e("this plugin doesn't save images in the media library. It means that enabling the two toggles below all post types that have an external featured image will no longer have any featured image. And you can't undo this action later. This also applies to FIFU galleries, videos, sliders and shortcodes.", FIFU_SLUG);
    };
    $fifu['delete']['confirm'] = function() {
        _e("confirm that you are ready to lose your featured images", FIFU_SLUG);
    };
    $fifu['delete']['now'] = function() {
        _e("delete all your URLs now", FIFU_SLUG);
    };
    $fifu['delete']['requirement'] = function() {
        _e("Requirement: access Plugins -> Plugin Editor -> Select plugin to edit -> Featured Image from URL -> Select. Then change the value of FIFU_DELETE_ALL_URLS from false to true.", FIFU_SLUG);
    };

    // lazy
    $fifu['lazy']['desc'] = function() {
        _e("With lazy load, images and videos won't be loaded until user scrolls to them. It makes your home (or shop) faster.", FIFU_SLUG);
    };
    $fifu['lazy']['important'] = function() {
        _e("some themes and plugins (Jetpack for instance) have their own lazy load implementations, causing conflicts. Your images may not load if you have more than one lazy load component running at the same time.", FIFU_SLUG);
    };

    // flickr
    $fifu['flickr']['desc'] = function() {
        _e("Flickr images have thumbnails and FIFU is able to load the exactly thumbnail your site needs. The supported sizes are 75, 100, 150, 240, 320, 500, 640, 800 and 1024 px width. Larger sizes can't be used due a different URL pattern.", FIFU_SLUG);
    };
    $fifu['flickr']['important'] = function() {
        _e("the Lazy Load feature should be enabled.", FIFU_SLUG);
    };

    // api
    $fifu['api']['tab']['endpoints'] = function() {
        _e("Endpoints", FIFU_SLUG);
    };
    $fifu['api']['tab']['custom'] = function() {
        _e("Custom fields", FIFU_SLUG);
    };
    $fifu['api']['tab']['product'] = function() {
        _e("Creating your first product", FIFU_SLUG);
    };
    $fifu['api']['tab']['category'] = function() {
        _e("product category", FIFU_SLUG);
    };
    $fifu['api']['tab']['variable'] = function() {
        _e("variable product", FIFU_SLUG);
    };
    $fifu['api']['tab']['variation'] = function() {
        _e("product variation", FIFU_SLUG);
    };
    $fifu['api']['tab']['batch'] = function() {
        _e("batch", FIFU_SLUG);
    };
    $fifu['api']['tab']['post'] = function() {
        _e("post", FIFU_SLUG);
    };
    $fifu['api']['tab']['documentation'] = function() {
        _e("Documentation", FIFU_SLUG);
    };
    $fifu['api']['endpoint']['product'] = function() {
        _e("Product", FIFU_SLUG);
    };
    $fifu['api']['endpoint']['category'] = function() {
        _e("Product category", FIFU_SLUG);
    };
    $fifu['api']['endpoint']['variation'] = function() {
        _e("Product variation", FIFU_SLUG);
    };
    $fifu['api']['endpoint']['batch'] = function() {
        _e("Batch", FIFU_SLUG);
    };
    $fifu['api']['endpoint']['post'] = function() {
        _e("Post", FIFU_SLUG);
    };
    $fifu['api']['endpoint']['cpt'] = function() {
        _e("Custom post type", FIFU_SLUG);
    };
    $fifu['api']['custom']['image'] = function() {
        _e("Image", FIFU_SLUG);
    };
    $fifu['api']['custom']['title'] = function() {
        _e("Image title", FIFU_SLUG);
    };
    $fifu['api']['custom']['images'] = function() {
        _e("Product image + gallery (URLs delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['api']['custom']['titles'] = function() {
        _e("Product image title + gallery titles (delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['api']['custom']['video'] = function() {
        _e("Video", FIFU_SLUG);
    };
    $fifu['api']['custom']['videos'] = function() {
        _e("Product video + gallery (URLs delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['api']['custom']['slider'] = function() {
        _e("Slider", FIFU_SLUG);
    };
    $fifu['api']['custom']['key'] = function() {
        _e("Key", FIFU_SLUG);
    };
    $fifu['api']['documentation']['wordpress'] = function() {
        _e("WordPress REST API", FIFU_SLUG);
    };
    $fifu['api']['documentation']['woocommerce'] = function() {
        _e("WooCommerce REST API", FIFU_SLUG);
    };

    // shortcode
    $fifu['shortcode']['desc'] = function() {
        _e("This feature adds a field where you can input a shortcode instead of an URL. This way you could have a featured map, featured music etc.", FIFU_SLUG);
    };
    $fifu['shortcode']['important'] = function() {
        _e("FIFU has no control over your shortcode content or how your theme or plugins (or even other FIFU features) will deal with that. So normally there are style issues, except if you use a simple theme, such as Twenty Twenty. Featured Shortcode shouldn't work with page builders, lightboxes, sliders and ajax calls (the shortcode conversion happens on backend). If your theme use background-images, this feature won't work as well.", FIFU_SLUG);
    };
    $fifu['shortcode']['start1'] = function() {
        _e("install and active a shortcode plugin.", FIFU_SLUG);
    };
    $fifu['shortcode']['start2'] = function() {
        _e("create a shortcode that contains an HTML code, such as:", FIFU_SLUG);
    };
    $fifu['shortcode']['start3'] = function() {
        _e("create a new post and paste your [shortcode] into Featured Shortcode field on post editor;", FIFU_SLUG);
    };
    $fifu['shortcode']['start4'] = function() {
        _e("add a ratio (required field) and publish.", FIFU_SLUG);
    };
    $fifu['shortcode']['facebook'] = function() {
        _e("Facebook video", FIFU_SLUG);
    };
    $fifu['shortcode']['map'] = function() {
        _e("Google map", FIFU_SLUG);
    };
    $fifu['shortcode']['spotify'] = function() {
        _e("Spotify playlist", FIFU_SLUG);
    };
    $fifu['shortcode']['tab']['featured'] = function() {
        _e("Featured shortcode", FIFU_SLUG);
    };
    $fifu['shortcode']['tab']['important'] = function() {
        _e("Important", FIFU_SLUG);
    };
    $fifu['shortcode']['tab']['start'] = function() {
        _e("Getting started", FIFU_SLUG);
    };

    // slider
    $fifu['slider']['desc'] = function() {
        _e("This feature allows you to have a slider of images instead of a regular featured image. It's often quite useful on some types of websites, such as real states. It can run fast even with a huge amount of big images (just follow the performance tips below).", FIFU_SLUG);
    };
    $fifu['slider']['lazy'] = function() {
        _e("enable FIFU Settings > Performance > Lazy Load", FIFU_SLUG);
    };
    $fifu['slider']['jetpack'] = function() {
        _e("install Jetpack plugin and enable Jetpack Settings > Performance > Speed up image load times", FIFU_SLUG);
    };
    $fifu['slider']['tab']['configuration'] = function() {
        _e("Configuration", FIFU_SLUG);
    };
    $fifu['slider']['tab']['tips'] = function() {
        _e("Performance tips", FIFU_SLUG);
    };
    $fifu['slider']['featured'] = function() {
        _e("show featured slider fields on post editor", FIFU_SLUG);
    };
    $fifu['slider']['pause'] = function() {
        _e("pause autoplay on hover", FIFU_SLUG);
    };
    $fifu['slider']['buttons'] = function() {
        _e("show prev/next buttons", FIFU_SLUG);
    };
    $fifu['slider']['start'] = function() {
        _e("start automatically", FIFU_SLUG);
    };
    $fifu['slider']['click'] = function() {
        _e("show gallery on click", FIFU_SLUG);
    };
    $fifu['slider']['thumb'] = function() {
        _e("show thumbnails gallery", FIFU_SLUG);
    };
    $fifu['slider']['time'] = function() {
        _e("time between each transition (in ms)", FIFU_SLUG);
    };
    $fifu['slider']['duration'] = function() {
        _e("transition duration (in ms)", FIFU_SLUG);
    };

    // social
    $fifu['social']['desc'] = function() {
        _e("Use social tags to share your posts (and their featured images) on the social media.", FIFU_SLUG);
    };
    $fifu['social']['add'] = function() {
        _e("add social tags", FIFU_SLUG);
    };
    $fifu['social']['only'] = function() {
        _e("only image tags", FIFU_SLUG);
    };

    // rss
    $fifu['rss']['desc'] = function() {
        _e("Add media RSS tags in the RSS feed. This way, services that make use of RSS, such as Google News, can show the featured images.", FIFU_SLUG);
    };

    // title
    $fifu['title']['desc'] = function() {
        _e("Set the title of a featured image with the post title.", FIFU_SLUG);
    };
    $fifu['title']['copy'] = function() {
        _e("copy the post title to FIFU alt/title field (it has effect when you click on Publish button in the post editor)", FIFU_SLUG);
    };
    $fifu['title']['always'] = function() {
        _e("always use the post title as image title (it will ignore FIFU alt/title field)", FIFU_SLUG);
    };

    // video
    $fifu['video']['desc'] = function() {
        _e("FIFU supports videos from YouTube, Vimeo, Imgur, 9GAG, Cloudinary, Tumblr and Publitio (videos hosted elsewhere are not supported).", FIFU_SLUG);
    };

    // thumbnail
    $fifu['thumbnail']['desc'] = function() {
        _e("Show the video thumbnail instead of the video. Thumbnails are images, so they are loaded much faster than embedded videos.", FIFU_SLUG);
    };

    // play
    $fifu['play']['desc'] = function() {
        _e("Add play button to video thumbnail. Clicking on that, the video starts inline or in a lightbox.", FIFU_SLUG);
    };
    $fifu['play']['hide'] = function() {
        _e("hide from grid", FIFU_SLUG);
    };

    // width
    $fifu['width']['desc'] = function() {
        _e("Define a minimum width that a theme area should have to show a video. FIFU automatically shows a thumbnail when the minimum width is not reached.", FIFU_SLUG);
    };

    // black
    $fifu['black']['desc'] = function() {
        _e("Unlike Youtube, Vimeo videos can't fit a theme area without generating a vertical padding. Here you can change the background color from transparent to black.", FIFU_SLUG);
    };

    // mouseover
    $fifu['mouseover']['desc'] = function() {
        _e("Play a video on \"mouseover\" and pause on \"mouseout\".", FIFU_SLUG);
    };

    // autoplay
    $fifu['autoplay']['desc'] = function() {
        _e("Autoplay videos (available for YouTube and Vimeo).", FIFU_SLUG);
    };

    // loop
    $fifu['loop']['desc'] = function() {
        _e("Loop videos (available for YouTube and Vimeo).", FIFU_SLUG);
    };

    // mute
    $fifu['mute']['desc'] = function() {
        _e("Start the videos without audio (available for YouTube and Vimeo).", FIFU_SLUG);
    };

    // background
    $fifu['background']['desc'] = function() {
        _e("Start the videos in background, which means autoplay, no controls and no sound.", FIFU_SLUG);
    };

    // related
    $fifu['related']['desc'] = function() {
        _e("Show related videos when the video ends.", FIFU_SLUG);
    };

    // icon
    $fifu['icon']['desc'] = function() {
        _e("Add icons to the video thumbnails in the WooCommerce gallery.", FIFU_SLUG);
    };
    $fifu['icon']['css'] = function() {
        _e("CSS selector", FIFU_SLUG);
    };
    $fifu['icon']['info'] = function() {
        _e("In order to FIFU identify your gallery, it's necessary to inform its CSS selector here. The default value is ol.flex-control-thumbs, but you may need a different selector if your theme overwrites the original WooCommerce layout.", FIFU_SLUG);
    };

    // zoom
    $fifu['zoom']['desc'] = function() {
        _e("Disable lightbox and zoom from image gallery.", FIFU_SLUG);
    };

    // category
    $fifu['category']['desc'] = function() {
        _e("Set one image to each category. The chosen image is the featured image from the most recent product from that category.", FIFU_SLUG);
    };

    // grid
    $fifu['grid']['desc'] = function() {
        _e("Show the category image on the category page, immediately before the product grid.", FIFU_SLUG);
    };

    // variable
    $fifu['variable']['desc'] = function() {
        _e("Add FIFU fields (featured image and image gallery) to product variations.", FIFU_SLUG);
    };
    $fifu['variable']['important'] = function() {
        _e("variation image gallery requires <a href='https://woocommerce.com/products/woocommerce-additional-variation-images/' target='_blank'>WooCommerce Additional Variation Images</a>. Unofficial solutions are not supported.", FIFU_SLUG);
    };

    // import
    $fifu['import']['desc'] = function() {
        _e("Use FIFU with WooCommerce import.", FIFU_SLUG);
    };
    $fifu['import']['tab']['import'] = function() {
        _e("Importing products...", FIFU_SLUG);
    };
    $fifu['import']['tab']['custom'] = function() {
        _e("Custom fields", FIFU_SLUG);
    };
    $fifu['import']['import']['csv'] = function() {
        _e("CSV example", FIFU_SLUG);
    };
    $fifu['import']['custom']['key'] = function() {
        _e("Key", FIFU_SLUG);
    };
    $fifu['import']['custom']['image'] = function() {
        _e("Image", FIFU_SLUG);
    };
    $fifu['import']['custom']['alt'] = function() {
        _e("Alt", FIFU_SLUG);
    };
    $fifu['import']['custom']['video'] = function() {
        _e("Video", FIFU_SLUG);
    };
    $fifu['import']['custom']['images'] = function() {
        _e("Image + image gallery (URLs delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['import']['custom']['titles'] = function() {
        _e("Title + titles gallery (delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['import']['custom']['videos'] = function() {
        _e("Video + video gallery (URLs delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['import']['custom']['slider'] = function() {
        _e("Slider (URLs delimited by \"|\")", FIFU_SLUG);
    };

    // addon
    $fifu['addon']['desc'] = function() {
        _e("FIFU automatically adds its add-on to WP All Import.", FIFU_SLUG);
    };
    $fifu['addon']['tab']['import'] = function() {
        _e("Importing products...", FIFU_SLUG);
    };
    $fifu['addon']['tab']['custom'] = function() {
        _e("Custom fields", FIFU_SLUG);
    };
    $fifu['addon']['tab']['faq'] = function() {
        _e("FAQ", FIFU_SLUG);
    };
    $fifu['addon']['import']['csv'] = function() {
        _e("CSV example", FIFU_SLUG);
    };
    $fifu['addon']['custom']['key'] = function() {
        _e("Key", FIFU_SLUG);
    };
    $fifu['addon']['custom']['image'] = function() {
        _e("Featured image URL", FIFU_SLUG);
    };
    $fifu['addon']['custom']['title'] = function() {
        _e("Featured image title", FIFU_SLUG);
    };
    $fifu['addon']['custom']['video'] = function() {
        _e("Featured video URL", FIFU_SLUG);
    };
    $fifu['addon']['custom']['images'] = function() {
        _e("Featured image URL + gallery URLs (delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['addon']['custom']['titles'] = function() {
        _e("Featured image title + gallery titles (delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['addon']['custom']['videos'] = function() {
        _e("Featured video URL + gallery URLs (delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['addon']['custom']['slider'] = function() {
        _e("Featured slider URLs (delimited by \"|\")", FIFU_SLUG);
    };
    $fifu['addon']['faq']['woocommerce'] = function() {
        _e("<a href='http://www.wpallimport.com/documentation/woocommerce/variable-products/'>Importing variable products to WooCommerce</a>", FIFU_SLUG);
    };

    // key
    $fifu['key']['desc'] = function() {
        _e("Please insert your email and license key below to use this plugin without limitations.", FIFU_SLUG);
    };
    $fifu['key']['domain'] = function() {
        _e("if your domain has changed, please contact the support", FIFU_SLUG);
    };
    $fifu['key']['buy'] = function() {
        _e("if you intend to use FIFU in multiple distinct sites you can buy more license keys <a href='https://fifu.app/#price' target='_blank'>here</a>", FIFU_SLUG);
    };
    $fifu['key']['email'] = function() {
        _e("Email", FIFU_SLUG);
    };
    $fifu['key']['address'] = function() {
        _e("Email address where you received the license key", FIFU_SLUG);
    };
    $fifu['key']['key'] = function() {
        _e("License key", FIFU_SLUG);
    };

    return $fifu;
}

function fifu_get_strings_meta_box() {
    $fifu = array();

    // word
    $fifu['word']['next'] = function() {
        _e("Next", FIFU_SLUG);
    };
    $fifu['word']['remove'] = function() {
        _e("Remove", FIFU_SLUG);
    };

    // common
    $fifu['common']['alt'] = function() {
        _e("alt/title attribute (optional)", FIFU_SLUG);
    };
    $fifu['common']['image'] = function() {
        _e("Image URL", FIFU_SLUG);
    };
    $fifu['common']['preview'] = function() {
        _e("Preview", FIFU_SLUG);
    };
    $fifu['common']['video'] = function() {
        _e("Video URL", FIFU_SLUG);
    };

    // details
    $fifu['detail']['ratio'] = function() {
        _e("Ratio", FIFU_SLUG);
    };
    $fifu['detail']['eg'] = function() {
        _e("e.g.:", FIFU_SLUG);
    };

    // titles
    $fifu['title']['category']['video'] = function() {
        _e("Featured video", FIFU_SLUG);
    };
    $fifu['title']['category']['image'] = function() {
        _e("Featured image", FIFU_SLUG);
    };

    // shortcode
    $fifu['shortcode']['placeholder'] = function() {
        _e("Shortcode", FIFU_SLUG);
    };

    // video
    $fifu['video']['remove'] = function() {
        _e("remove external featured video", FIFU_SLUG);
    };

    // image
    $fifu['image']['show']['center'] = function() {
        _e("center", FIFU_SLUG);
    };
    $fifu['image']['show']['top'] = function() {
        _e("top", FIFU_SLUG);
    };
    $fifu['image']['show']['bottom'] = function() {
        _e("bottom", FIFU_SLUG);
    };
    $fifu['image']['show']['left'] = function() {
        _e("left", FIFU_SLUG);
    };
    $fifu['image']['show']['right'] = function() {
        _e("right", FIFU_SLUG);
    };
    $fifu['image']['ignore'] = function() {
        _e("ignore Content URL", FIFU_SLUG);
    };
    $fifu['image']['giphy'] = function() {
        _e("Giphy search", FIFU_SLUG);
    };
    $fifu['image']['height'] = function() {
        _e("You've enabled Same Height feature, that works by cropping the image. Here you can define which part of the image should be shown.", FIFU_SLUG);
    };
    $fifu['image']['keywords'] = function() {
        _e("Image URL or Keywords", FIFU_SLUG);
    };
    $fifu['image']['help'] = function() {
        _e("Examples: https://domain.com/image.jpg (image URL); sea,sun (keywords); empty (random image).", FIFU_SLUG);
    };
    $fifu['image']['remove'] = function() {
        _e("remove external featured image", FIFU_SLUG);
    };
    $fifu['image']['sirv']['add'] = function() {
        _e("Add image from Sirv", FIFU_SLUG);
    };
    $fifu['image']['sirv']['choose'] = function() {
        _e("Choose Sirv image", FIFU_SLUG);
    };

    return $fifu;
}

function fifu_get_strings_meta_box_php() {
    $fifu = array();

    // common
    $fifu['common']['wait'] = function() {
        return __("Please wait some seconds...", FIFU_SLUG);
    };

    // wait
    $fifu['title']['product']['image'] = function() {
        return __("Product image", FIFU_SLUG);
    };
    $fifu['title']['product']['images'] = function() {
        return __("Image gallery", FIFU_SLUG);
    };
    $fifu['title']['product']['video'] = function() {
        return __("Featured video", FIFU_SLUG);
    };
    $fifu['title']['product']['videos'] = function() {
        return __("Video gallery", FIFU_SLUG);
    };
    $fifu['title']['product']['slider'] = function() {
        return __("Featured slider", FIFU_SLUG);
    };
    $fifu['title']['post']['image'] = function() {
        return __("Featured image", FIFU_SLUG);
    };
    $fifu['title']['post']['video'] = function() {
        return __("Featured video", FIFU_SLUG);
    };
    $fifu['title']['post']['slider'] = function() {
        return __("Featured slider", FIFU_SLUG);
    };
    $fifu['title']['post']['shortcode'] = function() {
        return __("Featured shortcode", FIFU_SLUG);
    };

    // variation
    $fifu['variation']['field'] = function() {
        return __("Product Image (URL)", FIFU_SLUG);
    };
    $fifu['variation']['info'] = function() {
        return __("Powered by Featured Image from URL plugin", FIFU_SLUG);
    };
    $fifu['variation']['image'] = function() {
        return __("Image URL", FIFU_SLUG);
    };
    $fifu['variation']['images'] = function() {
        return __("Gallery Image (URL)", FIFU_SLUG);
    };
    $fifu['variation']['wavi'] = function() {
        return __("Requires WooCommerce Additional Variation Images plugin", FIFU_SLUG);
    };

    return $fifu;
}

function fifu_get_strings_wai() {
    $fifu = array();

    // titles
    $fifu['title']['image'] = function() {
        return __("Featured image (URL)", FIFU_SLUG);
    };
    $fifu['title']['title'] = function() {
        return __("Featured image title", FIFU_SLUG);
    };
    $fifu['title']['video'] = function() {
        return __("Featured video (URL)", FIFU_SLUG);
    };
    $fifu['title']['images'] = function() {
        return __("Featured image URL + gallery URLs", FIFU_SLUG);
    };
    $fifu['title']['titles'] = function() {
        return __("Featured image title + gallery titles", FIFU_SLUG);
    };
    $fifu['title']['videos'] = function() {
        return __("Featured video URL + gallery URLs", FIFU_SLUG);
    };
    $fifu['title']['slider'] = function() {
        return __("Featured slider (URLs)", FIFU_SLUG);
    };
    $fifu['title']['delimiter'] = function() {
        return __("List delimiter", FIFU_SLUG);
    };

    // info
    $fifu['info']['delimited'] = function() {
        return __("Delimited by |", FIFU_SLUG);
    };
    $fifu['info']['default'] = function() {
        return __("Default values is |", FIFU_SLUG);
    };

    return $fifu;
}
