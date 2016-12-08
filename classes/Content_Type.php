<?php 
namespace startertheme\content;
/**
 * Content_Type
 * 
 * @package  class for adding different content types with meta data and taxonomy if concerned. Includes validation and sanitization
 * @author Andy Walpole
 * @copyright AWalpole
 * @access public
 */

class Content_Type {

    static $wpdb = null;

    /**
     * Content_Type::__construct()
     * 
     * @return
     */
    public function __construct() {

        global $wpdb;
        self::$wpdb = $wpdb;

        add_action('init', array(&$this, 'content_type'));

        if (session_id() == '') {
            session_start();
            session_regenerate_id(true);
        } else {
            session_regenerate_id(true);
        }

    }

    /**
     * Content_Type::metabox_attributes()
     * 
     * This is the meat and bones of the meta box array
     * 
     * Called in Content_Type::text_one_html() AND 
     * 
     * @return array
     */

    public function metabox_attributes() {

        return array(
            'first_text' => array(
                'name' => 'first_text',
                'type' => 'input',
                'title' => '<strong>First text</strong>',
                'description' => 'Some description text here',
                ),
            'second_text' => array(
                'name' => 'second_text',
                'type' => 'input',
                'title' => '<strong>Second text</strong>',
                'description' => 'Some more description text here',
                ),
            );

    } // end function metabox_attributes()

    /**
     * Content_Type::content_type()
     * 
     * This is the to register the 
     * 
     * @return
     */
    public function content_type() {

        $labels = array(
            'name' => _x('Alt types', 'post type general name'),
            'singular_name' => _x('Alt type', 'post type singular name'),
            'add_new' => _x('Add New', 'book'),
            'add_new_item' => __('Add alt type'),
            'edit_item' => __('Edit alt type'),
            'new_item' => __('New alt type'),
            'all_items' => __('All alt types'),
            'view_item' => __('View alt types'),
            'search_items' => __('Search alt types'),
            'not_found' => __('No alt types found'),
            'not_found_in_trash' => __('No alt types found in Trash'),
            'parent_item_colon' => '',
            'menu_name' => __('Alt content type'));

        $args = array(
            'labels' => $labels,
            'description' => 'This is where the description should be for alt types',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'register_meta_box_cb' => array(&$this, 'add_metaboxes'),
            'taxonomies' => array('radio'),
            'supports' => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'comments'));

        add_action('save_post', array(&$this, 'save_postdata'), 10, 2);
        add_action('admin_notices', array(&$this, 'my_post_admin_notices'));

        register_post_type('alternative_content', $args);

    }

    /**
     * Content_Type::add_metaboxes()
     * 
     * Calls the add_meta_box hook
     * Called in Content_Type::content_type()
     * 
     * @return
     */
    public function add_metaboxes() {

        add_meta_box('text_one', 'Add more data here', array(&$this, 'text_one_html'),
            'alternative_content', 'normal', 'default');

    }

    /**
     * Content_Type::text_one_html()
     * 
     * This is the html of the meta_boxes
     * Called in Content_Type::content_type()
     * 
     * @return string
     */
    public function text_one_html() {

        $new_meta_boxes = $this->metabox_attributes();

        global $post;

        if (!is_null($post)) {

            foreach ($new_meta_boxes as $result) {

                // add nonce

                echo '<input type="hidden" name="'.$result['name'].'_noncename" id="'.$result['name'].
                    '_noncename" value="'.wp_create_nonce(plugin_basename(__file__)).'" />';

                echo '<h2>'.$result['title'].'</h2>';

                if ($result['type'] == 'input') {

                    $meta_box_value = get_post_meta($post->ID, $result['name'], true);

                    echo '<p><label for="'.$result['name'].'">'.$result['description'].
                        "</label></p>";

                    echo '<input type="text" name="'.$result['name'].'" value="'.esc_attr($meta_box_value).
                        '" size="55" /><br />';

                } // end if

            } // end foreach

        } // end if if (!is_null($post)) {

    } // end private function text_one_html() {

    /**
     * Content_Type::save_postdata()
     * 
     * @return
     */
    public function save_postdata() {

        $new_meta_boxes = $this->metabox_attributes();

        global $post;

        if (!is_null($post)) {

            // don't do on autosave or when new posts are first created
            if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || $post->post_status == 'auto-draft') 
                    return $post->ID;

            // abort if not my custom type
            if ($post->post_type != 'alternative_content') return $post->ID;

            $meta_missing = null;
            $error = array();

            // sanitization here

            $form = array_map('stripslashes_deep', $_POST);

            foreach ($new_meta_boxes as $result) {

                if (!wp_verify_nonce($form[$result['name'].'_noncename'], plugin_basename(__file__))) {
                    return $post->ID;
                }

                $data = $form[$result['name']];

                $post_data = get_post_meta($post->ID, $result['name'], true);

                if ($post_data == false || $data != $post_data) {

                    // validation here

                    if (!ctype_digit($data)) {

                        $meta_missing = true;

                        $error[] = 'Make sure you only enter digits for '.$result['title'];

                    } else {

                        update_post_meta($post->ID, $result['name'], $data, true);

                    } // end if

                    // on attempting to publish - check for completion and intervene if necessary
                    if ((isset($_POST['publish']) || isset($_POST['save'])) && $_POST['post_status'] ==
                        'publish') {
                        //  don't allow publishing while any of these are incomplete
                        if ($meta_missing) {

                            self::$wpdb->update(self::$wpdb->posts, array('post_status' => 'pending'),
                                array('ID' => $post->ID));

                        }

                    } // end fi

                    // delete if empty
                } elseif ($data == "") {

                    delete_post_meta($post->ID, $result['name'], true);

                } // end if statement

            } // end foreach loop

            // filter the query URL to change the published message
            if ($meta_missing) {

                add_filter('wp_insert_post_data', array(&$this, 'add_redirect_filter'), 99);
                
                $this->add_redirect_filter();

                $_SESSION['error'] = serialize($error);

            } // end meta missing

        } // end if(!null($post)) {

    } // public function ah_save_postdata() {


    /**
     * Content_Type::add_redirect_filter()
     * Called if there are errors in the form
     * 
     * @return
     */
    public function add_redirect_filter() {

        add_filter('redirect_post_location', array(&$this, 'my_redirect_post_location_filter'), 99);

    } // end public function add_redirect_filter() {

    /**
     * Content_Type::my_redirect_post_location_filter()
     * 
     * Adds 99 as a value for message in the query string
     * 
     * @param mixed $location
     * @return
     */
    public function my_redirect_post_location_filter($location) {

        remove_filter('redirect_post_location', __function__, 99);

        $location = add_query_arg('message', 99, $location);

        return $location;

    } // end public function my_redirect_post_location_filter($location) {

    /**
     * Content_Type::my_post_admin_notices()
     * 
     * 
     * 
     * @return string
     */
    public function my_post_admin_notices() {

        if (!isset($_GET['message'])) return;

        if ($_GET['message'] == '99') {

            $message = '<div id="notice" class="error"><p>';
            $message .= "Error: please check that all form values are correct - <br>";
            $message .= isset($_SESSION['error']) ? implode('<br>', unserialize($_SESSION['error'])) : null;
            $message .= '</p></div>';

            echo $message;

        } // end if

    } // end public function my_post_admin_notices() {

} // end class


new \startertheme\content\Content_Type; ?>