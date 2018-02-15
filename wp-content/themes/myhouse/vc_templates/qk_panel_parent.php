<?php
extract(shortcode_atts(array(
	'el_id'=>'',
), $atts));

?>
<div class="panel-group" <?php if($el_id!=''){ ?> id="<?php echo esc_html($el_id);?>" <?php } ?>>
	<?php echo wpb_js_remove_wpautop($content); ?>
</div>