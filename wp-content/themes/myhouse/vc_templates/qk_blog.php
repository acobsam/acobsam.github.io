<?php
extract(shortcode_atts(array(
    'order' => '',
    'el_class' => '',
    'btn_name' => ''
), $atts));
$order = intval( $order );
$order = $order <= 0 ? -1 : $order;
?>
<?php
  $args = array(
    'posts_per_page'=> $order
  );
  $owl = new WP_Query($args);
  if($owl->have_posts()):
  ?>
  <div class="row blogBox <?php echo esc_attr( $el_class );?>">
  <?php while($owl->have_posts()):$owl->the_post();
  ?>
  <div class="col-sm-4">
    <div class="blogPost ">
      <div class="image">
        <?php the_post_thumbnail( array(360,414, 'bfi_thumb'=>true ) );?>
        <div class="imgHover"><a href="<?php esc_url(the_permalink());?>"><?php echo esc_html( $btn_name );?></a><hr></div>
      </div>
      <div class="blogContent">
        <h3><a href="<?php esc_url(the_permalink());?>"><?php esc_html(the_title());?></a></h3>
        <ul class="clearfix" >
          <li><a href="<?php esc_js('javascript:void(0)'); ?>"><i class="fa fa-user"></i><?php esc_attr(the_author());?></a></li>
          <li><a href="<?php esc_js('javascript:void(0)'); ?>"><i class="fa fa-calendar-o"></i> <?php esc_attr(get_option('date_format'));?></a></li>
          <li><i class="fa fa-book"></i> <?php the_category( ',' );?></li>
        </ul>
        <p><?php the_excerpt();?></p>
        <div class="bottomContent">
          <ul>
            <li>
              <i class="fa fa-comments"></i>
              <span class="comments"><?php comments_number( 'No Comment', '1 Comment', '% Comments' );?></span>
            </li>
            <li>
              <i class="fa fa-comments"></i>
              <span class="likes"><?php echo esc_html(intval( get_post_meta( get_the_ID(), 'post_views_count', true ) ));?> <?php esc_html_e('likes', 'myhouse'); ?></span>
            </li>
          </ul>
        </div>
      </div><!--end blogContent -->
    </div><!--end blogPost -->
  </div><!-- end col-sm-4 -->
  <?php endwhile;wp_reset_postdata(); ?>
  </div>
<?php endif; ?>