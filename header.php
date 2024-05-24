<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <link rel="stylesheet" src="/sass/style.scss">
    <?php wp_head(); ?>
        <link rel="stylesheet" src="sass/style.scss">

</head>
<body <?php body_class(); ?>>
   