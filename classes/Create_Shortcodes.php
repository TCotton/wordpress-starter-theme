<?php 
namespace startertheme\shortcodes;
/**
 * @author 
 * @copyright 2012
 */

class Create_Shortcodes {
    
    public function __construct() {
        
        add_shortcode('aURL', array(&$this, 'aURL'));
        add_shortcode('aURL', array(&$this, 'anotherURL'));
        
    }
    
    
    public function aURL() {
        
        return 'http://www.example.com';
        
    }
    
    public function anotherURL() {
        
        return 'http://www.example.co.uk';
        
    }
    
}


new \startertheme\shortcodes\Create_Shortcodes();

?>