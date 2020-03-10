<?php
namespace startertheme\sidebars;

/**
 * @author Andy Walpole
 *
 */

class Register_Sidebars {

	public function __construct() {

		add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );

	}

	public function register_sidebars() {

		register_sidebar( array(
			'name'          => 'Sidebar',
			'id'            => 'sidebar1',
			'description'   => 'The first (primary) sidebar.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		) );

		register_sidebar( array(
			'name'          => 'Main Sidebar',
			'id'            => 'sidebar2',
			'description'   => 'The second (primary) sidebar.',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

	}


}

new \startertheme\sidebars\Register_Sidebars();
