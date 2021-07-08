<?php

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Translations Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'translations-settings-tab',
			'type'  => 'tab-title',
		));

	$translation_texts = apply_filters( 'TieLabs/translation_texts', array() );


	if( ! empty( $translation_texts ) && is_array( $translation_texts ) ){

		foreach ( $translation_texts as $id => $text ){

			tie_build_theme_option(
				array(
					'id'          => 'translations',
					'key'         => sanitize_title( htmlspecialchars( $id ) ),
					'name'        => htmlspecialchars( $text ),
					'placeholder' => htmlspecialchars( $text ),
					'type'        => 'arrayText',
				));
		}
	}
