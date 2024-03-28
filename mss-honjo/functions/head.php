<?php
     function tcd_head() {
       $options = get_design_plus_option();
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/design-plus.css?ver=<?php echo version_num(); ?>">
<!-- <link rel="stylesheet" media="screen and (max-width:1050px)" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css?ver=<?php echo version_num(); ?>"> -->
<?php if(is_single()) { ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/sns-botton.css?ver=<?php echo version_num(); ?>">
<script src="<?php echo get_template_directory_uri(); ?>/js/comment.js?ver=<?php echo version_num(); ?>"></script>
<?php } ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.4.js?ver=<?php echo version_num(); ?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jscript.js?ver=<?php echo version_num(); ?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cookie.min.js?ver=<?php echo version_num(); ?>"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/simplebar.css?ver=<?php echo version_num(); ?>">
<script src="<?php echo get_template_directory_uri(); ?>/js/simplebar.min.js?ver=<?php echo version_num(); ?>"></script>
<?php 

/* URLやモバイル等でcssが変わらないものをここで出力 */ 
?>
<style type="text/css">

/* ----------------------------------------------------------------------
 色の設定 メインカラー、サブカラー等
---------------------------------------------------------------------- */
<?php
     // メインカラー #333 ----------------------------------
     $main_color = $options['main_color'];
     $sub_color = $options['index_slider_bg_color'];
     $text_color = $options['content_link_color'];
     $link_hover_color = $options['sub_color'];
?>
:root {
  --primary: <?php echo esc_html($main_color); ?>;
  --bg: <?php echo esc_html($sub_color); ?>;
  --text: <?php echo esc_html($text_color); ?>;
  --gray: <?php echo esc_html($link_hover_color); ?>;
}

<?php
/* ----------------------------------------------------------------------
 サムネイルのホバーエフェクト
---------------------------------------------------------------------- */

     // サムネイルのアニメーション設定　■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
     if($options['hover_type']!="type4"){

       // ズーム ------------------------------------------------------------------------------
       if($options['hover_type']=="type1"){
?>
.author_profile .avatar_area img, .animate_image img, .animate_background .image {
  width:100%; /*height:auto;*/ height:100%;
  -webkit-transition: transform  0.75s ease;
  transition: transform  0.75s ease;
}
.author_profile a.avatar:hover img, .animate_image:hover img, .animate_background:hover .image {
  -webkit-transform: scale(<?php echo $options['hover1_zoom']; ?>);
  transform: scale(<?php echo $options['hover1_zoom']; ?>);
}
<?php

     // スライド ------------------------------------------------------------------------------
     } elseif($options['hover_type']=="type2"){
?>
.animate_image, .animate_background .image_wrap {
  background: <?php echo $options['hover2_bgcolor']; ?>;
}
.animate_image img, .animate_background .image {
  -webkit-width:calc(100% + 30px) !important; width:calc(100% + 30px) !important; height:100%; /*max-width:inherit !important;*/ position:relative;
  <?php if($options['hover2_direct']=='type1'): ?>
  -webkit-transform: translate(-15px, 0px); -webkit-transition-property: opacity, translateX; -webkit-transition: 0.5s;
  transform: translate(-15px, 0px); transition-property: opacity, translateX; transition: 0.5s;
  <?php else: ?>
  -webkit-transform: translate(-15px, 0px); -webkit-transition-property: opacity, translateX; -webkit-transition: 0.5s;
  transform: translate(-15px, 0px); transition-property: opacity, translateX; transition: 0.5s;
  <?php endif; ?>
}
.animate_image:hover img, .animate_background:hover .image {
  opacity:<?php echo $options['hover2_opacity']; ?>;
  <?php if($options['hover2_direct']=='type1'): ?>
  -webkit-transform: translate(0px, 0px);
  transform: translate(0px, 0px);
  <?php else: ?>
  -webkit-transform: translate(-30px, 0px);
  transform: translate(-30px, 0px);
  <?php endif; ?>
}
.animate_image.square img {
  -webkit-width:calc(100% + 30px) !important; width:calc(100% + 30px) !important; height:auto; max-width:inherit !important; position:relative;
  <?php if($options['hover2_direct']=='type1'): ?>
  -webkit-transform: translate(-15px, -15px); -webkit-transition-property: opacity, translateX; -webkit-transition: 0.5s;
  transform: translate(-15px, -15px); transition-property: opacity, translateX; transition: 0.5s;
  <?php else: ?>
  -webkit-transform: translate(-15px, -15px); -webkit-transition-property: opacity, translateX; -webkit-transition: 0.5s;
  transform: translate(-15px, -15px); transition-property: opacity, translateX; transition: 0.5s;
  <?php endif; ?>
}
.animate_image.square:hover img {
  opacity:<?php echo $options['hover2_opacity']; ?>;
  <?php if($options['hover2_direct']=='type1'): ?>
  -webkit-transform: translate(0px, -15px);
  transform: translate(0px, -15px);
  <?php else: ?>
  -webkit-transform: translate(-30px, -15px);
  transform: translate(-30px, -15px);
  <?php endif; ?>
}
<?php

     // フェードアウト ------------------------------------------------------------------------------
     } elseif($options['hover_type']=="type3"){
?>
.author_profile .avatar_area, .animate_image, .animate_background .image_wrap {
  background: <?php echo $options['hover3_bgcolor']; ?>;
}
.author_profile a.avatar img, .animate_image img, .animate_background .image {
  -webkit-transition-property: opacity; -webkit-transition: 0.5s;
  transition-property: opacity; transition: 0.5s;
}
.author_profile a.avatar:hover img, .animate_image:hover img, .animate_background:hover .image {
  opacity: <?php echo $options['hover3_opacity']; ?>;
}
<?php }; }; // アニメーションここまで 


/* ----------------------------------------------------------------------
 トップページ
---------------------------------------------------------------------- */
    // オーバーレイ
    if($options['index_slider_use_overlay']) {
      $overlay_color = hex2rgb($options['index_slider_overlay_color']);
      $overlay_color = implode(",",$overlay_color);
      $overlay_opacity = $options['index_slider_overlay_opacity'];
?>
.index_slider .overlay { background:rgba(<?php echo esc_html($overlay_color); ?>,<?php echo esc_html($overlay_opacity); ?>); }
<?php }; ?>


<style id="current-page-style" type="text/css">
<?php

     // カスタムCSS --------------------------------------------
     if(is_single() || is_page()) {
       global $post;
       $custom_css = get_post_meta($post->ID, 'custom_css', true);
       if($custom_css) {
         echo $custom_css."\n";
       };
     }

?>
</style>
<?php
     // JavaScriptの設定はここから　■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■

     // トップページ
     if(is_front_page()) {
       
       // swiperの読み込み
       if($options['show_index_slider'] ){
           
           wp_enqueue_style('swiper-style', get_template_directory_uri() . '/js/swiper-bundle.min.css', '', '1.0.0');
           wp_enqueue_script('swiper-script', get_template_directory_uri() . '/js/swiper-bundle.min.js', '', '1.0.0', true);

?>
<script type="text/javascript">
  
document.addEventListener('DOMContentLoaded', function() {
  
  let header_slider;
  let selector = document.getElementById('index_header_slider');
  let options = {
    loop: true,
    speed: 700,
    autoplay: {
      delay: 3000,
    },
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: 'true'
    },
  }
  header_slider = new Swiper(selector, options);
    
});
</script>
<?php
         }; // END $display_header_content
     }; // END front page

     // カスタムスクリプト--------------------------------------------
     if($options['script_code']) {
       echo $options['script_code']."\n";
     };
     if(is_single() || is_page()) {
       global $post;
       $custom_script = get_post_meta($post->ID, 'custom_script', true);
       if($custom_script) {
         echo $custom_script;
       };
     };// END カスタムスクリプト


     }; // END function tcd_head()
     add_action("wp_head", "tcd_head");
?>