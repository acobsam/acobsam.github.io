<?php global $myhouse_options;?>
	<!-- ================================ -->
	<!-- ========== START FOOTER ========== -->
	<!-- ================================ -->
	<!-- ================================ -->
	<section class="bgk bgk2 footer_bgsss">
		<div class="footer">
			<?php echo apply_filters( 'the_content', $myhouse_options['footer-text']);?>
			<div class="social">
				<?php if(isset($myhouse_options['pinterest'])&&!empty($myhouse_options['pinterest'])):?>
				    <a class="pinterest" href="<?php echo esc_url($myhouse_options['pinterest']); ?>"><i class="fa fa-pinterest-p"></i></a>
				<?php endif; ?>	
				<?php if(isset($myhouse_options['google'])&&!empty($myhouse_options['google'])):?>    
				    <a class="google" href="<?php echo esc_url($myhouse_options['google']); ?>"><i class="fa fa-google-plus"></i></a>
				<?php endif; ?>
				<?php if(isset($myhouse_options['twitter'])&&!empty($myhouse_options['twitter'])):?>
				    <a class="twitter" href="<?php echo esc_url($myhouse_options['twitter']);?>"><i class="fa fa-twitter"></i></a>
				<?php endif; ?>
				<?php if(isset($myhouse_options['facebook'])&&!empty($myhouse_options['facebook'])):?>
				    <a class="facebook" href="<?php echo esc_url($myhouse_options['facebook']);?>"><i class="fa fa-facebook"></i></a>
				<?php endif;?>
				<?php if(isset($myhouse_options['vine'])&&!empty($myhouse_options['vine'])):?>
				    <a class="vine" href="<?php echo esc_url($myhouse_options['vine']); ?>"><i class="fa fa-vine"></i></a>
				<?php endif; ?>	
			</div>
		</div>
	</section>
	<!-- ================================ -->
	<!-- ========== END FOOTER ========== -->
	<!-- ================================ -->




	<!-- ========== GO TOP ========== -->
	<div class="back-to-top icon-up-open"></div>

	<?php wp_footer(); ?>
</body>
</html>