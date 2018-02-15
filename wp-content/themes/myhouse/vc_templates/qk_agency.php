<?php
extract(shortcode_atts(array(
    'agcy1'=>'',
    'agcy2'=>'',
    'el_class'=>''
), $atts));
$agcy1 = wp_get_attachment_url($agcy1);
$agcy2 = wp_get_attachment_url($agcy2);
?>
<div class="agencyBox <?php echo esc_attr( $el_class );?>">
	<img src="<?php echo esc_url( $agcy1 );?>" alt="agency img">
	<img src="<?php echo esc_url( $agcy2 );?>" alt="agency img2">
	<?php echo apply_filters( 'the_content', $content );?>
</div><!-- end agencyBox -->