<?php

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Logo Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'logo-settings-tab',
			'type'  => 'tab-title',
		));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Logo', TIELABS_TEXTDOMAIN ),
			'id'    => 'logo-settings-section',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Logo Settings', TIELABS_TEXTDOMAIN ),
			'id'      => 'logo_setting',
			'type'    => 'radio',
			'toggle'  => array(
				'logo'  => '#logo-item, #logo_retina-item, #logo_retina_width-item, #logo_retina_height-item',
				'title' => ''),
			'options'	=> array(
				'logo'  => esc_html__( 'Image', TIELABS_TEXTDOMAIN ),
				'title' => esc_html__( 'Site Title', TIELABS_TEXTDOMAIN ),
			)));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Logo Image', TIELABS_TEXTDOMAIN ),
			'id'    => 'logo',
			'type'  => 'upload',
			'class' => 'logo_setting',
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Logo Image (Retina Version @2x)', TIELABS_TEXTDOMAIN ),
			'id'    => 'logo_retina',
			'type'  => 'upload',
			'class' => 'logo_setting',
			'hint'	=> esc_html__( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', TIELABS_TEXTDOMAIN ),
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Standard Logo Width for Retina Logo', TIELABS_TEXTDOMAIN ),
			'id'    => 'logo_retina_width',
			'type'  => 'number',
			'class' => 'logo_setting',
			'hint'  => esc_html__( 'If retina logo is uploaded, please enter the standard logo (1x) version width, do not enter the retina logo width.', TIELABS_TEXTDOMAIN ),
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Standard Logo Height for Retina Logo', TIELABS_TEXTDOMAIN ),
			'id'    => 'logo_retina_height',
			'type'  => 'number',
			'class' => 'logo_setting',
			'hint'  => esc_html__( 'If retina logo is uploaded, please enter the standard logo (1x) version height, do not enter the retina logo height.', TIELABS_TEXTDOMAIN ),
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Logo Text', TIELABS_TEXTDOMAIN ),
			'id'      => 'logo_text',
			'type'    => 'text',
			'default' => get_bloginfo(),
			'hint'    => esc_html__( 'In the Logo Image type this will be used as the ALT text.', TIELABS_TEXTDOMAIN ),
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Logo Margin Top', TIELABS_TEXTDOMAIN ),
			'id'   => 'logo_margin',
			'type' => 'number',
			'hint' => esc_html__( 'Leave it empty to use the default value.', TIELABS_TEXTDOMAIN ),
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Logo Margin Bottom', TIELABS_TEXTDOMAIN ),
			'id'   => 'logo_margin_bottom',
			'type' => 'number',
			'hint' => esc_html__( 'Leave it empty to use the default value.', TIELABS_TEXTDOMAIN ),
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Custom Logo URL', TIELABS_TEXTDOMAIN ),
			'id'    => 'logo_url',
			'type'  => 'text',
			'hint'  => esc_html__( 'Leave it empty to use the Site URL.', TIELABS_TEXTDOMAIN ),
		));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Favicon', TIELABS_TEXTDOMAIN ),
			'id'    => 'set-favicon-section',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'text' => '<a href="'. admin_url( '/customize.php?autofocus[section]=title_tagline' ) .'" target="_blank">'. esc_html__( 'Click here to set a Site Icon (favicon)', TIELABS_TEXTDOMAIN ) .'</a>',
			'type' => 'message',
		));
