<?php
    get_header();
    $options = get_design_plus_option();
    $side_content_layout = get_post_meta($post->ID, 'side_content_layout', true) ?  get_post_meta($post->ID, 'side_content_layout', true) : 'type0';

    $obj = get_post_type_object(get_post_type());
    $slug = $obj->rewrite['slug'];
    if($slug == 'post') { $slug = 'NEWS';}
?>
<div class="content-wrap">
<div class="page-mv <?php echo $slug; ?>">
  <h1 class="page-title"><?php echo $obj->labels->name; ?></h1>
  <div class="page-title-en"><?php echo strtoupper($slug); ?></div>
</div>

<div id="main_contents" class="layout_type1 wide_content">
  <div id="main_col" class="lower_page">

    <?php
    if ( have_posts() ) : while ( have_posts() ) : the_post();
      if($slug == 'news') {
        $category = get_the_terms($post->ID, 'cat-news');
        $taxonomy = 'cat-news';
      } else {
        $category = get_the_category();
        $taxonomy = 'category';
      }
    ?>
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <div class="main_col_inner">
      <article id="article">
      <?php #$text_field = get_field('time'); echo $text_field; ?> 
        <?php if($page == '1') { // ***** only show on first page ***** ?>

        <div id="post_title">
          <h2 class="title entry-title rich_font"><?php the_title(); ?></h2>
          <ul class="meta_top">
            <?php if ( $options['single_blog_show_date']){ ?>
            <li class="date"><time class="entry-date published" datetime="<?php the_modified_time('c'); ?>"><?php the_time('Y.m.d'); ?></time></li>
              <?php if ( $options['single_blog_show_update']){ ?>
              <li class="update"><time class="entry-date updated" datetime="<?php the_modified_time('c'); ?>"><?php the_modified_date('Y.m.d'); ?></time></li>
          <?php }; }; ?>
            <?php if ($options['single_blog_show_meta_tag']){ the_tags('<li class="post_tag">',' ','</li>'); } ?>
          </ul>
          <?php if ( $category && $options['index_post_list_show_category'] && !is_wp_error($category) ) { ?>
          <?php
          foreach ( $category as $cat ) :
            $cat_name = $cat->name;
            $cat_id = $cat->term_id;
            $cat_url = get_term_link($cat_id, $taxonomy);
          ?>
          <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span>
          <?php endforeach; }; ?>
        </div>

        <?php
            if(has_post_thumbnail()) {
              $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'size6' );
        ?>
        <!-- <div id="post_image" style="background:url(<?php echo esc_attr($image[0]); ?>) no-repeat center center; background-size:cover;"></div> -->
        <?php }; ?>

        <?php
            // sns button top ------------------------------------------------------------------------------------------------------------------------
            if($options['single_blog_show_sns_top']) {
        ?>
        <div class="single_share clearfix" id="single_share_top">
        <?php get_template_part('template-parts/sns-btn-top'); ?>
        </div>
        <?php }; ?>

        <?php }; // ***** END only show on first page ***** 

        // post content ------------------------------------------------------------------------------------------------------------------------ 
        ?>
        <div class="post_content clearfix">
        <?php if(!empty($post->post_content)) : ?>
          <div class="content-item"><?php the_content(); ?></div>
        <?php endif; ?>

        <?php
        if(is_singular('works')) :
          $works_item = SCF::get('works-item');
          if(!empty($works_item[0])) :
          foreach($works_item as $item) :
            $before = $item['img-before'];
            $after = $item['img-after'];
            $comment = $item['works-comment'];
        ?>
        <div class="works-item">
          <?php if($before != '') { ?>
          <div class="works-img-before">
            <p>BEFORE</p>
            <div><img src=<?php echo wp_get_attachment_url($before, 'medium'); ?>></div>
          </div>
          <?php } ?>
          <?php if($after != '') { ?>
          <div class="works-img-after">
            <p>AFTER</p>
            <div><img src=<?php echo wp_get_attachment_url($after, 'medium'); ?>></div>
          </div>
          <?php } ?>
        </div>
        <p class="works-comment"><?php echo nl2br($comment); ?></p>
        <?php
          endforeach;
          endif;
        endif;

          //  if ( ! post_password_required() ) {
            //  $pagenation_type = get_post_meta($post->ID, 'pagenation_type', true);
            //  if($pagenation_type == 'type3') {
            //    $pagenation_type = $options['pagenation_type'];
            //  };
            //  if ( $pagenation_type == 'type2' ) {
            //    if ( $page < $numpages && preg_match( '/href="(.*?)"/', _wp_link_page( $page + 1 ), $matches ) ) :
        ?>
        <!-- <div id="p_readmore">
        <a class="button" href="<?php //echo esc_url( $matches[1] ); ?>#article"><?php //_e( 'Read more', 'tcd-w' ); ?></a>
        <p class="num"><?php //echo $page . ' / ' . $numpages; ?></p>
        </div> -->
        <?php
              //  endif;
            //  } else {
            custom_wp_link_pages();
            //}
          //}
        ?>
        </div>

        <?php
            // sns button ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            if($options['single_blog_show_sns_btm']) {
        ?>
        <div class="single_share clearfix" id="single_share_bottom">
        <?php get_template_part('template-parts/sns-btn-btm'); ?>
        </div>
        <?php }; ?>

        <?php
            // copy title&url button ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            if($options['single_blog_show_copy_btm']) {
        ?>
        <div class="single_copy_title_url" id="single_copy_title_url_bottom">
          <button class="single_copy_title_url_btn" data-clipboard-text="<?php echo esc_attr( strip_tags( get_the_title() ) . ' ' . get_permalink() ); ?>" data-clipboard-copied="<?php echo esc_attr( __( 'COPIED Title&amp;URL', 'tcd-w' ) ); ?>"><?php _e( 'COPY Title&amp;URL', 'tcd-w' ); ?></button>
        </div>
        <?php }; ?>

        <div id="next_prev_post">
        <?php next_prev_post_link(); ?>
        </div>

      </article><!-- END #article -->

      <?php 
          endwhile; endif; 

          $categories = get_the_category($post->ID);
          if ($categories) {
            $post_num = 4;
            if(is_mobile()){
              $post_num = 4;
            }
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
            $args = array( 'post_type' => array('post','works'), 'category__in' => $category_ids, 'post__not_in' => array($post->ID), 'showposts'=> $post_num, 'orderby' => 'rand');
            $related_post_list = new WP_Query($args);
            if($related_post_list->have_posts()):
      ?>
      <div id="related_post">
        <!-- <h3 class="design_headline1 rich_font"><span><?php _e('Related post', 'tcd-w'); ?></span></h3> -->
        <h3 class="widget_headline"><span><?php _e('Related post', 'tcd-w'); ?></span></h3>
        <div class="post_list">
          <?php
              while( $related_post_list->have_posts() ) : $related_post_list->the_post();
                if(has_post_thumbnail()) {
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'size2' );
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
            <a class="animate_background" href="<?php the_permalink(); ?>">
              <div class="image_outer">
              <div class="image_wrap">
                <div class="image" style="background:url(<?php echo esc_attr($image[0]); ?>) no-repeat center center; background-size:cover;"></div>
              </div>
              </div>
              <div class="title_area">
                <p class="meta">
                  <span class="date"><time class="entry-date updated"><?php the_time('Y.m.d'); ?></time></span>
                  <?php if ( $category && $options['index_post_list_show_category'] && ! is_wp_error($category) ) { ?>
                  <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span>
                  <?php }; ?>
                </p>
                <h4 class="title"><span><?php the_title(); ?></span></h4>
              </div>
            </a>
          </article>
          <?php endwhile; wp_reset_query(); ?>
        </div><!-- END .post_list -->
        <?php
        if(is_singular('news')) {

        }
        ?>
        <div class="btn-viewmore"><a href="<?php echo $cat_url; ?>">VIEW MORE</a></div>
      </div><!-- END #related_post -->
    <?php
            endif;
        };

        // comment ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($options['single_blog_show_comment'] || $options['single_blog_show_trackback']) { comments_template('', true); };
    ?>
    </div><!-- END .main_col_inner -->
  </div><!-- END #main_col -->
  </div><!-- /.content-wrap -->
  <?php
      // widget ------------------------
      #get_sidebar();
  ?>

</div><!-- END #main_contents -->
<?php get_footer(); ?>