<header id="#top" class="amp-wp-header">
	<div>
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<?php echo esc_html( $this->get( 'blog_name' ) ); ?>
		</a>
	</div>
</header>

<?php
	// below Header Ad
	if( tie_get_option( 'amp_ad_below_header' ) ){ ?>
		<div class="amp-custom-ad amp-below-header-ad amp-ad">
			<?php echo tie_get_option( 'amp_ad_below_header' ); ?>
		</div>
	<?php
	}
?>
