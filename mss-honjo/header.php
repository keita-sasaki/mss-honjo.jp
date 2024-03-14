<?php $options = get_design_plus_option(); ?>
<!DOCTYPE html>
<html class="pc" <?php language_attributes(); ?>>
<?php if($options['use_ogp']) { ?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<?php } else { ?>
<head>
<?php }; ?>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width">
<!-- <title>functionsで制御</title> -->
<meta name="description" content="<?php seo_description(); ?>">
<meta property="og:title" content="<?php wp_title(); ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://hanabishi-reform.net/">
<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/ogp.png">
<meta property="og:site_name" content="<?php bloginfo('charset'); ?>">
<meta property="og:description" content="<?php seo_description(); ?>">
<meta property="fb:app_id" content="977767480261004">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@1584917513087119360">
<meta name="twitter:player" content="@1584917513087119360">

<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico" id="favicon">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon-180x180.png">

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php wp_enqueue_style('style', get_stylesheet_uri(), false, version_num(), 'all'); wp_enqueue_script( 'jquery' ); if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/my-style.css">
<link rel="stylesheet" media="screen and (max-width:1050px)" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css?ver=<?php echo version_num(); ?>">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body id="body" <?php body_class(); ?>>
<div id="container">

  <header id="header">
  <?php
       // global menu ----------------------------------------------------------------
      if (has_nav_menu('global-menu')) {
  ?>
  <a id="menu_button" href="#"></a>
  <nav id="global_menu">
  <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'theme_location' => 'global-menu' , 'container' => '' ) ); ?>
  </nav>
  <?php }; ?>
  
    <div id="header_top">
      <div id="header_logo">
      <?php header_logo(); ?>
      </div>

    <?php
        // header banner ------------------------------------------------------------------------------------------------------------------------
        if(!wp_is_mobile()) {
          if( $options['header_ad_code'] || $options['header_ad_image'] ) {
    ?>
      <!-- <div id="header_banner" class="header_banner">
      <?php

          if ($options['header_ad_code']) {
            echo $options['header_ad_code'];
          } else {
            $banner_image = wp_get_attachment_image_src( $options['header_ad_image'], 'full' );
      ?>
        <a href="<?php echo esc_url( $options['header_ad_url'] ); ?>" target="_blank" class="header_banner_link">
          <img class="header_banner_image" src="<?php echo esc_attr($banner_image[0]); ?>" alt="" title="" />
        </a>
      <?php }; ?>
      </div>--><!-- END #header_banner -->
    <?php
          };
        };
    ?>
    </div><!-- END #header_top -->
    <div class="head-infomation">
      <p class="head-infomation-salestime">営業時間 / 平日-9:00 - 18:00・祝日-9:00 - 18:00　休診 / 第3木曜日 　</p>
      <p class="head-infomation-address">住所 / 秋田県由利本荘市薬師堂中道127</p>
      <p class="head-infomation-text">ご予約はお電話、お問い合わせからお気軽にどうぞ！</p>
      <p class="head-infomation-tel">000-0000-0000</p>
    </div>
  </header><!-- END #header -->


