/**
 * Declaring and initializing global variables
 */
var $doc           = jQuery(document),
    $window        = jQuery(window),
    $body          = jQuery('body'),
    $themeHeader   = jQuery('#theme-header'),
    $mainNav       = jQuery('#main-nav'),
    $container     = jQuery('#tie-container'),
    is_RTL         = tie.is_rtl ? true : false,
    intialWidth    = window.innerWidth,
    isDuringAjax   = false,
    adBlock        = false,
    scrollBarWidth = false,
    mobileMenu     = false;

/* jQuery.flexMenu 1.5 https://github.com/352Media/flexMenu */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e(jQuery)}(function(e){var i,n=window.innerWidth,l=[];e(window).resize(function(){clearTimeout(i),i=setTimeout(function(){e(window).width()!==n&&(e(l).each(function(){e(this).flexMenu({undo:!0}).flexMenu(this.options)}),n=e(window).width())},200)}),e.fn.flexMenu=function(i){var n,o=e.extend({threshold:2,cutoff:2,linkText:"More",linkTitle:"View More",linkTextAll:"Menu",linkTitleAll:"Open/Close Menu",shouldApply:function(){return!0},showOnHover:!0,popupAbsolute:!0,popupClass:"",undo:!1},i);return this.options=o,(n=e.inArray(this,l))>=0?l.splice(n,1):l.push(this),this.each(function(){var i=e(this),n=i.find("> li"),l=n.length;if(l){var t,f,u,p,r,d,s=n.first(),a=n.last(),h=Math.floor(s.offset().top),c=Math.floor(s.outerHeight(!0)),M=!1;function v(e){return Math.ceil(e.offset().top)>=h+c}if(v(a)&&l>o.threshold&&!o.undo&&i.is(":visible")&&o.shouldApply()){var w=e('<ul class="flexMenu-popup" style="display:none;'+(o.popupAbsolute?" position: absolute;":"")+'"></ul>');for(w.addClass(o.popupClass),d=l;d>1;d--){if(f=v(t=i.find("> li:last-child")),d-1<=o.cutoff){e(i.children().get().reverse()).appendTo(w),M=!0;break}if(!f)break;t.appendTo(w)}M?i.append('<li class="flexMenu-viewMore flexMenu-allInPopup"><a href="#" title="'+o.linkTitleAll+'">'+o.linkTextAll+"</a></li>"):i.append('<li class="flexMenu-viewMore"><a href="#" title="'+o.linkTitle+'">'+o.linkText+"</a></li>"),v(u=i.find("> li.flexMenu-viewMore"))&&i.find("> li:nth-last-child(2)").appendTo(w),w.children().each(function(e,i){w.prepend(i)}),u.append(w),i.find("> li.flexMenu-viewMore > a").click(function(i){var n;n=u,e("li.flexMenu-viewMore.active").not(n).find("> ul").hide(),w.toggle(),i.preventDefault()}),o.showOnHover&&"undefined"!=typeof Modernizr&&!Modernizr.touch&&u.hover(function(){w.show()},function(){w.hide()})}else if(o.undo&&i.find("ul.flexMenu-popup")){for(p=(r=i.find("ul.flexMenu-popup")).find("li").length,d=1;d<=p;d++)r.find("> li:first-child").appendTo(i);r.remove(),i.find("> li.flexMenu-viewMore").remove()}}})}});

/* LazyLoad */
!function(e,t){"function"==typeof define&&define.amd?define(function(){return t(e)}):"object"==typeof exports?module.exports=t:e.emergence=t(e)}(this,function(e){"use strict";var t,n,i,o,r,a,l,s={},c=function(){},d=function(){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|playbook|silk/i.test(navigator.userAgent)},u=function(e){var t=e.offsetWidth,n=e.offsetHeight,i=0,o=0;do{isNaN(e.offsetTop)||(i+=e.offsetTop),isNaN(e.offsetLeft)||(o+=e.offsetLeft)}while(null!==(e=e.offsetParent));return{width:t,height:n,top:i,left:o}},f=function(e){if(function(e){return null===e.offsetParent}(e))return!1;var t,i,o,s=u(e),c=function(e){var t,n;return e!==window?(t=e.clientWidth,n=e.clientHeight):(t=window.innerWidth||document.documentElement.clientWidth,n=window.innerHeight||document.documentElement.clientHeight),{width:t,height:n}}(n),d=function(e){return e!==window?{x:e.scrollLeft+u(e).left,y:e.scrollTop+u(e).top}:{x:window.pageXOffset||document.documentElement.scrollLeft,y:window.pageYOffset||document.documentElement.scrollTop}}(n),f=s.width,m=s.height,h=s.top;s.left;return t=h+m*r,i=h+m-m*r,o=d.y+a,t<d.y-l+c.height&&i>o},m=function(){t||(clearTimeout(t),t=setTimeout(function(){s.engage(),t=null},i))};return s.init=function(e){var t,s,u=function(e,t){return parseInt(e||t,10)};n=(e=e||{}).container||window,o=void 0===e.handheld||e.handheld,i=u(e.throttle,250),t=e.elemCushion,s=.1,r=parseFloat(t||s),a=u(e.offsetTop,0),u(e.offsetRight,0),l=u(e.offsetBottom,0),u(e.offsetLeft,0),c=e.callback||c,"querySelectorAll"in document?(d()&&o||!d())&&(window.addEventListener?(window.addEventListener("load",m,!1),n.addEventListener("scroll",m,!1),n.addEventListener("resize",m,!1)):(document.attachEvent("onreadystatechange",function(){"complete"===document.readyState&&m()}),n.attachEvent("onscroll",m),n.attachEvent("onresize",m))):console.log("Emergence.js is not supported in this browser.")},s.engage=function(){if(tie.lazyload){for(var e=(l=document.querySelectorAll("[data-src]")).length,t=0;t<e;t++)d=l[t],f(d)&&(d.setAttribute("src",d.getAttribute("data-src")),d.removeAttribute("data-src"),d.className+=" lazy-done",c(d,"tie_img_visible"),jQuery.fn.masonry&&jQuery("#masonry-grid").masonry("layout"));var n=(l=document.querySelectorAll("[data-lazy-bg]")).length;for(t=0;t<n;t++)d=l[t],f(d)&&(d.setAttribute("style","background-image:url("+d.getAttribute("data-lazy-bg")+")"),d.removeAttribute("data-lazy-bg"),d.className=d.className,c(d,"tie_bg_visible"))}if(tie.is_taqyeem_active){var i=(l=document.querySelectorAll("[data-lazy-pie]")).length;for(t=0;t<i;t++)if(d=l[t],f(d)){var o=parseInt(d.getAttribute("data-pct")),r=d.getElementsByClassName("circle_bar")[0],a=(100-o)/100*Math.PI*38;r.setAttribute("style","stroke-dashoffset:"+a+"px"),d.removeAttribute("data-lazy-pie"),d.className=d.className,c(d,"tie_pie_visible")}var l,d,u=(l=document.querySelectorAll("[data-lazy-percent]")).length;for(t=0;t<u;t++)d=l[t],f(d)&&(d.setAttribute("style","width:"+d.getAttribute("data-rate-val")),d.removeAttribute("data-lazy-percent"),d.className=d.className,c(d,"tie_rate_visible"))}e||i||u||n||s.disengage()},s.disengage=function(){window.removeEventListener?(n.removeEventListener("scroll",m,!1),n.removeEventListener("resize",m,!1)):(n.detachEvent("onscroll",m),n.detachEvent("onresize",m)),clearTimeout(t)},s});

/*! tieFitVids */
!function(t){"use strict";t.fn.tieFitVids=function(e){var i={customSelector:null,ignore:null};e&&t.extend(i,e);var r=['iframe[src*="player.vimeo.com"]','iframe[src*="player.twitch.tv"]','iframe[src*="youtube.com"]','iframe[src*="youtube-nocookie.com"]','iframe[src*="maps.google.com"]','iframe[src*="google.com/maps"]','iframe[src*="dailymotion.com"]','iframe[src*="twitter.com/i/videos"]',"object","embed"];if(r=r.join(","),i.customSelector&&r.push(i.customSelector),document.querySelectorAll(r).length){var a=".tie-ignore-fitvid, #buddypress";return i.ignore&&(a=a+", "+i.ignore),this.each(function(){t(this).find(r).each(function(){var e=t(this);if(!(e.parents(a).length>0||("embed"===this.tagName.toLowerCase()||"object"===this.tagName.toLowerCase())&&e.parent("object").length||e.parent(".tie-fluid-width-video-wrapper").length)){e.css("height")||e.css("width")||!isNaN(e.attr("height"))&&!isNaN(e.attr("width"))||(e.attr("height",9),e.attr("width",16));var i=("object"===this.tagName.toLowerCase()||e.attr("height")&&!isNaN(parseInt(e.attr("height"),10))?parseInt(e.attr("height"),10):e.height())/(isNaN(parseInt(e.attr("width"),10))?e.width():parseInt(e.attr("width"),10));e.removeAttr("height").removeAttr("width"),e.wrap('<div class="tie-fluid-width-video-wrapper"></div>').parent(".tie-fluid-width-video-wrapper").css("padding-top",100*i+"%")}})})}}}(window.jQuery);

/*
 * General Scripts
 */
$doc.ready(function(){

	'use strict';

	// Debugging
 	performance.mark('TieStart');


 	/**
	 * LazyLoad
	 */
 	emergence.init();


	/**
	 * Ad Blocker
	 */
	if( tie.ad_blocker_detector && typeof $tieE3 === 'undefined' ){
		adBlock = true;
		tieBtnOpen('#tie-popup-adblock');
	}


	/**
	 * Logged-in user icon
	 */
	$doc.on('click', '.profile-btn', function(){
		return false;
	});


	/**
	 * Responsive Videos
	 * use .tie-ignore-fitvid to manually exclude in videos for example in the post editor.
	 */
	$container.tieFitVids();


	/**
	 * Masonry
	 */
	if( jQuery.fn.masonry ){

		var $grid = jQuery('#masonry-grid');

		if( $grid.length ){

			var onloadsWrap = jQuery('#media-page-layout');

			$grid.masonry({
				columnWidth     : '.grid-sizer',
				gutter          : '.gutter-sizer',
				itemSelector    : '.post-element',
				percentPosition : true,
				isInitLayout    : false, // v3
				initLayout      : false, // v4
				originLeft      : ! is_RTL,
				isOriginLeft    : ! is_RTL
			}).addClass( 'masonry-loaded' );

			// Run after masonry complete
			$grid.masonry( 'on', 'layoutComplete', function(){
				isDuringAjax = false;
			});

			// Run the masonry
			$grid.masonry();

			// Load images and re fire masonry
			if( jQuery.fn.imagesLoaded ){
				$grid.imagesLoaded().progress( function(){
					$grid.masonry('layout');
				});
			}

			onloadsWrap.find('.loader-overlay').fadeOut().remove();
			onloadsWrap.find('.post-element').addClass('tie-animate-slideInUp tie-animate-delay');

			jQuery(window).resize(function () {
				onloadsWrap.find('.post-element').removeClass( 'tie-animate-slideInUp tie-animate-delay' );
			});

		}
	}


	/**
	 * Tabs
	 */
	var $tabsWrapper = jQuery('.tabs-wrapper').get(), $tab = null;
	for (var i = 0, length = $tabsWrapper.length; i < length; i++) {

		$tab = jQuery( $tabsWrapper[i] );
		$tab.find('.tabs li').first().addClass('active');

		if( $tab.hasClass( 'tabs-vertical') ){
			var minHeight = $tab.find('.tabs').outerHeight();
			$tab.find('.tab-content').css({minHeight: minHeight});
		}

		$tab.find('.tabs li').on( 'click', function(){

			var $tabTitle = jQuery( this );
			if( ! $tabTitle.hasClass( 'active' ) ){

				$tabTitle.parents('.tabs').find('li').removeClass('active');
				$tabTitle.addClass('active');

				$tabTitle.parents('.tabs-wrapper').find('.tab-content').hide().addClass('is-not-active');
				var currentTab = $tabTitle.find('a').attr('href'),
				     activeTab = jQuery( currentTab ).show();

				activeTab.find('.tab-content-elements li').addClass('tie-animate-slideInUp tie-animate-delay');
				activeTab.find('.tab-content-wrap').addClass('tie-animate-slideInUp');

				tie_animate_element( activeTab );
			}

			return false;
		});
	};


	/**
	 * Magazine box filters flexmenu
	 */
	var $flexmenu_elements = jQuery('.is-flex-tabs, .is-flex-tabs-shortcodes .tabs');
	if( $flexmenu_elements.length ){
		$flexmenu_elements.flexMenu({
			threshold   : 0,
			cutoff      : 0,
			linkText    : '<span class="tie-icon-dots-three-horizontal"><span class="screen-reader-text">More</span></span>',
			linkTextAll : '<span class="tie-icon-dots-three-horizontal"><span class="screen-reader-text">More</span></span>',
			linkTitle   : '',
			linkTitleAll: '',
			showOnHover : ( intialWidth > 991 ? true : false )
		});

		$flexmenu_elements.css({'opacity':1});
	}


	/**
	 * Mobile Sticky Nav
	 */
	function navSmartSticky(e) {

		var scrollInFirst          = true,
		    scrollInterval         = 0,
		    scrollPrevious         = 0,
		    scrollDirection        = 0,
		    loadStickyOffset       = 0,
		    loadAdminBar           = false,
		    nav_sticky_up          = ( tie.sticky_mobile_behavior == 'upwards') ? true : false,
		    nav_sticky_offset_type = 'auto',
		    nav_sticky_offset      = 0,
		    nav_sticky_offset_full = 0,
		    windwidth              = window.innerWidth;


		// Just for Tablet & Mobile
		if ( windwidth > 991) {
			return;
		}

		if (nav_sticky_offset_type !== 'size') {

			var calcbar = 0,
			    wpadminbar = 0;

			// Check if the admin bar is active
			if( $body.hasClass('admin-bar') ){
				var $wpadminbarElem = jQuery('#wpadminbar');

				if ( $wpadminbarElem.length > 0) {
					calcbar = $wpadminbarElem.outerHeight();
					wpadminbar = calcbar;

					if ('resize' !== e.type) {
						loadAdminBar = wpadminbar;
					}

					if ( 'absolute' === $wpadminbarElem.css('position')) {
						wpadminbar = 0;
						if ('resize' !== e.type) {
							loadAdminBar = 0;
						}
					}
				}
			}

			// Determine the Sticky Nav selector based on header layout.
			var $stickyNav     = $themeHeader.hasClass('header-layout-1') ? $mainNav : jQuery('.logo-container'),
			    $stickyNavWrap = $stickyNav.parent();

			var elOffset = $stickyNav.not('.fixed-nav').offset();
			nav_sticky_offset_full = $stickyNavWrap.outerHeight() + elOffset.top;

			if (elOffset && !$stickyNav.hasClass('.fixed-nav')) {
				nav_sticky_offset = elOffset.top;
				loadStickyOffset  = elOffset.top;
			} else {
				nav_sticky_offset = loadStickyOffset;
			}

			if (32 === loadAdminBar) {
				if (46 === calcbar) {
					nav_sticky_offset = nav_sticky_offset - wpadminbar + 14;
				} else {
					nav_sticky_offset = nav_sticky_offset - wpadminbar;
				}
			}
			else if (46 === loadAdminBar || 0 === loadAdminBar) {
				if (32 === calcbar) {
						nav_sticky_offset = nav_sticky_offset - wpadminbar - 14;
				} else {
						nav_sticky_offset = nav_sticky_offset - wpadminbar;
				}
			}
		}

		var navHeight = jQuery($stickyNav).outerHeight();
		$stickyNavWrap.data('min-height', nav_sticky_offset_full - navHeight);
		$stickyNavWrap.height(navHeight);

		if ('resize' !== e.type) {

			if (nav_sticky_up) {
				$stickyNavWrap.addClass('sticky-type-slide');
			}

			jQuery(window).scroll(function (e) {
				if (e.originalEvent) {

					var scrollCurrent = jQuery(window).scrollTop();

					if (nav_sticky_up) {
						if (scrollCurrent > nav_sticky_offset_full) {
							$stickyNav.addClass('fixed-nav');
						}
						if (scrollCurrent <= nav_sticky_offset) {
							$stickyNav.removeClass('fixed-nav');
						}
						if (scrollCurrent > scrollPrevious) {
							scrollInterval = 0;
							scrollDirection = 'down';
							$stickyNav.addClass('sticky-down').removeClass('sticky-up');
						} else {
							scrollInterval += scrollPrevious - scrollCurrent;
							scrollDirection = 'up';
							$stickyNav.addClass('sticky-up').removeClass('sticky-down');
						}
						if (scrollInterval > 150 && 'up' === scrollDirection) {
							$stickyNav.addClass('sticky-nav-slide-visible');
							jQuery(document).trigger('sticky-nav-visible');
						} else {
							$stickyNav.removeClass('sticky-nav-slide-visible');
							jQuery(document).trigger('sticky-nav-hide');
						}
						if (scrollCurrent > nav_sticky_offset_full + 150) {
							$stickyNav.addClass('sticky-nav-slide');
						} else {
							$stickyNav.removeClass('sticky-nav-slide');
						}
						if (scrollInFirst && scrollCurrent > nav_sticky_offset_full + 150) {
								$stickyNav.addClass('sticky-nav-slide sticky-nav-slide-visible sticky-up');
								jQuery(document).trigger('sticky-nav-visible');
								scrollInterval = 151;
								scrollDirection = 'up';
								scrollInFirst = false;
						}
					} else {

						if (scrollCurrent > nav_sticky_offset) {
							$stickyNav.addClass('fixed-nav default-behavior-mode');
							jQuery(document).trigger('sticky-nav-visible');
						} else {
							$stickyNav.removeClass('fixed-nav');
							jQuery(document).trigger('sticky-nav-hide');
						}
					}
					scrollPrevious = scrollCurrent;
				}
			});
		}
	}

	if( tie.sticky_mobile ){
		$window.on( 'load', navSmartSticky );
		$window.resize(navSmartSticky);
	}


	/**
	 * Popup Module
	 */
	var $tiePopup = jQuery('.tie-popup' );

	$doc.on( 'click', '.tie-popup-trigger', function (event){
		event.preventDefault();
		tieBtnOpen('#tie-popup-login');
	});

	if ( jQuery('.tie-search-trigger').length ){

		if ( tie.type_to_search && window.self === window.top ){ // Make sure we are not in an iframe to avoid isues with front-end builders such as Elementor
			$doc.bind('keydown', function(e){

				if( ! jQuery( 'input, textarea' ).is( ':focus' ) && ! jQuery( '#tie-popup-login' ).is( ':visible' ) && ! e.ctrlKey && ! e.metaKey && e.keyCode >= 65 && e.keyCode <= 90 ){
					$container.removeClass('side-aside-open');
					tieBtnOpen('#tie-popup-search-wrap');
				}
			});
		}

		jQuery('.tie-search-trigger').on( 'click', function (){
			tieBtnOpen('#tie-popup-search-wrap');
			return false;
		});
	}

	function tieBtnOpen(windowToOpen){

		jQuery(windowToOpen).show();

		if( windowToOpen == '#tie-popup-search-wrap' ){
			$tiePopup.find('form input[type="text"]').focus();
		}

		tie_animate_element( jQuery(windowToOpen) );

		if( ! scrollBarWidth ){
			scrollBarWidth = ( 100 - document.getElementById('is-scroller').offsetWidth );
		}

		setTimeout(function(){ $body.addClass('tie-popup-is-opend'); },10);
		jQuery('html').css({'marginRight': scrollBarWidth, 'overflow': 'hidden'});
	}

	// Close popup when clicking the esc keyboard button
	if ( $tiePopup.length && ! adBlock ){
		$doc.keyup(function(event){
			if ( event.which == '27' && $body.hasClass('tie-popup-is-opend')){
				tie_close_popup();
			}
		});
	}

	// Close Popup when click on the background
	$tiePopup.on('click', function(event){
		if( jQuery( event.target ).is('.tie-popup:not(.is-fixed-popup)') ){
			tie_close_popup();
			return false;
		}
	});

	// Close Popup when click on the close button
	jQuery('.tie-btn-close').on( 'click', function (){
		tie_close_popup();
		return false;
	});

	// Popup close function
	function tie_close_popup(){
		jQuery.when($tiePopup.fadeOut(500)).done(function(){
			jQuery('html').removeAttr('style');
		});
		jQuery('#autocomplete-suggestions').fadeOut();
		$body.removeClass('tie-popup-is-opend');
		jQuery('#tie-popup-search-input').val('');
	}


	/**
	 * Slideout Sidebar
	 */
	// Reset the menu
	var resetMenu = function(){
		$container.removeClass('side-aside-open');
		$container.off( 'touchstart click', bodyClickFn );
	},

	//
	bodyClickFn = function(evt){
		if( ! $container.hasClass('side-aside-open') ){
			return false;
		}

		if( ! jQuery(evt.target).parents('.side-aside').length ){
			resetMenu();
		}
	},

	// Click on the Menu Button
	el = jQuery('.side-aside-nav-icon, #mobile-menu-icon');
	el.on( 'touchstart click', function(ev){

		// Create the Mobile menu
		create_mobile_menu();

		// ----
		$container.addClass('side-aside-open');
		$container.on( 'touchstart click', bodyClickFn );

		jQuery('#autocomplete-suggestions').hide();

		/*
		if( tie.lazyload ){
			jQuery('.side-aside .lazy-img').lazy({
				bind: 'event'
			});
		}
		*/

		return false;
	});


	// ESC Button close
	$doc.on('keydown', function(e){
		if( e.which == 27 ){
			resetMenu();
		}
	});

	// close when click on close button inside the sidebar
	jQuery('.close-side-aside').on('click',function(e){
		resetMenu();
		return false;
	});

	// close the aside on resize when reaches the breakpoint
	$window.resize(function() {
		intialWidth = window.innerWidth;

		if( intialWidth == 991 ){
			resetMenu();
		}
	});


	/**
	 * Scroll To #
	 */
	jQuery( 'a[href^="#go-to-"]' ).on('click', function(){

		var hrefId   = jQuery(this).attr('href'),
				target   = '#'+hrefId.slice(7),
				offset   = tie.sticky_desktop ? 100 : 40,
				position = jQuery(target).offset().top - offset;

		jQuery('html, body').animate({ scrollTop: position }, 'slow');

		return false;
	});


	/**
	 * Go to top button
	 */
	var $topButton   = jQuery('#go-to-top'),
			is_topButton = false,
			scrollTimer  = false;

	if( $topButton.length ){
		is_topButton = true;
	}

	$window.scroll(function(){

		if( is_topButton ){

			if( scrollTimer ){
				window.clearTimeout( scrollTimer );
			}

			scrollTimer = window.setTimeout(function(){
				if ( $window.scrollTop() > 100 ){
					$topButton.addClass('show-top-button');
				}
				else {
					$topButton.removeClass('show-top-button');
				}
			}, 100 );
		}
	});


	/**
	 * Blocks Ajax Pagination
	 */
	$doc.on( 'click', '.block-pagination', function(){

		var pagiButton   = jQuery(this),
				theBlock     = pagiButton.closest('.mag-box'),
				theBlockID   = theBlock.get(0).id,
				theSection   = theBlock.closest('.section-item'),
				theTermID    = theBlock.attr('data-term'),
				currentPage  = theBlock.attr('data-current'),
				theBlockList = theBlock.find('.posts-list-container'),
				theBlockDiv  = theBlock.find('.mag-box-container'),
				options      = jQuery.extend( {}, window[ 'js_'+theBlockID.replace( 'tie-', 'tie_' ) ] ),
				theListClass = 'posts-items',
				isLoadMore   = false,
				sectionWidth = 'single';

		if( currentPage && options ){
			if( theTermID ){
				if( options[ 'tags' ] ){
					options[ 'tags' ] = theTermID;
				}
				else{
					options[ 'id' ] = theTermID;
				}
			}

			// Custom Block List Class
			if( options[ 'ajax_class' ] ){
				theListClass = options[ 'ajax_class' ];
			}

			// Check if the Button Disabled
			if( pagiButton.hasClass( 'pagination-disabled' ) ){
				return false;
			}

			// Check if the button type is Load More
			if( pagiButton.hasClass( 'load-more-button' ) ){
				currentPage++;
				isLoadMore = true;
			}

			// Next page button
			else if( pagiButton.hasClass( 'next-posts' ) ){
				currentPage++;
				theBlock.find( '.prev-posts' ).removeClass( 'pagination-disabled' );
			}

			// Prev page button
			else if( pagiButton.hasClass( 'prev-posts' ) ){
				currentPage--;
				theBlock.find( '.next-posts' ).removeClass( 'pagination-disabled' );
			}

			// Full Width Section
			if( theSection.hasClass( 'full-width' ) ){
				sectionWidth = 'full';
			}

			// Ajax Call
			jQuery.ajax({
				url : tie.ajaxurl,
				type: 'post',
				data: {
					action : 'tie_blocks_load_more',
					block  : options,
					page   : currentPage,
					width  : sectionWidth
				},
				beforeSend: function(){

					// Load More button----------
					if( isLoadMore ){
						pagiButton.html( tie.ajax_loader );
					}
					// Other pagination Types
					else{
						var blockHeight = theBlockDiv.height();
						theBlockDiv.append( tie.ajax_loader ).attr( 'style', 'min-height:' +blockHeight+ 'px' );
						theBlockList.addClass('is-loading');
					}
				},
				success: function( data ){

					data = jQuery.parseJSON(data);

					// Hide next posts button
					if( data['hide_next'] ){
						theBlock.find( '.next-posts').addClass( 'pagination-disabled' );
						if( pagiButton.hasClass( 'show-more-button' ) || isLoadMore ){
							pagiButton.html( data['button'] );
						}
					}
					else if( isLoadMore ){
						pagiButton.html( pagiButton.attr('data-text') );
					}

					// Hide Prev posts button
					if( data[ 'hide_prev' ] ){
						theBlock.find( '.prev-posts').addClass( 'pagination-disabled' );
					}

					// Posts code
					data = data['code'];

					// Load More button append the new items
					if( isLoadMore ){
						var content = ( '<ul class="'+theListClass+' posts-list-container clearfix posts-items-loaded-ajax posts-items-'+currentPage+'">'+ data +'</ul>' );
						content = jQuery( content );
						theBlockDiv.append( content );
					}

					// Other pagination Types
					else{
						var content = ( '<ul class="'+theListClass+' posts-list-container posts-items-'+currentPage+'">'+ data +'</ul>' );
						content = jQuery( content );
						theBlockDiv.html( content );
					}

					var theBlockList_li = theBlock.find( '.posts-items-'+currentPage );

					// Animate the loaded items
					theBlockList_li.find( 'li' ).addClass( 'tie-animate-slideInUp tie-animate-delay' );

					tie_animate_element( theBlockList_li );

					theBlockDiv.attr( 'style', '' );
				}
			});

			// Change the next page number
			theBlock.attr( 'data-current', currentPage );
		}
		return false;
	});


	/**
	 * AJAX FILTER FOR BLOCKS
	 */
	$doc.on( 'click', '.block-ajax-term', function(){
		var termButton   = jQuery(this),
				theBlock     = termButton.closest('.mag-box'),
				theTermID    = termButton.attr('data-id'),
				theBlockID   = theBlock.get(0).id,
				theBlockList = theBlock.find('.posts-list-container'),
				theBlockDiv  = theBlock.find('.mag-box-container'),
				options      = jQuery.extend( {}, window[ 'js_'+theBlockID.replace( 'tie-', 'tie_' ) ] ),
				theListClass = 'posts-items';

		if( options ){

			// Set the data attr new values
			theBlock.attr( 'data-current', 1 );

			if( theTermID ){
				if( options[ 'tags' ] ){
					options[ 'tags' ] = theTermID;
				}
				else{
					options[ 'id' ] = theTermID;
				}

				theBlock.attr( 'data-term', theTermID );
			}
			else{
				theBlock.removeAttr( 'data-term' );
			}

			// Custom Block List Class
			if( options[ 'ajax_class' ] ){
				theListClass = options[ 'ajax_class' ];
			}

			// Ajax Call
			jQuery.ajax({
				url : tie.ajaxurl,
				type: 'post',
				data: {
					action: 'tie_blocks_load_more',
					block : options,
				},
				beforeSend: function(){
					var blockHeight = theBlockDiv.height();
					theBlockDiv.append( tie.ajax_loader ).attr( 'style', 'min-height:' +blockHeight+ 'px' );
					theBlockList.addClass('is-loading')
				},
				success: function( data ){

					data = jQuery.parseJSON(data);

					// Reset the pagination
					theBlock.find( '.block-pagination').removeClass( 'pagination-disabled' );
					var LoadMoreButton = theBlock.find( '.show-more-button' );
					LoadMoreButton.html( LoadMoreButton.attr('data-text') );

					// Active the selected term
					theBlock.find( '.block-ajax-term').removeClass( 'active' );
					termButton.addClass( 'active' );

					// Hide next posts button
					if( data['hide_next'] ){
						theBlock.find( '.next-posts').addClass( 'pagination-disabled' );
						theBlock.find( '.show-more-button' ).html( data['button'] )
					}

					// Hide Prev posts button
					if( data['hide_prev'] ){
						theBlock.find( '.prev-posts').addClass( 'pagination-disabled' );
					}

					// Posts code
					data = data['code'];

					var content = ( '<ul class="'+theListClass+' ajax-content posts-list-container">'+data+"</ul>" );
					content = jQuery( content );
					theBlockDiv.html( content );

					// Animate the loaded items
					theBlockDiv.find( 'li' ).addClass( 'tie-animate-slideInUp tie-animate-delay' );

					tie_animate_element( theBlockDiv );

					theBlockDiv.attr( 'style', '' );
				}
			});

		}

		return false;
	});


	/**
	 * Mobile Menus
	 */
	function create_mobile_menu(){

		if( ! tie.mobile_menu_active || mobileMenu ){
			return false;
		}

		var $mobileMenu = jQuery('#mobile-menu'),
				mobileItems = '';

		if( $mobileMenu.hasClass( 'has-custom-menu' ) ){

			var $mobileMenuCustom = jQuery('#mobile-custom-menu');

			$mobileMenuCustom.find( 'div.mega-menu-content' ).remove();
			$mobileMenuCustom.find( 'li.menu-item-has-children:not(.hide-mega-headings)' ).append( '<span class="mobile-arrows fa fa-chevron-down"></span>' );
		}
		else{

			var $mainNavMenu = $mainNav.find('div.main-menu > ul');

			// Main Nav
			if( $mainNavMenu.length ){
				var mobileItems = $mainNavMenu.clone();

				mobileItems.find( '.mega-menu-content' ).remove();
				mobileItems.removeAttr('id').find( 'li' ).removeAttr('id');
				mobileItems.find( 'li.menu-item-has-children:not(.hide-mega-headings)' ).append( '<span class="mobile-arrows fa fa-chevron-down"></span>' );
				$mobileMenu.append( mobileItems );

				/* if the mobile menu has only one element, show it's sub content menu */
				var mobileItemsLis = mobileItems.find('> li');
				if( mobileItemsLis.length == 1 ){
					mobileItemsLis.find('> .mobile-arrows').toggleClass('is-open');
					mobileItemsLis.find('> ul').show();
				}
			}

			// Top Nav
			if( tie.mobile_menu_top ){
				var $topNav = jQuery('#top-nav div.top-menu > ul');

				if( $topNav.length ){
					var mobileItemsTop = $topNav.clone();

					mobileItemsTop.removeAttr('id').find( 'li' ).removeAttr('id');
					mobileItemsTop.find( 'li.menu-item-has-children' ).append( '<span class="mobile-arrows fa fa-chevron-down"></span>' );
					$mobileMenu.append( mobileItemsTop );
				}
			}
		}

		// Open, Close behavior
		if( ! tie.mobile_menu_parent ){
			jQuery('li.menu-item-has-children > a, li.menu-item-has-children > .mobile-arrows', '#mobile-menu' ).click(function(){
				jQuery(this).parent().find('ul').first().slideToggle(300);
				jQuery(this).parent().find('> .mobile-arrows').toggleClass('is-open');
				return false;
			});
		}
		else{
			jQuery('li.menu-item-has-children .mobile-arrows', '#mobile-menu' ).click(function(){
				jQuery(this).toggleClass('is-open').closest('.menu-item').find('ul').first().slideToggle(300);
				return false;
			});
		}

		//
		mobileMenu = true;
	}


	// Debugging
	performance.mark('TieEnd');
	performance.measure( 'TieLabs Custom JS', 'TieStart', 'TieEnd' );

});




/**
 * ANIMATE ELEMENTS
 * This function used to animate theme elements
 * Used multiple times in this files to fire the animation for intial and Ajax content
 */
function tie_animate_element( $itemContainer ){

	if( ! $itemContainer  ){
		return;
	}

	// Reviews
	tie_animate_reviews( $itemContainer );

	// LazyLoad
	if( tie.lazyload ){

		// Images
		$itemContainer.find( '[data-src]' ).each(function(){
			var elem = jQuery(this);
			elem.attr('src', elem.data('src') );
			elem.removeAttr('data-src');
		});

		// BG
		$itemContainer.find( '[data-lazy-bg]' ).each(function(){
			var elem = jQuery(this);
			elem.attr('style', 'background-image:url(' + elem.data('lazy-bg') + ')' );
			elem.removeAttr('data-lazy-bg');
		});
	}
}

/**
 * Animate Reviews
 */
function tie_animate_reviews( $itemContainer ){

	// Reviews
	if( tie.is_taqyeem_active ){

		// Pie
		$itemContainer.find( '[data-lazy-pie]' ).each(function(){
			var elem    = jQuery(this),
		      pctVal  = parseInt( elem.data('pct') ),
		      $circle = elem.find('.circle_bar'),
		      pctNew  = ((100-pctVal)/100) * Math.PI*(19*2); // 19 == $circle.getAttribute('r')

			$circle.attr('style', 'stroke-dashoffset:'+ pctNew +'px' );
			elem.removeAttr('data-lazy-pie');
		});

		// Star
		$itemContainer.find( '[data-lazy-percent]' ).each(function(){
			var elem = jQuery(this);
			elem.attr('style', 'width:'+ elem.data('rate-val') );
			elem.removeAttr('data-lazy-percent');
		});
	}
}
