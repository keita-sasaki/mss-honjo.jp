<?php
    $options = get_design_plus_option();
    get_header();

    $show_left_post_list = $options['show_index_left_post_list'];
    $show_right_post_list = $options['show_index_right_post_list'];
    $show_bottom_post_list = $options['show_index_bottom_post_list'];

    
?>
<div class="home-wrap">
<div class="firstview">
  <div class="firstview-text">
    <h2 class="firstview-text-head">キャッチコピーが入ります。</h2>
    <div class="firstview-text-content">説明が入ります。説明が入ります。説明が入ります。説明が入ります。説明が入ります。</div>
  </div>
</div>
<section class="section-about">
  <div class="post_list_title">
    <h3 class="section-title rich_font"><span class="en">ABOUT US</span><span class="ja">私たちについて</span></h3>
    <div class="about-item">
      <div class="about-item-img"><img src="<?php echo get_template_directory_uri(); ?>/img/about-aisatu.jpg" alt=""></div>
      <div class="about-item-text">
        <h4>代表あいさつ</h4>
        <p>
        基本テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト基本テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
        </p>
      </div>
    </div>
    <div class="about-item">
      <div class="about-item-img"><img src="<?php echo get_template_directory_uri(); ?>/img/about-tokutyo.jpg" alt=""></div>
      <div class="about-item-text">
        <h4>当院の特徴</h4>
        <p>
        基本テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト基本テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
        </p>
      </div>
    </div>
  </div>
  <div></div>
</section>
<?php include "inc/inc_service.php"; ?>
<section class="section-news">
  <div class="post_list_title">
      <h3 class="section-title rich_font"><span class="en">NEWS</span><span class="ja">お知らせ</span></h3>
  </div>
  <div id="main_contents" class="layout_<?php echo esc_attr($options['index_sidebar']); ?>">
    <div id="main_col" class="no_title">
      <div class="main_col_inner" <?php if(!$options['show_index_slider']){ echo "style='border:solid 1px #ddd;'"; } ?>>
        <div id="index_post_list">
        <?php

          if(is_mobile()){ // Number of articles
            $post_num = 3; // sp
          } else {
            $post_num = 3; // pc
          }
          
          #for($i = 1; $i <= 3; $i++): // index_post_list_wrap

          #if($i == 1) { 
            if($show_left_post_list) {
            $args = array( 'post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, );
            $post_title = wp_kses_post(nl2br($options['index_left_post_list_headline']));
            } //else { continue; }

          /* } elseif($i == 2) {

            if($show_right_post_list) {
            $args = array( 'post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, 'meta_key' => 'recommend_post', 'meta_value' => 'on' );
            $post_title = wp_kses_post(nl2br($options['index_right_post_list_headline']));
            } else { continue; }

          } elseif($i == 3) {

            if($show_bottom_post_list) {
            $args = array( 'post_type' => 'post', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1, 'meta_key' => 'recommend_post2', 'meta_value' => 'on' );
            $post_title = wp_kses_post(nl2br($options['index_bottom_post_list_headline']));
            } else { continue; }

          } */

        ?>
          <div class="index_post_list_wrap bottom">
            <?php

              $query = new WP_Query( $args );
              if ( $query->have_posts() ):
            
            ?>
            <div class="post_list">
            <?php
            
              $count = 0;
              while( $query->have_posts() ) : $query->the_post(); $count++; // loop start
              if(has_post_thumbnail()) {
                if($count <= 1) { 
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'size3' ); 
                } else { 
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'size1' ); }
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
              <article class="item">
                <a class="link animate_background clearfix" href="<?php the_permalink(); ?>">
                  <div class="image_outer">
                  <div class="image_wrap">
                    <div class="image" style="background:url(<?php echo esc_attr($image[0]); ?>) no-repeat center center; background-size:cover;"></div>
                  </div>
                  </div>
                  <div class="title_area">
                    <p class="meta">
                    <?php if($options['index_post_list_show_date']) { ?>
                    <span class="date"><time class="entry-date updated"><?php the_time('Y.m.d'); ?></time></span><?php }; ?>
                    <?php #if ( $category && $options['index_post_list_show_category'] && ! is_wp_error($category) ) { ?>
                    <!-- <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span> -->
                    <?php #}; ?>
                    <?php if ( $terms && ! is_wp_error($terms) ) { ?>
                    <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span>
                    <?php } ?>
                    </p> 
                    <h4 class="title rich_font"><span><?php the_title_attribute(); ?></span></h4>
                    <?php if($count <= 1){ ?><p class="desc"><span><?php echo trim_excerpt(100); ?></span></p><?php }; ?>
                  </div>
                </a>
              </article>
            <?php endwhile; wp_reset_postdata(); // END loop ?>
            </div><!-- END .post_list -->
            <?php 
              else: // if no post            
            ?>
            <div class="no_post">
              <p><?php _e("There is no registered post.","tcd-w"); ?></p>
            </div>
            <?php endif; ?>
          </div><!-- END .index_post_list_wrap -->
          <?php #endfor; ?>
        </div><!-- END #index_post_list -->
        <div class="btn-viewmore"><a href="<?php echo home_url(); ?>/news">VIEW MORE</a></div>
      </div>
    </div><!-- END #main_col -->
    <?php
        // widget ------------------------
        #get_sidebar();
    ?>
  </div><!-- END #main_contents -->
</section>

<section id="company" class="section-company">
  <div class="post_list_title">
    <h3 class="section-title rich_font"><span class="en">ACCESS</span><span class="ja">アクセス</span></h3>
  </div>
  <div class="company-img">
    <img src="<?php echo get_template_directory_uri(); ?>/img/company-img.jpg" alt="">
  </div>
  <div class="company-detail">
     <!-- <h4 class="section-inner-title">会社概要</h4> -->
    <table>
      <tr>
        <th>会社名</th>
        <td>まさきスポーツ鍼灸治療院</td>
      </tr>
      <tr>
        <th>住所</th>
        <td>秋田県由利本荘市薬師堂中道127</td>
      </tr>
      <tr>
        <th>電話</th>
        <td>000-0000-0000</td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td>info@mail.address.com</td>
      </tr>
    </table>
  </div>
</section>

<section id="map" class="section-map">
<iframe src="https://maps.google.co.jp/maps?output=embed&q=秋田県由利本荘市薬師堂中道127&z=16" width="800" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>
</div><!-- /.home-wrap -->
<?php get_footer(); ?>