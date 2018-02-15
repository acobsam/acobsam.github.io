<?php
extract(shortcode_atts(array(
    'title' => '',
    'skill' => '',
), $atts));
?>
<div class="progress col-lg-9 col-md-9 col-sm-9 col-xs-9">
  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_html(intval( $skill ));?>" aria-valuemin="0" aria-valuemax="100">
  	<span class="left"><?php echo esc_html( $title );?></span>
  </div><!-- end progress-bar -->
   
</div><!-- end progress -->	
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 progress-font font"><span><?php echo intval( $skill ); esc_html_e('%', 'myhouse'); ?></span></div>	