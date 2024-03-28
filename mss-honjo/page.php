<?php
  get_header();
  $options = get_design_plus_option();

  $page_header_title = get_post_meta($post->ID, 'page_header_title', true);
  $page_header_image = get_post_meta($post->ID, 'page_header_image', true);
  $side_content_layout = get_post_meta($post->ID, 'side_content_layout', true) ?  get_post_meta($post->ID, 'side_content_layout', true) : 'type2';
  $page_content_type = get_post_meta($post->ID, 'page_content_type', true) ?  get_post_meta($post->ID, 'page_content_type', true) : 'type1';
  $wide_content = '';
  if( $side_content_layout == 'type1' && $page_content_type == 'type2'){
    $wide_content = ' wide_content';
  }

  $pageslug = get_post_field( 'post_name', get_the_ID() );
?>
<div class="content-wrap">
<div class="page-mv <?php echo $pageslug; ?>">
  <h1 class="page-title"><?php the_title(); ?></h1>
  <div class="page-title-en"><?php echo SCF::get('title-en'); ?></div>
</div>

<?php get_template_part('template-parts/breadcrumb'); ?>
<div id="main_contents" class="layout_<?php echo esc_attr($side_content_layout); ?><?php echo esc_attr($wide_content); ?>">
  <div id="main_col" class="lower_page<?php if($page_header_title)echo ' no_title'; ?>">
    <div class="article_top">
      <h2 class="title rich_font"><?php the_title(); ?></h2>
    </div>
    <div class="main_col_inner">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post();

          if(has_post_thumbnail() && !$page_header_image ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'size4' );
      ?>
      <div id="post_image" style="background:url(<?php echo esc_attr($image[0]); ?>) no-repeat center center; background-size:cover;"></div>
      <?php }; ?>

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

  <?php endwhile; endif; ?>

  </div>
</div><!-- END #main_col -->
<?php
  $args = array( 'post_type' => 'works', 'posts_per_page' => 3, 'ignore_sticky_posts' => 1, 'category_name' => $pageslug);
  $query = new WP_Query( $args );
  if ( $query->have_posts() ):
?>
<section class="section-works">
<div class="post_list_title">
    <h3 class="section-title rich_font"><span class="en">WORKS</span><span class="ja">施工事例</span></h3>
  </div>
<div>
    <div class="main_col_inner" <?php if(!$options['show_index_slider']){ echo "style='border:solid 1px #ddd;'"; } ?>>
      <div id="index_post_list">
        <div class="index_post_list_wrap bottom">
          <div class="post_list">
          <?php
          
            $count = 0;
            while( $query->have_posts() ) : $query->the_post(); $count++; // loop start
            if(has_post_thumbnail()) {
              if($count <= 1) { 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); 
              } else { 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); }
            } elseif($options['no_image1']) {
              $image = wp_get_attachment_image_src( $options['no_image1'], 'full' );
            } else {
              $image = array();
              $image[0] = esc_url(get_bloginfo('template_url')) . "/img/common/no_image2.gif";
            }
            $category = wp_get_post_terms( $post->ID, 'category' , array( 'orderby' => 'term_order' ));
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
                  <?php if ( $category && $options['index_post_list_show_category'] && ! is_wp_error($category) ) {
                    foreach ( $category as $cat ) :
                      $cat_name = $cat->name;
                      $cat_id = $cat->term_id;
                      $cat_url = get_term_link($cat_id,'category');
                  ?>
                      <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span>
                  <?php endforeach; ?>
                  <?php }; ?>
                  </p> 
                  <h4 class="title rich_font"><span><?php the_title_attribute(); ?></span></h4>
                  <?php if($count <= 1){ ?><p class="desc"><span><?php echo trim_excerpt(100); ?></span></p><?php }; ?>
                </div>
              </a>
            </article>
          <?php endwhile; wp_reset_postdata(); // END loop ?>
          </div><!-- END .post_list -->

        </div><!-- END .index_post_list_wrap -->
      </div><!-- END #index_post_list -->
    </div>
    <div class="btn-viewmore"><a href="<?php echo home_url().'/category/'.$pageslug; ?>">VIEW MORE</a></div>
  </div>
</section>
<?php endif; ?>

<?php
    // widget ------------------------
    if($side_content_layout != 'type1'){
        get_sidebar();
    }
?>

</div><!-- END #main_contents -->
  </div><!-- /.content-wrap -->
<?php
if(!is_page('contact')) :
  include "inc/inc_service.php";
endif;
?>

<?php get_footer(); ?>