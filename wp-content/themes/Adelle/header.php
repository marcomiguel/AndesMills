<!DOCTYPE html>
<!--[if IE 6]><html id="ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html id="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

<title><?php wp_title('|', true, 'right'); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); echo "/images/favicon.gif"; ?>?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="image/x-icon" />
<link href='http://fonts.googleapis.com/css?family=Ropa+Sans:400,400italic|Arvo:400,700|Handlee' rel='stylesheet' type='text/css'>

<!--[if lt IE 7]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script><![endif]-->
<!--[if lt IE 8]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script><![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if lt IE 9]><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header class="header" role="banner">

  <?php echo adelle_theme_heading(); ?>

  <nav class="nav" role="navigation">
    <?php wp_nav_menu( 'theme_location=top_menu&container_class=menu&fallback_cb=wp_page_menu&show_home=1' ); ?>

   

  </nav><!-- .nav -->

</header><!-- .header -->

<section class="container">