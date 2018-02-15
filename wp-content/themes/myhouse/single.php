<?php
  $post = $wp_query->post;
  if (in_category('project')) {
      include(TEMPLATEPATH.'/single-project.php');
  } else {
      include(TEMPLATEPATH.'/single-default.php');
  }
?>