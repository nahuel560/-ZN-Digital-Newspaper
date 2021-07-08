<?php

$archives_layouts = array(
	'excerpt'        => array( esc_html__( 'Classic', TIELABS_TEXTDOMAIN )          => 'archives/blog.png' ),
	'full_thumb'     => array( esc_html__( 'Large Thumbnail', TIELABS_TEXTDOMAIN )  => 'archives/full-thumb.png' ),
	'content'        => array( esc_html__( 'Content', TIELABS_TEXTDOMAIN )          => 'archives/content.png' ),
	'timeline'       => array( esc_html__( 'Timeline', TIELABS_TEXTDOMAIN )         => 'archives/timeline.png' ),
	'masonry'        => array( esc_html__( 'Masonry', TIELABS_TEXTDOMAIN ).' #1'    => 'archives/masonry.png' ),
	'overlay'        => array( esc_html__( 'Masonry', TIELABS_TEXTDOMAIN ).' #2'    => 'archives/overlay.png' ),
	'overlay-spaces' => array( esc_html__( 'Masonry', TIELABS_TEXTDOMAIN ).' #3'    => 'archives/overlay-spaces.png' ),
	'first_big'      => array( esc_html__( 'Large Post Above', TIELABS_TEXTDOMAIN ) => 'archives/first_big.png' ),
	'overlay-title'  => array( esc_html__( 'Overlay Title', TIELABS_TEXTDOMAIN )    => 'archives/overlay-title.png' ),
	'overlay-title-center' => array( esc_html__( 'Overlay Title Centered', TIELABS_TEXTDOMAIN ) => 'archives/overlay-title-center.png' ),
	'classic-small'  => array( esc_html__( 'Classic Small', TIELABS_TEXTDOMAIN )    => 'archives/blog-small.png' ),
);

$pagination_styles = array(
	'next-prev' => esc_html__( 'Next and Previous', TIELABS_TEXTDOMAIN ),
	'numeric'   => esc_html__( 'Numeric',           TIELABS_TEXTDOMAIN ),
	'load-more' => esc_html__( 'Load More',         TIELABS_TEXTDOMAIN ),
	'infinite'  => esc_html__( 'Infinite Scroll',   TIELABS_TEXTDOMAIN ),
);

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Archives Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'archives-settings-tab',
		'type'  => 'tab-title',
	));

# Global Archives Settings
tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Global Archives Settings', TIELABS_TEXTDOMAIN ),
		'id'    =>	'archives-global-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable Author name meta', TIELABS_TEXTDOMAIN ),
		'id'   => 'archives_disable_author_meta',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable Comments number meta', TIELABS_TEXTDOMAIN ),
		'id'   => 'archives_disable_comments_meta',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable Views Number meta', TIELABS_TEXTDOMAIN ),
		'id'   => 'archives_disable_views_meta',
		'type' => 'checkbox',
	));


# Default settings
tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Default Layout Settings', TIELABS_TEXTDOMAIN ),
		'id'    =>	'archives-default-layout-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'id'      => 'blog_display',
		'type'    => 'visual',
		'columns' => 7,
		'options' => $archives_layouts
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', TIELABS_TEXTDOMAIN ),
		'id'      => 'blog_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', TIELABS_TEXTDOMAIN ),
		'id'      => 'blog_pagination',
		'type'    => 'radio',
		'options' => $pagination_styles
	));



# Category page settings
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Category Page Settings', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'id'      => 'category_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => $archives_layouts
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', TIELABS_TEXTDOMAIN ),
		'id'      => 'category_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Category Description', TIELABS_TEXTDOMAIN ),
		'id'   => 'category_desc',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', TIELABS_TEXTDOMAIN ),
		'id'      => 'category_pagination',
		'type'    => 'radio',
		'options' => $pagination_styles
	));



# Tag page settings
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Tag Page Settings', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'id'      => 'tag_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => $archives_layouts
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', TIELABS_TEXTDOMAIN ),
		'id'      => 'tag_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Tag Description', TIELABS_TEXTDOMAIN ),
		'id'   => 'tag_desc',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', TIELABS_TEXTDOMAIN ),
		'id'      => 'tag_pagination',
		'type'    => 'radio',
		'options' => $pagination_styles
	));



# Author page settings
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Author Page Settings', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'id'		=> 'author_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => $archives_layouts
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', TIELABS_TEXTDOMAIN ),
		'id'      => 'author_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Author Bio', TIELABS_TEXTDOMAIN ),
		'id'   => 'author_bio',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', TIELABS_TEXTDOMAIN ),
		'id'      => 'author_pagination',
		'type'    => 'radio',
		'options' => $pagination_styles
	));



# Search page settings
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Search Page Settings', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'id'		  => 'search_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => $archives_layouts
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', TIELABS_TEXTDOMAIN ),
		'id'      => 'search_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', TIELABS_TEXTDOMAIN ),
		'id'      => 'search_pagination',
		'type'    => 'radio',
		'options' => $pagination_styles
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Search in Category IDs', TIELABS_TEXTDOMAIN ),
		'id'   => 'search_cats',
		'hint' => esc_html__( 'Use minus sign (-) to exclude categories. Example: (1,4,-7) = search only in Category 1 & 4, and exclude Category 7.', TIELABS_TEXTDOMAIN ),
		'type' => 'text',
	));

$args = array(
	'public' => true,
	'exclude_from_search' => false,
);

$post_types = get_post_types( $args );
unset( $post_types['post'] );
unset( $post_types['attachment'] );

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Exclude post types from search', TIELABS_TEXTDOMAIN ),
		'id'      => 'search_exclude_post_types',
		'type'    => 'select-multiple',
		'options' => $post_types,
	));

