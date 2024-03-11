<?php
    $options = get_design_plus_option();
    get_header();

    $show_left_post_list = $options['show_index_left_post_list'];
    $show_right_post_list = $options['show_index_right_post_list'];
    $show_bottom_post_list = $options['show_index_bottom_post_list'];

    
?>

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
          $post_num = 5; // pc
        }
        
        for($i = 1; $i <= 3; $i++): // index_post_list_wrap

        if($i == 1) { 
          if($show_left_post_list) {
          $args = array( 'post_type' => 'news', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, );
          $post_title = wp_kses_post(nl2br($options['index_left_post_list_headline']));
          } else { continue; }

        } elseif($i == 2) {

          if($show_right_post_list) {
          $args = array( 'post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, 'meta_key' => 'recommend_post', 'meta_value' => 'on' );
          $post_title = wp_kses_post(nl2br($options['index_right_post_list_headline']));
          } else { continue; }

        } elseif($i == 3) {

          if($show_bottom_post_list) {
          $args = array( 'post_type' => 'post', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1, 'meta_key' => 'recommend_post2', 'meta_value' => 'on' );
          $post_title = wp_kses_post(nl2br($options['index_bottom_post_list_headline']));
          } else { continue; }

        }

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
            $terms = get_the_terms($query->post->ID, 'cat-news');
            if ( $terms && ! is_wp_error($terms) ) {
              $cat_name = $terms[0]->name;
              $cat_id = $terms[0]->term_taxonomy_id;
              $cat_url = get_term_link($cat_id,'cat-news');
            }
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
        <?php endfor; ?>
      </div><!-- END #index_post_list -->
      <div class="btn-viewmore"><a href="<?php echo home_url(); ?>/news">VIEW MORE</a></div>
    </div>
  </div><!-- END #main_col -->
  <?php
      // widget ------------------------
      get_sidebar();
  ?>
</div><!-- END #main_contents -->

<?php include "inc/inc_service.php"; ?>

<section id="company" class="section-company">
  <div class="post_list_title">
    <h3 class="section-title rich_font"><span class="en">COMPANY</span><span class="ja">会社概要</span></h3>
  </div>
  <div class="company-message">
    <h4 class="section-inner-title">代表あいさつ</h4>
    <div class="imgontext-bg">
      <p class="imgontext-text">
      平素は格別のお引き立てを賜り、誠にありがとうございます。<br>
      令和5年5月に創業しました、花菱リフォームと申します。<br>
      花菱という言葉には、「高貴」「上品」という意味があり、リフォームを検討されるお客様に「より美しく」を経営理念として従事させて頂いております。<br>
      多様化する現代の中で、「どこに相談したらいいのか？」「何を選んだらいいのか？」に迅速に応えられるように努めさせて頂きます。<br>
      さらに、地域社会に貢献できる企業組織を目指し、たゆまぬ努力を続けてまいります。<br>
      今後とも皆様のご愛顧の程、よろしくお願いいたします。<br><br>
      <span class="written">代表 原田優輝</span></p>
    </div>
  </div>
  <div class="company-detail">
    <h4 class="section-inner-title">会社概要</h4>
    <table>
      <tr>
        <th>会社名</th>
        <td>花菱リフォーム</td>
      </tr>
      <tr>
        <th>住　所</th>
        <td>秋田県潟上市天王字上北野4-603</td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td>018-811-4996</td>
      </tr>
      <tr>
        <th>設　立</th>
        <td>2023年5月</td>
      </tr>
      <tr>
        <th>代表者名</th>
        <td>原田　優輝</td>
      </tr>
      <tr>
        <th>事業内容</th>
        <td>住宅リフォーム</td>
      </tr>
      <tr>
        <th>保有資格</th>
        <td>石綿作業主任者<br>石綿含有調査者<br>二等無人航空機操縦士<br>ドローン認定スクール講師</td>
      </tr>
    </table>
  </div>
</section>

<section id="map" class="section-map">
<iframe src="https://maps.google.co.jp/maps?output=embed&q=39.819493,140.048218&z=16" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>
<?php get_footer(); ?>