<?php
global $myhouse_options;
$main_color = '#f0542d';
if($myhouse_options['main-color']!='')
	$main_color = $myhouse_options['main-color'];
?>
<style>
.descriptions h3 span,
.items h4,
.location h3 span,
.infoContent h4,
.media-body span,
.aboutAgent h3 span,
.aboutAgent ul li a,
.comment-form-themeIndex .one img,
.comment-form-themeIndex .two img,
.comment-form-themeIndex .three img,
.footer h2 span,
.footer h2:after,
.blogPost .blogContent h3 a:hover,
.blogPost .blogContent ul li i,
.blogPost .blogContent ul li a:hover,
.bottomContent ul li span.comments
.blog-article-content a:hover,
.blog-article-content ul li i,
.article-pagination ul li a:hover,
.comment-form-theme h4,
.hoverUl .heading i,
.blog-sidebar-1 .categoriesBlog .heading i,
.blog-sidebar-1 .featured-posts .heading i,
.blog-sidebar-1 .featured-posts ul li span.title,
.blog-sidebar-1 .about .content p a:hover,
.menu nav ul li a:hover,
.carousel-caption h2,
.author h5 span,
{
	color:<?php echo esc_attr($main_color);?>
}
.box a,
.categories ul li a p,
.footer .social a,
.progress-bar,
.article-pagination ul li a,
.blogTags a,
.comment-container ul li .comment .right-section h1 a,
.menu nav ul li.active a
{
	background-color:<?php echo esc_attr($main_color);?>
}
.allButton a p,.categories ul li a p,
.information p:after,
.blog-sidebar-1 .search-widget form.search button[type="submit"],
.menu nav ul li a:hover,
.menu nav ul li.active a,
.carouselPresentation .owl-prev,
.carouselPresentation .owl-next
{
	background:<?php echo esc_attr($main_color);?>
}
.panel-title i,
.categories ul li a,
.allButton a ,
.box i,
.socialIcons i,
.blogTags a,
.hoverUl .heading i,
.hoverUl ul li a:hover,.hoverUl ul li a:hover .name,
.hoverUl ul li a:hover .value,
.blog-sidebar-1 .categoriesBlog .heading i,
.menu nav ul li a:hover,
.menu nav ul li.active a
{
	border-color:<?php echo esc_attr($main_color);?>
}
.contentGallery ul li a h3 img:after
{
	border-color: transparent transparent <?php echo esc_attr($main_color);?> <?php echo esc_attr($main_color);?>;
}
.article-pagination ul li a:hover,.blog-sidebar-1 .search-widget{
	border-bottom-color: <?php echo esc_attr($main_color);?>
}

@media (max-width: 1030px) {
  .media-body span {
    color: <?php echo esc_attr($main_color);?>;
  }
}
.footer_bgsss {
	padding: 3rem 0;
    background:url( <?php echo esc_url( $myhouse_options['footer-bg']['url'] );?>) no-repeat;
}
.sectionPadding {
	padding-top:11.5rem; padding-bottom:4.5rem;
}
</style>