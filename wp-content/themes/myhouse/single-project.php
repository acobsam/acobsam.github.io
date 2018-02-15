<?php get_header(); ?>
<!-- ================================ -->
<!-- ========== START Project ========== -->
<!-- ================================ -->
<!-- ================================ -->
<!-- ================================ -->
<section class="sectionPadding" id="project">
    <div class="projectContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php 
                    if(have_posts()) :
                    	while(have_posts()) : the_post(); 
                    		get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) );
						endwhile; 
					else: ?>
                    	<div class="not-found">
                            <h1><?php esc_html_e('Nothing Found Here!','myhouse'); ?></h1>    
                    	</div>
                    <?php endif; ?>
                </div><!-- end col-sm-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end bloContent -->
</section>
<!-- ========== END Project ========== -->
<!-- ================================ -->
<!-- ================================ -->

<?php get_footer(); ?>