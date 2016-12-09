<?php

/**
 * @author
 * @copyright 2012
 */

add_action( 'widgets_init', 'register_example_widget' );

function register_example_widget() {

	register_widget( 'Widget_Example' );

}

class Widget_Example extends WP_Widget {

	public function __construct() {

		$widget_args = array(
			'classname'   => 'Widget_Example',
			'description' => 'This is a description for the example widget',
		);

		//$this->WP_Widget('widget_example_id', $widget_args);

		parent::__construct( 'widget_example_id', 'This is an example Widget', $widget_args );

	}

	public function form( $instance ) {

		$defaults = array(
			'title' => 'The widget title',
			'name'  => '',
			'bio'   => ''
		);

		$instance = wp_parse_tags( (array ) $instance, $defaults );

		$title = strip_tags( $instance['title'] );

		$name = strip_tags( $instance['name'] );

		$bio = strip_tags( $instance['bio'] );

		$form = '<h3>Title here</h3>';

		$form .= '<p>';
		$form .= '<input class="widefat" name=' . $this->get_field_name( 'title' ) .
		         '" type="text" value="' . esc_attr( $title ) . '" />';
		$form .= '</p>';

		$form .= '<p>';
		$form .= '<input class="widefat" name=' . $this->get_field_name( 'name' ) .
		         '" type="text" value="' . esc_attr( $name ) . '" />';
		$form .= '</p>';

		$form .= '<p>';
		$form .= '<textarea class="widefat" name=' . $this->get_field_name( 'bio' ) .
		         '" value="' . esc_attr( $name ) . '" ></textarea>';
		$form .= '</p>';

		echo $form;


	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name']  = strip_tags( $new_instance['name'] );
		$instance['bio']   = strip_tags( $new_instance['bio'] );

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( args );

		echo $before_widget;
		echo $after_widget;

	}

}

