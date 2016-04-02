<!DOCTYPE html>
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php do_action('socbet_favicon'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/lib/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

</head><!-- /head -->

<body <?php body_class(); ?>>

<?php do_action( 'socbet_after_body_tag' ); ?>

<div class="content-wrapper">

<?php 
/** call the left sidebar */
get_template_part( 'layouts/left', 'sidebar' );
?>

<div class="content-sub-wrapper">

	<div class="left-gutter only-mob-hide">&nbsp;</div>

<?php
/** cal the top container */
get_template_part( 'layouts/top', 'container' );
?>

<?php do_action( 'socbet_before_main' ); ?>