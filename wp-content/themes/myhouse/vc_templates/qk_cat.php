<?php
extract(shortcode_atts(array(
  'type' =>''
), $atts));
$exclude = explode( ',', $exclude );
$cat_args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'hide_empty'        => true, 
    'exclude_tree'      => array(), 
    'include'           => array(),
    'number'            => '', 
    'fields'            => 'all', 
    'slug'              => '',
    'parent'            => '',
    'hierarchical'      => true, 
    'child_of'          => 0,
    'childless'         => false,
    'get'               => '', 
    'name__like'        => '',
    'description__like' => '',
    'pad_counts'        => false, 
    'offset'            => '', 
    'search'            => '', 
    'cache_domain'      => 'core'
);
$taxonomy = array($type);
$cats = get_terms( $taxonomy, $cat_args );
?>
<ul class="clearfix" data-option-key="filter">
	<li><a href="#" class="selected" data-option-value="*"><small><?php esc_html_e('All', 'myhouse');?></a></small></li>
	<?php foreach( $cats as $cat):?>
    <li><a href="#" data-option-value=".<?php echo esc_attr( $cat->slug );?>"><small><?php echo esc_attr( $cat->name );?></a></small></li>
	<?php endforeach;?>
</ul>