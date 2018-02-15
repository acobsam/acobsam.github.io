<?php session_start(); ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<?php 
global $myhouse_options, $woocommerce; 
?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <?php
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {    
		?>
		<link rel="shortcut icon" href="<?php echo esc_url($myhouse_options['favicon']['url']); ?>">
        <?php
	} else {
	if($myhouse_options['apple_icon']['url']!=''){ ?>
        <link rel="apple-touch-icon" href="<?php echo esc_url($myhouse_options['apple_icon']['url']); ?>" />
        <?php } ?>
        <?php if($myhouse_options['apple_icon_57']['url']!=''){ ?>
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url($myhouse_options['apple_icon_57']['url']); ?>">
        <?php } ?>
       <?php if($myhouse_options['apple_icon_72']['url']!=''){ ?>
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url($myhouse_options['apple_icon_72']['url']); ?>">
        <?php } ?>
       <?php if($myhouse_options['apple_icon_114']['url']!=''){ ?>
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url($myhouse_options['apple_icon_114']['url']); ?>">
        <?php }  
	}
	?>
    <?php require_once get_template_directory() . '/assets/css/colors.php'; ?>
    <link href='https://fonts.googleapis.com/css?family=Parisienne' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
	<?php
	require_once 'Mobile_Detect.php';
	$detect = new Mobile_Detect;

	/*if ( $detect->isMobile() ) {?>
	<link rel='stylesheet' id='myhouse-mobile-css'  href='<?php bloginfo('template_directory'); ?>/mobile.css' type='text/css' media='all' />
	<?php } else { ?>
	<link rel='stylesheet' id='myhouse-theDesktop-css'  href='<?php bloginfo('template_directory'); ?>/theDesktop.css' type='text/css' media='all' />
	<?php }*/ ?>
</head>
<body <?php body_class(); ?>>

	<!-- ==========  START MENU ========== -->
	<?php if( $myhouse_options['body_style'] != 3):?>
		<div class="menu nav middle <?php if(!is_page_template('template-home.php')){?>static<?php }?>">
			<div class="container">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".menu nav > ul">
				  <span class="icon-bar first"></span>
				  <span class="icon-bar first-2"></span>
				  <span class="icon-bar last"></span>
				</button>
				
                <div class="navbar-brand <?php if(!empty($myhouse_options['logo']['url'])){ ?> brand-img<?php } ?> alpha omega">	
					<?php if(!empty($myhouse_options['logo']['url'])){ ?>
						<a href="<?php echo esc_url(home_url('/?scmlwelcome')); ?>" class="logo-area">
							<img src="<?php echo esc_url($myhouse_options['logo']['url']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>">
						</a>
					<?php }else{ ?>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="logo-text">
							<?php esc_attr(bloginfo('name')); ?>
						</a>
					<?php } ?>			
				</div>
				<nav>
					<!-- ============== NAVIGATION ============= -->
					<?php    
						/**
						* Displays a navigation menu
						* @param array $args Arguments
						*/
						$args = array(
							'theme_location' => 'one_page',
							'menu' => '',
							'container' => '',
							'container_class' => 'menu-{menu-slug}-container',
							'container_id' => '',
							'menu_class' => 'nav',
							'menu_id' => '',
							'echo' => true,
							'fallback_cb' => 'wp_page_menu',
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
							'depth' => 0,
							'walker' => new wp_bootstrap_navwalker
						);
					     if ( has_nav_menu( 'one_page' ) ) {
							wp_nav_menu( $args );
						  }
						?>
				</nav>
			</div>
		</div>
	<!-- ========== END MENU ========== -->

	<?php echo do_shortcode($myhouse_options['top_slider']); ?>
	<?php if(!empty($myhouse_options['top_slider'])){ ?>
	<!-- ============== ARROW  ================ -->
	<!-- ================================ -->
	<div class="arrow">
		<div class="hero-link">
			<?php if(is_page_template('template-home.php')){
				$id = 'information';
				}else{
				$id = 'blog';
			} ?>
        	<a href="#<?php echo esc_attr($id); ?>" data-easing="easeInOutCubic" data-scroll="" data-speed="900" data-url="false"><i class="fa fa-angle-double-down"></i></a>
    	</div><!--END HERO  -->
    	<div class="hero-line"></div>
	</div><!--end arrow  -->
	<!-- ============== END ARROW ================ -->
	<!-- ================================ -->
	<?php } ?>
	<?php else:
	echo do_shortcode('[rev_slider home-v3]'); ?>
	<!-- ==========  START MENU ========== -->
	<div class="menu middle">
		<div class="container">
			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".menu nav > ul">
			  <span class="icon-bar first"></span>
			  <span class="icon-bar first-2"></span>
			  <span class="icon-bar last"></span>
			</button>
			<div class="navbar-brand">
				<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_attr(bloginfo('name')); ?></a>
			</div>
			<nav>
				<!-- ============== NAVIGATION ============= -->
				<?php    /**
					* Displays a navigation menu
					* @param array $args Arguments
					*/
					$args = array(
						'theme_location' => 'one_page',
						'menu' => '',
						'container' => '',
						'container_class' => 'menu-{menu-slug}-container',
						'container_id' => '',
						'menu_class' => 'nav',
						'menu_id' => '',
						'echo' => true,
						'fallback_cb' => 'wp_page_menu',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
						'depth' => 0,
						'walker' => new wp_bootstrap_navwalker
					);
				
					if ( has_nav_menu( 'one_page' ) ) {
							wp_nav_menu( $args );
						  }
					?>
			</nav>
		</div>
	</div>
	<!-- ========== END MENU ========== -->
	<?php endif;?>

<?php
	if(is_front_page()) {
		$url = parse_url($_SERVER['REQUEST_URI']);
		if(!isset($_SESSION['homepagelogoloader']) || $url['query'] == 'scmlwelcome') {
			$_SESSION['homepagelogoloader'] = 'filled';
	?>
			<style>
				.hideHtmlBody {
				    background: #06182e !important;
				    overflow: hidden !important;
				}
				.home .menu.nav.middle,
				.home .vc_row.wpb_row.vc_row-fluid.vc_row-no-padding,
				div#contact,
				section.bgk.bgk2.footer_bgsss,
				.back-to-top.icon-up-open {opacity: 0;}

				.beforeHomeLoader {
				    width: 100%;
				    height: 100%;
				    overflow: hidden;
				    padding-top: 5%;
				    padding-bottom: 100%;
				    display: block;
				    background: #06182e;
				    text-align: center;
				    z-index: 99999999;
				    position: fixed;
				}
				#firstLoaderHome {opacity: 1;}
			</style>
			<div id="firstLoaderHome">
				<div class="beforeHomeLoader">
					<a href="#"><img src="<?php echo home_url(); ?>/assets/uploads/2016/01/logo.jpg" alt="Safavi Capital" /></a>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery("html, body").addClass("hideHtmlBody");
					jQuery(".beforeHomeLoader a").click(function(){
						jQuery("html, body").removeClass("hideHtmlBody");
						jQuery("#firstLoaderHome").css("display","none");
						jQuery(".home .menu.nav.middle, .home .vc_row.wpb_row.vc_row-fluid.vc_row-no-padding, div#contact, section.bgk.bgk2.footer_bgsss, .back-to-top.icon-up-open").css("opacity","1");
						return false;
					});
				});
			</script>
	<?php
		} else {
			//
		}
	}
?>