<?php
    get_header();
?>

<div class="page-mv">
  <h1 class="page-title"><?php the_title(); ?></h1>
  <div class="page-title-en"></div>
</div>

<?php get_template_part('template-parts/breadcrumb'); ?>
<section class="page-text">
  <article id="article">

  <?php // post content ------------------------------------------------------------------------------------------------------------------------ ?>
  <div class="post_content clearfix">
    <?php
        the_content();
        if ( ! post_password_required() ) {
          $pagenation_type = get_post_meta($post->ID, 'pagenation_type', true);
          if($pagenation_type == 'type3') {
          $pagenation_type = $options['pagenation_type'];
          };
          if ( $pagenation_type == 'type2' ) {
            if ( $page < $numpages && preg_match( '/href="(.*?)"/', _wp_link_page( $page + 1 ), $matches ) ) :
    ?>
    <div id="p_readmore">
      <a class="button" href="<?php echo esc_url( $matches[1] ); ?>#article"><?php _e( 'Read more', 'tcd-w' ); ?></a>
      <p class="num"><?php echo $page . ' / ' . $numpages; ?></p>
    </div>
    <?php
            endif;
          } else {
            custom_wp_link_pages();
        }
      }
  ?>
    </div>
  </article>
</section>

<section class="section-works">
<div class="post_list_title">
    <h3 class="design_headline1 rich_font"><span>COMPANY</span><br>会社概要</h3>
  </div>
<div id="main_col" class="no_title">
    <div class="main_col_inner" <?php if(!$options['show_index_slider']){ echo "style='border:solid 1px #ddd;'"; } ?>>
      <div id="index_post_list">
      <?php
  $args = array( 'post_type' => 'post','works', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1, );
  $query = new WP_Query( $args );
  if ( $query->have_posts() ):
?>
        <div class="index_post_list_wrap bottom">
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
                  <?php if ( $category && $options['index_post_list_show_category'] && ! is_wp_error($category) ) { ?>
                  <!-- <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span> -->
                  <?php }; ?>
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

        </div><!-- END .index_post_list_wrap -->
        <?php endif; ?>
      </div><!-- END #index_post_list -->
    </div>
  </div><!-- END #main_col -->
</section>

<?php get_footer(); ?>