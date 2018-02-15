<article <?php post_class('');?>>
	<?php if (!in_category('project')) { if(has_post_thumbnail()){ ?>
		<div class="imgBlog">
			<?php the_post_thumbnail(); ?>
		</div><!-- end imgBlog -->
	<?php } } ?>
    
	<div class="col-sm-12 blog-article-content">
		<a href="<?php esc_url(the_permalink()); ?>">
			<h3><?php esc_attr(the_title()); ?></h3>
		</a>
		<?php /*<ul class="clearfix" >
				<li><i class="fa fa-user"></i> <?php esc_url(the_author_posts_link()); ?></li>
				<li><a href="#"><i class="fa fa-calendar-o"></i><?php esc_attr(get_option('date_format')); ?></a></li>
				<li><i class="fa fa-music"></i> <?php esc_attr(the_category(', ')); ?></li>
		</ul>*/?>
		<div class="post-content">
		<?php the_content(); ?>
		<?php
			$defaults = array(
			  'before'           => '<div id="page-links"><strong>'.esc_html__('Page:', 'myhouse').' </strong>',
			  'after'            => '</div>',
			  'link_before'      => '<span>',
			  'link_after'       => '</span>',
			  'next_or_number'   => 'number',
			  'separator'        => ' ',
			  'nextpagelink'     => esc_html__( 'Next page', 'myhouse' ),
			  'previouspagelink' => esc_html__( 'Previous page', 'myhouse' ),
			  'pagelink'         => '%',
			  'echo'             => 1
			);
		   ?>
		  <?php wp_link_pages($defaults); ?>
		  <?php if(has_tag()){ ?>
			<?php the_tags('<ul class="single-post-tags"><li><span>'.esc_html__('Tags:', 'myhouse').' </span> </li><li>',' </li>, <li>','</li></ul>'); ?>
		  <?php } ?>  
		  
		</div>
	</div><!--end blog-article-content -->
</article>