<?php 
namespace startertheme\menu;
/**
 * Create_Menus
 * 
 * @package   
 * @author 
 * @copyright
 * @access public
 * 
 * Class for creating menus
 */
class Create_Menus {

    public function __construct() {

        add_action('after_setup_theme', array(&$this, 'create_menus'), 15);

    }

    /**
     * Create_Menus::create_menus()
     * 
     * @return register_nav_menus() hook
     */
    public function create_menus() {

        register_nav_menus(array('main-nav' => __('The Main Menu'), // main nav in header
                'footer-links' => __('Footer Links') // secondary nav in footer
                ));

    }

    /**
     * Create_Menus::main_nav()
     * 
     * @return
     */
    public static function main_nav() {
        // display the wp3 menu if available
        wp_nav_menu(array(
            'container' => false, // remove nav container
            'container_class' => 'menu clearfix', // class of container (should you choose to use it)
            'menu' => 'The Main Menu', // nav name
            'menu_class' => 'nav top-nav clearfix', // adding custom nav class
            'theme_location' => 'main-nav', // where it's located in the theme
            'before' => '', // before the menu
            'after' => '', // after the menu
            'link_before' => '', // before each link
            'link_after' => '', // after each link
            'depth' => 0, // limit the depth of the nav
            'role' => 'menu' //'fallback_cb' => 'main_nav_fallback'      // fallback function
                ));
    }

    /**
     * Create_Menus::footer_links()
     * 
     * @return
     */
    public static function footer_links() {
        // display the wp3 menu if available
        wp_nav_menu(array(
            'container' => '', // remove nav container
            'container_class' => 'footer-links clearfix', // class of container (should you choose to use it)
            'menu' => 'Footer Links', // nav name
            'menu_class' => 'nav footer-nav clearfix', // adding custom nav class
            'theme_location' => 'footer-links', // where it's located in the theme
            'before' => '', // before the menu
            'after' => '', // after the menu
            'link_before' => '', // before each link
            'link_after' => '', // after each link
            'depth' => 0, // limit the depth of the nav
            //'fallback_cb' => 'footer_links_fallback'  // fallback function
            ));
    }


}

new \startertheme\menu\Create_Menus(); 

echo '"', __NAMESPACE__, '"'; // outputs "MyProject"