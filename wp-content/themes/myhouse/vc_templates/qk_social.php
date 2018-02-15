<?php
extract(shortcode_atts(array(
    'twlink'=>'',
    'twname'=>'',
    'fblink'=>'',
    'fbname'=>'',
    'el_class'=>''
), $atts));
$twlink = wp_get_attachment_url($twlink);
$fblink = wp_get_attachment_url($fblink);
?>
<div class="<?php echo esc_attr( $el_class);?>">
	<ul class="clearfix socialIcons">
		<li class="col-sm-5">
			<a href="<?php echo esc_url( $twlink );?>"><i class="fa fa-twitter"></i>	
			<h4><?php echo esc_html( $twname );?></h4>
			</a>
		</li>
		<li class="col-sm-5">
			<a href="<?php echo esc_url( $fblink );?>">
				<i class="fa fa-facebook"></i>	
				<h4><?php echo esc_html( $fbname );?></h4>
			</a>
		</li>
	</ul>
</div>