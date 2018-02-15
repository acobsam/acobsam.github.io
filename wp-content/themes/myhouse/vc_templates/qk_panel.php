<?php
extract(shortcode_atts(array(
    'icon' => '',
    'title' => '',
    'el_id' => '',
    'el_class'=>'none',
    'parent' => '',
    'expanded'=> ''
), $atts));
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
			<i class="fa <?php echo esc_attr($icon);?>"></i>
			<a href="#<?php echo esc_attr( $el_id );?>"  data-toggle="collapse" data-parent="#<?php if( $parent ){ echo esc_html( $parent );}else{ echo 'accordion';}?>"><?php esc_html_e('Interior Features', 'myhouse'); ?></a>
		</h4>
	</div><!--end panel heading -->
	<div class="panel-collapse collapse<?php if( $expanded ){echo ' in';}?>" id="<?php echo esc_attr( $el_id );?>">
		<div class="panel-body">
			<?php if( $el_class !='none' ){?>
			<div class="<?php echo esc_html( $el_class);?> items">
				<?php
					$content = strip_tags( $content, '<ul><li>');
					$content = preg_replace_callback('/<li>([ \w\s]+):(.*)<\/li>/im', function( $matches ){
						return "<li class='col-sm-6' ><i class='fa fa fa-arrow-circle-o-right'></i> <p>{$matches[1]}: <span>{$matches[2]}</span></p></li>";
						}, $content);
					echo str_replace('<ul>', '<ul class="clearfix">', $content);
				?>
			</div><!-- end items -->
			<?php }else{?>
			<p><?php echo apply_filters( 'the_content', $content);?></p>
			<?php }?>
		</div>
	</div><!--end panel -collapse -->
</div><!--end panel -->	