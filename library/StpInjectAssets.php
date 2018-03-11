<?php
// The main plugin class.
if (!class_exists("StpInjectAssets") || class_exists("PageTemplater")) {
  class StpInjectAssets {
    function __construct() {
      add_action("wp_enqueue_scripts", array($this, "registerCustomCodes"));
    } // __construct()
  
    /**
     * Registers modifications made to WorkCast HTML.
     */
    public function registerCustomCodes() {
      wp_enqueue_style( "s2p-main", plugin_dir_url( __FILE__ ) . "../assets/css/main.css", false );
    }
  } // StpInjectAssets
} // if (!class_exists("StpInjectAssets") || !class_exists("PageTemplater"))

