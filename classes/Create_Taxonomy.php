<?php 
namespace startertheme\taxonomy;
/**
 * Create_Taxonomy
 * 
 * @package   
 * @author 
 * @copyright 
 * @version 2012
 * @access public
 * 
 * Class for creating new taxonomy terms
 * 
 */

class Create_Taxonomy {

    public function __construct() {

        add_action('init', array(&$this, 'define_taxonomy'), 0);

    }

    public function define_taxonomy() {

        $labels = array(
            'name' => 'Radio',
            'singular_name' => 'Radio',
            'search_items' => __('Search Genres'),
            'all_items' => __('All Genres'),
            'parent_item' => __('Parent Genre'),
            'parent_item_colon' => __('Parent Genre:'),
            'edit_item' => __('Edit Genre'),
            'update_item' => __('Update Genre'),
            'add_new_item' => __('Add New Genre'),
            'new_item_name' => __('New Genre Name'),
            'menu_name' => __('Radio'),
            );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array('slug' => 'radio'),
            );

        register_taxonomy('radio', null, $args);

    }

}

new \startertheme\taxonomy\Create_Taxonomy(); ?>