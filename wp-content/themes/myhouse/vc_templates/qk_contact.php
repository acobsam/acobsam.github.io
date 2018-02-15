<?php
extract(shortcode_atts(array(
    'icon' => '',
    'type' => '',
    'contact_info' => ''
), $atts));
?>
<div class="wrapper">
	<div class="<?php echo esc_attr( $icon );?>"></div>
	<p><?php echo esc_html( $type );?>: <br><span><?php echo esc_html( $contact_info );?></span> </p>
</div>