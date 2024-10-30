<?php 
/*
Plugin Name: Bytecoder Post Ticker
Plugin URI: http://bytecoder.info
Description: This plugin will enable post as a ticker in your wordpress theme. You can embed post ticker using shortcode in everywhere you want, 
even in theme files. 
Author: Sayfur Rahman
Version: 1.0
Author URI: http://sayfur-rahman.info
*/

function defalut_jquery() {
	wp_enqueue_script('jquery');
}

add_action('init', 'defalut_jquery');

function add_main_script() {
   wp_enqueue_script( 'post-js-3', plugins_url( '/js/jquery.easy-ticker.min.js', __FILE__ ), array('jquery'), 1.0, false);
   wp_enqueue_style( 'post-css', plugins_url( '/css/style.css', __FILE__ ));
}

add_action('init','add_main_script');

function post_list_shortcode($atts){
	extract( shortcode_atts( array(
		'id' => 'post',
		'category' => '',
		'count' => '-1',
		'show' => '5',
		'transition' => '2000',
		'mousehover' => '1',
		'category_slug' => 'category_ID',
	), $atts, 'projects' ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => 'post', $category_slug => $category)
        );		
		
		
	$list = '<script type="text/javascript" language="javascript">
	jQuery(document).ready(function(){

	jQuery("#postticker'.$id.'").easyTicker({
		visible: '.$show.',
		interval: '.$transition.',
		mousePause: '.$mousehover.',
	});
	
});
</script><div id="postticker'.$id.'" class="post-ticker"><ul>';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list.= '
		
			<li>
				'.get_the_post_thumbnail().'
				<strong><a href="'.get_permalink().'">'.get_the_title().'</a></strong><br>
				<strong>Author:</strong> <a href="'.get_the_author_link().'">'.get_the_author().'</a><br> 
				<strong>Posted:</strong> '.get_the_date().'
			</li>
		
		';        
	endwhile;
	$list.= '</ul></div>';
	wp_reset_query();
	return $list;
}

add_shortcode('post_list', 'post_list_shortcode');	


?>