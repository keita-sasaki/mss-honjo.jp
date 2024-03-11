<?php
//デフォルトの投稿のラベルを変更
function change_post_menu_label() {
  global $menu;
  global $submenu;
  $menu[5][0] = 'コラム';
  $submenu['edit.php'][5][0] = 'コラム一覧';
  $submenu['edit.php'][10][0] = '新しいコラム';
  $submenu['edit.php'][16][0] = 'タグ';
}

function change_post_object_label() {
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name = 'コラム';
  $labels->singular_name = 'コラム';
  $labels->add_new = _x('追加', 'コラム');
  $labels->add_new_item = 'コラムの新規追加';
  $labels->edit_item = 'コラムの編集';
  $labels->new_item = '新規コラム';
  $labels->view_item = 'コラムを表示';
  $labels->search_items = 'コラムを検索';
  $labels->not_found = '記事が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に記事は見つかりませんでした';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

//カスタム投稿追加
function create_post_type() {
  register_post_type( 'news', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => 'お知らせ', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'お知らせ',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 5,     // 管理画面上での配置場所
    'supports' => array('title', 'editor', 'thumbnail'), //アイキャッチ画像対応
    'rewrite' => array('with_front' => false,),
    'show_in_rest'  => true,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
  ]);
  register_post_type( 'works', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => '施工事例', // 管理画面上で表示する投稿タイプ名
      'singular_name' => '施工事例',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 5,     // 管理画面上での配置場所
    'supports' => array('title', 'editor', 'thumbnail'), //アイキャッチ画像対応
    'rewrite' => array('with_front' => false,),
    'show_in_rest'  => true,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
  ]);
  //既存のカテゴリーを使用する
  register_taxonomy_for_object_type('category', 'works');
}
add_action( 'init', 'create_post_type' );

//カテゴリーアーカイブに施工事例を表示する
function add_post_category_archive( $wp_query ) {
  if ($wp_query->is_main_query() && $wp_query->is_category()) {
  $wp_query->set( 'post_type', array('post','works'));
  }
}
add_action( 'pre_get_posts', 'add_post_category_archive' , 10 , 1);

//タクソノミー追加
function add_taxonomy() {
  //お知らせカテゴリ
  register_taxonomy(
  'cat-news',
  array('news'), //利用する投稿タイプ（通常の投稿の場合は「post」、固定ページの場合は「page」）
  array(
  'label' => 'お知らせカテゴリー',
  'singular_label' => 'お知らせカテゴリー',
  'labels' => array(
  'all_items' => 'お知らせカテゴリ一覧',
  'add_new_item' => 'お知らせカテゴリーを追加'
  ),
  'public' => true,
  'show_ui' => true,
  'show_in_nav_menus' => true,
  'hierarchical' => true //階層を持たせる場合は「true」、持たせない場合は「false」
  )
  );
}
add_action( 'init', 'add_taxonomy' );

//POSTのアーカイブURLをカスタマイズ
function post_has_archive( $args, $post_type ) {
  if ( 'post' == $post_type ) {
   $args['rewrite'] = true;
   $args['has_archive'] = 'column'; //任意のスラッグ名　←アーカイブページを有効に
   #$args['label'] = 'TECHブログ'; //管理画面左ナビに「投稿」の代わりに表示される
   }
   return $args;
  }
  add_filter( 'register_post_type_args', 'post_has_archive', 10, 2 );
  add_filter( 'post_type_archive_link', function( $link, $post_type ) {
   if ( 'post' === $post_type ) {
   $post_type_object = get_post_type_object( 'post' );
   $slug = $post_type_object->has_archive;
   $link = get_home_url( null, '/' . $slug . '/' );
   }
   return $link;
  }, 10, 2 );
  function add_article_post_permalink( $permalink ) {
  $permalink = '/column' . $permalink;
   return $permalink;
  }
  add_filter( 'pre_post_link', 'add_article_post_permalink' );
  function add_article_post_rewrite_rules( $post_rewrite ) {
   $return_rule = array();
   foreach ( $post_rewrite as $regex => $rewrite ) {
   $return_rule['column/' . $regex] = $rewrite;
   }
  return $return_rule;
  }
  add_filter( 'post_rewrite_rules', 'add_article_post_rewrite_rules' );

//カスタム投稿のパーマリンクをidに変更
function information_post_type_link( $link, $post ){
  if ( $post->post_type === 'works' ) {
    return home_url( '/works/' . $post->ID );
  } elseif( $post->post_type === 'news' ) {
    return home_url( '/news/' . $post->ID );
  } else {
    return $link;
  }
}
add_filter( 'post_type_link', 'information_post_type_link', 1, 2 );

function information_rewrite_rules_array( $rules ) {
  $new_rewrite_rules = array( 
    'works/([0-9]+)/?$' => 'index.php?post_type=works&p=$matches[1]',
    'news/([0-9]+)/?$' => 'index.php?post_type=news&p=$matches[1]',
  );
  return $new_rewrite_rules + $rules;
}
add_filter( 'rewrite_rules_array', 'information_rewrite_rules_array' );

//マニュアル追加
add_action ( 'admin_menu', 'artist_add_pages' );
function artist_add_pages () {
	add_menu_page('マニュアル', 'マニュアル', 'manage_options', 'manual', 'manual', 'dashicons-admin-generic', 2);
}
function add_side_menu_manual() {
	//pdfのurlを設定
	$pdf_url = get_bloginfo('template_directory') . '/manual.pdf';
	?>
	<script type="text/javascript">
		jQuery( function( $ ) {
			$ ("#toplevel_page_manual a").attr("href","<?php echo $pdf_url; ?>"); //hrefを書き換える
			$ ("#toplevel_page_manual a").attr("target","_blank"); //target blankを追加する
		} );
	</script>
<?php
}
add_action('admin_footer', 'add_side_menu_manual');
?>