<?php
wp_enqueue_script("google-map", "//maps.google.com/maps/api/js?sensor=false");
wp_enqueue_script("maps", get_template_directory_uri()."/assets/js/map.js",array('google-map'),false,true);
extract(shortcode_atts(array(
    'lat' =>'',
    'lon' => '',
    'maker'=>''
), $atts));
$maker = wp_get_attachment_url($maker);
?>
<div id="map-canvas" class="google-map" data-lat="<?php echo esc_attr( $lat );?>" data-long="<?php echo esc_attr( $lon );?>" data-img="<?php echo esc_url( $maker );?>"></div>