<?php
/*
 * Plugin Name:       SR Related Posts
 * Plugin URI:        https://devellix.com
 * Description:       Awesome QR Codes for posts plugin will help you to show QR codes inside your post single page.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sagar Roy
 * Author URI:        https://devellix.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       sr-related-posts
 * Domain Path:       /languages
 */


 class SR_RELATED_POSTS{

	function __construct(){
		add_action('init',[$this, 'plugin_init']);
	}

	function plugin_init(){

		// modify content hook
		add_filter('the_content', [$this, 'modify_content']);
	}
	function modify_content($content) {
    if (is_single()) {
        global $post;
        $id = $post->ID;
        $categories = get_the_category($id);
        $cat_id = array();

        // Get category ids
        foreach ($categories as $category) {
            $cat_id[] = $category->cat_ID;
        }

        // Query for related posts
        $args = array(
            'category__in' => $cat_id,
            'posts_per_page' => 5,
            'orderby' => 'rand',
            'post_status' => 'publish',
            'post__not_in' => array($id)
        );

        $get_related_posts = new WP_Query($args);

        // Output related posts
        if ($get_related_posts->have_posts()) {
            $content .= '<h2>Related Posts</h2><div class="sr-related-post-container">';
            while ($get_related_posts->have_posts()) {
                $get_related_posts->the_post();
                $content .= '<div class="post" >';
                if (has_post_thumbnail()) {
                    $content .= '<div class="post-thumbnail">';
                    $content .= get_the_post_thumbnail();
                    $content .= '</div>';
                }
                $content .= '<a href="' .  get_permalink() . '">' . get_the_title() . '</a>';
                $content .= '</div>';
            }
            $content .= '</div>'; // Close sr-related-post-container
            wp_reset_postdata(); // Restore global post data
        } else {
            $content .= '<p>No related posts found.</p>';
        }
    }

    return $content;
}
}

 new SR_RELATED_POSTS;
