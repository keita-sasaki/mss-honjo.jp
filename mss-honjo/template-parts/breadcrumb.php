<?php
     $options = get_design_plus_option();
     global $post;
     //if( $options['single_blog_show_category'] ){
?>
<div id="bread_crumb">
 <ul class="clearfix" itemscope itemtype="http://schema.org/BreadcrumbList">
 <?php
      // Search -----------------------
      if(is_search()) {
 ?>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
 <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php _e('Search result','tcd-w'); ?></span><meta itemprop="position" content="2"></li>
 <?php
      // Blog page -----------------------
      } elseif(is_home()) {
 ?>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
 <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php echo esc_html($options['blog_label']); ?></span><meta itemprop="position" content="2"></li>
 <?php
      //Tag , Archive page -----------------------
      } elseif( is_tag() || is_day() || is_month() || is_year()) {
        if( is_tag() ) {
          $title = single_tag_title('', false);
        } elseif (is_day()) {
          $title = sprintf(__('Archive for %s', 'tcd-w'), get_the_time(__('F jS, Y', 'tcd-w')) );
        } elseif (is_month()) {
          $title = sprintf(__('Archive for %s', 'tcd-w'), get_the_time(__('F, Y', 'tcd-w')) );
        } elseif (is_year()) {
          $title = sprintf(__('Archive for %s', 'tcd-w'), get_the_time(__('Y', 'tcd-w')) );
        }
 ?>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><span itemprop="name"><?php echo esc_html($options['blog_label']); ?></span></a><meta itemprop="position" content="2"></li>
 <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php echo esc_html($title); ?></span><meta itemprop="position" content="3"></li>
 <?php
    } elseif (is_category()) {
      $term = get_queried_object();
      $title = $term->name;
?>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
 <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php echo esc_html($title); ?></span><meta itemprop="position" content="3"></li>
 <?php
      //  Page -----------------------
      } elseif(is_page()) {
 ?>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
 <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php the_title_attribute(); ?></span><meta itemprop="position" content="3"></li>
 <?php
    } elseif (is_single()) {
      $obj = get_post_type_object(get_post_type());
      $title = $obj->labels->name;
      $slug = $obj->rewrite['slug'];
      if($slug == 'post') { $slug = 'column';}
?>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo esc_url(home_url('/')).$slug; ?>"><span itemprop="name"><?php echo esc_html($title); ?></span></a><meta itemprop="position" content="2"></li>
 <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php the_title(); ?></span><meta itemprop="position" content="3"></li>
<?php
    } elseif(is_post_type_archive()) {
     $obj = get_post_type_object(get_post_type());
     $title = $obj->labels->name;

   ?>
   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
   <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php echo esc_html($title); ?></span><meta itemprop="position" content="2"></li>
   <?php
    } elseif(is_tax('cat-news')) {
     $obj = get_post_type_object(get_post_type());
     $title = $obj->labels->name;

   ?>
   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo esc_url(home_url()); ?>/news"><span itemprop="name">お知らせ</span></a><meta itemprop="position" content="2"></li>
   <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php single_term_title(); ?></span><meta itemprop="position" content="3"></li>

   <?php
      // Other page -----------------------
      } else {
      $category = get_the_category();
 ?>
 <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="home"><a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>"><span itemprop="name"><?php _e('Home', 'tcd-w'); ?></span></a><meta itemprop="position" content="1"></li>
 <!-- <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><span itemprop="name"><?php echo get_the_title( get_option( 'page_for_posts' )); ?></span></a><meta itemprop="position" content="2"></li> -->
 <?php if($category) { ?>
 <li class="category" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
  <?php
       $count=1;
       foreach ($category as $cat) {
  ?>
  <a itemprop="item" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><span itemprop="name"><?php echo esc_html($cat->name); ?></span></a>
  <?php $count++; } ?>
  <meta itemprop="position" content="3">
 </li>
 <?php }; ?>
 <li class="last" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"><?php the_title_attribute(); ?></span><meta itemprop="position" content="4"></li>
 <?php }; ?>
 </ul>
</div>
<?php //} ?>
