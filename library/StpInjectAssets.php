<?php
// The main plugin class.
if (!class_exists("StpInjectAssets") || class_exists("PageTemplater")) {
  class StpInjectAssets {
    function __construct($postID) {
      add_action("wp_enqueue_scripts", array($this, "registerWorkCastStyles"), 10, $postID);
      add_action("wp_enqueue_scripts", array($this, "registerCustomCodes"));
    } // __construct()
  
    /*
     * Registers WorkCast to <head> to a specific post/page.
     * @param {int} $postID - The post of page ID.
     */
    public function registerWorkCastStyles($postID) {
      if(is_page($postID)) {
        // Disable the built in jquery and use WorkCast preferred jquery.
        wp_deregister_script("jquery");
        wp_enqueue_script( "jquery", "https://607c5dc4c1541a604b6a-f45dce0462984165c96c36581d3ab586.ssl.cf1.rackcdn.com/jquery.1.6.2.min.js", array(), null, false );
  
        // Required modules.
        wp_enqueue_script( "workcast-jquery-ui", "https://fe6fb6b85d6334307b13-496a2897963cd528a3555dcf427cda5c.ssl.cf1.rackcdn.com/workcast-jquery-ui-1.11.4.min.js", array("jquery") );
        wp_enqueue_script( "querytools", "https://607c5dc4c1541a604b6a-f45dce0462984165c96c36581d3ab586.ssl.cf1.rackcdn.com/jquery.tools.1.2.6.min.js", array("jquery") );
        wp_enqueue_script( "workcastchm", "https://607c5dc4c1541a604b6a-f45dce0462984165c96c36581d3ab586.ssl.cf1.rackcdn.com/workcast-chem-1.0.4.min.js", array("jquery") );
        wp_enqueue_script( "workcastchem10949", "https://fe6fb6b85d6334307b13-496a2897963cd528a3555dcf427cda5c.ssl.cf1.rackcdn.com/Embed/10949/9952486094509220/workcast-chem-10949-1078538760264033.js", array("jquery") );
        wp_enqueue_script( "workcastchemtools", "https://607c5dc4c1541a604b6a-f45dce0462984165c96c36581d3ab586.ssl.cf1.rackcdn.com/workcast-chem-tools-1.0.1.min.js", array("jquery") );
        wp_enqueue_style( "workcastembedcss0203182", "https://www.workcast.com/media/10949/9952486094509220/Documents/embed_css_0203182.css", false );
      } // if
    } // registerWorkCastStyles
  
    /**
     * Registers modifications made to WorkCast HTML.
     */
    public function registerCustomCodes() {
      wp_enqueue_style( "s2p-main", plugin_dir_url( __FILE__ ) . "../assets/css/main.css", false );
    }
  } // StpInjectAssets
} // if (!class_exists("StpInjectAssets") || !class_exists("PageTemplater"))

