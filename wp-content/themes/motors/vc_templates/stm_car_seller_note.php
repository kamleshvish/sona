<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = (!empty($css)) ? apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' ')) : '';
$note = get_post_meta(get_the_ID(),'listing_seller_note', true);
?>


<div class="stm-car-seller-note <?php echo esc_attr($css_class); ?>">
	<?php echo esc_html($note); ?>
</div>