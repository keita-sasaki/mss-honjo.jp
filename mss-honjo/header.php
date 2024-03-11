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
<title><?php wp_title('|', true, 'right'); ?></title>
<meta name="description" content="秋田県潟上市のリフォーム業者です。リフォームのプロフェッショナルであり、細かい修繕から大規模修繕まで対応しています。">
<meta property="og:title" content="花菱リフォーム">
<meta property="og:type" content="website">
<meta property="og:url" content="https://hanabishi-reform.net/">
<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/ogp.png">
<meta property="og:site_name" content="花菱リフォーム">
<meta property="og:description" content="秋田県潟上市のリフォーム業者です。リフォームのプロフェッショナルであり、細かい修繕から大規模修繕まで対応しています。">
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

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-S4X3MCJERX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-S4X3MCJERX');
</script>
</head>

<body id="body" <?php body_class(); ?>>
<div id="container">

  <header id="header">

  <?php
       // global menu ----------------------------------------------------------------
      if (has_nav_menu('global-menu')) {
  ?>
  <a id="menu_button" href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/sp-menu.png" alt=""></a>
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
      <div id="header_banner" class="header_banner">
      <?php

          if ($options['header_ad_code']) {
            echo $options['header_ad_code'];
          } else {
            $banner_image = wp_get_attachment_image_src( $options['header_ad_image'], 'full' );
      ?>
        <a href="tel:<?php echo $options['header_ad_url']; ?>" class="header_banner_link">
          <img class="header_banner_image" src="<?php echo esc_attr($banner_image[0]); ?>" alt="<?php echo $options['header_ad_url']; ?>" title="" />
        </a>
      <?php }; ?>
      </div><!-- END #header_banner -->
    <?php
          };
        };
    ?>
    </div><!-- END #header_top -->

  </header><!-- END #header -->

  <?php
      //  Header slider -------------------------------------------------------------------------
      if(is_front_page() && $options['show_index_slider']) {

        // Post slider -----------------------------------------------------------------
        if($options['index_slider_type'] == 'type1'){
  ?>
  <div id="header_post_slider" class="index_slider">
  <?php

      $post_num = $options['index_slider_post_num'];
      $post_type = $options['index_slider_post_type'];
      $post_order = $options['index_slider_post_order'];
      $show_date = $options['index_slider_show_date'];
      $show_category = $options['index_slider_show_category'];

      if($post_type == 'recent_post') {
        if($post_order == 'random') {
          $args = array( 'post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, 'orderby' => 'rand' );
        } else {
          $args = array( 'post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1 );
        }
      } else {
        $args = array( 'post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, 'meta_key' => $post_type, 'meta_value' => 'on' );
      }

      $post_list = new wp_query($args);
      if($post_list->have_posts()):
  ?>
    <div class="post_list header_slider">
      <div class="swiper-container" id="index_header_slider"> 
        <div class="swiper-wrapper">
    <?php
        // loop start
        while( $post_list->have_posts() ) : $post_list->the_post();
          if(has_post_thumbnail()) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'size5' );            
          } elseif($options['no_image1']) {
            $image = wp_get_attachment_image_src( $options['no_image1'], 'full' );
          } else {
            $image = array();
            $image[0] = esc_url(get_bloginfo('template_url')) . "/img/common/no_image2.gif";
          }
          $category = wp_get_post_terms( $post->ID, 'category' , array( 'orderby' => 'term_order' ));
          if ( $category && ! is_wp_error($category) ) {
            foreach ( $category as $cat ) :
              $cat_name = $cat->name;
              $cat_id = $cat->term_id;
              $cat_url = get_term_link($cat_id,'category');
              break;
            endforeach;
          };
    ?>
      <div class="item swiper-slide">
        <a class="link" href="<?php the_permalink(); ?>">
          <div class="image_wrap">
            <div class="image" style="background:url(<?php echo esc_attr($image[0]); ?>) no-repeat center center; background-size:cover;"></div>
          </div>
          <div class="content">
            <div class="content_inner">
              <h4 class="title rich_font"><span><?php the_title_attribute(); ?></span></h4>
              <p class="meta">
                <?php if($show_date) { ?>
                <span class="date<?php if( $show_category ) echo " mr5" ?>"><time class="entry-date updated"><?php the_time('Y.m.d'); ?></time></span>
                <?php }; ?>
                <?php if ( $category && $show_category && ! is_wp_error($category) ) { ?>
                <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span>
                <?php }; ?>
              </p>
            </div>
          </div>
          <div class="overlay"></div>
        </a>
      </div><!-- END .swiper-slide -->
    <?php endwhile; wp_reset_query(); // END loop ?>
      </div><!-- END .swiper-wrapper -->
      <div class="swiper-pagination"></div> 
    </div><!-- END .swiper-container -->
  </div><!-- END .post_list -->
    <?php endif; ?>
  </div><!-- END #header_post_slider -->
  <?php

          // Image slider -----------------------------------------------------------------
          } else {
            
  ?>
<div id="header_slider" class="index_slider">
  <div class="header_slider">
    <div class="swiper-container" id="index_header_slider">  
      <div class="swiper-wrapper">
        <div class="swiper-slide item image_item item1">
          <div class="image_wrap">
            <div class="bg_image image"></div>
          </div>
          <div class="mv-text">
            <div class="mv-text-head">
            リフォームのプロフェッショナルであり、<br class="pc">細かい修繕から大規模修繕まで対応しています。
            </div>
            <p>現地調査も見積りも無料の為、気軽に相談可能です。<br>
            建物診断・外壁診断も対応しています。<br>
            ドローンによる技術指導や業務請負も行っており、ドローン国家操縦ライセンスも保持しております。</p>
          </div>
        </div><!-- END .item -->

        <div class="swiper-slide item image_item item2">
          <div class="image_wrap">
            <div class="bg_image image"></div>
          </div>
        </div><!-- END .item -->
      </div><!-- END swiper-wrapper -->

      
    </div><!-- END swiper-container -->
  </div><!-- END .header_slider -->
  <div class="swiper-pagination"></div>
</div><!-- END #header_slider -->
  <?php
        }; // END $slider_type
      }; // END front page
  ?>
