<?php
extract(shortcode_atts(array(
    'icon' => ''
), $atts));
?>
<i class="fa <?php echo esc_attr( $icon );?>"></i>
<div class="infoContent">
	<?php echo apply_filters( 'the_content', $content);?>
</div>