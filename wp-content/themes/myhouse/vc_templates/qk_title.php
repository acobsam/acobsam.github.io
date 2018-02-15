<?php
extract(shortcode_atts(array(
    'icon' => '',
    'title' => '',
    'el_class' => ''
), $atts));
?>
<div class="featuresTitle <?php echo esc_attr( $el_class );?>">
	<h3><span><?php echo esc_attr( $icon );?></span><?php echo esc_attr( $title );?> <span class="hr"></span></h3>
	<?php echo apply_filters( 'the_content', esc_html($content) );?>
</div><!-- end features title -->