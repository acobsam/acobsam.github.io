<?php
$css = '';
extract(shortcode_atts(array(
  'image' => '',
  'title' => '',
  'icon' => '',
  'link' => '',
), $atts));

?>
<article class="featureBox">
	<?php
		$img = wp_get_attachment_image_src($image,'full');
		$img = $img[0];
	?>
	<div class="img">
		<a href="<?php echo esc_url($link); ?>"><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>"><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>"></a>
	</div><!-- end img -->
	<a href="<?php echo esc_url($link); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/content/ic.png" alt=""></a>
	<h4><?php echo esc_html($title); ?></h4>
	<p><?php echo do_shortcode($content)?></p>
</article>