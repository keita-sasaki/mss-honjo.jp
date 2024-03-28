<?php
    get_header();
    $options = get_design_plus_option();

    if (is_category()) {
      $query_obj = get_queried_object();
      $current_cat_id = $query_obj->term_id;
      $term_meta = get_option( 'taxonomy_' . $current_cat_id, array() );
      $title = $query_obj->name;

    } elseif(is_tag()) {
      $query_obj = get_queried_object();
      $title = $query_obj->name;

    } elseif(is_author()) {
      $author_info = $wp_query->get_queried_object();
      $author_id = $author_info->ID;
      $title = get_userdata($author_id)->display_name;

    } elseif (is_search()) {
      if( !empty( get_search_query() ) ) {
        $title = sprintf( __( 'Search result for %s', 'tcd-w' ), get_search_query() );
      } else {
        $title = __( 'Search result', 'tcd-w' );
      }

    } else {
      $title = get_the_title( get_option( 'page_for_posts' ));
    }
?>

<?php
if(is_post_type_archive()) {
    $slug = 'news';
    $name = 'お知らせ';
  } else {
    $obj = get_post_type_object(get_post_type());
    $slug = $obj->rewrite['slug'];
    $name = $obj->labels->name;
  }
?>
<div class="content-wrap">
<div class="page-mv <?php echo $slug; ?>">
  <h1 class="page-title"><?php echo $name; ?></h1>
  <div class="page-title-en"><?php echo strtoupper($slug); ?></div>
</div>

<div id="main_contents" class="layout_type1 wide_content">

  <div id="main_col" class="archive_page">
  <?php get_template_part('template-parts/breadcrumb'); ?>

  <?php
  if(is_category()) :
    $term = get_queried_object();
    $slug = 'category';
    $name = $term->name;
    ?>
  <div class="post_list_title">
    <h3 class="section-title rich_font"><span class="en"><?php echo strtoupper($slug); ?></span><span class="ja"><?php echo $name; ?></span></h3>
  </div>
  <?php endif; ?>
    <div class="main_col_inner">

    <?php if ( have_posts() ) : ?>

      <div id="index_post_list">
        <div class="index_post_list_wrap bottom">
          <div class="post_list">
      <?php
          while ( have_posts() ) : the_post();
            if(has_post_thumbnail()) {
              $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
            } elseif($options['no_image1']) {
              $image = wp_get_attachment_image_src( $options['no_image1'], 'full' );
            } else {
              $image = array();
              $image[0] = esc_url(get_bloginfo('template_url')) . "/img/common/no_image2.gif";
            }
            
            $category = wp_get_post_terms( $post->ID, 'category' , array( 'orderby' => 'term_order' ));
            $terms = get_the_terms($post->ID, 'cat-news');
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
              <span class="date"><time class="entry-date updated"><?php the_time('Y.m.d'); ?></time></span>
              <?php
                if ( $category && $options['index_post_list_show_category'] && ! is_wp_error($category) ) {
                foreach ( $category as $cat ) :
                  $cat_name = $cat->name;
                  $cat_id = $cat->term_id;
                  $cat_url = get_term_link($cat_id,'category');
              ?>
                  <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span>
              <?php endforeach; ?>
              <?php }; ?>
              <?php if ( $terms && ! is_wp_error($terms) ) { ?>
              <span class="category cat_id<?php echo esc_attr($cat_id); ?>" data-href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></span>
              <?php } ?>
              </p>
              <h4 class="title rich_font"><span><?php the_title_attribute(); ?></span></h4>
              <p class="desc"><span><?php echo trim_excerpt(100); ?></span></p>
            </div>
          </a>
        </article>
      <?php endwhile; ?>
      </div><!-- END .post_list -->

</div><!-- END .index_post_list_wrap -->
</div><!-- END #index_post_list -->
      <?php
          get_template_part('template-parts/navigation'); 
          else: // if no post
      ?>
      <p id="no_post"><?php _e('There is no registered post.', 'tcd-w');  ?></p>
      <?php endif; ?>
    </div><!-- END .main_col_inner -->
  </div><!-- END #main_col -->
  </div><!-- /.content-wrap -->
  <?php
      // widget
      #get_sidebar();
  ?>

</div><!-- END #main_contents -->
<?php get_footer(); ?>