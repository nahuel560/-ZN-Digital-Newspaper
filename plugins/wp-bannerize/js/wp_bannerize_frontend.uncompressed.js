/**
 * Javascript functions
 *
 * @package         wp_bannerize
 * @subpackage      wp_bannerzie_frontend.js
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright © 2008-2010 Saidmade Srl
 * @version         2.7.0
 */

var SMWPBannerizeJavascript = {
	vesion : "1.0.0",

	incrementClickCount : function(id) {
		jQuery.post(wpBannerizeMainL10n.ajaxURL, {
                id : id
            }
        );
	}
};