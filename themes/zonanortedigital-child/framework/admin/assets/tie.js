var $doc     = jQuery(document),
		$window  = jQuery(window);

$window.on( 'load', function() {

	jQuery('.widgets-chooser-sidebars').find('li').each(function(){
		var $thisElem = jQuery(this),
				thistext  = $thisElem.text();

		if( /^Page #\d+ - Section #\d+$/.test( thistext ) ){
			$thisElem.addClass('tie-chooser-section').hide();
		}
	});


	/* PAGE TEMPLATES OPTIONS
	------------------------------------------------------------------------------------------*/
	var $pageTemplateAttr = "select[name='page_template']";
	if( jQuery('body').hasClass('block-editor-page') ){
		$pageTemplateAttr = '.editor-page-attributes__template select';
	}

	console.log( 'Page Template Attr: '+ $pageTemplateAttr );

	var selected_item = jQuery( $pageTemplateAttr ).val();

	if ( selected_item == 'template-masonry.php' ){
		jQuery('#tie-page-template-categories').show();
	}
	else if ( selected_item == 'template-authors.php' ){
		jQuery('#tie-page-template-authors').show();
	}

	jQuery($pageTemplateAttr).change(function(){
		var selected_item = jQuery($pageTemplateAttr).val();
		jQuery('.tie-page-templates-options').hide();
		if ( selected_item == 'template-masonry.php' ){
			jQuery('#tie-page-template-categories').show();
		}
		else if ( selected_item == 'template-authors.php' ){
			jQuery('#tie-page-template-authors').show();
		}
	});

});



$doc.ready(function() {

	var $tieBody = jQuery('body');

	/* DASHBORED COLOR
	------------------------------------------------------------------------------------------ */
	var brandColor = '#d54e21';
	if( $tieBody.hasClass('admin-color-blue') ){
		brandColor = '#e1a948';
	}
	else if( $tieBody.hasClass('admin-color-coffee') ){
		brandColor = '#9ea476';
	}
	else if( $tieBody.hasClass('admin-color-ectoplasm') ){
		brandColor = '#d46f15';
	}
	else if( $tieBody.hasClass('admin-color-midnight') ){
		brandColor = '#69a8bb';
	}
	else if( $tieBody.hasClass('admin-color-ocean') ){
		brandColor = '#aa9d88';
	}
	else if( $tieBody.hasClass('admin-color-sunrise') ){
		brandColor = '#ccaf0b';
	}



	jQuery('.tie-toggle-option').each(function(){
		var $thisElement = jQuery(this),
				elementType  = $thisElement.attr('type'),
				toggleItems  = $thisElement.data('tie-toggle');

		toggleItems  = jQuery(toggleItems).hide();

		if( elementType = 'checkbox' ){
			if($thisElement.is(':checked')){
				toggleItems.slideDown();
			};

			$thisElement.change(function(){
				toggleItems.slideToggle('fast');

				// CodeMirror
				toggleItems.find('.CodeMirror').each(function(i, el){
			    el.CodeMirror.refresh();
				});

			});
		}
	});



	/* Revoke Theme License
	------------------------------------------------------------------------------------------ */
	jQuery('#revoke-tie-token').click(function(){

		var message = jQuery(this).data('message'),
		    revoke  = confirm(message);

		if ( ! revoke ) {
			return false;
		}
	});



	/* Reset button message
	------------------------------------------------------------------------------------------ */
	jQuery('#tie-reset-settings').click(function(){
		var message = jQuery(this).data('message'),
		    reset   = confirm(message);

		if ( ! reset ) {
			return false;
		}
	});



	/* Import theme options
	------------------------------------------------------------------------------------------ */
	jQuery('#tie-import-upload').click(function(){

		var importSettings = jQuery('#tie-import-file').val();
		if( importSettings.length > 0 ){
			return true;
		}

		return false;
	});



	/* Send Push Notifications
	------------------------------------------------------------------------------------------ */
	jQuery('#send-notification').click(function(){

		var $theParent   = jQuery( '#foxpush-create-campaign' ),
		    $loadSpinner = $theParent.find('.spinner'),
		    theTitle     = jQuery( '#tie_foxpush_title' ).val(),
		    theMessage   = jQuery( '#tie_foxpush_msg' ).val(),
		    theImage     = jQuery( '#tie_foxpush_icon' ).val(),
		    thePostID    = jQuery( '#foxpush_post_id' ).val();


		// Check the requried data
		if( ! theTitle || ! theMessage ){
			alert( 'Complete all requried fields.' );
			return false;
		}
		else if( theTitle.length > 50 ){
			alert( 'Title should be max. 50 char.' );
			return false;
		}
		else if( theMessage.length > 80 ){
			alert( 'Title Messagec should be max. 50 char.' );
			return false;
		}


		// Run the Request
		jQuery.ajax({
			url : ajaxurl,
			type: 'post',
			data: {
				title  : theTitle,
				message: theMessage,
				image  : theImage,
				id     : thePostID,
				action : 'tie-foxpush-send-campaign',
			},

			beforeSend: function(data){

				// Hide the options
				jQuery( '#send-notification-options' ).hide();

				// Show the Spinner
				$loadSpinner.addClass('is-active');

			},

			success: function( data ){

				// Hide the Spinner
				$loadSpinner.removeClass('is-active');

				// Append the data
				$theParent.find('.inside').append( data );
			}
		});


		return false;
	});

	/* Send Push Notifications
	------------------------------------------------------------------------------------------ */
	jQuery('#update-campaign-status').click(function(){

		var $theParent   = jQuery( '#foxpush-get-campaigns' ),
		    $loadSpinner = $theParent.find('.spinner'),
        thePostID    = jQuery( '#foxpush_post_id' ).val();

		// Run the Request
		jQuery.ajax({
			url : ajaxurl,
			type: 'post',
			data: {
				id     : thePostID,
				action : 'tie-foxpush-show-campaign',
			},

			beforeSend: function(data){

				// Hide the options
				$theParent.find('#campaigns-statistics-tables').hide();

				// Show the Spinner
				$loadSpinner.addClass('is-active');

			},

			success: function( data ){

				// Hide the Spinner
				$loadSpinner.removeClass('is-active');

				// Append the data
				$theParent.find('#campaigns-statistics-tables').html( data ).show();
			}
		});


		return false;
	});



	/* WIDGETS | CUSTOM SIDEBAR SECTIONS
	------------------------------------------------------------------------------------------ */
	if( jQuery('.widgets-php div[id*="tiepost-"]').length ){
		jQuery( '#tie-show-sections-sidebars-wrap' ).show();

		jQuery('.widgets-php div[id*="tiepost-"]').parent().addClass('tie-sidebar-section');
		jQuery('#tie-show-sections-sidebars').change(function(){
			jQuery('.tie-sidebar-section, .tie-chooser-section').toggle();
		});
	}



	/* THEME SEARCH
	------------------------------------------------------------------------------------------ */
	$searchTheme = jQuery('#theme-panel-search'),
	$searchList  = jQuery('#theme-search-list');

	$searchTheme.on('keyup', function(){
		var valThis = $searchTheme.val().toLowerCase();
		$searchList.html('');

		if( valThis == '' ){
			jQuery('.highlights-search').removeClass('highlights-search');
		}

		else{
			jQuery('.tie-label').each(function(){
				var $thisElem = jQuery(this),
						thistext  = $thisElem.text();

				if( thistext.toLowerCase().indexOf(valThis) >= 0 ){
					$thisElem.addClass('highlights-search');

					var thistextid       = $thisElem.closest('.option-item').attr('id'),
							$thisparent      = jQuery(this).closest('.tabs-wrap'),
							thistextparent   = $thisparent.find('.tie-tab-head h2').text(),
							thistextparentid = $thisparent.attr('id');

					$searchList.append( '<li><a href="#" data-section="'+ thistextid +'" data-url="'+ thistextparentid +'"><strong>' + thistextparent + '</strong> / ' + thistext + '</a></li>' );
				}
				else{
					$thisElem.removeClass('highlights-search');
				}
			});
		};
	});

	$searchList.on('click', 'a', function(){
		var $thisElem  = jQuery(this),
				tabId      = $thisElem.data('url'),
				tabsection = $thisElem.data('section');

		jQuery('.tie-panel-tabs ul li').removeClass('active');
		jQuery('.tie-panel-tabs').find('.' + tabId).addClass('active');
		jQuery('.tabs-wrap').hide();
		jQuery('#' + tabId).show();
		jQuery('html,body').unbind().animate({scrollTop: jQuery('#'+tabsection).offset().top-50},'slow');
		return false;
	});


	$doc.mouseup(function (e){
		var container = jQuery('#theme-options-search-wrap');

		if(!container.is(e.target) && container.has(e.target).length === 0){
			$searchList.html('');
			$searchTheme.val('');
			jQuery('.highlights-search').removeClass('highlights-search');
		}
	});



	/* LIVE HEADER PREVIEW
	------------------------------------------------------------------------------------------ */
	if( $tieBody.hasClass('toplevel_page_tie-theme-options') ){
		//Chnage the header layout
		var selected_val           = jQuery( "input[name='tie_options[header_layout]']:checked" ).val(),
				headerLayoutOptions    = jQuery( '#main_nav-item, .main-nav-related-options, .main-nav-components-wrapper, #header-preview .header-main-menu-wrap' ),
				headerLayout_1_Options = jQuery( '#main_nav-item, #main_nav_layout-item, #main_nav_position-item' ),
				$header_preview_area   = jQuery( '#header-preview' );
				$header_preview_wrap   = jQuery( '#header-preview-wrapper' );

		if( selected_val == 1 ){
			headerLayoutOptions.show();
			headerLayout_1_Options.hide();

			jQuery('#main_nav').attr('checked','checked');
			jQuery('#main_nav-item').find('.switchery').attr('style','border-color: rgb(0, 136, 255); box-shadow: rgb(0, 136, 255) 0px 0px 0px 13.5px inset; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s; background-color: rgb(0, 136, 255);')
			jQuery('#main_nav-item').find('.switchery small').attr('style','left: 25px; transition: left 0.2s; background-color: rgb(255, 255, 255);')
			$header_preview_area.removeClass( 'main-nav-disabled' );
		}

		jQuery("input[name='tie_options[header_layout]']").change(function(){
			selected_val = jQuery( this ).val();
			if ( selected_val ) {
				$header_preview_area.removeClass( 'header-layout-1 header-layout-2 header-layout-3' );
				$header_preview_area.addClass( 'header-layout-'+selected_val );
			}

			if( selected_val == 1 ){
				headerLayoutOptions.show();
				headerLayout_1_Options.hide();

				jQuery('#main_nav').attr('checked','checked');
				jQuery('#main_nav-item').find('.switchery').attr('style','border-color: '+ brandColor +'; box-shadow: '+ brandColor +' 0px 0px 0px 0px inset; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s; background-color:  '+ brandColor +';')
				jQuery('#main_nav-item').find('.switchery small').attr('style','left: 25px; transition: left 0.2s; background-color: rgb(255, 255, 255);')
				$header_preview_area.removeClass( 'main-nav-disabled' );
			}
			else{
				headerLayoutOptions.show();
			}

			if(! $header_preview_area.hasClass('sticky_area')){
				var preview_height = $header_preview_area.outerHeight();
				$header_preview_wrap.css({height: preview_height});
			}
		});


		jQuery("input[name='tie_options[top_nav]']").change(function(){
			$header_preview_area.toggleClass( 'top-nav-disabled' );
		});

		jQuery("input[name='tie_options[top_nav_position]']").change(function(){
			$header_preview_area.toggleClass( 'top-nav-below' );
		});

		jQuery("input[name='tie_options[top_nav_layout]']").change(function(){
			jQuery( '.top-bar-wrap' ).toggleClass( 'top-nav-full' );
		});

		jQuery("input[name='tie_options[top_nav_dark]']").change(function(){
			jQuery( '.top-bar-wrap' ).toggleClass( 'top-nav-dark-skin' );
		});


		if( jQuery("input[name='tie_options[top-nav-area-1]']").val() == 'components' || jQuery("input[name='tie_options[top-nav-area-1]']").val() == 'components' ){
			jQuery( '.top-nav-components-wrapper' ).show();
		}

		jQuery("input[name='tie_options[top-nav-area-2]']").change(function(){
			selected_val = jQuery( this ).val();
			if ( selected_val == 'components') {
				jQuery( "input[name='tie_options[top-nav-area-1]'][value='components']" ).removeAttr( 'checked' );
				jQuery( '#top-nav-components-1' ).hide();
			}else{
				if ( selected_val == 'menu') {
					jQuery( "input[name='tie_options[top-nav-area-1]'][value='menu']" ).removeAttr( 'checked' );
					jQuery( '#top-nav-menu-1' ).hide();
				}

				if( jQuery( "input[name='tie_options[top-nav-area-1]']:checked" ).val() != 'components' ){
					jQuery( '.top-nav-components-wrapper' ).hide();
				}
			}
		});

		jQuery("input[name='tie_options[top-nav-area-1]']").change(function(){
			selected_val = jQuery( this ).val();
			if ( selected_val == 'components') {
				jQuery( "input[name='tie_options[top-nav-area-2]'][value='components']" ).removeAttr( 'checked' );
				jQuery( '#top-nav-components-2' ).hide();
			}else{

				if ( selected_val == 'menu') {
					jQuery( "input[name='tie_options[top-nav-area-2]'][value='menu']" ).removeAttr( 'checked' );
					jQuery( '#top-nav-menu-2' ).hide();
				}

				if( jQuery( "input[name='tie_options[top-nav-area-2]']:checked" ).val() != 'components' ){
					jQuery( '.top-nav-components-wrapper' ).hide();
				}
			}
		});

		jQuery("input[name='tie_options[main_nav]']").change(function(){
			$header_preview_area.toggleClass( 'main-nav-disabled' );
		});

		jQuery("input[name='tie_options[main_nav_position]']").change(function(){
			$header_preview_area.toggleClass( 'main-nav-above' );
		});

		jQuery("input[name='tie_options[main_nav_layout]']").change(function(){
			jQuery( '.header-main-menu-wrap' ).toggleClass( 'main-nav-full' );
		});

		jQuery("input[name='tie_options[main_nav_dark]']").change(function(){
			jQuery( '.header-main-menu-wrap' ).toggleClass( 'main-nav-dark-skin' );
		});

		//Top and Main Nav settings
		$doc.on( 'click', '.header-settings-tabs a', function(){
			var targetedTab = jQuery( this ).attr( 'href' );
			jQuery( this ).parent().find( 'a' ).removeClass( 'active' );
			jQuery( this ).addClass( 'active' );
			jQuery( '.top-main-nav-settings' ).hide();
			jQuery( targetedTab ).fadeIn();
			return false;
		});


		/* Sticky options header */
		stickyNav = function(){
			if( jQuery( '#tie-options-tab-header' ).is( ':visible' ) ){

				var stickyNavTop   = $header_preview_wrap.offset().top,
						preview_height = $header_preview_area.outerHeight(),
						preview_width  = jQuery('#tie_form').width(),
						scrollTop      = $window.scrollTop();

				if ( scrollTop > stickyNavTop - 32) {
					$header_preview_area.addClass('sticky_area').css({width: preview_width});
					$header_preview_wrap.css({height: preview_height});
				}
				else{
					$header_preview_area.removeClass('sticky_area').removeAttr('style');
				}
			}
		};


		/* Stikcy Bottom Save Button */
		var lastScrollTop    = 0,
				$topSaveButton    = jQuery('.tie-panel-content'),
				$bottomSaveButton = jQuery('.tie-footer .tie-save-button');

		stickySaveButton = function(){
			var topSaveOffset = $topSaveButton.offset().top,
					scrollTop     = $window.scrollTop(),
					scrollBottom  = $doc.height() - scrollTop - $window.height(),
					st            = scrollTop;

			if ( scrollTop > topSaveOffset && scrollBottom > 105 - $bottomSaveButton.height()) {
				if(st > lastScrollTop){
					$bottomSaveButton.addClass('sticky-on-down').removeClass('sticky-on-up');

					if(scrollTop > topSaveOffset){
						$bottomSaveButton.addClass('sticky-on-down-appear').removeClass('sticky-on-up-disappear');
					}
				}
				else{
					$bottomSaveButton.addClass('sticky-on-up').removeClass('sticky-on-down');

					if (scrollTop < topSaveOffset){
						$bottomSaveButton.addClass('sticky-on-up-disappear').removeClass('sticky-on-up-appear');
					}
				}
			}
			else{
				$bottomSaveButton.removeClass('sticky-on-down sticky-on-up sticky-on-down-appear sticky-on-up-disappear');
			}

			lastScrollTop = st;
		}


		stickyNav();
		stickySaveButton();

		$window.scroll(function(){
			stickyNav();
			stickySaveButton();
		});
	}


	/* CUSTOM SCROLLBAR
		------------------------------------------------------------------------------------------ */
	if ( jQuery.fn.mCustomScrollbar ){
		jQuery('.has-custom-scroll').each(function(){

			var thisElement = jQuery(this);
			thisElement.mCustomScrollbar('destroy');

			var scroll_height = 'auto';

			thisElement.mCustomScrollbar({
				scrollButtons : { enable: false },
				autoHideScrollbar : true,
				scrollInertia : 150,
				mouseWheel:{
					enable      : true,
					scrollAmount: 60,
				},
				set_height : scroll_height,
				advanced : { updateOnContentResize: true },
			});
		});
	}



	/* PAGE BUILDER
	------------------------------------------------------------------------------------------ */
	/* Assign a Class to the builder depending on the Image Style */
	$doc.on('click', '#tie-builder-wrapper .tie-options label', function(){
		var $thisBlock  = jQuery( this ),
		    $thisImg    = $thisBlock.find( 'img' ),
		    $thisParent = $thisBlock.closest( '.block-item' ),
				blockClass  = $thisImg.attr( 'class' ) + '-container';
				imgPath     = $thisImg.attr( 'src' ),
				postsNumber = $thisImg.data( 'number' );

		if( postsNumber ){
			$thisParent.find( '.block-number-item-options input' ).val( postsNumber );
		}

		$thisParent.attr( 'class', 'block-item parent-item ' + blockClass );
		$thisParent.find('.block-small-img').attr( 'src', imgPath );
	});

	/* Blocks Color Picker */
	var tieBlocksColorsOptions = {
		change: function(event, ui){
			var newColor = ui.color.toString();
			jQuery(this).closest( '.block-item' ).find( '.tie-block-head' ).attr('style', 'background-color: '+newColor ).removeClass( 'block-head-light block-head-dark' ).addClass( 'block-head-'+getContrastColor( newColor ) );
		},
		clear: function() {
			jQuery(this).closest( '.block-item' ).find( '.tie-block-head' ).attr('style', '').removeClass( 'block-head-light block-head-dark' );
		}
	};

	if( jQuery().wpColorPicker ){
		jQuery('.tieBlocksColor').wpColorPicker( tieBlocksColorsOptions );
	}


	/* Enable/Disable the Builder For the page */
	jQuery('#tie-page-builder-button').click( function() {

		$tieBody.toggleClass('builder-is-active');
		jQuery( '#tie-page-builder' ).attr( 'style', '' );

		var tabsHeight = jQuery('.tie-panel-tabs').outerHeight();
		jQuery('.tie-panel-content').css({minHeight: tabsHeight});

		var $pageBuilderButton = jQuery(this);

		if( $pageBuilderButton.hasClass( 'builder_active' ) ){
			$pageBuilderButton.addClass('button-primary').removeClass( 'builder_active button-secondary' ).html($pageBuilderButton.data('editor'));
			jQuery( '#tie_builder_active' ).val( '' );
			pagePosition = $tieBody.scrollTop();
			jQuery( 'html, body' ).scrollTop( pagePosition + 1 );
		}
		else{
			$pageBuilderButton.addClass( 'builder_active button-secondary' ).removeClass('button-primary').html($pageBuilderButton.data('builder'));

			jQuery( '#tie_builder_active' ).val( 'yes' );

			jQuery('.tabs-wrap').hide();
			jQuery('.tie-panel-tabs ul li').removeClass('active');

			jQuery('.tie-panel-tabs ul li:first').addClass('active').show();
			jQuery('.tabs-wrap:first').show();

			//Page templates
			//jQuery( '#page_template option:first-child' ).attr('selected','selected');
		}
		return false;
	});

	/* If Builder Active hide boxes */
	if ( jQuery('#tie_builder_active').val() == 'yes') {
		$tieBody.addClass('builder-is-active');
	}

	/* Add a new block button */
	$doc.on( 'click', '.tie-add-new-block', function(){

		var $thisButton  = jQuery(this),
				$loadSpinner = $thisButton.closest('.tie-builder-container').find( '.tie-loading-container' ).addClass( 'is-animated' ).show(),
				sectionID    = $thisButton.data('section'),
				blockID      = tie_block_id;
				uniqueID     = sectionID + '-' + blockID;

		jQuery.post(
			ajaxurl,
			{
				action:'tie_get_builder_blocks',
				block_id: blockID,
				section_id: sectionID,
			},
			function(data) {

				var content = jQuery( data );
				content.find('.tabs_cats').sortable({placeholder: 'tie-state-highlight'});

				content.appendTo( '#cat_sortable_'+sectionID );

				content.find('.tie-img-path').each(function(){
					tie_image_uploader_trigger( jQuery(this) );
				});

				tie_builder_dragdrop();

				// Disable the Sortable and Draggable if the PopUp is open
				jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('disable');
				jQuery( '.block-item' ).draggable('disable');
				// ----

				var addedBlock = jQuery( '#listItem_'+ uniqueID );

				//addedBlock.hide().fadeIn();
				addedBlock.find( '.tie-builder-content-area, .toggle-close' ).show();
				addedBlock.find( '.toggle-open' ).hide();
				addedBlock.find( '.tieBlocksColor' ).wpColorPicker( tieBlocksColorsOptions );

				$tieBody.addClass('has-overlay');

				// Switch Button
				var $blockSwitches = addedBlock.find( '.tie-js-switch' );
				$blockSwitches.each(function(){

					new Switchery( this,{ color: brandColor } );

					var $thisElement = jQuery(this),
							elementType  = $thisElement.attr('type'),
							toggleItems  = $thisElement.data('tie-toggle');

					toggleItems = jQuery(toggleItems).hide();

					if( elementType = 'checkbox' ){
						if($thisElement.is(':checked')){
							toggleItems.slideDown();
						};

						$thisElement.change(function(){
							toggleItems.slideToggle('fast');
						});
					}

				});


				$thisButton.show();

				$loadSpinner.removeClass( 'is-animated' ).hide();

				// Classic Editor
				var defaultEditorID = 'content';
				// Gutenberg
				if (_.isUndefined(tinyMCEPreInit.qtInit['content'])) {
					defaultEditorID = 'tie_dummy_editor';
				}

				var wpEditorID = 'block-' + uniqueID +'-custom_content';

				delete window.tinyMCEPreInit.mceInit[wpEditorID];
				delete window.tinyMCEPreInit.qtInit[wpEditorID];

				window.tinyMCEPreInit.mceInit[wpEditorID] = _.extend({}, tinyMCEPreInit.mceInit[ defaultEditorID ], {resize: 'vertical', height: 400});

				if (_.isUndefined(tinyMCEPreInit.qtInit[wpEditorID])) {
					window.tinyMCEPreInit.qtInit[wpEditorID] = _.extend({}, tinyMCEPreInit.qtInit['replycontent'], {id: wpEditorID})
				}

				qt = quicktags(window.tinyMCEPreInit.qtInit[wpEditorID]);
				QTags._buttonsInit();
				window.switchEditors.go(wpEditorID, 'tmce');
				tinymce.execCommand( 'mceRemoveEditor', true, wpEditorID );
				tinymce.execCommand( 'mceAddEditor', true, wpEditorID );

				tie_block_id++;

			}, 'html');


		return false;
	});


	/* Manage Widgets button */
	$widgetsCustomizer   = jQuery('#tie-sidebars-customize');
	$customWidgetsHolder = jQuery('#custom-widgtes-settings');

	$doc.on( 'click', '.tie-manage-widgets', function(){

		var $thisButton     = jQuery(this),
				sectionID       = $thisButton.data('widgets'),
				$sidebarOptions = jQuery('#' + sectionID + '-sidebar-options'),
				$widgetsToggle  = $sidebarOptions.find('.tie-toggle-option');

		// Hide
		$widgetsCustomizer.find('#widgets-right .widgets-holder-wrap, .sections-sidebars-options').hide();
		$customWidgetsHolder.hide()

		// Show
		$tieBody.addClass('has-overlay');
		$widgetsCustomizer.show();
		$sidebarOptions.show();
		jQuery('#wrap-' + sectionID).removeClass('closed').show();


		if( ! $widgetsToggle.is(':checked') ){
			$customWidgetsHolder.show();
		};

		return false;
	});

	$widgetsCustomizer.find('.tie-toggle-option').change(function(){
		$customWidgetsHolder.toggle();
	});



	/* Add a new section button */
	$doc.on( 'click', '.tie-add-new-section', function(){

		var $thisButton  = jQuery(this).hide(),
				sectionID    = $thisButton.data('sections'),
				postID       = $thisButton.data('post'),
				$loadSpinner = $thisButton.closest('.tie-add-new-section-wrapper').find( '.tie-loading-container' ).addClass( 'is-animated' ).show();


		jQuery.post(
			ajaxurl,
			{
				action:'tie_get_builder_section',
				section_id: sectionID,
				post_id: postID
			},
			function(data) {
				var sectionUnique = 'section-' + Math.floor(Math.random() * 10000),
						content = data.replace( /tiexyz20/g, sectionUnique );

				content = jQuery( content );
				content.appendTo( '#tie-builder-wrapper' );

				tie_builder_dragdrop();

				// Disable the Sortable and Draggable if the PopUp is open
				jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('disable');
				jQuery( '.block-item' ).draggable('disable');
				// ----

				content.find('.tie-img-path').each(function(){
					tie_image_uploader_trigger( jQuery(this) );
				});

				$tieBody.addClass('has-overlay');

				content.find( '.tie-builder-content-area' ).show();

				var $blockSwitches = content.find( '.tie-js-switch' );
				$blockSwitches.each(function(){
					new Switchery( this,{ color: brandColor } );


					var $thisElement = jQuery(this),
							elementType  = $thisElement.attr('type'),
							toggleItems  = $thisElement.data('tie-toggle');

					toggleItems  = jQuery(toggleItems).hide();

					if( elementType = 'checkbox' ){
						if($thisElement.is(':checked')){
							toggleItems.slideDown();
						};

						$thisElement.change(function(){
							toggleItems.slideToggle('fast');
						});
					}
				});


				content.find( '.tieColorSelector' ).wpColorPicker( tieBlocksColorsOptions );
				content.find( '.sections-sidebars-options' ).appendTo('#section-sidebar-options').find('.tie-toggle-option').change(function(){
					jQuery('#custom-widgtes-settings').toggle();
				});

				content.find( '.sections-sidebars-options' ).remove();

				$thisButton.show();
				$loadSpinner.removeClass( 'is-animated' ).hide();

				jQuery('#widgets-right').append('\
					<div id="wrap-tiepost-'+ postID + '-' + sectionUnique +'"class="widgets-holder-wrap">\
						<div id="tiepost-'+ postID + '-' + sectionUnique +'" class="widgets-sortables">\
							<div class="sidebar-name">\
								<div class="sidebar-name-arrow"><br></div>\
								<h3>Section Widgets Area<span class="spinner"></span></h3>\
							</div>\
						</div>\
					</div>\
				');

				$thisButton.data( 'sections', sectionID+1 );

				wpPWidgets.refresh();

			}, 'html');

		return false;
	});



	/* Section Sidebar */
	$doc.on( 'click', '.tie-section-sidebar-options a', function(){

		var $thisElement = jQuery(this),
				$theSection  = $thisElement.closest('.tie-builder-container');
				$inputField  = $thisElement.closest('li').find('input');
				inputValue   = $inputField.val();

		$theSection.removeClass('sidebar-right sidebar-left sidebar-full');
		$theSection.addClass( 'sidebar-'+inputValue );

		return false;
	});

	/* Close Options popup with esc  */
	$doc.keyup(function(event){
		if ( event.which == '27' && ( $tieBody.hasClass('builder-is-active') || $tieBody.hasClass('tietheme_page_tie-one-click-demo-import') ) ){

			if( $tieBody.hasClass( 'force-refresh' ) ){
				location.reload();
			}

			$tieBody.removeClass('has-overlay');
			jQuery('.tie-popup-window').hide();

			// Enable the Sortable and Draggable when the PopUp closed
			if ( $tieBody.hasClass('builder-is-active') ){
				jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('enable');
				jQuery( '.block-item' ).draggable('enable');
			}
			// ----
		}
	});

	/* Edit Block Done Button */
	$doc.on( 'click', '.builder-is-active #tie-page-overlay, #tie-page-overlay.is-notice-dismissible, .tietheme_page_tie-one-click-demo-import #tie-page-overlay, .tie-popup-window .close, .tie-edit-block-done', function(){

		// Dismiss the notice
		if( jQuery( this ).hasClass( 'is-notice-dismissible' ) ){
			var noticeID = jQuery( this ).data('id');

			jQuery.ajax({
				url : ajaxurl,
				type: 'post',
				data: {
					pointer: noticeID,
					action : 'dismiss-wp-pointer',
				},
			});

			jQuery( this ).hide();
		}


		// Force Refresh
		if( $tieBody.hasClass( 'force-refresh' ) ){
			location.reload();
		}

		$tieBody.removeClass('has-overlay');
		jQuery('.tie-popup-window').hide();

		// Enable the Sortable and Draggable when the PopUp closed
		if ( $tieBody.hasClass('builder-is-active') ){
			jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('enable');
			jQuery( '.block-item' ).draggable('enable');
		}
		// ----

		return false;
	});

	/* Toggle open/Close */
	$doc.on('click', '.toggle-section', function(){
		var $thisElement = jQuery(this).closest('.tie-builder-container');
		$thisElement.find('.tie-builder-section-inner').slideToggle('fast');
		$thisElement.toggleClass('tie-section-open');
		return false;
	});

	/* Chnage the Block Title */
	$doc.on( 'keyup', '.block-title-item-options input', function(){
		var NewTitleText = jQuery( this ).val();
		jQuery( this ).parents( '.block-item' ).find( '.block-preview-title' ).text( NewTitleText );
	});

	/* Edit Block/Section */
	$doc.on('click', '.edit-block-icon', function(){
		var $thisElement = jQuery(this).closest('.parent-item');
		$tieBody.addClass('has-overlay');
		$thisElement.find('> .tie-builder-content-area').fadeIn('fast');

		// Disable the Sortable and Draggable if the PopUp is open
		jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('disable');
		jQuery( '.block-item' ).draggable('disable');
		// ----

		return false;
	});

	/* Block Settings */
	$doc.on( 'click', '.blocks-settings-tabs a', function(){
		var $thisButtonTab = jQuery(this),
				$blockContent  = $thisButtonTab.closest('.tie-builder-content-area'),
				targetTab      = $thisButtonTab.data('target');

		$thisButtonTab.parent().find('a').removeClass( 'active' );
		$thisButtonTab.addClass('active');

		$blockContent.find('.block-settings').hide();
		$blockContent.find('.'+ targetTab).show();

		return false;
	});

	/* Assign a Class to the slider depending on the Image Style */
	$doc.on('click', '#tie_featured_posts_style a', function(){
		var sliderClass = jQuery( this ).find( 'img' ).attr( 'class' ) + '-container';
		jQuery( '#main-slider-options' ).attr( 'class', sliderClass );
		return false;
	});

	/* Categories Tabs box */
	jQuery( '.tabs_cats input:checked' ).parent().addClass('selected');
	$doc.on( 'click', '.tabs_cats span', function( event ){
		var $thisTab = jQuery(this).parent();

		if( $thisTab.find(':checkbox').is(':checked') ){
			event.preventDefault();
			$thisTab.removeClass('selected');
			$thisTab.find(':checkbox').removeAttr('checked');
		}else{
			$thisTab.addClass('selected');
			$thisTab.find(':checkbox').attr('checked','checked');
		}
	});



	/* Misc
	------------------------------------------------------------------------------------------ */
	/* COLOR PICKER */
	if( jQuery().wpColorPicker ){
		tie_color_picker();
	}


	/* PAGE BUILDER SRAG AND DROP */
	tie_builder_dragdrop();


	/* IMAGE UPLOADER PREVIEW */
	jQuery('.tie-img-path').each(function(){
		tie_image_uploader_trigger( jQuery(this) );
	});


	/* Font Uploader */
	jQuery('.tie-font-path').each(function(){
		tie_set_font_uploader( jQuery(this) );
	});


	/* FONTS */
	jQuery( '.tie-select-font' ).fontselect();


	/* CHECKBOXES */
	var checkInputs = Array.prototype.slice.call(document.querySelectorAll('.tie-js-switch'));
	checkInputs.forEach(function(html) {
		new Switchery( html,{ color: brandColor });
	});


	/* MAIN MENU UPDATES NOTIFICATION */
	if( jQuery( 'li.menu-top.toplevel_page_tie-theme-options .tie-theme-update' ).length ){
		jQuery( 'li.menu-top.toplevel_page_tie-theme-options .wp-menu-name' ).append( ' <span class="update-plugins"><span class="update-count">'+tieLang.update+'</span></span>' );
	}



/* Widgets
	------------------------------------------------------------------------------------------ */
	if( $tieBody.hasClass('widgets-php') || $tieBody.hasClass('nav-menus-php') || $tieBody.hasClass('post-type-page') ){
		$doc.ajaxComplete(function() {
			jQuery('.tieColorSelector').wpColorPicker();
		});
	}

	/* Widget Tabs Sortable  */
	jQuery('.tab-sortable').each(function(){
		tie_sortable_tabs_trigger( jQuery(this) );
	});

	/* Widget Posts order option  */
	jQuery('.tie-posts-order-option').each(function(){
		tie_widget_posts_order( jQuery(this) );
	});

	/* Trigger when Widget Added */
	$doc.on( 'widget-added', function( event, widgetContainer ) {

		var $thisTabs = widgetContainer.find('.tab-sortable');
		tie_sortable_tabs_trigger( $thisTabs );

		// ------
		var $thisOption = widgetContainer.find('.tie-posts-order-option');
		tie_widget_posts_order( $thisOption );
	});

	/* Trigger when Widget Updated */
	$doc.on( 'widget-updated', function( event, widgetContainer ) {

		var $thisTabs = widgetContainer.find('.tab-sortable');
		tie_sortable_tabs_trigger( $thisTabs );

		// ------
		var $thisOption = widgetContainer.find('.tie-posts-order-option');
		tie_widget_posts_order( $thisOption );
	});



	/* DISMISS NOTICES
	------------------------------------------------------------------------------------------ */
	$doc.on('click', '.tie-notice .notice-dismiss', function(){

		jQuery( '#tie-page-overlay' ).hide();

		jQuery.ajax({
			url : ajaxurl,
			type: 'post',
			data: {
				pointer: jQuery(this).closest('.tie-notice').attr('id'),
				action : 'dismiss-wp-pointer',
			},
		});
	});



	/* SAVE THEME SETTINGS
	------------------------------------------------------------------------------------------ */
	var $saveAlert = jQuery( '#tie-saving-settings' );

	jQuery('#tie_form').submit(function() {

		// Check if the import field has a file
		var importSettings = jQuery('#tie-import-file').val();
		if( importSettings.length > 0 ){
			return true;
		}

		// Disable all blank fields to reduce the size of the data
		jQuery('form#tie_form input, form#tie_form textarea, form#tie_form select').each(function(){
			if( ! jQuery(this).val() ){
				jQuery(this).attr( 'disabled', true );
			}
		});

		// Serialize the data array
		var data = jQuery(this).serialize().replace( /%3C/g, '%3Ctie-open-tag' ); //issue in saving any code with meta tag on some servers

		// Re-activate the disabled options
		jQuery('form#tie_form input:disabled, form#tie_form textarea:disabled, form#tie_form select:disabled').attr( 'disabled', false );

		// Add the Overlay layer and reset the saving spinner
		$tieBody.addClass('has-overlay');
		$saveAlert.removeClass('is-success is-failed');

		// Send the Saving Ajax request
		jQuery.post(
			ajaxurl,
			data,
			function( response ){
				if( response == 1 ){
					$saveAlert.addClass('is-success').delay(900).fadeOut(700);
					setTimeout(function() { $tieBody.removeClass('has-overlay'); },1200);
				}
				else if( response == 2 ){
					location.reload();
				}
				else {
					$saveAlert.addClass('is-failed').delay(900).fadeOut(700);
					setTimeout(function() { $tieBody.removeClass('has-overlay'); },1200);
				}
			});

			return false;
	});


	/* SAVE SETTINGS ALERT */
	$saveAlert.fadeOut();
	jQuery('.tie-save-button').click( function() {
		$saveAlert.fadeIn();
	});



	/* THEME PANEL
	------------------------------------------------------------------------------------------ */
	jQuery('.tie-panel, .tie-notice').css({ 'opacity':1, 'visibility':'visible'});

	var tabsHeight = jQuery('.tie-panel-tabs').outerHeight();
	jQuery('.tabs-wrap').hide();
	jQuery('.tie-panel-tabs ul li:first').addClass('active').show();
	jQuery('.tabs-wrap:first').show();
	jQuery('.tie-panel-content').css({minHeight: tabsHeight});

	jQuery('li.tie-tabs:not(.tie-not-tab)').click(function() {
		jQuery('.tie-panel-tabs ul li').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.tabs-wrap').hide();
		var activeTab = jQuery(this).find('a').attr('href');
		jQuery(activeTab).show();
		document.location.hash = activeTab + '-target';

		// CodeMirror
		jQuery(activeTab).find('.CodeMirror').each(function(i, el){
	    el.CodeMirror.refresh();
		});

	});

	/* GO TO THE OPENED TAB WITH LOAD */
	var currentTab = window.location.hash.replace( '-target', '' );
	    currentTab = currentTab.replace( /\//g, '' ); // avoid issues when the URL contains something like #/campaign/0/contacts

	if( jQuery(currentTab).parent( '#tie_form' ).length ){
		var tabLinkClass = currentTab.replace( '#', '.' );
		jQuery('.tabs-wrap').hide();
		jQuery('.tie-panel-tabs ul li').removeClass('active');
		jQuery( currentTab ).show();
		jQuery( tabLinkClass ).addClass( 'active' );
	}



	/* DELETE SECTIONS
	------------------------------------------------------------------------------------------ */
	/* OPTION ITEM */
	$doc.on('click', '.del-item', function(){
		var $thisButton = jQuery(this);

		if( $thisButton.hasClass('del-custom-sidebar') ){
			var option = $thisButton.parent().find('input').val();
			jQuery('#custom-sidebars select').find('option[value="'+option+'"]').remove();
			jQuery('#sidebar_bbpress-item select').find('option[value="'+option+'"]').remove();
		}

		if( $thisButton.hasClass('del-section') ){
			var widgets = $thisButton.closest('.parent-item').find('.tie-manage-widgets').data('widgets');
			jQuery( '#wrap-' + widgets + ', #' + widgets + '-sidebar-options' ).remove();
		}

		$thisButton.closest('.parent-item').addClass('removed').fadeOut(function() {
			$thisButton.closest('.parent-item').remove();
		});

		return false;
	});

	/* DELETE PREVIEW IMAGE */
	$doc.on('click', '.del-img', function(){
		var $img = jQuery(this).parent();
		$img.fadeOut( 'fast',function() {
			$img.hide();
			$img.closest('.option-item').find('.tie-img-path').attr( 'value', '' );
		});
	});

	/* DELETE PREVIEW IMAGE */
	$doc.on('click', '.del-img-all', function(){
		var $imgLi = jQuery(this).closest('li');
		$imgLi.fadeOut( 'fast', function() {
			$imgLi.remove();
		});
	});



	/* CUSTOM BREAKING NEWS TEXT
	------------------------------------------------------------------------------------------ */
	jQuery( '#breaking_news_button' ).click(function() {
		var customlink = jQuery('#custom_link').val(),
				customtext = tieHTMLspecialchars( jQuery('#custom_text').val() );

		if( customtext.length > 0 && customlink.length > 0  ){
			jQuery( '#breaking_custom_error-item' ).slideUp();
			jQuery( '#customList' ).append( '\
				<li class="parent-item">\
					<div class="tie-block-head">\
						<a href="'+customlink+'" target="_blank">'+customtext+'</a>\
						<input name="tie_options[breaking_custom]['+customnext+'][link]" type="hidden" value="'+customlink+'" />\
						<input name="tie_options[breaking_custom]['+customnext+'][text]" type="hidden" value="'+customtext+'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			');
		}
		else{
			jQuery( '#breaking_custom_error-item' ).fadeIn();
		}

		customnext ++;
		jQuery( '#custom_link, #custom_text' ).val('');
	});



	/* ADD HIGHLIGHTS
	------------------------------------------------------------------------------------------ */
	jQuery( '#add_highlights_button' ).click(function() {
		var customtext = tieHTMLspecialchars( jQuery( '#custom_text' ).val() );
		if( customtext.length > 0 ){
			jQuery( '#highlights_custom_error-item' ).slideUp();
			jQuery( '#customList' ).append( '\
				<li class="parent-item">\
					<div class="tie-block-head">\
						'+customtext+'\
						<input name="tie_highlights_text['+customnext+']" type="hidden" value="'+ customtext +'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			');
		}
		else{
			jQuery( '#highlights_custom_error-item' ).fadeIn();
		}

		customnext ++;
		jQuery( '#custom_text' ).val('');
	});



	/* ADD Sources
	------------------------------------------------------------------------------------------ */
	jQuery( '#add_source_button' ).click(function() {
		var source_name = tieHTMLspecialchars( jQuery('#source_name').val() ),
				source_link = jQuery('#source_link').val();

		if( source_name.length > 0 ){
			jQuery( '#add-source-error-item' ).slideUp();

			var source_code = '\
				<li class="parent-item">\
					<div class="tie-block-head">';

					if( source_link.length > 0 ){
						source_code += '\
							<a href="'+source_link+'" target="_blank">'+source_name+'</a>\
							<input name="tie_source['+source_next+'][url]" type="hidden" value="'+source_link+'" />\
						';
					}
					else{
						source_code += source_name;
					}

					source_code += '\
						<input name="tie_source['+source_next+'][text]" type="hidden" value="'+source_name+'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			';

			jQuery( '#sources-list' ).append( source_code );
		}
		else{
			jQuery( '#add-source-error-item' ).fadeIn();
		}

		source_next ++;
		jQuery( '#source_link, #source_name' ).val('');
	});



	/* ADD Via
	------------------------------------------------------------------------------------------ */
	jQuery( '#add_via_button' ).click(function() {
		var via_name = tieHTMLspecialchars( jQuery('#via_name').val() ),
				via_link = jQuery('#via_link').val();

		if( via_name.length > 0 ){

			jQuery( '#add-via-error-item' ).slideUp();

			var via_code = '\
				<li class="parent-item">\
					<div class="tie-block-head">';

					if( via_link.length > 0 ){
						via_code += '\
							<a href="'+via_link+'" target="_blank">'+via_name+'</a>\
							<input name="tie_via['+via_next+'][url]" type="hidden" value="'+via_link+'" />\
						';
					}
					else{
						via_code += via_name;
					}

					via_code += '\
						<input name="tie_via['+via_next+'][text]" type="hidden" value="'+via_name+'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			';

			jQuery( '#via-list' ).append( via_code );
		}
		else{
			jQuery( '#add-via-error-item' ).fadeIn();
		}

		via_next ++;
		jQuery( '#via_link, #via_name' ).val('');
	});



	/* CUSTOM SIDEBARS
	------------------------------------------------------------------------------------------ */
	jQuery( '#sidebarAdd' ).click(function() {
		var SidebarName = jQuery( '#sidebarName' ).val();

		if( SidebarName.length > 0 ){
			jQuery( '#custom_sidebar_error-item' ).slideUp();
			jQuery('#sidebarsList').append( '\
				<li class="parent-item">\
					<div class="tie-block-head">\
						'+SidebarName+'\
						<input id="tie_sidebars" name="tie_options[sidebars][]" type="hidden" value="'+SidebarName+'" />\
						<a class="del-custom-sidebar del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			');
			jQuery( '#custom-sidebars select' ).append('<option value="'+SidebarName+'">'+SidebarName+'</option>');
			jQuery( '#sidebar_bbpress-item select' ).append('<option value="'+SidebarName+'">'+SidebarName+'</option>');
		}else{
			jQuery( '#custom_sidebar_error-item' ).fadeIn();
		}

		jQuery( '#sidebarName' ).val('');
	});



	/* VISUAL OPTIONS
	------------------------------------------------------------------------------------------ */
	jQuery('ul.tie-options').each(function( index ) {
		jQuery(this).find('input:checked').closest('li').addClass('selected');
	});

	$doc.on('click', 'ul.tie-options label', function(){
		var $thisBlock = jQuery(this),
				blockID = $thisBlock.closest('ul.tie-options').attr('id');

		jQuery( '#' + blockID ).find( 'li' ).removeClass('selected');
		//jQuery( '#' + blockID ).find(':radio').removeAttr('checked');
		$thisBlock.parent().addClass('selected');
		//$thisBlock.parent().find(':radio').attr('checked','checked');
		//return false;
	});



	/* SLIDERS - Category Options
	------------------------------------------------------------------------------------------ */
	// Show/hide slider and video playlist options

	if( $tieBody.hasClass('taxonomy-category') ){

		var $featured_posts_options  = jQuery( '.featured-posts-options' ).hide(),
				$featured_videos_options = jQuery( '.featured-videos-options' ).hide();

		selected_val = jQuery( '.visual-option-videos_list' ).find( 'input:checked' ).val();

		if( selected_val == 'videos_list' ){
			$featured_videos_options.show();
		}else{
			$featured_posts_options.show();
		}

		$doc.on('click', '#tie_featured_posts_style a', function(){
			var selected_val = jQuery( this ).closest( 'li' ).find( 'input' ).val();

			if( selected_val == 'videos_list' ){
				$featured_posts_options.hide();
				$featured_videos_options.show();
			}else{
				$featured_videos_options.hide();
				$featured_posts_options.show();
			}
		});
	}



	/* PREDEFINED SKINS
	------------------------------------------------------------------------------------------ */
	jQuery('.predefined-skins-options select').change(function(){
		var skin = jQuery(this).val(),
				skin_colors = tie_skins[skin];

		jQuery( '#tie-options-tab-styling' ).find('.tieColorSelector').val('');
		jQuery( '#tie-options-tab-styling' ).find('.wp-color-result').attr( 'style', '' );

		for ( var key in skin_colors ) {
			if (skin_colors.hasOwnProperty(key)) {
			 jQuery( '#'+key ).wpColorPicker( 'color', skin_colors[key] );
			}
		}
	});

});



/* Fire Sortable on the Widgets Tabs
------------------------------------------------------------------------------------------ */
function tie_sortable_tabs_trigger( $thisTabs ){

	$thisTabs.sortable({
		placeholder: 'tie-state-highlight',

		stop: function(event, ui){
			var data = '';

			$thisTabs.find('li').each(function(){
				var type = jQuery(this).data('tab');
				data += type + ',';
			});

			$thisTabs.parent().find('.stored-tabs-order').val( data.slice(0, -1) );
		}
	});
}



/* Fire Sortable on the Widgets Tabs
------------------------------------------------------------------------------------------ */
function tie_widget_posts_order( $thisElement ){

	$thisElement.change(function(){

		var $thisElement      = jQuery(this),
		    jetPackOption     = $thisElement.closest('.widget-content').find('.tie-jetpack-posts-order-option'),
		    relatedOption     = $thisElement.closest('.widget-content').find('.tie-related-posts-order-option'),
		    NoneCustomOptions = $thisElement.closest('.widget-content').find('.tie-non-custom-posts-order-option'),
		    theOptionsValue   = $thisElement.find('option:selected').val();

		if( theOptionsValue.indexOf('jetpack') >= 0 ){
			jetPackOption.show();

			NoneCustomOptions.hide();
			relatedOption.hide();
		}
		else if( theOptionsValue.indexOf('related') >= 0 ){
			relatedOption.show();

			NoneCustomOptions.hide();
			jetPackOption.hide();
		}
		else{
			NoneCustomOptions.show();

			jetPackOption.hide();
			relatedOption.hide();
		}
	});
}



/* IMAGE UPLOADER PREVIEW
------------------------------------------------------------------------------------------ */
function tie_image_uploader_trigger( $thisElement ){

	var thisElementID      = $thisElement.attr('id').replace('#',''),
			$thisElementParent = $thisElement.closest('.option-item'),
			$thisElementImage  = $thisElementParent.find('.img-preview'),
			uploaderTypeStyles = false;

	$thisElement.change(function(){
		$thisElementImage.show();
		$thisElementImage.find('img').attr('src', $thisElement.val());
	});

	if( $thisElement.hasClass('tie-background-path') ){
		thisElementID = thisElementID.replace('-img','');
		uploaderTypeStyles = true;
	}

	tie_set_uploader( thisElementID, uploaderTypeStyles );
}



/* IMAGE UPLOADER FUNCTIONS
------------------------------------------------------------------------------------------ */
function tie_builder_dragdrop() {

	jQuery( '#tie-builder-wrapper' ).sortable({
		placeholder: 'tie-state-highlight tie-state-sections',
		activate: function( event, ui ) {

			var $sortableWrap = ui.item,
					outerHeight   = $sortableWrap.outerHeight()+40;

			jQuery('.tie-state-sections').css( 'min-height', outerHeight );
		},
	});

	jQuery( '.tabs_cats' ).sortable({placeholder: 'tie-state-highlight'});

	jQuery( '.block-item' ).draggable({
		distance: 2,
		refreshPositions: true,
		containment: '#wpwrap',
		cursor: 'move',
		zIndex: 100,
		connectToSortable: '.tie-builder-blocks-wrapper',
		revert: true,
		revertDuration: 0,

		/*start: function( event, ui ) {
			ui.helper.css('width', ui.helper.width());
		},*/

		stop: function( event, ui ) {
			ui.helper.css('width','100%');
		}
	});

	jQuery( '.tie-builder-blocks-wrapper' ).sortable({
		placeholder: 'tie-state-highlight',
		items: '> .block-item',
		cursor: 'move',
		distance: 2,
		containment: '#wpwrap',
		tolerance: 'pointer',
		refreshPositions: true,

		receive: function( event, ui ) {
			var sectionID = jQuery(this).data('section-id');

			ui.item.find('[name^=tie_home_cats]').each(function(){
				var newName = jQuery(this).attr('name').replace(/tie_home_cats\[(\w+)\]/g, 'tie_home_cats\['+ sectionID +']' );
				jQuery(this).attr( 'name', newName );
			});
		},

		activate: function( event, ui ) {
			jQuery('.tie-builder-blocks-wrapper').css( 'min-height', '65px' );
			var $sortableWrap = ui.item.closest('.tie-builder-blocks-wrapper'),
					outerHeight   = ( $sortableWrap.outerHeight() > 0 ) ?  $sortableWrap.outerHeight()+40 : '65px';

			$sortableWrap.css( 'min-height', outerHeight );
			jQuery('.tie-builder-container').addClass( 'tie-block-hover' );
		},

		deactivate: function() {
			jQuery('.tie-builder-container').removeClass( 'tie-block-hover' );
			jQuery('.tie-builder-blocks-wrapper').css( 'min-height', '' );
		},
	}).sortable( 'option', 'connectWith', '.tie-builder-container' );

}


/* IMAGE UPLOADER FUNCTIONS
------------------------------------------------------------------------------------------ */
function tie_set_uploader( field, styling ) {
	var tie_bg_uploader;

	$doc.on('click', '#upload_'+field+'_button', function( event ){

		event.preventDefault();
		tie_bg_uploader = wp.media.frames.tie_bg_uploader = wp.media({
			title: 'Choose Image',
			library: {type: 'image' },
			button: {text: 'Select'},
			multiple: false
		});

		tie_bg_uploader.on( 'select', function() {
			var selection = tie_bg_uploader.state().get('selection');
			selection.map( function( attachment ) {

				attachment = attachment.toJSON();

				if( styling ){
					jQuery('#'+field+'-img').val(attachment.url);
				}

				else{
					jQuery('#'+field).val(attachment.url);
				}

				jQuery('#'+field+'-preview').show();
				jQuery('#'+field+'-preview img').attr('src', attachment.url );

				//Set the Retina Logo Width and Height
				if( field == 'logo' ){
					jQuery('#logo_retina_height').val(attachment.height);
					jQuery('#logo_retina_width').val(attachment.width);
				}
			});
		});

		tie_bg_uploader.open();
	});
}




/* Font UPLOADER FUNCTIONS
------------------------------------------------------------------------------------------ */
function tie_set_font_uploader( thisElement ) {

	var tie_font_uploader,
	    field = thisElement.attr('id').replace('#','');

	$doc.on('click', '#upload_'+field+'_button', function( event ){

		event.preventDefault();
		tie_font_uploader = wp.media.frames.tie_font_uploader = wp.media({
			title: 'Choose Font',
			library: {type: [ 'image', 'application' ] },
			button: {text: 'Select'},
			multiple: false
		});

		tie_font_uploader.on( 'select', function() {
			var selection = tie_font_uploader.state().get('selection');
			selection.map( function( attachment ) {

				attachment = attachment.toJSON();
				jQuery('#'+field).val(attachment.url);
			});
		});

		tie_font_uploader.open();
	});
}




/* Custom Color Picker
------------------------------------------------------------------------------------------ */
function tie_color_picker(){
	Color.prototype.toString = function(remove_alpha) {
		if (remove_alpha == 'no-alpha') {
			return this.toCSS('rgba', '1').replace(/\s+/g, '');
		}
		if (this._alpha < 1) {
			return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
		}
		var hex = parseInt(this._color, 10).toString(16);
		if (this.error) return '';
		if (hex.length < 6) {
			for (var i = 6 - hex.length - 1; i >= 0; i--) {
				hex = '0' + hex;
			}
		}
		return '#' + hex;
	};

	jQuery('.tieColorSelector').each(function() {

		var $control = jQuery(this),
		    value    = $control.val().replace(/\s+/g, ''),
		    palette_input = $control.attr('data-palette');

		if (palette_input == 'false' || palette_input == false) {
			var palette = false;
		}
		else if (palette_input == 'true' || palette_input == true) {
			var palette = true;
		}
		else {
			var palette = $control.attr('data-palette').split(",");
		}

		$control.wpColorPicker({ // change some things with the color picker
			clear: function(event, ui) {
			// TODO reset Alpha Slider to 100
			},
			change: function(event, ui) {
				var $transparency = $control.parents('.wp-picker-container:first').find('.transparency');
				$transparency.css('backgroundColor', ui.color.toString('no-alpha'));
			},
			palettes: palette
		});

		jQuery('<div class="tie-alpha-container"><div class="slider-alpha"></div><div class="transparency"></div></div>').appendTo($control.parents('.wp-picker-container'));
		var $alpha_slider = $control.parents('.wp-picker-container:first').find('.slider-alpha');
		if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
			var alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]) * 100;
			var alpha_val = parseInt(alpha_val);
		}
		else {
			var alpha_val = 100;
		}

		$alpha_slider.slider({
			slide: function(event, ui) {
				jQuery(this).find('.ui-slider-handle').text(ui.value); // show value on slider handle
			},
			create: function(event, ui) {
				var v = jQuery(this).slider('value');
				jQuery(this).find('.ui-slider-handle').text(v);
			},
			value: alpha_val,
			range: 'max',
			step: 1,
			min: 1,
			max: 100
		});

		$alpha_slider.slider().on('slidechange', function(event, ui) {
			var new_alpha_val = parseFloat(ui.value),
					iris = $control.data('a8cIris'),
					color_picker = $control.data('wpWpColorPicker');

			iris._color._alpha = new_alpha_val / 100.0;

			$control.val(iris._color.toString());
			color_picker.toggler.css({
				backgroundColor: $control.val()
			});

			var get_val = $control.val();
			jQuery($control).wpColorPicker('color', get_val);
		});
	});
}


/* htmlspecialchars in JS */
function tieHTMLspecialchars(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}


/* Switcher: IOS Style Switch Button | http://abpetkov.github.io/switchery */
(function(){function require(name){var module=require.modules[name];if(!module)throw new Error('failed to require "'+name+'"');if(!("exports"in module)&&typeof module.definition==="function"){module.client=module.component=true;module.definition.call(this,module.exports={},module);delete module.definition}return module.exports}require.loader="component";require.helper={};require.helper.semVerSort=function(a,b){var aArray=a.version.split(".");var bArray=b.version.split(".");for(var i=0;i<aArray.length;++i){var aInt=parseInt(aArray[i],10);var bInt=parseInt(bArray[i],10);if(aInt===bInt){var aLex=aArray[i].substr((""+aInt).length);var bLex=bArray[i].substr((""+bInt).length);if(aLex===""&&bLex!=="")return 1;if(aLex!==""&&bLex==="")return-1;if(aLex!==""&&bLex!=="")return aLex>bLex?1:-1;continue}else if(aInt>bInt){return 1}else{return-1}}return 0};require.latest=function(name,returnPath){function showError(name){throw new Error('failed to find latest module of "'+name+'"')}var versionRegexp=/(.*)~(.*)@v?(\d+\.\d+\.\d+[^\/]*)$/;var remoteRegexp=/(.*)~(.*)/;if(!remoteRegexp.test(name))showError(name);var moduleNames=Object.keys(require.modules);var semVerCandidates=[];var otherCandidates=[];for(var i=0;i<moduleNames.length;i++){var moduleName=moduleNames[i];if(new RegExp(name+"@").test(moduleName)){var version=moduleName.substr(name.length+1);var semVerMatch=versionRegexp.exec(moduleName);if(semVerMatch!=null){semVerCandidates.push({version:version,name:moduleName})}else{otherCandidates.push({version:version,name:moduleName})}}}if(semVerCandidates.concat(otherCandidates).length===0){showError(name)}if(semVerCandidates.length>0){var module=semVerCandidates.sort(require.helper.semVerSort).pop().name;if(returnPath===true){return module}return require(module)}var module=otherCandidates.pop().name;if(returnPath===true){return module}return require(module)};require.modules={};require.register=function(name,definition){require.modules[name]={definition:definition}};require.define=function(name,exports){require.modules[name]={exports:exports}};require.register("abpetkov~transitionize@0.0.3",function(exports,module){module.exports=Transitionize;function Transitionize(element,props){if(!(this instanceof Transitionize))return new Transitionize(element,props);this.element=element;this.props=props||{};this.init()}Transitionize.prototype.isSafari=function(){return/Safari/.test(navigator.userAgent)&&/Apple Computer/.test(navigator.vendor)};Transitionize.prototype.init=function(){var transitions=[];for(var key in this.props){transitions.push(key+" "+this.props[key])}this.element.style.transition=transitions.join(", ");if(this.isSafari())this.element.style.webkitTransition=transitions.join(", ")}});require.register("ftlabs~fastclick@v0.6.11",function(exports,module){function FastClick(layer){"use strict";var oldOnClick,self=this;this.trackingClick=false;this.trackingClickStart=0;this.targetElement=null;this.touchStartX=0;this.touchStartY=0;this.lastTouchIdentifier=0;this.touchBoundary=10;this.layer=layer;if(!layer||!layer.nodeType){throw new TypeError("Layer must be a document node")}this.onClick=function(){return FastClick.prototype.onClick.apply(self,arguments)};this.onMouse=function(){return FastClick.prototype.onMouse.apply(self,arguments)};this.onTouchStart=function(){return FastClick.prototype.onTouchStart.apply(self,arguments)};this.onTouchMove=function(){return FastClick.prototype.onTouchMove.apply(self,arguments)};this.onTouchEnd=function(){return FastClick.prototype.onTouchEnd.apply(self,arguments)};this.onTouchCancel=function(){return FastClick.prototype.onTouchCancel.apply(self,arguments)};if(FastClick.notNeeded(layer)){return}if(this.deviceIsAndroid){layer.addEventListener("mouseover",this.onMouse,true);layer.addEventListener("mousedown",this.onMouse,true);layer.addEventListener("mouseup",this.onMouse,true)}layer.addEventListener("click",this.onClick,true);layer.addEventListener("touchstart",this.onTouchStart,false);layer.addEventListener("touchmove",this.onTouchMove,false);layer.addEventListener("touchend",this.onTouchEnd,false);layer.addEventListener("touchcancel",this.onTouchCancel,false);if(!Event.prototype.stopImmediatePropagation){layer.removeEventListener=function(type,callback,capture){var rmv=Node.prototype.removeEventListener;if(type==="click"){rmv.call(layer,type,callback.hijacked||callback,capture)}else{rmv.call(layer,type,callback,capture)}};layer.addEventListener=function(type,callback,capture){var adv=Node.prototype.addEventListener;if(type==="click"){adv.call(layer,type,callback.hijacked||(callback.hijacked=function(event){if(!event.propagationStopped){callback(event)}}),capture)}else{adv.call(layer,type,callback,capture)}}}if(typeof layer.onclick==="function"){oldOnClick=layer.onclick;layer.addEventListener("click",function(event){oldOnClick(event)},false);layer.onclick=null}}FastClick.prototype.deviceIsAndroid=navigator.userAgent.indexOf("Android")>0;FastClick.prototype.deviceIsIOS=/iP(ad|hone|od)/.test(navigator.userAgent);FastClick.prototype.deviceIsIOS4=FastClick.prototype.deviceIsIOS&&/OS 4_\d(_\d)?/.test(navigator.userAgent);FastClick.prototype.deviceIsIOSWithBadTarget=FastClick.prototype.deviceIsIOS&&/OS ([6-9]|\d{2})_\d/.test(navigator.userAgent);FastClick.prototype.needsClick=function(target){"use strict";switch(target.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(target.disabled){return true}break;case"input":if(this.deviceIsIOS&&target.type==="file"||target.disabled){return true}break;case"label":case"video":return true}return/\bneedsclick\b/.test(target.className)};FastClick.prototype.needsFocus=function(target){"use strict";switch(target.nodeName.toLowerCase()){case"textarea":return true;case"select":return!this.deviceIsAndroid;case"input":switch(target.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return false}return!target.disabled&&!target.readOnly;default:return/\bneedsfocus\b/.test(target.className)}};FastClick.prototype.sendClick=function(targetElement,event){"use strict";var clickEvent,touch;if(document.activeElement&&document.activeElement!==targetElement){document.activeElement.blur()}touch=event.changedTouches[0];clickEvent=document.createEvent("MouseEvents");clickEvent.initMouseEvent(this.determineEventType(targetElement),true,true,window,1,touch.screenX,touch.screenY,touch.clientX,touch.clientY,false,false,false,false,0,null);clickEvent.forwardedTouchEvent=true;targetElement.dispatchEvent(clickEvent)};FastClick.prototype.determineEventType=function(targetElement){"use strict";if(this.deviceIsAndroid&&targetElement.tagName.toLowerCase()==="select"){return"mousedown"}return"click"};FastClick.prototype.focus=function(targetElement){"use strict";var length;if(this.deviceIsIOS&&targetElement.setSelectionRange&&targetElement.type.indexOf("date")!==0&&targetElement.type!=="time"){length=targetElement.value.length;targetElement.setSelectionRange(length,length)}else{targetElement.focus()}};FastClick.prototype.updateScrollParent=function(targetElement){"use strict";var scrollParent,parentElement;scrollParent=targetElement.fastClickScrollParent;if(!scrollParent||!scrollParent.contains(targetElement)){parentElement=targetElement;do{if(parentElement.scrollHeight>parentElement.offsetHeight){scrollParent=parentElement;targetElement.fastClickScrollParent=parentElement;break}parentElement=parentElement.parentElement}while(parentElement)}if(scrollParent){scrollParent.fastClickLastScrollTop=scrollParent.scrollTop}};FastClick.prototype.getTargetElementFromEventTarget=function(eventTarget){"use strict";if(eventTarget.nodeType===Node.TEXT_NODE){return eventTarget.parentNode}return eventTarget};FastClick.prototype.onTouchStart=function(event){"use strict";var targetElement,touch,selection;if(event.targetTouches.length>1){return true}targetElement=this.getTargetElementFromEventTarget(event.target);touch=event.targetTouches[0];if(this.deviceIsIOS){selection=window.getSelection();if(selection.rangeCount&&!selection.isCollapsed){return true}if(!this.deviceIsIOS4){if(touch.identifier===this.lastTouchIdentifier){event.preventDefault();return false}this.lastTouchIdentifier=touch.identifier;this.updateScrollParent(targetElement)}}this.trackingClick=true;this.trackingClickStart=event.timeStamp;this.targetElement=targetElement;this.touchStartX=touch.pageX;this.touchStartY=touch.pageY;if(event.timeStamp-this.lastClickTime<200){event.preventDefault()}return true};FastClick.prototype.touchHasMoved=function(event){"use strict";var touch=event.changedTouches[0],boundary=this.touchBoundary;if(Math.abs(touch.pageX-this.touchStartX)>boundary||Math.abs(touch.pageY-this.touchStartY)>boundary){return true}return false};FastClick.prototype.onTouchMove=function(event){"use strict";if(!this.trackingClick){return true}if(this.targetElement!==this.getTargetElementFromEventTarget(event.target)||this.touchHasMoved(event)){this.trackingClick=false;this.targetElement=null}return true};FastClick.prototype.findControl=function(labelElement){"use strict";if(labelElement.control!==undefined){return labelElement.control}if(labelElement.htmlFor){return document.getElementById(labelElement.htmlFor)}return labelElement.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")};FastClick.prototype.onTouchEnd=function(event){"use strict";var forElement,trackingClickStart,targetTagName,scrollParent,touch,targetElement=this.targetElement;if(!this.trackingClick){return true}if(event.timeStamp-this.lastClickTime<200){this.cancelNextClick=true;return true}this.cancelNextClick=false;this.lastClickTime=event.timeStamp;trackingClickStart=this.trackingClickStart;this.trackingClick=false;this.trackingClickStart=0;if(this.deviceIsIOSWithBadTarget){touch=event.changedTouches[0];targetElement=document.elementFromPoint(touch.pageX-window.pageXOffset,touch.pageY-window.pageYOffset)||targetElement;targetElement.fastClickScrollParent=this.targetElement.fastClickScrollParent}targetTagName=targetElement.tagName.toLowerCase();if(targetTagName==="label"){forElement=this.findControl(targetElement);if(forElement){this.focus(targetElement);if(this.deviceIsAndroid){return false}targetElement=forElement}}else if(this.needsFocus(targetElement)){if(event.timeStamp-trackingClickStart>100||this.deviceIsIOS&&window.top!==window&&targetTagName==="input"){this.targetElement=null;return false}this.focus(targetElement);if(!this.deviceIsIOS4||targetTagName!=="select"){this.targetElement=null;event.preventDefault()}return false}if(this.deviceIsIOS&&!this.deviceIsIOS4){scrollParent=targetElement.fastClickScrollParent;if(scrollParent&&scrollParent.fastClickLastScrollTop!==scrollParent.scrollTop){return true}}if(!this.needsClick(targetElement)){event.preventDefault();this.sendClick(targetElement,event)}return false};FastClick.prototype.onTouchCancel=function(){"use strict";this.trackingClick=false;this.targetElement=null};FastClick.prototype.onMouse=function(event){"use strict";if(!this.targetElement){return true}if(event.forwardedTouchEvent){return true}if(!event.cancelable){return true}if(!this.needsClick(this.targetElement)||this.cancelNextClick){if(event.stopImmediatePropagation){event.stopImmediatePropagation()}else{event.propagationStopped=true}event.stopPropagation();event.preventDefault();return false}return true};FastClick.prototype.onClick=function(event){"use strict";var permitted;if(this.trackingClick){this.targetElement=null;this.trackingClick=false;return true}if(event.target.type==="submit"&&event.detail===0){return true}permitted=this.onMouse(event);if(!permitted){this.targetElement=null}return permitted};FastClick.prototype.destroy=function(){"use strict";var layer=this.layer;if(this.deviceIsAndroid){layer.removeEventListener("mouseover",this.onMouse,true);layer.removeEventListener("mousedown",this.onMouse,true);layer.removeEventListener("mouseup",this.onMouse,true)}layer.removeEventListener("click",this.onClick,true);layer.removeEventListener("touchstart",this.onTouchStart,false);layer.removeEventListener("touchmove",this.onTouchMove,false);layer.removeEventListener("touchend",this.onTouchEnd,false);layer.removeEventListener("touchcancel",this.onTouchCancel,false)};FastClick.notNeeded=function(layer){"use strict";var metaViewport;var chromeVersion;if(typeof window.ontouchstart==="undefined"){return true}chromeVersion=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1];if(chromeVersion){if(FastClick.prototype.deviceIsAndroid){metaViewport=document.querySelector("meta[name=viewport]");if(metaViewport){if(metaViewport.content.indexOf("user-scalable=no")!==-1){return true}if(chromeVersion>31&&window.innerWidth<=window.screen.width){return true}}}else{return true}}if(layer.style.msTouchAction==="none"){return true}return false};FastClick.attach=function(layer){"use strict";return new FastClick(layer)};if(typeof define!=="undefined"&&define.amd){define(function(){"use strict";return FastClick})}else if(typeof module!=="undefined"&&module.exports){module.exports=FastClick.attach;module.exports.FastClick=FastClick}else{window.FastClick=FastClick}});require.register("component~indexof@0.0.3",function(exports,module){module.exports=function(arr,obj){if(arr.indexOf)return arr.indexOf(obj);for(var i=0;i<arr.length;++i){if(arr[i]===obj)return i}return-1}});require.register("component~classes@1.2.1",function(exports,module){var index=require("component~indexof@0.0.3");var re=/\s+/;var toString=Object.prototype.toString;module.exports=function(el){return new ClassList(el)};function ClassList(el){if(!el)throw new Error("A DOM element reference is required");this.el=el;this.list=el.classList}ClassList.prototype.add=function(name){if(this.list){this.list.add(name);return this}var arr=this.array();var i=index(arr,name);if(!~i)arr.push(name);this.el.className=arr.join(" ");return this};ClassList.prototype.remove=function(name){if("[object RegExp]"==toString.call(name)){return this.removeMatching(name)}if(this.list){this.list.remove(name);return this}var arr=this.array();var i=index(arr,name);if(~i)arr.splice(i,1);this.el.className=arr.join(" ");return this};ClassList.prototype.removeMatching=function(re){var arr=this.array();for(var i=0;i<arr.length;i++){if(re.test(arr[i])){this.remove(arr[i])}}return this};ClassList.prototype.toggle=function(name,force){if(this.list){if("undefined"!==typeof force){if(force!==this.list.toggle(name,force)){this.list.toggle(name)}}else{this.list.toggle(name)}return this}if("undefined"!==typeof force){if(!force){this.remove(name)}else{this.add(name)}}else{if(this.has(name)){this.remove(name)}else{this.add(name)}}return this};ClassList.prototype.array=function(){var str=this.el.className.replace(/^\s+|\s+$/g,"");var arr=str.split(re);if(""===arr[0])arr.shift();return arr};ClassList.prototype.has=ClassList.prototype.contains=function(name){return this.list?this.list.contains(name):!!~index(this.array(),name)}});require.register("switchery",function(exports,module){var transitionize=require("abpetkov~transitionize@0.0.3"),fastclick=require("ftlabs~fastclick@v0.6.11"),classes=require("component~classes@1.2.1");module.exports=Switchery;var defaults={color:"#64bd63",secondaryColor:"#dfdfdf",jackColor:"#fff",className:"switchery",disabled:false,disabledOpacity:.5,speed:"0.4s",size:"default"};function Switchery(element,options){if(!(this instanceof Switchery))return new Switchery(element,options);this.element=element;this.options=options||{};for(var i in defaults){if(this.options[i]==null){this.options[i]=defaults[i]}}if(this.element!=null&&this.element.type=="checkbox")this.init()}Switchery.prototype.hide=function(){this.element.style.display="none"};Switchery.prototype.show=function(){var switcher=this.create();this.insertAfter(this.element,switcher)};Switchery.prototype.create=function(){this.switcher=document.createElement("span");this.jack=document.createElement("small");this.switcher.appendChild(this.jack);this.switcher.className=this.options.className;return this.switcher};Switchery.prototype.insertAfter=function(reference,target){reference.parentNode.insertBefore(target,reference.nextSibling)};Switchery.prototype.isChecked=function(){return this.element.checked};Switchery.prototype.isDisabled=function(){return this.options.disabled||this.element.disabled||this.element.readOnly};Switchery.prototype.setPosition=function(clicked){var checked=this.isChecked(),switcher=this.switcher,jack=this.jack;if(clicked&&checked)checked=false;else if(clicked&&!checked)checked=true;if(checked===true){this.element.checked=true;if(window.getComputedStyle)jack.style.left=parseInt(window.getComputedStyle(switcher).width)-parseInt(window.getComputedStyle(jack).width)+"px";else jack.style.left=parseInt(switcher.currentStyle["width"])-parseInt(jack.currentStyle["width"])+"px";if(this.options.color)this.colorize();this.setSpeed()}else{jack.style.left=0;this.element.checked=false;this.switcher.style.boxShadow="inset 0 0 0 0 "+this.options.secondaryColor;this.switcher.style.borderColor=this.options.secondaryColor;this.switcher.style.backgroundColor=this.options.secondaryColor!==defaults.secondaryColor?this.options.secondaryColor:"#fff";this.jack.style.backgroundColor=this.options.jackColor;this.setSpeed()}};Switchery.prototype.setSpeed=function(){var switcherProp={},jackProp={left:this.options.speed.replace(/[a-z]/,"")/2+"s"};if(this.isChecked()){switcherProp={border:this.options.speed,"box-shadow":this.options.speed,"background-color":this.options.speed.replace(/[a-z]/,"")*3+"s"}}else{switcherProp={border:this.options.speed,"box-shadow":this.options.speed}}transitionize(this.switcher,switcherProp);transitionize(this.jack,jackProp)};Switchery.prototype.setSize=function(){var small="switchery-small",normal="switchery-default",large="switchery-large";switch(this.options.size){case"small":classes(this.switcher).add(small);break;case"large":classes(this.switcher).add(large);break;default:classes(this.switcher).add(normal);break}};Switchery.prototype.colorize=function(){var switcherHeight=this.switcher.offsetHeight/2;this.switcher.style.backgroundColor=this.options.color;this.switcher.style.borderColor=this.options.color;this.switcher.style.boxShadow="inset 0 0 0 "+switcherHeight+"px "+this.options.color;this.jack.style.backgroundColor=this.options.jackColor};Switchery.prototype.handleOnchange=function(state){if(document.dispatchEvent){var event=document.createEvent("HTMLEvents");event.initEvent("change",true,true);this.element.dispatchEvent(event)}else{this.element.fireEvent("onchange")}};Switchery.prototype.handleChange=function(){var self=this,el=this.element;if(el.addEventListener){el.addEventListener("change",function(){self.setPosition()})}else{el.attachEvent("onchange",function(){self.setPosition()})}};Switchery.prototype.handleClick=function(){var self=this,switcher=this.switcher,parent=self.element.parentNode.tagName.toLowerCase(),labelParent=parent==="label"?false:true;if(this.isDisabled()===false){fastclick(switcher);if(switcher.addEventListener){switcher.addEventListener("click",function(e){self.setPosition(labelParent);self.handleOnchange(self.element.checked)})}else{switcher.attachEvent("onclick",function(){self.setPosition(labelParent);self.handleOnchange(self.element.checked)})}}else{this.element.disabled=true;this.switcher.style.opacity=this.options.disabledOpacity}};Switchery.prototype.markAsSwitched=function(){this.element.setAttribute("data-switchery",true)};Switchery.prototype.markedAsSwitched=function(){return this.element.getAttribute("data-switchery")};Switchery.prototype.init=function(){this.hide();this.show();this.setSize();this.setPosition();this.markAsSwitched();this.handleChange();this.handleClick()}});if(typeof exports=="object"){module.exports=require("switchery")}else if(typeof define=="function"&&define.amd){define("Switchery",[],function(){return require("switchery")})}else{(this||window)["Switchery"]=require("switchery")}})();


/*
 * jQuery.fontselect - A font selector for the Google Web Fonts api
 * Tom Moor, http://tommoor.com
 * Copyright (c) 2011 Tom Moor
 * MIT Licensed
 * @version 0.1
*/

(function($){
	$.fn.fontselect = function(options) {
		var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

		var standardFonts = [
			"safefont#Arial, Helvetica, sans-serif",
			"safefont#'Arial Black', Gadget, sans-serif",
			"safefont#'Bookman Old Style', serif",
			"safefont#'Comic Sans MS', cursive",
			"safefont#Courier, monospace",
			"safefont#Garamond, serif",
			"safefont#Georgia, serif",
			"safefont#Impact, Charcoal, sans-serif",
			"safefont#'Lucida Console', Monaco, monospace",
			"safefont#'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"safefont#'MS Sans Serif', Geneva, sans-serif",
			"safefont#'MS Serif', 'New York', sans-serif",
			"safefont#'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"safefont#Tahoma, Geneva, sans-serif",
			"safefont#'Times New Roman', Times, serif",
			"safefont#'Trebuchet MS', Helvetica, sans-serif",
			"safefont#Verdana, Geneva, sans-serif",
		];

		var fonts = [
			'ABeeZee',
			'Abel',
			'Abhaya+Libre',
			'Abril+Fatface',
			'Aclonica',
			'Acme',
			'Actor',
			'Adamina',
			'Advent+Pro',
			'Aguafina+Script',
			'Akronim',
			'Aladin',
			'Aldrich',
			'Alef',
			'Alegreya',
			'Alegreya+SC',
			'Alegreya+Sans',
			'Alegreya+Sans+SC',
			'Aleo',
			'Alex+Brush',
			'Alfa+Slab+One',
			'Alice',
			'Alike',
			'Alike+Angular',
			'Allan',
			'Allerta',
			'Allerta+Stencil',
			'Allura',
			'Almendra',
			'Almendra+Display',
			'Almendra+SC',
			'Amarante',
			'Amaranth',
			'Amatic+SC',
			'Amethysta',
			'Amiko',
			'Amiri',
			'Amita',
			'Anaheim',
			'Andada',
			'Andika',
			'Angkor',
			'Annie+Use+Your+Telescope',
			'Anonymous+Pro',
			'Antic',
			'Antic+Didone',
			'Antic+Slab',
			'Anton',
			'Arapey',
			'Arbutus',
			'Arbutus+Slab',
			'Architects+Daughter',
			'Archivo',
			'Archivo+Black',
			'Archivo+Narrow',
			'Aref+Ruqaa',
			'Arima+Madurai',
			'Arimo',
			'Arizonia',
			'Armata',
			'Arsenal',
			'Artifika',
			'Arvo',
			'Arya',
			'Asap',
			'Asap+Condensed',
			'Asar',
			'Asset',
			'Assistant',
			'Astloch',
			'Asul',
			'Athiti',
			'Atma',
			'Atomic+Age',
			'Aubrey',
			'Audiowide',
			'Autour+One',
			'Average',
			'Average+Sans',
			'Averia+Gruesa+Libre',
			'Averia+Libre',
			'Averia+Sans+Libre',
			'Averia+Serif+Libre',
			'B612',
			'B612+Mono',
			'Bad+Script',
			'Bahiana',
			'Bai+Jamjuree',
			'Baloo',
			'Baloo+Bhai',
			'Baloo+Bhaijaan',
			'Baloo+Bhaina',
			'Baloo+Chettan',
			'Baloo+Da',
			'Baloo+Paaji',
			'Baloo+Tamma',
			'Baloo+Tammudu',
			'Baloo+Thambi',
			'Balthazar',
			'Bangers',
			'Barlow',
			'Barlow+Condensed',
			'Barlow+Semi+Condensed',
			'Barrio',
			'Basic',
			'Battambang',
			'Baumans',
			'Bayon',
			'Belgrano',
			'Bellefair',
			'Belleza',
			'BenchNine',
			'Bentham',
			'Berkshire+Swash',
			'Bevan',
			'Bigelow+Rules',
			'Bigshot+One',
			'Bilbo',
			'Bilbo+Swash+Caps',
			'BioRhyme',
			'BioRhyme+Expanded',
			'Biryani',
			'Bitter',
			'Black+And+White+Picture',
			'Black+Han+Sans',
			'Black+Ops+One',
			'Bokor',
			'Bonbon',
			'Boogaloo',
			'Bowlby+One',
			'Bowlby+One+SC',
			'Brawler',
			'Bree+Serif',
			'Bubblegum+Sans',
			'Bubbler+One',
			'Buda',
			'Buenard',
			'Bungee',
			'Bungee+Hairline',
			'Bungee+Inline',
			'Bungee+Outline',
			'Bungee+Shade',
			'Butcherman',
			'Butterfly+Kids',
			'Cabin',
			'Cabin+Condensed',
			'Cabin+Sketch',
			'Caesar+Dressing',
			'Cagliostro',
			'Cairo',
			'Calligraffitti',
			'Cambay',
			'Cambo',
			'Candal',
			'Cantarell',
			'Cantata+One',
			'Cantora+One',
			'Capriola',
			'Cardo',
			'Carme',
			'Carrois+Gothic',
			'Carrois+Gothic+SC',
			'Carter+One',
			'Catamaran',
			'Caudex',
			'Caveat',
			'Caveat+Brush',
			'Cedarville+Cursive',
			'Ceviche+One',
			'Chakra+Petch',
			'Changa',
			'Changa+One',
			'Chango',
			'Charm',
			'Charmonman',
			'Chathura',
			'Chau+Philomene+One',
			'Chela+One',
			'Chelsea+Market',
			'Chenla',
			'Cherry+Cream+Soda',
			'Cherry+Swash',
			'Chewy',
			'Chicle',
			'Chivo',
			'Chonburi',
			'Cinzel',
			'Cinzel+Decorative',
			'Clicker+Script',
			'Coda',
			'Coda+Caption',
			'Codystar',
			'Coiny',
			'Combo',
			'Comfortaa',
			'Coming+Soon',
			'Concert+One',
			'Condiment',
			'Content',
			'Contrail+One',
			'Convergence',
			'Cookie',
			'Copse',
			'Corben',
			'Cormorant',
			'Cormorant+Garamond',
			'Cormorant+Infant',
			'Cormorant+SC',
			'Cormorant+Unicase',
			'Cormorant+Upright',
			'Courgette',
			'Cousine',
			'Coustard',
			'Covered+By+Your+Grace',
			'Crafty+Girls',
			'Creepster',
			'Crete+Round',
			'Crimson+Text',
			'Croissant+One',
			'Crushed',
			'Cuprum',
			'Cute+Font',
			'Cutive',
			'Cutive+Mono',
			'Damion',
			'Dancing+Script',
			'Dangrek',
			'David+Libre',
			'Dawning+of+a+New+Day',
			'Days+One',
			'Dekko',
			'Delius',
			'Delius+Swash+Caps',
			'Delius+Unicase',
			'Della+Respira',
			'Denk+One',
			'Devonshire',
			'Dhurjati',
			'Didact+Gothic',
			'Diplomata',
			'Diplomata+SC',
			'Do+Hyeon',
			'Dokdo',
			'Domine',
			'Donegal+One',
			'Doppio+One',
			'Dorsa',
			'Dosis',
			'Dr+Sugiyama',
			'Duru+Sans',
			'Dynalight',
			'EB+Garamond',
			'Eagle+Lake',
			'East+Sea+Dokdo',
			'Eater',
			'Economica',
			'Eczar',
			'El+Messiri',
			'Electrolize',
			'Elsie',
			'Elsie+Swash+Caps',
			'Emblema+One',
			'Emilys+Candy',
			'Encode+Sans',
			'Encode+Sans+Condensed',
			'Encode+Sans+Expanded',
			'Encode+Sans+Semi+Condensed',
			'Encode+Sans+Semi+Expanded',
			'Engagement',
			'Englebert',
			'Enriqueta',
			'Erica+One',
			'Esteban',
			'Euphoria+Script',
			'Ewert',
			'Exo',
			'Exo+2',
			'Expletus+Sans',
			'Fahkwang',
			'Fanwood+Text',
			'Farsan',
			'Fascinate',
			'Fascinate+Inline',
			'Faster+One',
			'Fasthand',
			'Fauna+One',
			'Faustina',
			'Federant',
			'Federo',
			'Felipa',
			'Fenix',
			'Finger+Paint',
			'Fira+Mono',
			'Fira+Sans',
			'Fira+Sans+Condensed',
			'Fira+Sans+Extra+Condensed',
			'Fjalla+One',
			'Fjord+One',
			'Flamenco',
			'Flavors',
			'Fondamento',
			'Fontdiner+Swanky',
			'Forum',
			'Francois+One',
			'Frank+Ruhl+Libre',
			'Freckle+Face',
			'Fredericka+the+Great',
			'Fredoka+One',
			'Freehand',
			'Fresca',
			'Frijole',
			'Fruktur',
			'Fugaz+One',
			'GFS+Didot',
			'GFS+Neohellenic',
			'Gabriela',
			'Gaegu',
			'Gafata',
			'Galada',
			'Galdeano',
			'Galindo',
			'Gamja+Flower',
			'Gentium+Basic',
			'Gentium+Book+Basic',
			'Geo',
			'Geostar',
			'Geostar+Fill',
			'Germania+One',
			'Gidugu',
			'Gilda+Display',
			'Give+You+Glory',
			'Glass+Antiqua',
			'Glegoo',
			'Gloria+Hallelujah',
			'Goblin+One',
			'Gochi+Hand',
			'Gorditas',
			'Gothic+A1',
			'Goudy+Bookletter+1911',
			'Graduate',
			'Grand+Hotel',
			'Gravitas+One',
			'Great+Vibes',
			'Griffy',
			'Gruppo',
			'Gudea',
			'Gugi',
			'Gurajada',
			'Habibi',
			'Halant',
			'Hammersmith+One',
			'Hanalei',
			'Hanalei+Fill',
			'Handlee',
			'Hanuman',
			'Happy+Monkey',
			'Harmattan',
			'Headland+One',
			'Heebo',
			'Henny+Penny',
			'Herr+Von+Muellerhoff',
			'Hi+Melody',
			'Hind',
			'Hind+Guntur',
			'Hind+Madurai',
			'Hind+Siliguri',
			'Hind+Vadodara',
			'Holtwood+One+SC',
			'Homemade+Apple',
			'Homenaje',
			'IBM+Plex+Mono',
			'IBM+Plex+Sans',
			'IBM+Plex+Sans+Condensed',
			'IBM+Plex+Serif',
			'IM+Fell+DW+Pica',
			'IM+Fell+DW+Pica+SC',
			'IM+Fell+Double+Pica',
			'IM+Fell+Double+Pica+SC',
			'IM+Fell+English',
			'IM+Fell+English+SC',
			'IM+Fell+French+Canon',
			'IM+Fell+French+Canon+SC',
			'IM+Fell+Great+Primer',
			'IM+Fell+Great+Primer+SC',
			'Iceberg',
			'Iceland',
			'Imprima',
			'Inconsolata',
			'Inder',
			'Indie+Flower',
			'Inika',
			'Inknut+Antiqua',
			'Irish+Grover',
			'Istok+Web',
			'Italiana',
			'Italianno',
			'Itim',
			'Jacques+Francois',
			'Jacques+Francois+Shadow',
			'Jaldi',
			'Jim+Nightshade',
			'Jockey+One',
			'Jolly+Lodger',
			'Jomhuria',
			'Josefin+Sans',
			'Josefin+Slab',
			'Joti+One',
			'Jua',
			'Judson',
			'Julee',
			'Julius+Sans+One',
			'Junge',
			'Jura',
			'Just+Another+Hand',
			'Just+Me+Again+Down+Here',
			'K2D',
			'Kadwa',
			'Kalam',
			'Kameron',
			'Kanit',
			'Kantumruy',
			'Karla',
			'Karma',
			'Katibeh',
			'Kaushan+Script',
			'Kavivanar',
			'Kavoon',
			'Kdam+Thmor',
			'Keania+One',
			'Kelly+Slab',
			'Kenia',
			'Khand',
			'Khmer',
			'Khula',
			'Kirang+Haerang',
			'Kite+One',
			'Knewave',
			'KoHo',
			'Kodchasan',
			'Kosugi',
			'Kosugi+Maru',
			'Kotta+One',
			'Koulen',
			'Kranky',
			'Kreon',
			'Kristi',
			'Krona+One',
			'Krub',
			'Kumar+One',
			'Kumar+One+Outline',
			'Kurale',
			'La+Belle+Aurore',
			'Laila',
			'Lakki+Reddy',
			'Lalezar',
			'Lancelot',
			'Lateef',
			'Lato',
			'League+Script',
			'Leckerli+One',
			'Ledger',
			'Lekton',
			'Lemon',
			'Lemonada',
			'Libre+Barcode+128',
			'Libre+Barcode+128+Text',
			'Libre+Barcode+39',
			'Libre+Barcode+39+Extended',
			'Libre+Barcode+39+Extended+Text',
			'Libre+Barcode+39+Text',
			'Libre+Baskerville',
			'Libre+Franklin',
			'Life+Savers',
			'Lilita+One',
			'Lily+Script+One',
			'Limelight',
			'Linden+Hill',
			'Lobster',
			'Lobster+Two',
			'Londrina+Outline',
			'Londrina+Shadow',
			'Londrina+Sketch',
			'Londrina+Solid',
			'Lora',
			'Love+Ya+Like+A+Sister',
			'Loved+by+the+King',
			'Lovers+Quarrel',
			'Luckiest+Guy',
			'Lusitana',
			'Lustria',
			'M+PLUS+1p',
			'M+PLUS+Rounded+1c',
			'Macondo',
			'Macondo+Swash+Caps',
			'Mada',
			'Magra',
			'Maiden+Orange',
			'Maitree',
			'Major+Mono+Display',
			'Mako',
			'Mali',
			'Mallanna',
			'Mandali',
			'Manuale',
			'Marcellus',
			'Marcellus+SC',
			'Marck+Script',
			'Margarine',
			'Markazi+Text',
			'Marko+One',
			'Marmelad',
			'Martel',
			'Martel+Sans',
			'Marvel',
			'Mate',
			'Mate+SC',
			'Maven+Pro',
			'McLaren',
			'Meddon',
			'MedievalSharp',
			'Medula+One',
			'Meera+Inimai',
			'Megrim',
			'Meie+Script',
			'Merienda',
			'Merienda+One',
			'Merriweather',
			'Merriweather+Sans',
			'Metal',
			'Metal+Mania',
			'Metamorphous',
			'Metrophobic',
			'Michroma',
			'Milonga',
			'Miltonian',
			'Miltonian+Tattoo',
			'Mina',
			'Miniver',
			'Miriam+Libre',
			'Mirza',
			'Miss+Fajardose',
			'Mitr',
			'Modak',
			'Modern+Antiqua',
			'Mogra',
			'Molengo',
			'Molle',
			'Monda',
			'Monofett',
			'Monoton',
			'Monsieur+La+Doulaise',
			'Montaga',
			'Montez',
			'Montserrat',
			'Montserrat+Alternates',
			'Montserrat+Subrayada',
			'Moul',
			'Moulpali',
			'Mountains+of+Christmas',
			'Mouse+Memoirs',
			'Mr+Bedfort',
			'Mr+Dafoe',
			'Mr+De+Haviland',
			'Mrs+Saint+Delafield',
			'Mrs+Sheppards',
			'Mukta',
			'Mukta+Mahee',
			'Mukta+Malar',
			'Mukta+Vaani',
			'Muli',
			'Mystery+Quest',
			'NTR',
			'Nanum+Brush+Script',
			'Nanum+Gothic',
			'Nanum+Gothic+Coding',
			'Nanum+Myeongjo',
			'Nanum+Pen+Script',
			'Neucha',
			'Neuton',
			'New+Rocker',
			'News+Cycle',
			'Niconne',
			'Niramit',
			'Nixie+One',
			'Nobile',
			'Nokora',
			'Norican',
			'Nosifer',
			'Notable',
			'Nothing+You+Could+Do',
			'Noticia+Text',
			'Noto+Sans',
			'Noto+Sans+JP',
			'Noto+Sans+KR',
			'Noto+Sans+SC',
			'Noto+Sans+TC',
			'Noto+Serif',
			'Noto+Serif+JP',
			'Noto+Serif+KR',
			'Noto+Serif+SC',
			'Noto+Serif+TC',
			'Nova+Cut',
			'Nova+Flat',
			'Nova+Mono',
			'Nova+Oval',
			'Nova+Round',
			'Nova+Script',
			'Nova+Slim',
			'Nova+Square',
			'Numans',
			'Nunito',
			'Nunito+Sans',
			'Odor+Mean+Chey',
			'Offside',
			'Old+Standard+TT',
			'Oldenburg',
			'Oleo+Script',
			'Oleo+Script+Swash+Caps',
			'Open+Sans',
			'Open+Sans+Condensed',
			'Oranienbaum',
			'Orbitron',
			'Oregano',
			'Orienta',
			'Original+Surfer',
			'Oswald',
			'Over+the+Rainbow',
			'Overlock',
			'Overlock+SC',
			'Overpass',
			'Overpass+Mono',
			'Ovo',
			'Oxygen',
			'Oxygen+Mono',
			'PT+Mono',
			'PT+Sans',
			'PT+Sans+Caption',
			'PT+Sans+Narrow',
			'PT+Serif',
			'PT+Serif+Caption',
			'Pacifico',
			'Padauk',
			'Palanquin',
			'Palanquin+Dark',
			'Pangolin',
			'Paprika',
			'Parisienne',
			'Passero+One',
			'Passion+One',
			'Pathway+Gothic+One',
			'Patrick+Hand',
			'Patrick+Hand+SC',
			'Pattaya',
			'Patua+One',
			'Pavanam',
			'Paytone+One',
			'Peddana',
			'Peralta',
			'Permanent+Marker',
			'Petit+Formal+Script',
			'Petrona',
			'Philosopher',
			'Piedra',
			'Pinyon+Script',
			'Pirata+One',
			'Plaster',
			'Play',
			'Playball',
			'Playfair+Display',
			'Playfair+Display+SC',
			'Podkova',
			'Poiret+One',
			'Poller+One',
			'Poly',
			'Pompiere',
			'Pontano+Sans',
			'Poor+Story',
			'Poppins',
			'Port+Lligat+Sans',
			'Port+Lligat+Slab',
			'Pragati+Narrow',
			'Prata',
			'Preahvihear',
			'Press+Start+2P',
			'Pridi',
			'Princess+Sofia',
			'Prociono',
			'Prompt',
			'Prosto+One',
			'Proza+Libre',
			'Puritan',
			'Purple+Purse',
			'Quando',
			'Quantico',
			'Quattrocento',
			'Quattrocento+Sans',
			'Questrial',
			'Quicksand',
			'Quintessential',
			'Qwigley',
			'Racing+Sans+One',
			'Radley',
			'Rajdhani',
			'Rakkas',
			'Raleway',
			'Raleway+Dots',
			'Ramabhadra',
			'Ramaraja',
			'Rambla',
			'Rammetto+One',
			'Ranchers',
			'Rancho',
			'Ranga',
			'Rasa',
			'Rationale',
			'Ravi+Prakash',
			'Redressed',
			'Reem+Kufi',
			'Reenie+Beanie',
			'Revalia',
			'Rhodium+Libre',
			'Ribeye',
			'Ribeye+Marrow',
			'Righteous',
			'Risque',
			'Roboto',
			'Roboto+Condensed',
			'Roboto+Mono',
			'Roboto+Slab',
			'Rochester',
			'Rock+Salt',
			'Rokkitt',
			'Romanesco',
			'Ropa+Sans',
			'Rosario',
			'Rosarivo',
			'Rouge+Script',
			'Rozha+One',
			'Rubik',
			'Rubik+Mono+One',
			'Ruda',
			'Rufina',
			'Ruge+Boogie',
			'Ruluko',
			'Rum+Raisin',
			'Ruslan+Display',
			'Russo+One',
			'Ruthie',
			'Rye',
			'Sacramento',
			'Sahitya',
			'Sail',
			'Saira',
			'Saira+Condensed',
			'Saira+Extra+Condensed',
			'Saira+Semi+Condensed',
			'Salsa',
			'Sanchez',
			'Sancreek',
			'Sansita',
			'Sarabun',
			'Sarala',
			'Sarina',
			'Sarpanch',
			'Satisfy',
			'Sawarabi+Gothic',
			'Sawarabi+Mincho',
			'Scada',
			'Scheherazade',
			'Schoolbell',
			'Scope+One',
			'Seaweed+Script',
			'Secular+One',
			'Sedgwick+Ave',
			'Sedgwick+Ave+Display',
			'Sevillana',
			'Seymour+One',
			'Shadows+Into+Light',
			'Shadows+Into+Light+Two',
			'Shanti',
			'Share',
			'Share+Tech',
			'Share+Tech+Mono',
			'Shojumaru',
			'Short+Stack',
			'Shrikhand',
			'Siemreap',
			'Sigmar+One',
			'Signika',
			'Signika+Negative',
			'Simonetta',
			'Sintony',
			'Sirin+Stencil',
			'Six+Caps',
			'Skranji',
			'Slabo+13px',
			'Slabo+27px',
			'Slackey',
			'Smokum',
			'Smythe',
			'Sniglet',
			'Snippet',
			'Snowburst+One',
			'Sofadi+One',
			'Sofia',
			'Song+Myung',
			'Sonsie+One',
			'Sorts+Mill+Goudy',
			'Source+Code+Pro',
			'Source+Sans+Pro',
			'Source+Serif+Pro',
			'Space+Mono',
			'Special+Elite',
			'Spectral',
			'Spectral+SC',
			'Spicy+Rice',
			'Spinnaker',
			'Spirax',
			'Squada+One',
			'Sree+Krushnadevaraya',
			'Sriracha',
			'Srisakdi',
			'Staatliches',
			'Stalemate',
			'Stalinist+One',
			'Stardos+Stencil',
			'Stint+Ultra+Condensed',
			'Stint+Ultra+Expanded',
			'Stoke',
			'Strait',
			'Stylish',
			'Sue+Ellen+Francisco',
			'Suez+One',
			'Sumana',
			'Sunflower',
			'Sunshiney',
			'Supermercado+One',
			'Sura',
			'Suranna',
			'Suravaram',
			'Suwannaphum',
			'Swanky+and+Moo+Moo',
			'Syncopate',
			'Tajawal',
			'Tangerine',
			'Taprom',
			'Tauri',
			'Taviraj',
			'Teko',
			'Telex',
			'Tenali+Ramakrishna',
			'Tenor+Sans',
			'Text+Me+One',
			'Thasadith',
			'The+Girl+Next+Door',
			'Tienne',
			'Tillana',
			'Timmana',
			'Tinos',
			'Titan+One',
			'Titillium+Web',
			'Trade+Winds',
			'Trirong',
			'Trocchi',
			'Trochut',
			'Trykker',
			'Tulpen+One',
			'Ubuntu',
			'Ubuntu+Condensed',
			'Ubuntu+Mono',
			'Ultra',
			'Uncial+Antiqua',
			'Underdog',
			'Unica+One',
			'UnifrakturCook',
			'UnifrakturMaguntia',
			'Unkempt',
			'Unlock',
			'Unna',
			'VT323',
			'Vampiro+One',
			'Varela',
			'Varela+Round',
			'Vast+Shadow',
			'Vesper+Libre',
			'Vibur',
			'Vidaloka',
			'Viga',
			'Voces',
			'Volkhov',
			'Vollkorn',
			'Vollkorn+SC',
			'Voltaire',
			'Waiting+for+the+Sunrise',
			'Wallpoet',
			'Walter+Turncoat',
			'Warnes',
			'Wellfleet',
			'Wendy+One',
			'Wire+One',
			'Work+Sans',
			'Yanone+Kaffeesatz',
			'Yantramanav',
			'Yatra+One',
			'Yellowtail',
			'Yeon+Sung',
			'Yeseva+One',
			'Yesteryear',
			'Yrsa',
			'ZCOOL+KuaiLe',
			'ZCOOL+QingKe+HuangYou',
			'ZCOOL+XiaoWei',
			'Zeyada',
			'Zilla+Slab',
			'Zilla+Slab+Highlight',
		];

	 //Early Access Google Web fonts
		var earlyaccessFonts = {
			earlyaccess: [

				//Arabic Fonts
				{ fontName: 'Cairo',        text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Amiri',        text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Lateef',       text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Scheherazade', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Changa',       text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Lemonada',     text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Lalezar',      text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Mirza',        text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Rakkas',       text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Mada',         text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Katibeh',      text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Jomhuria',     text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Harmattan',    text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'El Messiri',   text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Reem Kufi',    text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Aref Ruqaa',   text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},

				{ fontName: 'early#Droid Arabic Kufi',  text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Droid Arabic Naskh', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Kufi Arabic',   text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Naskh Arabic',  text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Nastaliq Urdu', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Thabit',             text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Nastaliq Urdu Draft', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Sans Kufi Arabic',    text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },

				//Lao Fonts
				{ fontName: 'early#Dhyana',         text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Lao Muang Don',  text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Lao Sans Pro',   text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Noto Sans Lao',  text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Noto Serif Lao', text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Phetsarath',     text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Souliyo',        text: 'ຂອບໃຈຫຼາຍໆເດີ້' },

				//Tamil Fonts
				{ fontName: 'early#Droid Sans Tamil', text:'வாருங்கள்'},
				{ fontName: 'early#Karla Tamil Inclined', text:'வாருங்கள்'},
				{ fontName: 'early#Karla Tamil Upright', text:'வாருங்கள்'},
				{ fontName: 'early#Lohit Tamil', text:'வாருங்கள்'},
				{ fontName: 'early#Noto Sans Tamil', text:'வாருங்கள்'},

				//Thai
				{ fontName: 'early#Droid Sans Thai', text:'ยินดีต้อนรับ'},
				{ fontName: 'early#Droid Serif Thai', text:'ยินดีต้อนรับ'},
				{ fontName: 'early#Noto Sans Thai', text:'ยินดีต้อนรับ'},

				//Bengali
				{ fontName: 'early#Noto Sans Bengali', text:'স্বাগতম'},
				{ fontName: 'early#Lohit Bengali', text:'স্বাগতম'},

				//Devanagari
				{ fontName: 'early#Noto Sans Devanagari', text:'नमस्कार'},
				{ fontName: 'early#Lohit Devanagari', text:'नमस्कार'},

				//Korean
				{ fontName: 'early#Hanna', text:'환영합니다'},
				{ fontName: 'early#Jeju Gothic', text:'환영합니다'},
				{ fontName: 'early#Jeju Hallasan', text:'환영합니다'},
				{ fontName: 'early#Jeju Myeongjo', text:'환영합니다'},
				{ fontName: 'early#KoPub Batang', text:'환영합니다'},
				{ fontName: 'early#Nanum Brush Script', text:'환영합니다'},
				{ fontName: 'early#Nanum Gothic', text:'환영합니다'},
				{ fontName: 'early#Nanum Myeongjo', text:'환영합니다'},
				{ fontName: 'early#Nanum Pen Script', text:'환영합니다'},
				{ fontName: 'early#Nanum Gothic Coding', text:'환영합니다'},
				{ fontName: 'early#Noto Sans KR', text:'환영합니다'},

				//Balinese
				{ fontName: 'early#Noto Sans Balinese', text:'환영합니다'},

				//Georgian
				{ fontName: 'early#Noto Serif Georgian', text:'გამარჯობა'},
				{ fontName: 'early#Noto Sans Georgian', text:'გამარჯობა'},

				//Georgian
				{ fontName: 'early#Noto Serif Georgian', text:'გამარჯობა'},
				{ fontName: 'early#Noto Sans Georgian', text:'გამარჯობა'},

				//Chinese
				{ fontName: 'early#Noto Sans SC', text:'谢谢'}, //Simplified
				{ fontName: 'early#Noto Sans TC', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXFangSong', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXHei', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXMing', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXKai', text:'謝謝'}, //Traditional

			],
		};

		//FontFace.me Fonts || http://fontface.me/font/all
		var fontfaceME = '[{"name":"\u062c\u0630\u0648\u0631 \u0645\u0633\u0637\u062d","permalink":"flat-jooza"},{"name":"\u0628\u0627\u0633\u0645 \u0645\u0631\u062d","permalink":"basim-marah"},{"name":"\u062d\u0645\u0627\u062f\u0647 \u062e\u0641\u064a\u0641","permalink":"hamada"},{"name":"\u062f\u064a\u0643\u0648 \u062b\u0644\u062b","permalink":"decotype-thuluth"},{"name":"\u0643\u0645\u0628\u0648\u0633\u064a\u062a","permalink":"b-compset"},{"name":"\u0643\u0648\u0641\u064a \u0645\u0632\u062e\u0631\u0641","permalink":"old-antic-decorative"},{"name":"Al Gemah Alhoda","permalink":"al-gemah-alhoda"},{"name":"\u062d\u0627\u0645\u062f","permalink":"b-hamid"},{"name":"\u0645\u062d\u0631\u0645","permalink":"ah-moharram-bold"},{"name":"\u062f\u064a\u0648\u0627\u0646\u064a \u0628\u064a\u0646\u062a","permalink":"diwani-bent"},{"name":"\u0641\u0627\u0631\u0633\u064a \u0628\u0633\u064a\u0637","permalink":"farsi-simple-bold"},{"name":"\u0643\u0648\u0641\u064a \u0639\u0631\u064a\u0636","permalink":"Old-Antic-Bold"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a","permalink":"amiri"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a \u0639\u0631\u064a\u0636","permalink":"amiri-bold"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a \u0645\u0627\u0626\u0644","permalink":"amiri-slanted"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a \u0642\u0631\u0622\u0646","permalink":"amiri-quran"},{"name":"\u062f\u0631\u0648\u064a\u062f \u0643\u0648\u0641\u064a","permalink":"DroidKufi-Regular"},{"name":"\u062d\u0645\u0627\u0647","permalink":"hama"},{"name":"\u062c\u0630\u0648\u0631","permalink":"jooza"},{"name":"\u0627\u0644\u0643\u0648\u0641\u064a","permalink":"kufi"},{"name":"\u0641\u0646\u064a","permalink":"fanni"},{"name":"\u0637\u0647\u0631\u0627\u0646","permalink":"btehran"},{"name":"\u0623\u0631\u0627\u0628\u064a\u0643\u0633","permalink":"barabics"},{"name":"\u0627\u0644\u062f\u064a\u0648\u0627\u0646\u064a","permalink":"diwanltr"},{"name":"STC","permalink":"stc"},{"name":"\u0628\u0637\u0631\u0633","permalink":"boutros-ads"},{"name":"Sepideh","permalink":"b-sepideh"},{"name":"\u062b\u0627\u0628\u062a","permalink":"Thabit"},{"name":"\u0646\u0648\u062a\u0648 \u0623\u0648\u0631\u062f\u0648","permalink":"Noto-Urdu"},{"name":"\u0644\u0637\u064a\u0641","permalink":"lateef"},{"name":"\u062f\u0631\u0648\u064a\u062f \u0633\u0627\u0646\u0632","permalink":"droid-sans"},{"name":"\u0627\u0644\u062c\u0632\u064a\u0631\u0629","permalink":"jazeera"},{"name":"\u0631\u0627\u0648\u064a","permalink":"rawi"},{"name":"\u0631\u0627\u0648\u064a \u0633\u062a\u0631\u0627\u064a\u0643","permalink":"strick"},{"name":"\u0645\u064a\u0643\u0633 \u0639\u0631\u0628\u064a","permalink":"themixarab"},{"name":"\u0646\u0648\u0631 \u0647\u062f\u0649","permalink":"noorehuda"},{"name":"\u0627\u0644\u062c\u0632\u0627\u0626\u0631","permalink":"algeria"},{"name":"\u0628\u063a\u062f\u0627\u062f","permalink":"baghdad"},{"name":"\u0623\u0633\u0627\u0645\u0629","permalink":"osama"},{"name":"\u0647\u0627\u0644\u0629","permalink":"hala"},{"name":"\u0627\u0644\u0628\u064a\u0627\u0646","permalink":"albayan"},{"name":"\u0639\u0633\u0627\u0641","permalink":"assaf"},{"name":"\u062a\u0642\u0646\u064a\u0629","permalink":"taqniya"},{"name":"\u0623\u0633\u0645\u0627\u0621","permalink":"asmaa"},{"name":"\u0628\u064f\u0646","permalink":"bon"},{"name":"\u0627\u0644\u0642\u0635\u064a\u0631","permalink":"alqusair"},{"name":"\u0627\u0644\u0634\u0647\u062f\u0627\u0621","permalink":"alshohadaa"},{"name":"\u0639\u0642\u064a\u0642","permalink":"aqeeq"},{"name":"\u062f\u064a\u0627\u0646\u0627","permalink":"diana-light"},{"name":"\u062f\u064a\u0627\u0646\u0627 \u0639\u0631\u064a\u0636","permalink":"diana-regular"},{"name":"\u062c\u0646\u0627\u062a","permalink":"jannat"},{"name":"\u0645\u064a\u062f\u0627\u0646","permalink":"maidan"},{"name":"\u0646\u0648\u0627\u0631","permalink":"nawar"},{"name":"\u0645\u063a\u0631\u0628\u064a","permalink":"maghrebi"},{"name":"\u0627\u0644\u0623\u0648\u0631\u0627\u0633","permalink":"aures"},{"name":"\u064a\u0631\u0627\u0639 \u0631\u0641\u064a\u0639","permalink":"yaraa"},{"name":"\u064a\u0631\u0627\u0639","permalink":"yaraa-regular"},{"name":"\u0644\u0645\u0627\u0631","permalink":"lamar"},{"name":"\u0627\u0644\u062d\u0631","permalink":"alhorr"},{"name":"\u0645\u0633\u0644\u0645\u0629","permalink":"muslimah"},{"name":"\u062d\u064a\u0627\u0647","permalink":"hayah"},{"name":"\u0631\u0648\u062d \u0627\u0644\u062f\u0648\u062d\u0629","permalink":"spirit-of-doha"},{"name":"\u0637\u064a\u0648\u0631 \u0627\u0644\u062c\u0646\u0629","permalink":"toyor-aljanah"},{"name":"\u0634\u0631\u0648\u0642","permalink":"shorooq"},{"name":"\u0627\u0628\u062a\u0633\u0627\u0645","permalink":"Ibtisam"},{"name":"Davat","permalink":"bdavat"},{"name":"\u0641\u0627\u0646\u062a\u0627\u0632\u064a","permalink":"fantezy"},{"name":"\u0627\u0635\u0641\u0647\u0627\u0646","permalink":"esfahan"},{"name":"\u0643\u0648\u0641\u064a \u062b\u0627\u0628\u062a","permalink":"fixed-kufi"},{"name":"\u0627\u0646\u0633\u0627\u0646","permalink":"insan"},{"name":"\u0645\u062a\u0642\u0646","permalink":"motken"},{"name":"kacst \u0641\u0627\u0631\u0633\u064a","permalink":"kacst-farsi"},{"name":"\u0627\u0644\u0645\u0648\u062f\u0647","permalink":"almawadah"},{"name":"\u0634\u0643\u0627\u0631\u064a","permalink":"shekari"},{"name":"\u0627\u0644\u0645\u062c\u062f","permalink":"al-majd"},{"name":"kamran","permalink":"kamran"},{"name":"\u063a\u0644\u0627","permalink":"ghala"},{"name":"\u063a\u0644\u0627 \u0639\u0631\u064a\u0636","permalink":"ghala-bold"},{"name":"\u0628\u0627\u0631\u0627\u0646","permalink":"baran"},{"name":"\u062f\u0631\u0648\u064a\u062f \u0646\u0633\u062e","permalink":"droid-naskh"},{"name":"\u0639\u062b\u0645\u0627\u0646","permalink":"taha-naskh"},{"name":"\u0643\u0648\u0643\u0628","permalink":"kawkab"},{"name":"BEIN \u0628\u064a \u0625\u0646 \u0639\u0631\u064a\u0636","permalink":"bein"},{"name":"\u0628\u064a \u0627\u0646 BEIN","permalink":"bein-normal"},{"name":"\u064a\u0627\u0633\u064a\u0646","permalink":"yassin"},{"name":"\u0627\u0644\u0623\u0631\u062f\u0646","permalink":"jordan"},{"name":"\u0645\u064a\u0644\u0627\u0646\u0648","permalink":"milano"},{"name":"\u062b\u0645\u064a\u0646","permalink":"thameen"},{"name":"MBC","permalink":"mbc"},{"name":"\u0625\u0634\u0631\u0627\u0642","permalink":"ishraq"},{"name":"\u0627\u0644\u0633\u0639\u0648\u062f\u064a\u0629","permalink":"saudi"},{"name":"\u0633\u0628\u0623","permalink":"sheba"},{"name":"\u062a\u0646\u0633\u064a\u0642","permalink":"tanseek"},{"name":"\u0628\u062f\u0627\u064a\u0629 ","permalink":"bedayah"},{"name":"\u0646\u064a\u0643\u0627\u0631","permalink":"neckar"},{"name":"\u0645\u0637\u064a\u0631\u0629","permalink":"motairah"},{"name":"\u0645\u0637\u064a\u0631\u0629 \u062e\u0641\u064a\u0641","permalink":"motairah-light"},{"name":"\u0628\u0647\u064a\u062c","permalink":"bahij"},{"name":"\u0628\u0643\u0631\u0647","permalink":"bokra"},{"name":"\u0633\u0643\u0631","permalink":"sukar"},{"name":"\u0633\u0643\u0631 \u0639\u0631\u064a\u0636","permalink":"sukar-bold"},{"name":"\u0633\u0643\u0631 \u0627\u0633\u0648\u062f","permalink":"sukar-black"},{"name":"\u0625\u0635\u0631\u0627\u0631 \u0633\u0648\u0631\u064a\u0627","permalink":"israr-syria"},{"name":"\u062a\u0634\u0643\u064a\u0644\u064a","permalink":"tachkili"},{"name":"\u0623\u0631\u0648\u0649","permalink":"arwa"},{"name":"\u0627\u0644\u0633\u0645\u0627\u0621","permalink":"sky"},{"name":"\u0639\u0645\u0631","permalink":"omar"},{"name":"\u0634\u064a\u0631\u0627\u0632","permalink":"shiraz"},{"name":"\u0633\u062a\u0627\u0631\u0647","permalink":"setareh"},{"name":"\u062d\u0645\u0627","permalink":"homa"},{"name":"\u0647\u0644\u0627\u0644","permalink":"helal"},{"name":"\u062a\u0635\u0645\u064a\u0645","permalink":"tasmeem-med"},{"name":"\u0631\u0643\u0627\u0633","permalink":"rakkas"},{"name":"\u062c\u0645\u0647\u0648\u0631\u064a\u0629","permalink":"jomhuria"},{"name":"\u0647\u0631\u0645\u062a\u0627\u0646","permalink":"harmattan"},{"name":"\u0643\u062a\u064a\u0628\u0629","permalink":"katibeh"},{"name":"\u0631\u064a\u0645 \u0643\u0648\u0641\u064a","permalink":"reem-kufi"},{"name":"\u0627\u0644\u062c\u0632\u064a\u0631\u0629 \u062e\u0641\u064a\u0641","permalink":"jazeera-light"},{"name":"\u0639\u0627\u0631\u0641 \u0631\u0642\u0639\u0647","permalink":"aref-ruqaa"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629","permalink":"cairo"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629 \u062e\u0641\u064a\u0641","permalink":"cairo-light"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629 \u062e\u0641\u064a\u0641 \u062c\u062f\u0627","permalink":"cairo-extra-light"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629 \u062b\u0642\u064a\u0644","permalink":"cairo-bold"},{"name":"\u0627\u0644\u0645\u0633\u064a\u0631\u064a","permalink":"elmessiri"},{"name":"\u0627\u0644\u0645\u0633\u064a\u0631\u064a \u062b\u0642\u064a\u0644","permalink":"elmessiri-bold"},{"name":"\u0627\u0644\u0645\u0633\u064a\u0631\u064a \u062e\u0641\u064a\u0641","permalink":"elmessiri-light"},{"name":"\u0644\u064a\u0645\u0648\u0646\u0627\u062f\u0629","permalink":"lemonada"},{"name":"\u0644\u064a\u0645\u0648\u0646\u0627\u062f\u0629 \u062b\u0642\u064a\u0644","permalink":"lemonada-bold"},{"name":"\u0644\u064a\u0645\u0648\u0646\u0627\u062f\u0629 \u062e\u0641\u064a\u0641","permalink":"lemonada-light"},{"name":"\u0645\u062f\u0649","permalink":"mada"},{"name":"\u0645\u062f\u0649 \u062b\u0642\u064a\u0644","permalink":"mada-bold"},{"name":"\u0645\u062f\u0649 \u062e\u0641\u064a\u0641","permalink":"mada-light"},{"name":"\u0645\u064a\u0631\u0632\u0627","permalink":"mirza"},{"name":"\u0645\u064a\u0631\u0632\u0627 \u062b\u0642\u064a\u0644","permalink":"mirza-bold"},{"name":"\u0645\u064a\u0631\u0632\u0627 \u0645\u062a\u0648\u0633\u0637","permalink":"mirza-medium"},{"name":"\u062a\u064a\u0645 \u062e\u0641\u064a\u0641","permalink":"vip-tim-light"},{"name":"\u062a\u064a\u0645","permalink":"vip-tim"},{"name":"\u062a\u064a\u0645 \u062b\u0642\u064a\u0644","permalink":"vip-tim-bold"},{"name":"\u062a\u064a\u0645 \u0627\u0633\u0648\u062f","permalink":"vip-tim-black"},{"name":"\u0633\u0637\u0648\u0631","permalink":"stoor"},{"name":"\u062b\u0644\u062b \u0645\u0632\u062e\u0631\u0641","permalink":"thuluth-decorated"},{"name":"\u0627\u0644\u0645\u0635\u062d\u0641","permalink":"almushaf"},{"name":"\u0634\u0645\u0633","permalink":"shams"},{"name":"\u0633\u0639\u062f\u064a\u0647","permalink":"sadiyah"},{"name":"\u0632\u0647\u0631\u0629","permalink":"zahra"},{"name":"\u0632\u0647\u0631\u0629 \u062b\u0642\u064a\u0644","permalink":"zahra-bold"},{"name":"\u0633\u0645\u0627\u0631\u062a \u0645\u0627\u0646","permalink":"smartman"},{"name":"\u062d\u0627\u0643\u0645","permalink":"vip-hakm"},{"name":"\u062d\u0627\u0643\u0645 \u062e\u0641\u064a\u0641","permalink":"vip-hakm-thin"},{"name":"\u062d\u0627\u0643\u0645 \u062b\u0642\u064a\u0644","permalink":"vip-hakm-bold"},{"name":"\u0635\u0628\u063a\u0647","permalink":"sabgha"},{"name":"\u0646\u0642\u0627\u0621","permalink":"alnaqaa"},{"name":"\u0631\u0627\u0648\u064a \u062e\u0641\u064a\u0641","permalink":"rawy-thin"},{"name":"\u0631\u0627\u0648\u064a \u062b\u0642\u064a\u0644","permalink":"rawy-bold"},{"name":"\u0627\u0644\u062d\u0631\u0647","permalink":"alhurra"},{"name":"\u0634\u0647\u062f","permalink":"shahd"},{"name":"\u0634\u0647\u062f \u0639\u0631\u064a\u0636","permalink":"shahd-bold"},{"name":"\u0646\u064a\u0643\u0627\u0631","permalink":"neckar"},{"name":" \u0646\u064a\u0643\u0627\u0631 \u062b\u0642\u064a\u0644","permalink":"neckar-bold"},{"name":"\u0633\u0627\u0631\u0647","permalink":"sara"},{"name":"\u0627\u0644\u0633\u0645\u0627\u0621 \u062b\u0642\u064a\u0644","permalink":"sky-bold"},{"name":"\u0631\u0628\u0627\u0637","permalink":"rabat"},{"name":"\u0639\u0631\u0628 \u0648\u064a\u0644","permalink":"arabswell-1"},{"name":"\u0631\u0633\u0627\u064a\u0644 \u062e\u0641\u064a\u0641","permalink":"rsail-light"},{"name":"\u0631\u0633\u0627\u064a\u0644 \u062b\u0642\u064a\u0644","permalink":"rsail-bold"},{"name":"\u0631\u0633\u0627\u064a\u0644","permalink":"rsail"},{"name":"\u062f\u0628\u064a \u062b\u0642\u064a\u0644","permalink":"dubai-bold"},{"name":"\u062f\u0628\u064a \u0645\u062a\u0648\u0633\u0637","permalink":"dubai-medium"},{"name":"\u062f\u0628\u064a \u062e\u0641\u064a\u0641","permalink":"dubai-light"},{"name":"\u062f\u0628\u064a","permalink":"dubai"},{"name":"\u062c\u064a\u0632\u0627 \u0628\u0631\u0648","permalink":"geeza-pro"},{"name":"\u062c\u064a\u0632\u0627 \u0628\u0631\u0648 \u062b\u0642\u064a\u0644","permalink":"geeza-pro-bold"},{"name":"\u0627\u0644\u0639\u0647\u062f","permalink":"alahed"}]';


		var fontFaceFonts = JSON.parse( fontfaceME );

		var settings = {
			style: 'font-select',
			placeholder: 'Select a font',
			lookahead: 2,
			api: '//fonts.googleapis.com/css?family=',
			api_early: '//fonts.googleapis.com/earlyaccess/',
			fontfaceApi: '//www.fontstatic.com/f='
		};


		var Fontselect = (function(){

			function Fontselect(original, o){
				this.$original = $(original);
				this.options = o;
				//this.active = false;
				this.setupHtml();
				this.getVisibleFonts();
				this.bindEvents();

				var font = this.$original.val();
				if(font) {
					this.updateSelected();
					this.addFontLink(font);
				}
			}

			Fontselect.prototype.bindEvents = function(){
				$('li', this.$results)
				.click(__bind(this.selectFont, this))
				.mouseenter(__bind(this.activateFont, this))
				.mouseleave(__bind(this.deactivateFont, this));

				$('span', this.$select).click(__bind(this.toggleDrop, this));

				this.$arrow.click(__bind(this.toggleDrop, this));

				$(document).mouseup(function (e){
					if (!$('.font-select').is(e.target) && $('.font-select').has(e.target).length === 0){
						$( '.font-select' ).removeClass('font-select-active');
						$( '.fs-drop' ).hide();
					}
				});

			};

			Fontselect.prototype.toggleDrop = function(ev){

				if(this.$element.hasClass('font-select-active')){
					this.$element.removeClass('font-select-active');
					this.$drop.hide();
					clearInterval(this.visibleInterval);
				}
				else{
					$( '.font-select' ).removeClass('font-select-active');
					$( '.fs-drop' ).hide();

					this.$element.addClass('font-select-active');
					this.$drop.show();
					this.moveToSelected();
					this.visibleInterval = setInterval(__bind(this.getVisibleFonts, this), 500);
				}

				//this.active = !this.active;
			};

			Fontselect.prototype.selectFont = function(){
				var font = $('li.active', this.$results).data('value');
				this.$original.val(font).change();
				this.updateSelected();
				this.toggleDrop();
			};


			Fontselect.prototype.moveToSelected = function(){

				var $li, font = this.$original.val();

				if (font){
					$li = $('li[data-value="'+ font +'"]', this.$results);
				}
				else {
					$li = $("li", this.$results).first();
				}

				if( $li.length ){
					this.$results.scrollTop(0).scrollTop($li.addClass('active').position().top);
				}

			};

			Fontselect.prototype.activateFont = function(ev){
				$('li.active', this.$results).removeClass('active');
				$(ev.currentTarget).addClass('active');
			};

			Fontselect.prototype.deactivateFont = function(ev){
				$(ev.currentTarget).removeClass('active');
			};

			Fontselect.prototype.updateSelected = function(){
				var font = this.$original.val();

				if( font.indexOf( 'early#' ) >= 0 ){
					var earlyaccess = earlyaccessFonts['earlyaccess'];
					l = earlyaccess.length;
					for(var i=0; i<l; i++){
						var fontName =  earlyaccess[i]['fontName'];
						if ( fontName.indexOf( font ) >= 0 ){
							var fontText = earlyaccess[i]['fontName'].replace( 'early#', '');
							//var fontText = earlyaccess[i]['text'];
							break;
						}
					}
				}
				else{
					var fontText = this.toReadable(font);
				}

				$('span', this.$element).text(fontText).css(this.toStyle(font));
			};

			Fontselect.prototype.setupHtml = function(){
				this.$original.empty().hide();
				this.$element = $('<div>', {'class': this.options.style});
				this.$arrow = $('<div><b></b></div>');
				this.$select = $('<a><span>'+ this.options.placeholder +'</span></a>');
				this.$drop = $('<div>', {'class': 'fs-drop'});
				this.$results = $('<ul>', {'class': 'fs-results'});
				this.$original.after(this.$element.append(this.$select.append(this.$arrow)).append(this.$drop));
				this.$drop.append(this.$results.append(this.fontsAsHtml())).hide();
			};

			Fontselect.prototype.fontsAsHtml = function(){

				var r, s, f, h = ' ';

				var l = standardFonts.length;


				if( this.$original.attr( 'id' ).indexOf( 'standard_font' ) >= 0 ){

					//Standard Fonts
					for(var i=0; i<l; i++){
						r = this.toReadable(standardFonts[i]);
						s = this.toStyle(standardFonts[i]);

						h += '<li data-value="'+ standardFonts[i] +'" style="font-family: '+s['font-family'] +'; font-weight: '+s['font-weight'] +'">'+ r +'</li>';
					}

				}

				else if( this.$original.attr( 'id' ).indexOf( '_fontfaceme' ) >= 0 ){

					l = fontFaceFonts.length;

					fontFaceFontName = '';

					for(var i=0; i<l; i++){
						fontFaceFontName = fontFaceFonts[i]['name'];
						fontFaceFontid   = fontFaceFonts[i]['permalink'];

						h += '<li data-value="faceme#'+ fontFaceFontid +'" style="font-size: 20px; font-family: \''+ fontFaceFontid +'\';">'+ fontFaceFontName +'</li>';
					}

				}

				else{
					//Google Fonts
					var l = fonts.length;
					for(var i=0; i<l; i++){
						r = this.toReadable(fonts[i]);
						s = this.toStyle(fonts[i]);

						h += '<li data-value="'+ fonts[i] +'" style="font-family: '+s['font-family'] +'; font-weight: '+s['font-weight'] +'">'+ r +'</li>';
					}

					//Early Access fonts
					var earlyaccess = earlyaccessFonts['earlyaccess'],
					earlyFontName = '';
					l = earlyaccess.length;

					for(var i=0; i<l; i++){
						earlyFontName = earlyaccess[i]['fontName'];
						earlyFontStyle = earlyFontName.replace( 'early#', '');
						r = earlyaccess[i]['text'];
						s = this.toStyle( earlyFontStyle );
						h += '<li data-value="'+ earlyFontName +'" style="font-family: \''+s['font-family'] +'\'; font-weight: '+s['font-weight'] +'">'+ r +'</li>';
					}

				};

				return h;
			};

			Fontselect.prototype.toReadable = function(font){
				if ( font.indexOf( 'safefont#' ) >= 0 ){
					font = font.replace( 'safefont#', '');
				}

				else if ( font.indexOf( 'early#' ) >= 0 ){
					font = font.replace( 'early#', '');
				}

				else if( font.indexOf( 'faceme#' ) >= 0 ){
					font = font.replace( 'faceme#', '');
				}

				return font.replace(/[\+|:]/g, ' ').replace( /\'/g, '');
			};

			Fontselect.prototype.toStyle = function(font){

				if( font.indexOf( 'safefont#' ) >= 0 ){
					font = font.replace( 'safefont#', '');
				}

				else if( font.indexOf( 'early#' ) >= 0 ){
					font = font.replace( 'early#', '');
				}

				else if( font.indexOf( 'faceme#' ) >= 0 ){
					font = font.replace( 'faceme#', '');
				}

				var t = font.split(':');
				return {'font-family': this.toReadable(t[0]), 'font-weight': (t[1] || 400)};

			};

			Fontselect.prototype.getVisibleFonts = function(){

				if(this.$results.is(':hidden')) return;

				var fs = this;
				var top = this.$results.scrollTop();
				var bottom = top + this.$results.height();

				if(this.options.lookahead){
					var li = $('li', this.$results).first().height();
					bottom += li*this.options.lookahead;
				}

				$('li', this.$results).each(function(){

					var ft = $(this).position().top+top;
					var fb = ft + $(this).height();

					if ((fb >= top) && (ft <= bottom)){
						var font = $(this).data('value');
						fs.addFontLink(font);
					}

				});
			};

			Fontselect.prototype.addFontLink = function(font){

				if ( font.indexOf( 'safefont#' ) >= 0 ){
					return;
				}
				else if ( font.indexOf( 'faceme#' ) >= 0 ){
					font = font.replace( 'faceme#', '').replace( / /g, '' ).toLowerCase();
					var link = this.options.fontfaceApi + font;
				}
				else if ( font.indexOf( 'early#' ) >= 0 ){
					font = font.replace( 'early#', '').replace( / /g, '' ).toLowerCase();
					var link = this.options.api_early + font + '.css';
				}
				else{
					var link = this.options.api + font;
				}

				if ($("link[href*='" + font + "']").length === 0){
					$('link:last').after('<link href="' + link + '" rel="stylesheet" type="text/css">');
				}

			};

			return Fontselect;
		})();

		return this.each(function(options) {
			// If options exist, lets merge them
			if (options) $.extend( settings, options );

			return new Fontselect(this, settings);
		});

	};

})(jQuery);



/* Icon Picker */
(function($) {

	$.fn.iconPicker = function(options) {
		var options = ['fa', 'fa']; // default font set
		var icons;
		$list = jQuery('');

		function font_set() {
			icons = [
				'blank',
				'adjust',
				'adn',
				'align-center',
				'align-justify',
				'align-left',
				'align-right',
				'ambulance',
				'anchor',
				'android',
				'angellist',
				'angle-double-down',
				'angle-double-left',
				'angle-double-right',
				'angle-double-up',
				'angle-down',
				'angle-left',
				'angle-right',
				'angle-up',
				'apple',
				'archive',
				'area-chart',
				'arrow-circle-down',
				'arrow-circle-left',
				'arrow-circle-o-down',
				'arrow-circle-o-left',
				'arrow-circle-o-right',
				'arrow-circle-o-up',
				'arrow-circle-right',
				'arrow-circle-up',
				'arrow-down',
				'arrow-left',
				'arrow-right',
				'arrow-up',
				'arrows',
				'arrows-alt',
				'arrows-h',
				'arrows-v',
				'asterisk',
				'at',
				'backward',
				'ban',
				'bar-chart',
				'barcode',
				'bars',
				'bed',
				'beer',
				'behance',
				'behance-square',
				'bell',
				'bell-o',
				'bell-slash',
				'bell-slash-o',
				'bicycle',
				'binoculars',
				'birthday-cake',
				'bitbucket',
				'bitbucket-square',
				'bold',
				'bolt',
				'bomb',
				'book',
				'bookmark',
				'bookmark-o',
				'briefcase',
				'btc',
				'bug',
				'building',
				'building-o',
				'bullhorn',
				'bullseye',
				'bus',
				'buysellads',
				'calculator',
				'calendar',
				'calendar-o',
				'camera',
				'camera-retro',
				'car',
				'caret-down',
				'caret-left',
				'caret-right',
				'caret-square-o-down',
				'caret-square-o-left',
				'caret-square-o-right',
				'caret-square-o-up',
				'caret-up',
				'cart-arrow-down',
				'cart-plus',
				'cc',
				'cc-amex',
				'cc-discover',
				'cc-mastercard',
				'cc-paypal',
				'cc-stripe',
				'cc-visa',
				'certificate',
				'chain-broken',
				'check',
				'check-circle',
				'check-circle-o',
				'check-square',
				'check-square-o',
				'chevron-circle-down',
				'chevron-circle-left',
				'chevron-circle-right',
				'chevron-circle-up',
				'chevron-down',
				'chevron-left',
				'chevron-right',
				'chevron-up',
				'child',
				'circle',
				'circle-o',
				'circle-o-notch',
				'circle-thin',
				'clipboard',
				'clock-o',
				'cloud',
				'cloud-download',
				'cloud-upload',
				'code',
				'code-fork',
				'codepen',
				'coffee',
				'cog',
				'cogs',
				'columns',
				'comment',
				'comment-o',
				'comments',
				'comments-o',
				'compass',
				'compress',
				'connectdevelop',
				'copyright',
				'credit-card',
				'crop',
				'crosshairs',
				'css3',
				'cube',
				'cubes',
				'cutlery',
				'dashcube',
				'database',
				'delicious',
				'desktop',
				'deviantart',
				'diamond',
				'digg',
				'dot-circle-o',
				'download',
				'dribbble',
				'dropbox',
				'drupal',
				'eject',
				'ellipsis-h',
				'ellipsis-v',
				'empire',
				'envelope',
				'envelope-o',
				'envelope-square',
				'eraser',
				'eur',
				'exchange',
				'exclamation',
				'exclamation-circle',
				'exclamation-triangle',
				'expand',
				'external-link',
				'external-link-square',
				'eye',
				'eye-slash',
				'eyedropper',
				'facebook',
				'facebook-official',
				'facebook-square',
				'fast-backward',
				'fast-forward',
				'fax',
				'female',
				'fighter-jet',
				'file',
				'file-archive-o',
				'file-audio-o',
				'file-code-o',
				'file-excel-o',
				'file-image-o',
				'file-o',
				'file-pdf-o',
				'file-powerpoint-o',
				'file-text',
				'file-text-o',
				'file-video-o',
				'file-word-o',
				'files-o',
				'film',
				'filter',
				'fire',
				'fire-extinguisher',
				'flag',
				'flag-checkered',
				'flag-o',
				'flask',
				'flickr',
				'floppy-o',
				'folder',
				'folder-o',
				'folder-open',
				'folder-open-o',
				'font',
				'forumbee',
				'forward',
				'foursquare',
				'frown-o',
				'futbol-o',
				'gamepad',
				'gavel',
				'gbp',
				'gift',
				'git',
				'git-square',
				'github',
				'github-alt',
				'github-square',
				'glass',
				'globe',
				'google',
				'google-plus',
				'google-plus-square',
				'google-wallet',
				'graduation-cap',
				'gratipay',
				'h-square',
				'hacker-news',
				'hand-o-down',
				'hand-o-left',
				'hand-o-right',
				'hand-o-up',
				'hdd-o',
				'header',
				'headphones',
				'heart',
				'heart-o',
				'heartbeat',
				'history',
				'home',
				'hospital-o',
				'html5',
				'ils',
				'inbox',
				'indent',
				'info',
				'info-circle',
				'inr',
				'instagram',
				'ioxhost',
				'italic',
				'joomla',
				'jpy',
				'jsfiddle',
				'key',
				'keyboard-o',
				'krw',
				'language',
				'laptop',
				'lastfm',
				'lastfm-square',
				'leaf',
				'leanpub',
				'lemon-o',
				'level-down',
				'level-up',
				'life-ring',
				'lightbulb-o',
				'line-chart',
				'link',
				'linkedin',
				'linkedin-square',
				'linux',
				'list',
				'list-alt',
				'list-ol',
				'list-ul',
				'location-arrow',
				'lock',
				'long-arrow-down',
				'long-arrow-left',
				'long-arrow-right',
				'long-arrow-up',
				'magic',
				'magnet',
				'male',
				'map-marker',
				'mars',
				'mars-double',
				'mars-stroke',
				'mars-stroke-h',
				'mars-stroke-v',
				'maxcdn',
				'meanpath',
				'medium',
				'medkit',
				'meh-o',
				'mercury',
				'microphone',
				'microphone-slash',
				'minus',
				'minus-circle',
				'minus-square',
				'minus-square-o',
				'mobile',
				'money',
				'moon-o',
				'motorcycle',
				'music',
				'neuter',
				'newspaper-o',
				'openid',
				'outdent',
				'pagelines',
				'paint-brush',
				'paper-plane',
				'paper-plane-o',
				'paperclip',
				'paragraph',
				'pause',
				'paw',
				'paypal',
				'pencil',
				'pencil-square',
				'pencil-square-o',
				'phone',
				'phone-square',
				'picture-o',
				'pie-chart',
				'pied-piper',
				'pied-piper-alt',
				'pinterest',
				'pinterest-p',
				'pinterest-square',
				'plane',
				'play',
				'play-circle',
				'play-circle-o',
				'plug',
				'plus',
				'plus-circle',
				'plus-square',
				'plus-square-o',
				'power-off',
				'print',
				'puzzle-piece',
				'qq',
				'qrcode',
				'question',
				'question-circle',
				'quote-left',
				'quote-right',
				'random',
				'rebel',
				'recycle',
				'reddit',
				'reddit-square',
				'refresh',
				'renren',
				'repeat',
				'reply',
				'reply-all',
				'retweet',
				'road',
				'rocket',
				'rss',
				'rss-square',
				'rub',
				'scissors',
				'search',
				'search-minus',
				'search-plus',
				'sellsy',
				'server',
				'share',
				'share-alt',
				'share-alt-square',
				'share-square',
				'share-square-o',
				'shield',
				'ship',
				'shirtsinbulk',
				'shopping-cart',
				'sign-in',
				'sign-out',
				'signal',
				'simplybuilt',
				'sitemap',
				'skyatlas',
				'skype',
				'slack',
				'sliders',
				'slideshare',
				'smile-o',
				'sort',
				'sort-alpha-asc',
				'sort-alpha-desc',
				'sort-amount-asc',
				'sort-amount-desc',
				'sort-asc',
				'sort-desc',
				'sort-numeric-asc',
				'sort-numeric-desc',
				'soundcloud',
				'space-shuttle',
				'spinner',
				'spoon',
				'spotify',
				'square',
				'square-o',
				'stack-exchange',
				'stack-overflow',
				'star',
				'star-half',
				'star-half-o',
				'star-o',
				'steam',
				'steam-square',
				'step-backward',
				'step-forward',
				'stethoscope',
				'stop',
				'street-view',
				'strikethrough',
				'stumbleupon',
				'stumbleupon-circle',
				'subscript',
				'subway',
				'suitcase',
				'sun-o',
				'superscript',
				'table',
				'tablet',
				'tachometer',
				'tag',
				'tags',
				'tasks',
				'taxi',
				'tencent-weibo',
				'terminal',
				'text-height',
				'text-width',
				'th',
				'th-large',
				'th-list',
				'thumb-tack',
				'thumbs-down',
				'thumbs-o-down',
				'thumbs-o-up',
				'thumbs-up',
				'ticket',
				'times',
				'times-circle',
				'times-circle-o',
				'tint',
				'toggle-off',
				'toggle-on',
				'train',
				'transgender',
				'transgender-alt',
				'trash',
				'trash-o',
				'tree',
				'trello',
				'trophy',
				'truck',
				'try',
				'tty',
				'tumblr',
				'tumblr-square',
				'twitch',
				'twitter',
				'twitter-square',
				'umbrella',
				'underline',
				'undo',
				'university',
				'unlock',
				'unlock-alt',
				'upload',
				'usd',
				'user',
				'user-md',
				'user-plus',
				'user-secret',
				'user-times',
				'users',
				'venus',
				'venus-double',
				'venus-mars',
				'viacoin',
				'video-camera',
				'vimeo-square',
				'vine',
				'vk',
				'volume-down',
				'volume-off',
				'volume-up',
				'weibo',
				'weixin',
				'whatsapp',
				'wheelchair',
				'wifi',
				'windows',
				'wordpress',
				'wrench',
				'xing',
				'xing-square',
				'yahoo',
				'yelp',
				'youtube',
				'youtube-play',
				'youtube-square',
				'500px',
				'amazon',
				'balance-scale',
				'battery-empty',
				'battery-full',
				'battery-half',
				'battery-quarter',
				'battery-three-quarters',
				'black-tie',
				'calendar-check-o',
				'calendar-minus-o',
				'calendar-plus-o',
				'calendar-times-o',
				'cc-diners-club',
				'cc-jcb',
				'chrome',
				'clone',
				'commenting',
				'commenting-o',
				'contao',
				'creative-commons',
				'expeditedssl',
				'firefox',
				'fonticons',
				'genderless',
				'get-pocket',
				'gg',
				'gg-circle',
				'hand-lizard-o',
				'hand-paper-o',
				'hand-peace-o',
				'hand-pointer-o',
				'hand-rock-o',
				'hand-scissors-o',
				'hand-spock-o',
				'hourglass',
				'hourglass-end',
				'hourglass-half',
				'hourglass-o',
				'hourglass-start',
				'houzz',
				'i-cursor',
				'industry',
				'internet-explorer',
				'map',
				'map-o',
				'map-pin',
				'map-signs',
				'mouse-pointer',
				'object-group',
				'object-ungroup',
				'odnoklassniki',
				'odnoklassniki-square',
				'opencart',
				'opera',
				'optin-monster',
				'registered',
				'safari',
				'sticky-note',
				'sticky-note-o',
				'television',
				'trademark',
				'tripadvisor',
				'vimeo',
				'wikipedia-w',
				'y-combinator',
				'reddit-alien',
				'edge',
				'credit-card-alt',
				'codiepie',
				'modx',
				'fort-awesome',
				'usb',
				'product-hunt',
				'scribd',
				'pause-circle',
				'pause-circle-o',
				'stop-circle',
				'stop-circle-o',
				'shopping-bag',
				'shopping-basket',
				'hashtag',
				'bluetooth',
				'bluetooth-b',
				'percent',
				'gitlab',
				'envira',
				'universal-access',
				'wheelchair-alt',
				'question-circle-o',
				'blind',
				'audio-description',
				'volume-control-phone',
				'braille',
				'assistive-listening-systems',
				'asl-interpreting',
				'american-sign-language-interpreting',
				'deafness',
				'hard-of-hearing',
				'deaf',
				'glide',
				'glide-g',
				'signing',
				'sign-language',
				'low-vision',
				'viadeo',
				'viadeo-square',
				'snapchat',
				'snapchat-ghost',
				'snapchat-square',
				'pied-piper',
				'first-order',
				'fa-yoast',
				'themeisle',
				'google-plus-circle',
				'font-awesome',
				'handshake-o',
				'envelope-open',
				'envelope-open-o',
				'linode',
				'address-book',
				'address-book-o',
				'vcard',
				'vcard-o',
				'user-circle',
				'user-circle-o',
				'user-o',
				'id-badge',
				'id-card',
				'id-card-o',
				'quora',
				'free-code-camp',
				'telegram',
				'thermometer-full',
				'thermometer-three-quarters',
				'thermometer-half',
				'thermometer-quarter',
				'thermometer-empty',
				'shower',
				'bath',
				'podcast',
				'window-maximize',
				'window-minimize',
				'window-restore',
				'window-close',
				'window-close-o',
				'bandcamp',
				'grav',
				'etsy',
				'imdb',
				'ravelry',
				'eercast',
				'microchip',
				'snowflake-o',
				'superpowers',
				'wpexplorer',
				'meetup',
			];
		options[1] = 'fa';
	};

	font_set();

	function build_list($popup, $button, clear) {
		$list = $popup.find('.icon-picker-list');
		if (clear == 1) {
			$list.empty(); // clear list //
		}
		for (var i in icons) {
			$list.append('<li data-icon="' + icons[i] + '"><a href="#" title="' + icons[i] + '"><span class="' + options[0] + ' ' + options[1] + '-' + icons[i] + '"></span></a></li>');
		};
		$('a', $list).click(function(e) {
			e.preventDefault();
			var title = $(this).attr("title");
			if (title == 'blank') {
				$target.closest('.menu-item').find('.preview-menu-item-icon').attr('class', 'preview-menu-item-icon');
				$target.val('');
			} else {
				$target.val(options[1] + "-" + title);
				$target.closest('.menu-item').find('.preview-menu-item-icon').attr('class', 'preview-menu-item-icon fa ' + options[1] + "-" + title );
			}
			$button.removeClass().addClass("button icon-picker " + options[0] + " " + options[1] + "-" + title);
			removePopup();
		});
	};

	function removePopup() {
		$(".icon-picker-container").remove();
	}

	/*
	$button = $('.icon-picker');
	$button.each(function() {
		$(this).on('click.iconPicker', function() {
			createPopup($(this));
		});
	});
	*/

	$(document).on("click", ".icon-picker", function() {
		createPopup($(this));
	});

	function createPopup($button) {
		$target = $($button.data('target'));
		$popup = $('<div class="icon-picker-container"> \
			<div class="icon-picker-control" /> \
			<ul class="icon-picker-list" /> \
		</div>');

		/*
			$popup.css({
				'top': $button.offset().top,
				'left': $button.offset().left
			});
		*/

			build_list($popup, $button, 0);

			var $control = $popup.find('.icon-picker-control');
			$control.html('<a data-direction="back" href="#"><span class="dashicons dashicons-arrow-left-alt2"></span></a> ' +
					'<input type="text" class="" placeholder="' + tieLang.search + '" />' +
					'<a data-direction="forward" href="#"><span class="dashicons dashicons-arrow-right-alt2"></span></a>' +
					'');

			$('a', $control).click(function(e) {
				e.preventDefault();
				if ($(this).data('direction') === 'back') {
					//move last 25 elements to front
					$($('li:gt(' + (icons.length - 49) + ')', $list).get().reverse()).each(function() {
						$(this).prependTo($list);
					});
				} else {
					//move first 25 elements to the end
					$('li:lt(48)', $list).each(function() {
						$(this).appendTo($list);
					});
				}
			});

			$popup.appendTo( $button.parent() ).show();

			$('input', $control).on('keyup', function(e) {
				var search = $(this).val();
				if (search === '') {
					//show all again
					$('li:lt(48)', $list).show();
				} else {
					$('li', $list).each(function() {
						if ($(this).data('icon').toString().toLowerCase().indexOf(search.toLowerCase()) !== -1) {
							$(this).show();
						} else {
							$(this).hide();
						}
					});
				}
			});

			$(document).mouseup(function(e) {
				if (!$popup.is(e.target) && $popup.has(e.target).length === 0) {
					removePopup();
				}
			});
		}
	}

	$(function() {
		$('.icon-picker').iconPicker();
	});

}(jQuery));


/* Get Color Brightes */
function getContrastColor(hexcolor){
	hexcolor = hexcolor.replace( '#', '' );
  var r = parseInt(hexcolor.substr(0,2),16);
  var g = parseInt(hexcolor.substr(2,2),16);
  var b = parseInt(hexcolor.substr(4,2),16);
  var yiq = ((r*299)+(g*587)+(b*114))/1000;
  return (yiq >= 128) ? 'dark' : 'light';
}


/* == malihu jquery custom scrollbar plugin == Version: 3.1.5, License: MIT License (MIT) */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"undefined"!=typeof module&&module.exports?module.exports=e:e(jQuery,window,document)}(function(e){!function(t){var o="function"==typeof define&&define.amd,a="undefined"!=typeof module&&module.exports,n="https:"==document.location.protocol?"https:":"http:",i="cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js";o||(a?require("jquery-mousewheel")(e):e.event.special.mousewheel||e("head").append(decodeURI("%3Cscript src="+n+"//"+i+"%3E%3C/script%3E"))),t()}(function(){var t,o="mCustomScrollbar",a="mCS",n=".mCustomScrollbar",i={setTop:0,setLeft:0,axis:"y",scrollbarPosition:"inside",scrollInertia:950,autoDraggerLength:!0,alwaysShowScrollbar:0,snapOffset:0,mouseWheel:{enable:!0,scrollAmount:"auto",axis:"y",deltaFactor:"auto",disableOver:["select","option","keygen","datalist","textarea"]},scrollButtons:{scrollType:"stepless",scrollAmount:"auto"},keyboard:{enable:!0,scrollType:"stepless",scrollAmount:"auto"},contentTouchScroll:25,documentTouchScroll:!0,advanced:{autoScrollOnFocus:"input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",updateOnContentResize:!0,updateOnImageLoad:"auto",autoUpdateTimeout:60},theme:"light",callbacks:{onTotalScrollOffset:0,onTotalScrollBackOffset:0,alwaysTriggerOffsets:!0}},r=0,l={},s=window.attachEvent&&!window.addEventListener?1:0,c=!1,d=["mCSB_dragger_onDrag","mCSB_scrollTools_onDrag","mCS_img_loaded","mCS_disabled","mCS_destroyed","mCS_no_scrollbar","mCS-autoHide","mCS-dir-rtl","mCS_no_scrollbar_y","mCS_no_scrollbar_x","mCS_y_hidden","mCS_x_hidden","mCSB_draggerContainer","mCSB_buttonUp","mCSB_buttonDown","mCSB_buttonLeft","mCSB_buttonRight"],u={init:function(t){var t=e.extend(!0,{},i,t),o=f.call(this);if(t.live){var s=t.liveSelector||this.selector||n,c=e(s);if("off"===t.live)return void m(s);l[s]=setTimeout(function(){c.mCustomScrollbar(t),"once"===t.live&&c.length&&m(s)},500)}else m(s);return t.setWidth=t.set_width?t.set_width:t.setWidth,t.setHeight=t.set_height?t.set_height:t.setHeight,t.axis=t.horizontalScroll?"x":p(t.axis),t.scrollInertia=t.scrollInertia>0&&t.scrollInertia<17?17:t.scrollInertia,"object"!=typeof t.mouseWheel&&1==t.mouseWheel&&(t.mouseWheel={enable:!0,scrollAmount:"auto",axis:"y",preventDefault:!1,deltaFactor:"auto",normalizeDelta:!1,invert:!1}),t.mouseWheel.scrollAmount=t.mouseWheelPixels?t.mouseWheelPixels:t.mouseWheel.scrollAmount,t.mouseWheel.normalizeDelta=t.advanced.normalizeMouseWheelDelta?t.advanced.normalizeMouseWheelDelta:t.mouseWheel.normalizeDelta,t.scrollButtons.scrollType=g(t.scrollButtons.scrollType),h(t),e(o).each(function(){var o=e(this);if(!o.data(a)){o.data(a,{idx:++r,opt:t,scrollRatio:{y:null,x:null},overflowed:null,contentReset:{y:null,x:null},bindEvents:!1,tweenRunning:!1,sequential:{},langDir:o.css("direction"),cbOffsets:null,trigger:null,poll:{size:{o:0,n:0},img:{o:0,n:0},change:{o:0,n:0}}});var n=o.data(a),i=n.opt,l=o.data("mcs-axis"),s=o.data("mcs-scrollbar-position"),c=o.data("mcs-theme");l&&(i.axis=l),s&&(i.scrollbarPosition=s),c&&(i.theme=c,h(i)),v.call(this),n&&i.callbacks.onCreate&&"function"==typeof i.callbacks.onCreate&&i.callbacks.onCreate.call(this),e("#mCSB_"+n.idx+"_container img:not(."+d[2]+")").addClass(d[2]),u.update.call(null,o)}})},update:function(t,o){var n=t||f.call(this);return e(n).each(function(){var t=e(this);if(t.data(a)){var n=t.data(a),i=n.opt,r=e("#mCSB_"+n.idx+"_container"),l=e("#mCSB_"+n.idx),s=[e("#mCSB_"+n.idx+"_dragger_vertical"),e("#mCSB_"+n.idx+"_dragger_horizontal")];if(!r.length)return;n.tweenRunning&&Q(t),o&&n&&i.callbacks.onBeforeUpdate&&"function"==typeof i.callbacks.onBeforeUpdate&&i.callbacks.onBeforeUpdate.call(this),t.hasClass(d[3])&&t.removeClass(d[3]),t.hasClass(d[4])&&t.removeClass(d[4]),l.css("max-height","none"),l.height()!==t.height()&&l.css("max-height",t.height()),_.call(this),"y"===i.axis||i.advanced.autoExpandHorizontalScroll||r.css("width",x(r)),n.overflowed=y.call(this),M.call(this),i.autoDraggerLength&&S.call(this),b.call(this),T.call(this);var c=[Math.abs(r[0].offsetTop),Math.abs(r[0].offsetLeft)];"x"!==i.axis&&(n.overflowed[0]?s[0].height()>s[0].parent().height()?B.call(this):(G(t,c[0].toString(),{dir:"y",dur:0,overwrite:"none"}),n.contentReset.y=null):(B.call(this),"y"===i.axis?k.call(this):"yx"===i.axis&&n.overflowed[1]&&G(t,c[1].toString(),{dir:"x",dur:0,overwrite:"none"}))),"y"!==i.axis&&(n.overflowed[1]?s[1].width()>s[1].parent().width()?B.call(this):(G(t,c[1].toString(),{dir:"x",dur:0,overwrite:"none"}),n.contentReset.x=null):(B.call(this),"x"===i.axis?k.call(this):"yx"===i.axis&&n.overflowed[0]&&G(t,c[0].toString(),{dir:"y",dur:0,overwrite:"none"}))),o&&n&&(2===o&&i.callbacks.onImageLoad&&"function"==typeof i.callbacks.onImageLoad?i.callbacks.onImageLoad.call(this):3===o&&i.callbacks.onSelectorChange&&"function"==typeof i.callbacks.onSelectorChange?i.callbacks.onSelectorChange.call(this):i.callbacks.onUpdate&&"function"==typeof i.callbacks.onUpdate&&i.callbacks.onUpdate.call(this)),N.call(this)}})},scrollTo:function(t,o){if("undefined"!=typeof t&&null!=t){var n=f.call(this);return e(n).each(function(){var n=e(this);if(n.data(a)){var i=n.data(a),r=i.opt,l={trigger:"external",scrollInertia:r.scrollInertia,scrollEasing:"mcsEaseInOut",moveDragger:!1,timeout:60,callbacks:!0,onStart:!0,onUpdate:!0,onComplete:!0},s=e.extend(!0,{},l,o),c=Y.call(this,t),d=s.scrollInertia>0&&s.scrollInertia<17?17:s.scrollInertia;c[0]=X.call(this,c[0],"y"),c[1]=X.call(this,c[1],"x"),s.moveDragger&&(c[0]*=i.scrollRatio.y,c[1]*=i.scrollRatio.x),s.dur=ne()?0:d,setTimeout(function(){null!==c[0]&&"undefined"!=typeof c[0]&&"x"!==r.axis&&i.overflowed[0]&&(s.dir="y",s.overwrite="all",G(n,c[0].toString(),s)),null!==c[1]&&"undefined"!=typeof c[1]&&"y"!==r.axis&&i.overflowed[1]&&(s.dir="x",s.overwrite="none",G(n,c[1].toString(),s))},s.timeout)}})}},stop:function(){var t=f.call(this);return e(t).each(function(){var t=e(this);t.data(a)&&Q(t)})},disable:function(t){var o=f.call(this);return e(o).each(function(){var o=e(this);if(o.data(a)){o.data(a);N.call(this,"remove"),k.call(this),t&&B.call(this),M.call(this,!0),o.addClass(d[3])}})},destroy:function(){var t=f.call(this);return e(t).each(function(){var n=e(this);if(n.data(a)){var i=n.data(a),r=i.opt,l=e("#mCSB_"+i.idx),s=e("#mCSB_"+i.idx+"_container"),c=e(".mCSB_"+i.idx+"_scrollbar");r.live&&m(r.liveSelector||e(t).selector),N.call(this,"remove"),k.call(this),B.call(this),n.removeData(a),$(this,"mcs"),c.remove(),s.find("img."+d[2]).removeClass(d[2]),l.replaceWith(s.contents()),n.removeClass(o+" _"+a+"_"+i.idx+" "+d[6]+" "+d[7]+" "+d[5]+" "+d[3]).addClass(d[4])}})}},f=function(){return"object"!=typeof e(this)||e(this).length<1?n:this},h=function(t){var o=["rounded","rounded-dark","rounded-dots","rounded-dots-dark"],a=["rounded-dots","rounded-dots-dark","3d","3d-dark","3d-thick","3d-thick-dark","inset","inset-dark","inset-2","inset-2-dark","inset-3","inset-3-dark"],n=["minimal","minimal-dark"],i=["minimal","minimal-dark"],r=["minimal","minimal-dark"];t.autoDraggerLength=e.inArray(t.theme,o)>-1?!1:t.autoDraggerLength,t.autoExpandScrollbar=e.inArray(t.theme,a)>-1?!1:t.autoExpandScrollbar,t.scrollButtons.enable=e.inArray(t.theme,n)>-1?!1:t.scrollButtons.enable,t.autoHideScrollbar=e.inArray(t.theme,i)>-1?!0:t.autoHideScrollbar,t.scrollbarPosition=e.inArray(t.theme,r)>-1?"outside":t.scrollbarPosition},m=function(e){l[e]&&(clearTimeout(l[e]),$(l,e))},p=function(e){return"yx"===e||"xy"===e||"auto"===e?"yx":"x"===e||"horizontal"===e?"x":"y"},g=function(e){return"stepped"===e||"pixels"===e||"step"===e||"click"===e?"stepped":"stepless"},v=function(){var t=e(this),n=t.data(a),i=n.opt,r=i.autoExpandScrollbar?" "+d[1]+"_expand":"",l=["<div id='mCSB_"+n.idx+"_scrollbar_vertical' class='mCSB_scrollTools mCSB_"+n.idx+"_scrollbar mCS-"+i.theme+" mCSB_scrollTools_vertical"+r+"'><div class='"+d[12]+"'><div id='mCSB_"+n.idx+"_dragger_vertical' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>","<div id='mCSB_"+n.idx+"_scrollbar_horizontal' class='mCSB_scrollTools mCSB_"+n.idx+"_scrollbar mCS-"+i.theme+" mCSB_scrollTools_horizontal"+r+"'><div class='"+d[12]+"'><div id='mCSB_"+n.idx+"_dragger_horizontal' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"],s="yx"===i.axis?"mCSB_vertical_horizontal":"x"===i.axis?"mCSB_horizontal":"mCSB_vertical",c="yx"===i.axis?l[0]+l[1]:"x"===i.axis?l[1]:l[0],u="yx"===i.axis?"<div id='mCSB_"+n.idx+"_container_wrapper' class='mCSB_container_wrapper' />":"",f=i.autoHideScrollbar?" "+d[6]:"",h="x"!==i.axis&&"rtl"===n.langDir?" "+d[7]:"";i.setWidth&&t.css("width",i.setWidth),i.setHeight&&t.css("height",i.setHeight),i.setLeft="y"!==i.axis&&"rtl"===n.langDir?"989999px":i.setLeft,t.addClass(o+" _"+a+"_"+n.idx+f+h).wrapInner("<div id='mCSB_"+n.idx+"' class='mCustomScrollBox mCS-"+i.theme+" "+s+"'><div id='mCSB_"+n.idx+"_container' class='mCSB_container' style='position:relative; top:"+i.setTop+"; left:"+i.setLeft+";' dir='"+n.langDir+"' /></div>");var m=e("#mCSB_"+n.idx),p=e("#mCSB_"+n.idx+"_container");"y"===i.axis||i.advanced.autoExpandHorizontalScroll||p.css("width",x(p)),"outside"===i.scrollbarPosition?("static"===t.css("position")&&t.css("position","relative"),t.css("overflow","visible"),m.addClass("mCSB_outside").after(c)):(m.addClass("mCSB_inside").append(c),p.wrap(u)),w.call(this);var g=[e("#mCSB_"+n.idx+"_dragger_vertical"),e("#mCSB_"+n.idx+"_dragger_horizontal")];g[0].css("min-height",g[0].height()),g[1].css("min-width",g[1].width())},x=function(t){var o=[t[0].scrollWidth,Math.max.apply(Math,t.children().map(function(){return e(this).outerWidth(!0)}).get())],a=t.parent().width();return o[0]>a?o[0]:o[1]>a?o[1]:"100%"},_=function(){var t=e(this),o=t.data(a),n=o.opt,i=e("#mCSB_"+o.idx+"_container");if(n.advanced.autoExpandHorizontalScroll&&"y"!==n.axis){i.css({width:"auto","min-width":0,"overflow-x":"scroll"});var r=Math.ceil(i[0].scrollWidth);3===n.advanced.autoExpandHorizontalScroll||2!==n.advanced.autoExpandHorizontalScroll&&r>i.parent().width()?i.css({width:r,"min-width":"100%","overflow-x":"inherit"}):i.css({"overflow-x":"inherit",position:"absolute"}).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({width:Math.ceil(i[0].getBoundingClientRect().right+.4)-Math.floor(i[0].getBoundingClientRect().left),"min-width":"100%",position:"relative"}).unwrap()}},w=function(){var t=e(this),o=t.data(a),n=o.opt,i=e(".mCSB_"+o.idx+"_scrollbar:first"),r=oe(n.scrollButtons.tabindex)?"tabindex='"+n.scrollButtons.tabindex+"'":"",l=["<a href='#' class='"+d[13]+"' "+r+" />","<a href='#' class='"+d[14]+"' "+r+" />","<a href='#' class='"+d[15]+"' "+r+" />","<a href='#' class='"+d[16]+"' "+r+" />"],s=["x"===n.axis?l[2]:l[0],"x"===n.axis?l[3]:l[1],l[2],l[3]];n.scrollButtons.enable&&i.prepend(s[0]).append(s[1]).next(".mCSB_scrollTools").prepend(s[2]).append(s[3])},S=function(){var t=e(this),o=t.data(a),n=e("#mCSB_"+o.idx),i=e("#mCSB_"+o.idx+"_container"),r=[e("#mCSB_"+o.idx+"_dragger_vertical"),e("#mCSB_"+o.idx+"_dragger_horizontal")],l=[n.height()/i.outerHeight(!1),n.width()/i.outerWidth(!1)],c=[parseInt(r[0].css("min-height")),Math.round(l[0]*r[0].parent().height()),parseInt(r[1].css("min-width")),Math.round(l[1]*r[1].parent().width())],d=s&&c[1]<c[0]?c[0]:c[1],u=s&&c[3]<c[2]?c[2]:c[3];r[0].css({height:d,"max-height":r[0].parent().height()-10}).find(".mCSB_dragger_bar").css({"line-height":c[0]+"px"}),r[1].css({width:u,"max-width":r[1].parent().width()-10})},b=function(){var t=e(this),o=t.data(a),n=e("#mCSB_"+o.idx),i=e("#mCSB_"+o.idx+"_container"),r=[e("#mCSB_"+o.idx+"_dragger_vertical"),e("#mCSB_"+o.idx+"_dragger_horizontal")],l=[i.outerHeight(!1)-n.height(),i.outerWidth(!1)-n.width()],s=[l[0]/(r[0].parent().height()-r[0].height()),l[1]/(r[1].parent().width()-r[1].width())];o.scrollRatio={y:s[0],x:s[1]}},C=function(e,t,o){var a=o?d[0]+"_expanded":"",n=e.closest(".mCSB_scrollTools");"active"===t?(e.toggleClass(d[0]+" "+a),n.toggleClass(d[1]),e[0]._draggable=e[0]._draggable?0:1):e[0]._draggable||("hide"===t?(e.removeClass(d[0]),n.removeClass(d[1])):(e.addClass(d[0]),n.addClass(d[1])))},y=function(){var t=e(this),o=t.data(a),n=e("#mCSB_"+o.idx),i=e("#mCSB_"+o.idx+"_container"),r=null==o.overflowed?i.height():i.outerHeight(!1),l=null==o.overflowed?i.width():i.outerWidth(!1),s=i[0].scrollHeight,c=i[0].scrollWidth;return s>r&&(r=s),c>l&&(l=c),[r>n.height(),l>n.width()]},B=function(){var t=e(this),o=t.data(a),n=o.opt,i=e("#mCSB_"+o.idx),r=e("#mCSB_"+o.idx+"_container"),l=[e("#mCSB_"+o.idx+"_dragger_vertical"),e("#mCSB_"+o.idx+"_dragger_horizontal")];if(Q(t),("x"!==n.axis&&!o.overflowed[0]||"y"===n.axis&&o.overflowed[0])&&(l[0].add(r).css("top",0),G(t,"_resetY")),"y"!==n.axis&&!o.overflowed[1]||"x"===n.axis&&o.overflowed[1]){var s=dx=0;"rtl"===o.langDir&&(s=i.width()-r.outerWidth(!1),dx=Math.abs(s/o.scrollRatio.x)),r.css("left",s),l[1].css("left",dx),G(t,"_resetX")}},T=function(){function t(){r=setTimeout(function(){e.event.special.mousewheel?(clearTimeout(r),W.call(o[0])):t()},100)}var o=e(this),n=o.data(a),i=n.opt;if(!n.bindEvents){if(I.call(this),i.contentTouchScroll&&D.call(this),E.call(this),i.mouseWheel.enable){var r;t()}P.call(this),U.call(this),i.advanced.autoScrollOnFocus&&H.call(this),i.scrollButtons.enable&&F.call(this),i.keyboard.enable&&q.call(this),n.bindEvents=!0}},k=function(){var t=e(this),o=t.data(a),n=o.opt,i=a+"_"+o.idx,r=".mCSB_"+o.idx+"_scrollbar",l=e("#mCSB_"+o.idx+",#mCSB_"+o.idx+"_container,#mCSB_"+o.idx+"_container_wrapper,"+r+" ."+d[12]+",#mCSB_"+o.idx+"_dragger_vertical,#mCSB_"+o.idx+"_dragger_horizontal,"+r+">a"),s=e("#mCSB_"+o.idx+"_container");n.advanced.releaseDraggableSelectors&&l.add(e(n.advanced.releaseDraggableSelectors)),n.advanced.extraDraggableSelectors&&l.add(e(n.advanced.extraDraggableSelectors)),o.bindEvents&&(e(document).add(e(!A()||top.document)).unbind("."+i),l.each(function(){e(this).unbind("."+i)}),clearTimeout(t[0]._focusTimeout),$(t[0],"_focusTimeout"),clearTimeout(o.sequential.step),$(o.sequential,"step"),clearTimeout(s[0].onCompleteTimeout),$(s[0],"onCompleteTimeout"),o.bindEvents=!1)},M=function(t){var o=e(this),n=o.data(a),i=n.opt,r=e("#mCSB_"+n.idx+"_container_wrapper"),l=r.length?r:e("#mCSB_"+n.idx+"_container"),s=[e("#mCSB_"+n.idx+"_scrollbar_vertical"),e("#mCSB_"+n.idx+"_scrollbar_horizontal")],c=[s[0].find(".mCSB_dragger"),s[1].find(".mCSB_dragger")];"x"!==i.axis&&(n.overflowed[0]&&!t?(s[0].add(c[0]).add(s[0].children("a")).css("display","block"),l.removeClass(d[8]+" "+d[10])):(i.alwaysShowScrollbar?(2!==i.alwaysShowScrollbar&&c[0].css("display","none"),l.removeClass(d[10])):(s[0].css("display","none"),l.addClass(d[10])),l.addClass(d[8]))),"y"!==i.axis&&(n.overflowed[1]&&!t?(s[1].add(c[1]).add(s[1].children("a")).css("display","block"),l.removeClass(d[9]+" "+d[11])):(i.alwaysShowScrollbar?(2!==i.alwaysShowScrollbar&&c[1].css("display","none"),l.removeClass(d[11])):(s[1].css("display","none"),l.addClass(d[11])),l.addClass(d[9]))),n.overflowed[0]||n.overflowed[1]?o.removeClass(d[5]):o.addClass(d[5])},O=function(t){var o=t.type,a=t.target.ownerDocument!==document&&null!==frameElement?[e(frameElement).offset().top,e(frameElement).offset().left]:null,n=A()&&t.target.ownerDocument!==top.document&&null!==frameElement?[e(t.view.frameElement).offset().top,e(t.view.frameElement).offset().left]:[0,0];switch(o){case"pointerdown":case"MSPointerDown":case"pointermove":case"MSPointerMove":case"pointerup":case"MSPointerUp":return a?[t.originalEvent.pageY-a[0]+n[0],t.originalEvent.pageX-a[1]+n[1],!1]:[t.originalEvent.pageY,t.originalEvent.pageX,!1];case"touchstart":case"touchmove":case"touchend":var i=t.originalEvent.touches[0]||t.originalEvent.changedTouches[0],r=t.originalEvent.touches.length||t.originalEvent.changedTouches.length;return t.target.ownerDocument!==document?[i.screenY,i.screenX,r>1]:[i.pageY,i.pageX,r>1];default:return a?[t.pageY-a[0]+n[0],t.pageX-a[1]+n[1],!1]:[t.pageY,t.pageX,!1]}},I=function(){function t(e,t,a,n){if(h[0].idleTimer=d.scrollInertia<233?250:0,o.attr("id")===f[1])var i="x",s=(o[0].offsetLeft-t+n)*l.scrollRatio.x;else var i="y",s=(o[0].offsetTop-e+a)*l.scrollRatio.y;G(r,s.toString(),{dir:i,drag:!0})}var o,n,i,r=e(this),l=r.data(a),d=l.opt,u=a+"_"+l.idx,f=["mCSB_"+l.idx+"_dragger_vertical","mCSB_"+l.idx+"_dragger_horizontal"],h=e("#mCSB_"+l.idx+"_container"),m=e("#"+f[0]+",#"+f[1]),p=d.advanced.releaseDraggableSelectors?m.add(e(d.advanced.releaseDraggableSelectors)):m,g=d.advanced.extraDraggableSelectors?e(!A()||top.document).add(e(d.advanced.extraDraggableSelectors)):e(!A()||top.document);m.bind("contextmenu."+u,function(e){e.preventDefault()}).bind("mousedown."+u+" touchstart."+u+" pointerdown."+u+" MSPointerDown."+u,function(t){if(t.stopImmediatePropagation(),t.preventDefault(),ee(t)){c=!0,s&&(document.onselectstart=function(){return!1}),L.call(h,!1),Q(r),o=e(this);var a=o.offset(),l=O(t)[0]-a.top,u=O(t)[1]-a.left,f=o.height()+a.top,m=o.width()+a.left;f>l&&l>0&&m>u&&u>0&&(n=l,i=u),C(o,"active",d.autoExpandScrollbar)}}).bind("touchmove."+u,function(e){e.stopImmediatePropagation(),e.preventDefault();var a=o.offset(),r=O(e)[0]-a.top,l=O(e)[1]-a.left;t(n,i,r,l)}),e(document).add(g).bind("mousemove."+u+" pointermove."+u+" MSPointerMove."+u,function(e){if(o){var a=o.offset(),r=O(e)[0]-a.top,l=O(e)[1]-a.left;if(n===r&&i===l)return;t(n,i,r,l)}}).add(p).bind("mouseup."+u+" touchend."+u+" pointerup."+u+" MSPointerUp."+u,function(){o&&(C(o,"active",d.autoExpandScrollbar),o=null),c=!1,s&&(document.onselectstart=null),L.call(h,!0)})},D=function(){function o(e){if(!te(e)||c||O(e)[2])return void(t=0);t=1,b=0,C=0,d=1,y.removeClass("mCS_touch_action");var o=I.offset();u=O(e)[0]-o.top,f=O(e)[1]-o.left,z=[O(e)[0],O(e)[1]]}function n(e){if(te(e)&&!c&&!O(e)[2]&&(T.documentTouchScroll||e.preventDefault(),e.stopImmediatePropagation(),(!C||b)&&d)){g=K();var t=M.offset(),o=O(e)[0]-t.top,a=O(e)[1]-t.left,n="mcsLinearOut";if(E.push(o),W.push(a),z[2]=Math.abs(O(e)[0]-z[0]),z[3]=Math.abs(O(e)[1]-z[1]),B.overflowed[0])var i=D[0].parent().height()-D[0].height(),r=u-o>0&&o-u>-(i*B.scrollRatio.y)&&(2*z[3]<z[2]||"yx"===T.axis);if(B.overflowed[1])var l=D[1].parent().width()-D[1].width(),h=f-a>0&&a-f>-(l*B.scrollRatio.x)&&(2*z[2]<z[3]||"yx"===T.axis);r||h?(U||e.preventDefault(),b=1):(C=1,y.addClass("mCS_touch_action")),U&&e.preventDefault(),w="yx"===T.axis?[u-o,f-a]:"x"===T.axis?[null,f-a]:[u-o,null],I[0].idleTimer=250,B.overflowed[0]&&s(w[0],R,n,"y","all",!0),B.overflowed[1]&&s(w[1],R,n,"x",L,!0)}}function i(e){if(!te(e)||c||O(e)[2])return void(t=0);t=1,e.stopImmediatePropagation(),Q(y),p=K();var o=M.offset();h=O(e)[0]-o.top,m=O(e)[1]-o.left,E=[],W=[]}function r(e){if(te(e)&&!c&&!O(e)[2]){d=0,e.stopImmediatePropagation(),b=0,C=0,v=K();var t=M.offset(),o=O(e)[0]-t.top,a=O(e)[1]-t.left;if(!(v-g>30)){_=1e3/(v-p);var n="mcsEaseOut",i=2.5>_,r=i?[E[E.length-2],W[W.length-2]]:[0,0];x=i?[o-r[0],a-r[1]]:[o-h,a-m];var u=[Math.abs(x[0]),Math.abs(x[1])];_=i?[Math.abs(x[0]/4),Math.abs(x[1]/4)]:[_,_];var f=[Math.abs(I[0].offsetTop)-x[0]*l(u[0]/_[0],_[0]),Math.abs(I[0].offsetLeft)-x[1]*l(u[1]/_[1],_[1])];w="yx"===T.axis?[f[0],f[1]]:"x"===T.axis?[null,f[1]]:[f[0],null],S=[4*u[0]+T.scrollInertia,4*u[1]+T.scrollInertia];var y=parseInt(T.contentTouchScroll)||0;w[0]=u[0]>y?w[0]:0,w[1]=u[1]>y?w[1]:0,B.overflowed[0]&&s(w[0],S[0],n,"y",L,!1),B.overflowed[1]&&s(w[1],S[1],n,"x",L,!1)}}}function l(e,t){var o=[1.5*t,2*t,t/1.5,t/2];return e>90?t>4?o[0]:o[3]:e>60?t>3?o[3]:o[2]:e>30?t>8?o[1]:t>6?o[0]:t>4?t:o[2]:t>8?t:o[3]}function s(e,t,o,a,n,i){e&&G(y,e.toString(),{dur:t,scrollEasing:o,dir:a,overwrite:n,drag:i})}var d,u,f,h,m,p,g,v,x,_,w,S,b,C,y=e(this),B=y.data(a),T=B.opt,k=a+"_"+B.idx,M=e("#mCSB_"+B.idx),I=e("#mCSB_"+B.idx+"_container"),D=[e("#mCSB_"+B.idx+"_dragger_vertical"),e("#mCSB_"+B.idx+"_dragger_horizontal")],E=[],W=[],R=0,L="yx"===T.axis?"none":"all",z=[],P=I.find("iframe"),H=["touchstart."+k+" pointerdown."+k+" MSPointerDown."+k,"touchmove."+k+" pointermove."+k+" MSPointerMove."+k,"touchend."+k+" pointerup."+k+" MSPointerUp."+k],U=void 0!==document.body.style.touchAction&&""!==document.body.style.touchAction;I.bind(H[0],function(e){o(e)}).bind(H[1],function(e){n(e)}),M.bind(H[0],function(e){i(e)}).bind(H[2],function(e){r(e)}),P.length&&P.each(function(){e(this).bind("load",function(){A(this)&&e(this.contentDocument||this.contentWindow.document).bind(H[0],function(e){o(e),i(e)}).bind(H[1],function(e){n(e)}).bind(H[2],function(e){r(e)})})})},E=function(){function o(){return window.getSelection?window.getSelection().toString():document.selection&&"Control"!=document.selection.type?document.selection.createRange().text:0}function n(e,t,o){d.type=o&&i?"stepped":"stepless",d.scrollAmount=10,j(r,e,t,"mcsLinearOut",o?60:null)}var i,r=e(this),l=r.data(a),s=l.opt,d=l.sequential,u=a+"_"+l.idx,f=e("#mCSB_"+l.idx+"_container"),h=f.parent();f.bind("mousedown."+u,function(){t||i||(i=1,c=!0)}).add(document).bind("mousemove."+u,function(e){if(!t&&i&&o()){var a=f.offset(),r=O(e)[0]-a.top+f[0].offsetTop,c=O(e)[1]-a.left+f[0].offsetLeft;r>0&&r<h.height()&&c>0&&c<h.width()?d.step&&n("off",null,"stepped"):("x"!==s.axis&&l.overflowed[0]&&(0>r?n("on",38):r>h.height()&&n("on",40)),"y"!==s.axis&&l.overflowed[1]&&(0>c?n("on",37):c>h.width()&&n("on",39)))}}).bind("mouseup."+u+" dragend."+u,function(){t||(i&&(i=0,n("off",null)),c=!1)})},W=function(){function t(t,a){if(Q(o),!z(o,t.target)){var r="auto"!==i.mouseWheel.deltaFactor?parseInt(i.mouseWheel.deltaFactor):s&&t.deltaFactor<100?100:t.deltaFactor||100,d=i.scrollInertia;if("x"===i.axis||"x"===i.mouseWheel.axis)var u="x",f=[Math.round(r*n.scrollRatio.x),parseInt(i.mouseWheel.scrollAmount)],h="auto"!==i.mouseWheel.scrollAmount?f[1]:f[0]>=l.width()?.9*l.width():f[0],m=Math.abs(e("#mCSB_"+n.idx+"_container")[0].offsetLeft),p=c[1][0].offsetLeft,g=c[1].parent().width()-c[1].width(),v="y"===i.mouseWheel.axis?t.deltaY||a:t.deltaX;else var u="y",f=[Math.round(r*n.scrollRatio.y),parseInt(i.mouseWheel.scrollAmount)],h="auto"!==i.mouseWheel.scrollAmount?f[1]:f[0]>=l.height()?.9*l.height():f[0],m=Math.abs(e("#mCSB_"+n.idx+"_container")[0].offsetTop),p=c[0][0].offsetTop,g=c[0].parent().height()-c[0].height(),v=t.deltaY||a;"y"===u&&!n.overflowed[0]||"x"===u&&!n.overflowed[1]||((i.mouseWheel.invert||t.webkitDirectionInvertedFromDevice)&&(v=-v),i.mouseWheel.normalizeDelta&&(v=0>v?-1:1),(v>0&&0!==p||0>v&&p!==g||i.mouseWheel.preventDefault)&&(t.stopImmediatePropagation(),t.preventDefault()),t.deltaFactor<5&&!i.mouseWheel.normalizeDelta&&(h=t.deltaFactor,d=17),G(o,(m-v*h).toString(),{dir:u,dur:d}))}}if(e(this).data(a)){var o=e(this),n=o.data(a),i=n.opt,r=a+"_"+n.idx,l=e("#mCSB_"+n.idx),c=[e("#mCSB_"+n.idx+"_dragger_vertical"),e("#mCSB_"+n.idx+"_dragger_horizontal")],d=e("#mCSB_"+n.idx+"_container").find("iframe");d.length&&d.each(function(){e(this).bind("load",function(){A(this)&&e(this.contentDocument||this.contentWindow.document).bind("mousewheel."+r,function(e,o){t(e,o)})})}),l.bind("mousewheel."+r,function(e,o){t(e,o)})}},R=new Object,A=function(t){var o=!1,a=!1,n=null;if(void 0===t?a="#empty":void 0!==e(t).attr("id")&&(a=e(t).attr("id")),a!==!1&&void 0!==R[a])return R[a];if(t){try{var i=t.contentDocument||t.contentWindow.document;n=i.body.innerHTML}catch(r){}o=null!==n}else{try{var i=top.document;n=i.body.innerHTML}catch(r){}o=null!==n}return a!==!1&&(R[a]=o),o},L=function(e){var t=this.find("iframe");if(t.length){var o=e?"auto":"none";t.css("pointer-events",o)}},z=function(t,o){var n=o.nodeName.toLowerCase(),i=t.data(a).opt.mouseWheel.disableOver,r=["select","textarea"];return e.inArray(n,i)>-1&&!(e.inArray(n,r)>-1&&!e(o).is(":focus"))},P=function(){var t,o=e(this),n=o.data(a),i=a+"_"+n.idx,r=e("#mCSB_"+n.idx+"_container"),l=r.parent(),s=e(".mCSB_"+n.idx+"_scrollbar ."+d[12]);s.bind("mousedown."+i+" touchstart."+i+" pointerdown."+i+" MSPointerDown."+i,function(o){c=!0,e(o.target).hasClass("mCSB_dragger")||(t=1)}).bind("touchend."+i+" pointerup."+i+" MSPointerUp."+i,function(){c=!1}).bind("click."+i,function(a){if(t&&(t=0,e(a.target).hasClass(d[12])||e(a.target).hasClass("mCSB_draggerRail"))){Q(o);var i=e(this),s=i.find(".mCSB_dragger");if(i.parent(".mCSB_scrollTools_horizontal").length>0){if(!n.overflowed[1])return;var c="x",u=a.pageX>s.offset().left?-1:1,f=Math.abs(r[0].offsetLeft)-u*(.9*l.width())}else{if(!n.overflowed[0])return;var c="y",u=a.pageY>s.offset().top?-1:1,f=Math.abs(r[0].offsetTop)-u*(.9*l.height())}G(o,f.toString(),{dir:c,scrollEasing:"mcsEaseInOut"})}})},H=function(){var t=e(this),o=t.data(a),n=o.opt,i=a+"_"+o.idx,r=e("#mCSB_"+o.idx+"_container"),l=r.parent();r.bind("focusin."+i,function(){var o=e(document.activeElement),a=r.find(".mCustomScrollBox").length,i=0;o.is(n.advanced.autoScrollOnFocus)&&(Q(t),clearTimeout(t[0]._focusTimeout),t[0]._focusTimer=a?(i+17)*a:0,t[0]._focusTimeout=setTimeout(function(){var e=[ae(o)[0],ae(o)[1]],a=[r[0].offsetTop,r[0].offsetLeft],s=[a[0]+e[0]>=0&&a[0]+e[0]<l.height()-o.outerHeight(!1),a[1]+e[1]>=0&&a[0]+e[1]<l.width()-o.outerWidth(!1)],c="yx"!==n.axis||s[0]||s[1]?"all":"none";"x"===n.axis||s[0]||G(t,e[0].toString(),{dir:"y",scrollEasing:"mcsEaseInOut",overwrite:c,dur:i}),"y"===n.axis||s[1]||G(t,e[1].toString(),{dir:"x",scrollEasing:"mcsEaseInOut",overwrite:c,dur:i})},t[0]._focusTimer))})},U=function(){var t=e(this),o=t.data(a),n=a+"_"+o.idx,i=e("#mCSB_"+o.idx+"_container").parent();i.bind("scroll."+n,function(){0===i.scrollTop()&&0===i.scrollLeft()||e(".mCSB_"+o.idx+"_scrollbar").css("visibility","hidden")})},F=function(){var t=e(this),o=t.data(a),n=o.opt,i=o.sequential,r=a+"_"+o.idx,l=".mCSB_"+o.idx+"_scrollbar",s=e(l+">a");s.bind("contextmenu."+r,function(e){e.preventDefault()}).bind("mousedown."+r+" touchstart."+r+" pointerdown."+r+" MSPointerDown."+r+" mouseup."+r+" touchend."+r+" pointerup."+r+" MSPointerUp."+r+" mouseout."+r+" pointerout."+r+" MSPointerOut."+r+" click."+r,function(a){function r(e,o){i.scrollAmount=n.scrollButtons.scrollAmount,j(t,e,o)}if(a.preventDefault(),ee(a)){var l=e(this).attr("class");switch(i.type=n.scrollButtons.scrollType,a.type){case"mousedown":case"touchstart":case"pointerdown":case"MSPointerDown":if("stepped"===i.type)return;c=!0,o.tweenRunning=!1,r("on",l);break;case"mouseup":case"touchend":case"pointerup":case"MSPointerUp":case"mouseout":case"pointerout":case"MSPointerOut":if("stepped"===i.type)return;c=!1,i.dir&&r("off",l);break;case"click":if("stepped"!==i.type||o.tweenRunning)return;r("on",l)}}})},q=function(){function t(t){function a(e,t){r.type=i.keyboard.scrollType,r.scrollAmount=i.keyboard.scrollAmount,"stepped"===r.type&&n.tweenRunning||j(o,e,t)}switch(t.type){case"blur":n.tweenRunning&&r.dir&&a("off",null);break;case"keydown":case"keyup":var l=t.keyCode?t.keyCode:t.which,s="on";if("x"!==i.axis&&(38===l||40===l)||"y"!==i.axis&&(37===l||39===l)){if((38===l||40===l)&&!n.overflowed[0]||(37===l||39===l)&&!n.overflowed[1])return;"keyup"===t.type&&(s="off"),e(document.activeElement).is(u)||(t.preventDefault(),t.stopImmediatePropagation(),a(s,l))}else if(33===l||34===l){if((n.overflowed[0]||n.overflowed[1])&&(t.preventDefault(),t.stopImmediatePropagation()),"keyup"===t.type){Q(o);var f=34===l?-1:1;if("x"===i.axis||"yx"===i.axis&&n.overflowed[1]&&!n.overflowed[0])var h="x",m=Math.abs(c[0].offsetLeft)-f*(.9*d.width());else var h="y",m=Math.abs(c[0].offsetTop)-f*(.9*d.height());G(o,m.toString(),{dir:h,scrollEasing:"mcsEaseInOut"})}}else if((35===l||36===l)&&!e(document.activeElement).is(u)&&((n.overflowed[0]||n.overflowed[1])&&(t.preventDefault(),t.stopImmediatePropagation()),"keyup"===t.type)){if("x"===i.axis||"yx"===i.axis&&n.overflowed[1]&&!n.overflowed[0])var h="x",m=35===l?Math.abs(d.width()-c.outerWidth(!1)):0;else var h="y",m=35===l?Math.abs(d.height()-c.outerHeight(!1)):0;G(o,m.toString(),{dir:h,scrollEasing:"mcsEaseInOut"})}}}var o=e(this),n=o.data(a),i=n.opt,r=n.sequential,l=a+"_"+n.idx,s=e("#mCSB_"+n.idx),c=e("#mCSB_"+n.idx+"_container"),d=c.parent(),u="input,textarea,select,datalist,keygen,[contenteditable='true']",f=c.find("iframe"),h=["blur."+l+" keydown."+l+" keyup."+l];f.length&&f.each(function(){e(this).bind("load",function(){A(this)&&e(this.contentDocument||this.contentWindow.document).bind(h[0],function(e){t(e)})})}),s.attr("tabindex","0").bind(h[0],function(e){t(e)})},j=function(t,o,n,i,r){function l(e){u.snapAmount&&(f.scrollAmount=u.snapAmount instanceof Array?"x"===f.dir[0]?u.snapAmount[1]:u.snapAmount[0]:u.snapAmount);var o="stepped"!==f.type,a=r?r:e?o?p/1.5:g:1e3/60,n=e?o?7.5:40:2.5,s=[Math.abs(h[0].offsetTop),Math.abs(h[0].offsetLeft)],d=[c.scrollRatio.y>10?10:c.scrollRatio.y,c.scrollRatio.x>10?10:c.scrollRatio.x],m="x"===f.dir[0]?s[1]+f.dir[1]*(d[1]*n):s[0]+f.dir[1]*(d[0]*n),v="x"===f.dir[0]?s[1]+f.dir[1]*parseInt(f.scrollAmount):s[0]+f.dir[1]*parseInt(f.scrollAmount),x="auto"!==f.scrollAmount?v:m,_=i?i:e?o?"mcsLinearOut":"mcsEaseInOut":"mcsLinear",w=!!e;return e&&17>a&&(x="x"===f.dir[0]?s[1]:s[0]),G(t,x.toString(),{dir:f.dir[0],scrollEasing:_,dur:a,onComplete:w}),e?void(f.dir=!1):(clearTimeout(f.step),void(f.step=setTimeout(function(){l()},a)))}function s(){clearTimeout(f.step),$(f,"step"),Q(t)}var c=t.data(a),u=c.opt,f=c.sequential,h=e("#mCSB_"+c.idx+"_container"),m="stepped"===f.type,p=u.scrollInertia<26?26:u.scrollInertia,g=u.scrollInertia<1?17:u.scrollInertia;switch(o){case"on":if(f.dir=[n===d[16]||n===d[15]||39===n||37===n?"x":"y",n===d[13]||n===d[15]||38===n||37===n?-1:1],Q(t),oe(n)&&"stepped"===f.type)return;l(m);break;case"off":s(),(m||c.tweenRunning&&f.dir)&&l(!0)}},Y=function(t){var o=e(this).data(a).opt,n=[];return"function"==typeof t&&(t=t()),t instanceof Array?n=t.length>1?[t[0],t[1]]:"x"===o.axis?[null,t[0]]:[t[0],null]:(n[0]=t.y?t.y:t.x||"x"===o.axis?null:t,n[1]=t.x?t.x:t.y||"y"===o.axis?null:t),"function"==typeof n[0]&&(n[0]=n[0]()),"function"==typeof n[1]&&(n[1]=n[1]()),n},X=function(t,o){if(null!=t&&"undefined"!=typeof t){var n=e(this),i=n.data(a),r=i.opt,l=e("#mCSB_"+i.idx+"_container"),s=l.parent(),c=typeof t;o||(o="x"===r.axis?"x":"y");var d="x"===o?l.outerWidth(!1)-s.width():l.outerHeight(!1)-s.height(),f="x"===o?l[0].offsetLeft:l[0].offsetTop,h="x"===o?"left":"top";switch(c){case"function":return t();case"object":var m=t.jquery?t:e(t);if(!m.length)return;return"x"===o?ae(m)[1]:ae(m)[0];case"string":case"number":if(oe(t))return Math.abs(t);if(-1!==t.indexOf("%"))return Math.abs(d*parseInt(t)/100);if(-1!==t.indexOf("-="))return Math.abs(f-parseInt(t.split("-=")[1]));if(-1!==t.indexOf("+=")){var p=f+parseInt(t.split("+=")[1]);return p>=0?0:Math.abs(p)}if(-1!==t.indexOf("px")&&oe(t.split("px")[0]))return Math.abs(t.split("px")[0]);if("top"===t||"left"===t)return 0;if("bottom"===t)return Math.abs(s.height()-l.outerHeight(!1));if("right"===t)return Math.abs(s.width()-l.outerWidth(!1));if("first"===t||"last"===t){var m=l.find(":"+t);return"x"===o?ae(m)[1]:ae(m)[0]}return e(t).length?"x"===o?ae(e(t))[1]:ae(e(t))[0]:(l.css(h,t),void u.update.call(null,n[0]))}}},N=function(t){function o(){return clearTimeout(f[0].autoUpdate),0===l.parents("html").length?void(l=null):void(f[0].autoUpdate=setTimeout(function(){return c.advanced.updateOnSelectorChange&&(s.poll.change.n=i(),s.poll.change.n!==s.poll.change.o)?(s.poll.change.o=s.poll.change.n,void r(3)):c.advanced.updateOnContentResize&&(s.poll.size.n=l[0].scrollHeight+l[0].scrollWidth+f[0].offsetHeight+l[0].offsetHeight+l[0].offsetWidth,s.poll.size.n!==s.poll.size.o)?(s.poll.size.o=s.poll.size.n,void r(1)):!c.advanced.updateOnImageLoad||"auto"===c.advanced.updateOnImageLoad&&"y"===c.axis||(s.poll.img.n=f.find("img").length,s.poll.img.n===s.poll.img.o)?void((c.advanced.updateOnSelectorChange||c.advanced.updateOnContentResize||c.advanced.updateOnImageLoad)&&o()):(s.poll.img.o=s.poll.img.n,void f.find("img").each(function(){n(this)}))},c.advanced.autoUpdateTimeout))}function n(t){function o(e,t){return function(){
return t.apply(e,arguments)}}function a(){this.onload=null,e(t).addClass(d[2]),r(2)}if(e(t).hasClass(d[2]))return void r();var n=new Image;n.onload=o(n,a),n.src=t.src}function i(){c.advanced.updateOnSelectorChange===!0&&(c.advanced.updateOnSelectorChange="*");var e=0,t=f.find(c.advanced.updateOnSelectorChange);return c.advanced.updateOnSelectorChange&&t.length>0&&t.each(function(){e+=this.offsetHeight+this.offsetWidth}),e}function r(e){clearTimeout(f[0].autoUpdate),u.update.call(null,l[0],e)}var l=e(this),s=l.data(a),c=s.opt,f=e("#mCSB_"+s.idx+"_container");return t?(clearTimeout(f[0].autoUpdate),void $(f[0],"autoUpdate")):void o()},V=function(e,t,o){return Math.round(e/t)*t-o},Q=function(t){var o=t.data(a),n=e("#mCSB_"+o.idx+"_container,#mCSB_"+o.idx+"_container_wrapper,#mCSB_"+o.idx+"_dragger_vertical,#mCSB_"+o.idx+"_dragger_horizontal");n.each(function(){Z.call(this)})},G=function(t,o,n){function i(e){return s&&c.callbacks[e]&&"function"==typeof c.callbacks[e]}function r(){return[c.callbacks.alwaysTriggerOffsets||w>=S[0]+y,c.callbacks.alwaysTriggerOffsets||-B>=w]}function l(){var e=[h[0].offsetTop,h[0].offsetLeft],o=[x[0].offsetTop,x[0].offsetLeft],a=[h.outerHeight(!1),h.outerWidth(!1)],i=[f.height(),f.width()];t[0].mcs={content:h,top:e[0],left:e[1],draggerTop:o[0],draggerLeft:o[1],topPct:Math.round(100*Math.abs(e[0])/(Math.abs(a[0])-i[0])),leftPct:Math.round(100*Math.abs(e[1])/(Math.abs(a[1])-i[1])),direction:n.dir}}var s=t.data(a),c=s.opt,d={trigger:"internal",dir:"y",scrollEasing:"mcsEaseOut",drag:!1,dur:c.scrollInertia,overwrite:"all",callbacks:!0,onStart:!0,onUpdate:!0,onComplete:!0},n=e.extend(d,n),u=[n.dur,n.drag?0:n.dur],f=e("#mCSB_"+s.idx),h=e("#mCSB_"+s.idx+"_container"),m=h.parent(),p=c.callbacks.onTotalScrollOffset?Y.call(t,c.callbacks.onTotalScrollOffset):[0,0],g=c.callbacks.onTotalScrollBackOffset?Y.call(t,c.callbacks.onTotalScrollBackOffset):[0,0];if(s.trigger=n.trigger,0===m.scrollTop()&&0===m.scrollLeft()||(e(".mCSB_"+s.idx+"_scrollbar").css("visibility","visible"),m.scrollTop(0).scrollLeft(0)),"_resetY"!==o||s.contentReset.y||(i("onOverflowYNone")&&c.callbacks.onOverflowYNone.call(t[0]),s.contentReset.y=1),"_resetX"!==o||s.contentReset.x||(i("onOverflowXNone")&&c.callbacks.onOverflowXNone.call(t[0]),s.contentReset.x=1),"_resetY"!==o&&"_resetX"!==o){if(!s.contentReset.y&&t[0].mcs||!s.overflowed[0]||(i("onOverflowY")&&c.callbacks.onOverflowY.call(t[0]),s.contentReset.x=null),!s.contentReset.x&&t[0].mcs||!s.overflowed[1]||(i("onOverflowX")&&c.callbacks.onOverflowX.call(t[0]),s.contentReset.x=null),c.snapAmount){var v=c.snapAmount instanceof Array?"x"===n.dir?c.snapAmount[1]:c.snapAmount[0]:c.snapAmount;o=V(o,v,c.snapOffset)}switch(n.dir){case"x":var x=e("#mCSB_"+s.idx+"_dragger_horizontal"),_="left",w=h[0].offsetLeft,S=[f.width()-h.outerWidth(!1),x.parent().width()-x.width()],b=[o,0===o?0:o/s.scrollRatio.x],y=p[1],B=g[1],T=y>0?y/s.scrollRatio.x:0,k=B>0?B/s.scrollRatio.x:0;break;case"y":var x=e("#mCSB_"+s.idx+"_dragger_vertical"),_="top",w=h[0].offsetTop,S=[f.height()-h.outerHeight(!1),x.parent().height()-x.height()],b=[o,0===o?0:o/s.scrollRatio.y],y=p[0],B=g[0],T=y>0?y/s.scrollRatio.y:0,k=B>0?B/s.scrollRatio.y:0}b[1]<0||0===b[0]&&0===b[1]?b=[0,0]:b[1]>=S[1]?b=[S[0],S[1]]:b[0]=-b[0],t[0].mcs||(l(),i("onInit")&&c.callbacks.onInit.call(t[0])),clearTimeout(h[0].onCompleteTimeout),J(x[0],_,Math.round(b[1]),u[1],n.scrollEasing),!s.tweenRunning&&(0===w&&b[0]>=0||w===S[0]&&b[0]<=S[0])||J(h[0],_,Math.round(b[0]),u[0],n.scrollEasing,n.overwrite,{onStart:function(){n.callbacks&&n.onStart&&!s.tweenRunning&&(i("onScrollStart")&&(l(),c.callbacks.onScrollStart.call(t[0])),s.tweenRunning=!0,C(x),s.cbOffsets=r())},onUpdate:function(){n.callbacks&&n.onUpdate&&i("whileScrolling")&&(l(),c.callbacks.whileScrolling.call(t[0]))},onComplete:function(){if(n.callbacks&&n.onComplete){"yx"===c.axis&&clearTimeout(h[0].onCompleteTimeout);var e=h[0].idleTimer||0;h[0].onCompleteTimeout=setTimeout(function(){i("onScroll")&&(l(),c.callbacks.onScroll.call(t[0])),i("onTotalScroll")&&b[1]>=S[1]-T&&s.cbOffsets[0]&&(l(),c.callbacks.onTotalScroll.call(t[0])),i("onTotalScrollBack")&&b[1]<=k&&s.cbOffsets[1]&&(l(),c.callbacks.onTotalScrollBack.call(t[0])),s.tweenRunning=!1,h[0].idleTimer=0,C(x,"hide")},e)}}})}},J=function(e,t,o,a,n,i,r){function l(){S.stop||(x||m.call(),x=K()-v,s(),x>=S.time&&(S.time=x>S.time?x+f-(x-S.time):x+f-1,S.time<x+1&&(S.time=x+1)),S.time<a?S.id=h(l):g.call())}function s(){a>0?(S.currVal=u(S.time,_,b,a,n),w[t]=Math.round(S.currVal)+"px"):w[t]=o+"px",p.call()}function c(){f=1e3/60,S.time=x+f,h=window.requestAnimationFrame?window.requestAnimationFrame:function(e){return s(),setTimeout(e,.01)},S.id=h(l)}function d(){null!=S.id&&(window.requestAnimationFrame?window.cancelAnimationFrame(S.id):clearTimeout(S.id),S.id=null)}function u(e,t,o,a,n){switch(n){case"linear":case"mcsLinear":return o*e/a+t;case"mcsLinearOut":return e/=a,e--,o*Math.sqrt(1-e*e)+t;case"easeInOutSmooth":return e/=a/2,1>e?o/2*e*e+t:(e--,-o/2*(e*(e-2)-1)+t);case"easeInOutStrong":return e/=a/2,1>e?o/2*Math.pow(2,10*(e-1))+t:(e--,o/2*(-Math.pow(2,-10*e)+2)+t);case"easeInOut":case"mcsEaseInOut":return e/=a/2,1>e?o/2*e*e*e+t:(e-=2,o/2*(e*e*e+2)+t);case"easeOutSmooth":return e/=a,e--,-o*(e*e*e*e-1)+t;case"easeOutStrong":return o*(-Math.pow(2,-10*e/a)+1)+t;case"easeOut":case"mcsEaseOut":default:var i=(e/=a)*e,r=i*e;return t+o*(.499999999999997*r*i+-2.5*i*i+5.5*r+-6.5*i+4*e)}}e._mTween||(e._mTween={top:{},left:{}});var f,h,r=r||{},m=r.onStart||function(){},p=r.onUpdate||function(){},g=r.onComplete||function(){},v=K(),x=0,_=e.offsetTop,w=e.style,S=e._mTween[t];"left"===t&&(_=e.offsetLeft);var b=o-_;S.stop=0,"none"!==i&&d(),c()},K=function(){return window.performance&&window.performance.now?window.performance.now():window.performance&&window.performance.webkitNow?window.performance.webkitNow():Date.now?Date.now():(new Date).getTime()},Z=function(){var e=this;e._mTween||(e._mTween={top:{},left:{}});for(var t=["top","left"],o=0;o<t.length;o++){var a=t[o];e._mTween[a].id&&(window.requestAnimationFrame?window.cancelAnimationFrame(e._mTween[a].id):clearTimeout(e._mTween[a].id),e._mTween[a].id=null,e._mTween[a].stop=1)}},$=function(e,t){try{delete e[t]}catch(o){e[t]=null}},ee=function(e){return!(e.which&&1!==e.which)},te=function(e){var t=e.originalEvent.pointerType;return!(t&&"touch"!==t&&2!==t)},oe=function(e){return!isNaN(parseFloat(e))&&isFinite(e)},ae=function(e){var t=e.parents(".mCSB_container");return[e.offset().top-t.offset().top,e.offset().left-t.offset().left]},ne=function(){function e(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)if(e[t]+"Hidden"in document)return e[t]+"Hidden";return null}var t=e();return t?document[t]:!1};e.fn[o]=function(t){return u[t]?u[t].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof t&&t?void e.error("Method "+t+" does not exist"):u.init.apply(this,arguments)},e[o]=function(t){return u[t]?u[t].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof t&&t?void e.error("Method "+t+" does not exist"):u.init.apply(this,arguments)},e[o].defaults=i,window[o]=!0,e(window).bind("load",function(){e(n)[o](),e.extend(e.expr[":"],{mcsInView:e.expr[":"].mcsInView||function(t){var o,a,n=e(t),i=n.parents(".mCSB_container");if(i.length)return o=i.parent(),a=[i[0].offsetTop,i[0].offsetLeft],a[0]+ae(n)[0]>=0&&a[0]+ae(n)[0]<o.height()-n.outerHeight(!1)&&a[1]+ae(n)[1]>=0&&a[1]+ae(n)[1]<o.width()-n.outerWidth(!1)},mcsInSight:e.expr[":"].mcsInSight||function(t,o,a){var n,i,r,l,s=e(t),c=s.parents(".mCSB_container"),d="exact"===a[3]?[[1,0],[1,0]]:[[.9,.1],[.6,.4]];if(c.length)return n=[s.outerHeight(!1),s.outerWidth(!1)],r=[c[0].offsetTop+ae(s)[0],c[0].offsetLeft+ae(s)[1]],i=[c.parent()[0].offsetHeight,c.parent()[0].offsetWidth],l=[n[0]<i[0]?d[0]:d[1],n[1]<i[1]?d[0]:d[1]],r[0]-i[0]*l[0][0]<0&&r[0]+n[0]-i[0]*l[0][1]>=0&&r[1]-i[1]*l[1][0]<0&&r[1]+n[1]-i[1]*l[1][1]>=0},mcsOverflow:e.expr[":"].mcsOverflow||function(t){var o=e(t).data(a);if(o)return o.overflowed[0]||o.overflowed[1]}})})})});
