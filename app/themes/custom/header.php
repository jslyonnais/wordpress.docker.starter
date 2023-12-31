<!doctype html>
<!--[if lt IE 7 ]> <html class="ie6 ie"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7 ie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 ie"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9 ie"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head itemscope itemtype="http://schema.org/WebSite">
<meta charset="<?php bloginfo('charset'); ?>">
<title><?php wp_title(''); ?></title>
<meta itemprop="name" content="<?php bloginfo('name'); ?>"/>
<meta itemprop="url" content="<?= get_permalink(); ?>"/>

<link href="//www.google-analytics.com" rel="dns-prefetch">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="apple-touch-icon" sizes="57x57" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/favicon-16x16.png">
<link rel="manifest" href="<?= get_template_directory_uri(); ?>/assets/dist/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?= get_template_directory_uri(); ?>/assets/dist/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>