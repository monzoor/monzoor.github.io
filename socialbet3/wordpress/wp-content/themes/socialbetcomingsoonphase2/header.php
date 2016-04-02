<!DOCTYPE html>
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php echo esc_html( wp_title( '|', true, 'right' ) ); ?></title>

<?php do_action( 'socbet_favicon' ); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta property="og:image" content="http://socialbet.ru/wp-content/uploads/2014/11/avatar.jpg" />

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47508153-5', 'auto');
  ga('send', 'pageview');
</script>

</head><!-- /head -->

<body <?php body_class(); ?>>


<div id="site-main-bg"></div>
<div id="parallax-overlay">
	<img class="horse1" src="<?php echo get_template_directory_uri() . '/assets/images/horse1.png'; ?>" alt="" />
	<img class="horse2" src="<?php echo get_template_directory_uri() . '/assets/images/horse2.png'; ?>" alt="" />
	<img class="snow1" src="<?php echo get_template_directory_uri() . '/assets/images/snow1.png'; ?>" alt="" />
	<img class="snow2" src="<?php echo get_template_directory_uri() . '/assets/images/snow2.png'; ?>" alt="" />
</div>

<div id="site-wrap">
