<?php
extract(shortcode_atts(array(
    'order'=>'',
    'file' => '',
    'btn_link' => '',
    'btn_name' => ''
), $atts));
$order = intval( $order );
$order = $order <= 0 ? -1 : $order;
$file = wp_get_attachment_url( $file );
?>
<?php
  $args = array(
    'posts_per_page'=> $order,
    'post_type' => 'gallery',
  );
  $galleries = new WP_Query($args);
  if($galleries->have_posts()):
  ?>
 <div class="contentGallery row">
    <ul class="clearfix">
    <?php while( $galleries->have_posts() ) : $galleries->the_post();
      $cats = get_the_terms( get_the_ID(), 'gallery_type');
      $cls = '';
      if( count( $cats ) > 0){
        foreach( $cats as $cat ){
          $cls .="$cat->slug ";
        }
      }
      $img = get_post_thumbnail_id( get_the_ID() );
      $img = myhouse_get_img( $img, 357, 312 );
    ?>
      <li class="<?php echo esc_html( $cls );?>col-sm-4 " >
        <div class="wrapper-article galleryPopup1">
          <a href="<?php echo esc_url(myhouse_thumbnail_url(''));?>">
            <img src="<?php echo esc_url( $img );?>" class="img-responsive" alt="<?php esc_html(the_title());?>">
            <h3><img src="<?php echo esc_url( $file );?>"></h3>
          </a>
        </div><!--end wrapper-article -->
      </li>
    <?php endwhile;?>
    </ul>
  <?php if( is_front_page() ):?>
    <div class="allButton">
      <a href="<?php echo esc_url( get_permalink( $btn_link ) );?>">
        <p><?php echo esc_html( $btn_name);?></p>
      </a>
    </div><!-- end allButton -->
  <?php endif;?>
    </div><!-- end ContetnGallery -->
<?php endif; ?>