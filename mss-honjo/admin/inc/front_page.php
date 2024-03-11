<?php
/*
 * トップページの設定
 */


// Add default values
add_filter( 'before_getting_design_plus_option', 'add_front_page_dp_default_options' );


// Add label of front page tab
add_action( 'tcd_tab_labels', 'add_front_page_tab_label' );


// Add HTML of front page tab
add_action( 'tcd_tab_panel', 'add_front_page_tab_panel' );


// Register sanitize function
add_filter( 'theme_options_validate', 'add_front_page_theme_options_validate' );


// タブの名前
function add_front_page_tab_label( $tab_labels ) {
	$tab_labels['front_page'] = __( 'Front page', 'tcd-w' );
	return $tab_labels;
}


// 初期値
function add_front_page_dp_default_options( $dp_default_options ) {

  // ヘッダーコンテンツ
  
  // スライダー共通
	$dp_default_options['show_index_slider'] = 1;
  $dp_default_options['index_slider_time'] = '7000';
  $dp_default_options['index_slider_type'] = 'type1';
  
  $dp_default_options['index_slider_use_overlay'] = 1;
	$dp_default_options['index_slider_overlay_color'] = '#000000';
	$dp_default_options['index_slider_overlay_opacity'] = '0.3';
  
  //記事スライダー
  $dp_default_options['index_slider_post_type'] = 'recommend_post';
  $dp_default_options['index_slider_post_order'] = 'recent';

  $dp_default_options['index_slider_post_num'] = '3';
  $dp_default_options['index_slider_title_font_size'] = '32';
	$dp_default_options['index_slider_title_font_size_mobile'] = '18';
	$dp_default_options['index_slider_show_date'] = '1';
	$dp_default_options['index_slider_show_category'] = '1';

	// 画像スライダー
	for ( $i = 1; $i <= 3; $i++ ) {
  $dp_default_options['index_slider_image'.$i] = 'false';
  $dp_default_options['index_slider_catch'.$i] = '';
	$dp_default_options['index_slider_image_url'.$i] = '';
	}
	
  // サイドコンテンツ
  $dp_default_options['index_sidebar'] = 'type2';
  
	// ページ下部の記事一覧
	$dp_default_options['show_index_left_post_list'] = 1;
	$dp_default_options['index_left_post_list_headline'] = __( 'Recent post', 'tcd-w' );
	
	$dp_default_options['show_index_right_post_list'] = 1;
	$dp_default_options['index_right_post_list_headline'] = __( 'Recommend post', 'tcd-w' );
	
  $dp_default_options['show_index_bottom_post_list'] = 1;
  $dp_default_options['index_bottom_post_list_headline'] = __( 'Recommend post2', 'tcd-w' );

	$dp_default_options['index_post_list_headline_font_size'] = '16';
	$dp_default_options['index_post_list_headline_font_size_mobile'] = '14';

	$dp_default_options['index_post_list_show_category'] = 1;
  $dp_default_options['index_post_list_show_date'] = 1;

	return $dp_default_options;

}

// 入力欄の出力 ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
function add_front_page_tab_panel( $options ) {

  global $dp_default_options, $item_type_options, $time_options, $layout_options;

?>

<div id="tab-content-front-page" class="tab-content">

   <?php // ヘッダーコンテンツの設定 ---------- ?>
   <!-- スライダー設定削除　-->


   <?php // サイドコンテンツの設定 ----------------------------------------------------- ?>
   <div class="theme_option_field cf theme_option_field_ac">
    <h3 class="theme_option_headline"><?php _e('Side content setting', 'tcd-w');  ?></h3>
    <div class="theme_option_field_ac_content">
      <div class="theme_option_message2"><p><?php _e('You can change the display position of the side content on the top page.', 'tcd-w');  ?></p></div>
     <select name="dp_options[index_sidebar]">
      <?php $i = 1; foreach ( $layout_options as $option ) { if($i == 2 || $i == 3) { ?>
      <option style="padding-right: 10px;" value="<?php echo esc_attr($option['value']); ?>" <?php selected( $options['index_sidebar'], $option['value'] ); ?>><?php echo $option['label']; ?></option>
      <?php }; $i++; }; ?>
     </select>
     <ul class="button_list cf">
      <li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></li>
      <li><a class="close_ac_content button-ml" href="#"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
     </ul>
    </div><!-- END .theme_option_field_ac_content -->
   </div><!-- END .theme_option_field -->



   <?php // ページ下部の記事一覧の設定 ----------------------------------------------------- ?>
   <div class="theme_option_field cf theme_option_field_ac">
    <h3 class="theme_option_headline"><?php _e('Post list setting', 'tcd-w');  ?></h3>
    <div class="theme_option_field_ac_content">
			
		 <div style="<?php //if($options['show_index_bottom_post_list'] == 1) { echo 'display:block;'; } else { echo 'display:none;'; }; ?>">
			<h4 class="theme_option_headline2"><?php _e('Recent post setting', 'tcd-w');  ?></h4>
      <ul class="option_list">
			 <li class="cf"><span class="label"><?php _e('Display recent post', 'tcd-w');  ?></span><input name="dp_options[show_index_left_post_list]" type="checkbox" value="1" <?php checked( $options['show_index_left_post_list'], 1 ); ?> /></li>
			 <li class="cf"><span class="label"><?php _e('Headline', 'tcd-w');  ?></span><input type="text" class="full_width" name="dp_options[index_left_post_list_headline]" value="<?php echo esc_attr($options['index_left_post_list_headline']); ?>"></li>
			</ul>
			<h4 class="theme_option_headline2"><?php _e('Recommend post setting', 'tcd-w');  ?></h4>
			<ul class="option_list">
			 <li class="cf"><span class="label"><?php _e('Display recommend post', 'tcd-w');  ?></span><input name="dp_options[show_index_right_post_list]" type="checkbox" value="1" <?php checked( $options['show_index_right_post_list'], 1 ); ?> /></li>
			 <li class="cf"><span class="label"><?php _e('Headline', 'tcd-w');  ?></span><input type="text" class="full_width" name="dp_options[index_right_post_list_headline]" value="<?php echo esc_attr($options['index_right_post_list_headline']); ?>"></li>
			</ul>
			<h4 class="theme_option_headline2"><?php _e('Recommend post2 setting', 'tcd-w');  ?></h4>
			<ul class="option_list">			
			 <li class="cf"><span class="label"><?php _e('Display recommend post2', 'tcd-w');  ?></span><input name="dp_options[show_index_bottom_post_list]" type="checkbox" value="1" <?php checked( $options['show_index_bottom_post_list'], 1 ); ?> /></li>
			 <li class="cf"><span class="label"><?php _e('Headline', 'tcd-w');  ?></span><input type="text" class="full_width" name="dp_options[index_bottom_post_list_headline]" value="<?php echo esc_attr($options['index_bottom_post_list_headline']); ?>"></li>
		  </ul>
		  <h4 class="theme_option_headline2"><?php _e('Common setting', 'tcd-w');  ?></h4>
			<ul class="option_list">

       <li class="cf"><span class="label"><?php _e('Font size of headline', 'tcd-w'); ?></span><input class="font_size hankaku" type="text" name="dp_options[index_post_list_headline_font_size]" value="<?php esc_attr_e( $options['index_post_list_headline_font_size'] ); ?>" /><span>px</span></li>
       <li class="cf"><span class="label"><?php _e('Font size of headline (mobile)', 'tcd-w'); ?></span><input class="font_size hankaku" type="text" name="dp_options[index_post_list_headline_font_size_mobile]" value="<?php esc_attr_e( $options['index_post_list_headline_font_size_mobile'] ); ?>" /><span>px</span></li>
       
       <li class="cf"><span class="label"><?php _e('Display date', 'tcd-w');  ?></span><input name="dp_options[index_post_list_show_date]" type="checkbox" value="1" <?php checked( '1', $options['index_post_list_show_date'] ); ?> /></li>
       <li class="cf"><span class="label"><?php _e('Display category', 'tcd-w');  ?></span><input name="dp_options[index_post_list_show_category]" type="checkbox" value="1" <?php checked( '1', $options['index_post_list_show_category'] ); ?> /></li>
      </ul>
     </div>
     <ul class="button_list cf">
      <li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></li>
      <li><a class="close_ac_content button-ml" href="#"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
     </ul>
    </div><!-- END .theme_option_field_ac_content -->
   </div><!-- END .theme_option_field -->


</div><!-- END .tab-content -->

<?php
} // END add_front_page_tab_panel()


// バリデーション ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
function add_front_page_theme_options_validate( $input ) {

  global $dp_default_options, $item_type_options, $time_options;

  // スライダーの基本設定
  $input['show_index_slider'] = ! empty( $input['show_index_slider'] ) ? 1 : 0;
  if ( ! isset( $value['index_slider_time'] ) )
    $value['index_slider_time'] = null;
  if ( ! array_key_exists( $value['index_slider_time'], $time_options ) )
    $value['index_slider_time'] = null;

  // スライダーのタイプ
  $input['index_slider_type'] = wp_filter_nohtml_kses( $input['index_slider_type'] );


  // 記事スライダー
  $input['index_slider_post_type'] = wp_filter_nohtml_kses( $input['index_slider_post_type'] );
  $input['index_slider_post_order'] = wp_filter_nohtml_kses( $input['index_slider_post_order'] );

  $input['index_slider_post_num'] = wp_filter_nohtml_kses( $input['index_slider_post_num'] );
  $input['index_slider_show_date'] = ! empty( $input['index_slider_show_date'] ) ? 1 : 0;
  $input['index_slider_show_category'] = ! empty( $input['index_slider_show_category'] ) ? 1 : 0;

  $input['index_slider_title_font_size'] = wp_filter_nohtml_kses( $input['index_slider_title_font_size'] );
  $input['index_slider_title_font_size_mobile'] = wp_filter_nohtml_kses( $input['index_slider_title_font_size_mobile'] );
  
  // 画像スライダー
	for ( $i = 1; $i <= 3; $i++ ) {
  $input['index_slider_image'.$i] = wp_filter_nohtml_kses( $input['index_slider_image'.$i] );
  $input['index_slider_catch'.$i] = wp_filter_nohtml_kses( $input['index_slider_catch'.$i] );
	$input['index_slider_image_url'.$i] = wp_filter_nohtml_kses( $input['index_slider_image_url'.$i] );
  }
  
  // オーバーレイ
  if ( ! isset( $input['index_slider_use_overlay'] ) )
    $input['index_slider_use_overlay'] = null;
    $input['index_slider_use_overlay'] = ( $input['index_slider_use_overlay'] == 1 ? 1 : 0 );
    $input['index_slider_overlay_color'] = wp_filter_nohtml_kses( $input['index_slider_overlay_color'] );
    $input['index_slider_overlay_opacity'] = wp_filter_nohtml_kses( $input['index_slider_overlay_opacity'] );

  // サイドコンテンツ
  $input['index_sidebar'] = wp_kses_post( $input['index_sidebar'] );


  // ページ下部の記事一覧
  // 左上
	$input['show_index_left_post_list'] = ! empty( $input['show_index_left_post_list'] ) ? 1 : 0;
	$input['index_left_post_list_headline'] = wp_filter_nohtml_kses( $input['index_left_post_list_headline'] );
  
  // 右上
	$input['show_index_right_post_list'] = ! empty( $input['show_index_right_post_list'] ) ? 1 : 0;
	$input['index_right_post_list_headline'] = wp_filter_nohtml_kses( $input['index_right_post_list_headline'] );
  
  // 下
  $input['show_index_bottom_post_list'] = ! empty( $input['show_index_bottom_post_list'] ) ? 1 : 0;
  $input['index_bottom_post_list_headline'] = wp_filter_nohtml_kses( $input['index_bottom_post_list_headline'] );

  // 共通設定
  $input['index_post_list_headline_font_size'] = wp_filter_nohtml_kses( $input['index_post_list_headline_font_size'] );
  $input['index_post_list_headline_font_size_mobile'] = wp_filter_nohtml_kses( $input['index_post_list_headline_font_size_mobile'] );
  $input['index_post_list_show_category'] = ! empty( $input['index_post_list_show_category'] ) ? 1 : 0;
  $input['index_post_list_show_date'] = ! empty( $input['index_post_list_show_date'] ) ? 1 : 0;

  return $input;

};