<?php
require_once get_template_directory() . '/libs/aqua-resizer/aq_resizer.php';


add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
function theme_enqueue_scripts(){

	wp_register_script('modernizr', get_bloginfo('template_url') . '/js/modernizr.js');
	wp_enqueue_script('modernizr');

	wp_register_script('require', get_bloginfo('template_url') . '/js/vendor/requirejs/require.js', array(), false, true);
	wp_enqueue_script('require');

	wp_register_script('global', get_bloginfo('template_url') . '/js/global.js', array('require'), false, true);
	wp_enqueue_script('global');

	wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true);
	wp_enqueue_script('livereload');

	// wp_register_script('production', get_bloginfo('template_url') . '/js/optimized.min.js', array('require'), false, true);
	// wp_enqueue_script('production');

	wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Fira+Sans:400,500,700|Roboto:400,500,700');
	wp_enqueue_style('global', get_bloginfo('template_url') . '/css/global.css');
}

//Add Featured Image Support
add_theme_support('post-thumbnails');

function my_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="video-container">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

function wpcontent_svg_mime_type( $mimes = array() ) {
  $mimes['svg']  = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'wpcontent_svg_mime_type' );

// Clean up the <head>
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

function register_menus() {
	register_nav_menus(
		array(
			'main-nav' => 'Main Navigation',
			'social-nav' => 'Social Links'
		)
	);
}
add_action( 'init', 'register_menus' );

function register_widgets(){

	register_sidebar( array(
		'name' => __( 'Sidebar' ),
		'id' => 'main-sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}//end register_widgets()
add_action( 'widgets_init', 'register_widgets' );


function social_links() {
	$menu_name = 'social-nav'; // specify custom menu slug
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<ul class="social-menu">';
		foreach ((array) $menu_items as $key => $menu_item) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			$menu_list .= '<li>
		                        <a href="'.$url.'" target="_blank">
		                            <span>'.$title.'</span>
		                            <svg viewBox="0 0 66 66">
		                                <use xlink:href="#icon-'.strtolower($title).'"></use>
		                            </svg>
		                        </a>
		                    </li>' ."\n";
		}
		$menu_list .= '</ul>';
	} else {
		$menu_list = '';
	}
	echo $menu_list;
}


// add_action( 'init', 'create_posttype' );
// function create_posttype() {
//   register_post_type( 'eventos',
//     array(
//       'labels' => array(
//         'name' => __( 'Eventos' ),
//         'singular_name' => __( 'Evento' )
//       ),
//       'public' => true,
//       'has_archive' => true,
//       'rewrite' => array('slug' => 'eventos'),
//       'supports' => array(
// 			'title',
// 			'editor',
// 			'excerpt',
// 			'thumbnail',
// 			//'author',
// 			//'trackbacks',
// 			//'custom-fields',
// 			//'comments',
// 			'revisions',
// 			//'page-attributes', // (menu order, hierarchical must be true to show Parent option)
// 			//'post-formats',
// 		),
//     )
//   );
// }

//Lets add Open Graph Meta Info
function insert_fb_in_head() {
    global $post;

    

    $title = get_bloginfo("name")." - ".get_bloginfo("description");
    if (get_the_title() != "Home") {
    	$title =  get_the_title() . ' | ' . get_bloginfo("name")." - ".get_bloginfo("description");
    }

    $content = get_bloginfo("description");
    if (@$post->post_content!="") {
    	$content = strip_tags($post->post_content);
    }
    
    $thumbnail = get_field('imagem');
    if(!$thumbnail) { //the post does not have featured image, use a default image
        $default_image=get_bloginfo('template_url')."/images/social-image.jpg";
        
    }
    else{
        $default_image = trim($thumbnail['url']);
    }

    // echo '<meta property="fb:app_id" content="xxx" />';
    echo '<meta property="og:title" content="' . $title . '"/>';
    echo '<meta property="og:description" content="' . $content. '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="Fazenda Divisa"/>';
    echo '<meta property="og:image" content="' . $default_image . '"/>';

    echo "<meta name='twitter:card' content='summary'/>";
    echo '<meta name="twitter:title" content="' . $title . '" />';
	echo '<meta name="twitter:description" content="' . $content. '" />';
    echo '<meta name="twitter:image" content="' . $default_image . '" />';
	
	
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );


function lead_zero($n){
	if ($n<10) {
		$n = "0".$n;
	}

	return $n;
}

add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
