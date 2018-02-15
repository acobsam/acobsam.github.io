<?php
extract(shortcode_atts(array(
    'agcy1'=>'',
    'agcy2'=>'',
    'contact_info1' => '',
    'contact_info2' => '',
), $atts));
$agcy1 = wp_get_attachment_url($agcy1);
$agcy2 = wp_get_attachment_url($agcy2);
?>
<div class="agent-info clearfix">
	<span class="envelope">
		<img src="<?php echo esc_url( $agcy1 );?>" alt="agency about">
		<img src="<?php echo esc_url( $agcy2 );?>" alt="agency about2">
		<a href="#"><?php echo esc_attr( $contact_info1 );?></a>
		
	</span>
	<ul>
		<li class="col-sm-7" >
			<p><?php echo esc_attr( $contact_info2 );?></p>
		</li>
	</ul>
</div>