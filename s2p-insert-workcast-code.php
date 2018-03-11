<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://duaneleem.com
 * @since             1.0.0
 * @package           S2P_Insert_WorkCast_Code
 *
 * @wordpress-plugin
 * Plugin Name:       S2P Insert WorkCast Code
 * Plugin URI:        https://github.com/duaneleem/s2p-insert-workcast-code
 * Description:       Adds a WorkCast Theme page to WordPress.
 * Version:           1.0.0
 * Author:            Duane Leem
 * Author URI:        https://duaneleem.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       s2p-insert-workcast-code
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

if (!class_exists("StpInsertCustomCode")) {
  class StpInsertCustomCode {
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
        wp_deregister_script('jquery');
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
      wp_enqueue_style( "s2p-main", plugin_dir_url( __FILE__ ) . "assets/css/main.css", false );
    }
  } // StpInsertCustomCode

  new StpInsertCustomCode(2);
} // if

if (!class_exists("PageTemplater")) {
  class PageTemplater {
    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * The array of templates that this plugin tracks.
     */
    protected $templates;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {
      if ( null == self::$instance ) {
        self::$instance = new PageTemplater();
      }
      return self::$instance;
    }

    /**
     * Initializes the plugin by setting filters and administration functions.
     */
    private function __construct() {
      $this->templates = array();
      // Add a filter to the attributes metabox to inject template into the cache.
      if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
        // 4.6 and older
        add_filter(
          'page_attributes_dropdown_pages_args',
          array( $this, 'register_project_templates' )
        );
      } else {
        // Add a filter to the wp 4.7 version attributes metabox
        add_filter(
          'theme_page_templates', array( $this, 'add_new_template' )
        );
      }
      // Add a filter to the save post to inject out template into the page cache
      add_filter(
        'wp_insert_post_data',
        array( $this, 'register_project_templates' )
      );
      // Add a filter to the template include to determine if the page has our
      // template assigned and return it's path
      add_filter(
        'template_include',
        array( $this, 'view_project_template')
      );
      // Add your templates to this array.
      $this->templates = array(
        "pages/template-workcast.php" => "WorkCast Page",
      );
    }

    /**
     * Adds our template to the page dropdown for v4.7+
     *
     */
    public function add_new_template( $posts_templates ) {
      $posts_templates = array_merge( $posts_templates, $this->templates );
      return $posts_templates;
    }

    /**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists where it doens't really exist.
     */
    public function register_project_templates( $atts ) {
      // Create the key used for the themes cache
      $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
      // Retrieve the cache list.
      // If it doesn't exist, or it's empty prepare an array
      $templates = wp_get_theme()->get_page_templates();
      if ( empty( $templates ) ) {
        $templates = array();
      }
      // New cache, therefore remove the old one
      wp_cache_delete( $cache_key , 'themes');
      // Now add our template to the list of templates by merging our templates
      // with the existing templates array from the cache.
      $templates = array_merge( $templates, $this->templates );
      // Add the modified cache to allow WordPress to pick it up for listing
      // available templates
      wp_cache_add( $cache_key, $templates, 'themes', 1800 );
      return $atts;
    }

    /**
     * Checks if the template is assigned to the page
     */
    public function view_project_template( $template ) {
      // Return the search template if we're searching (instead of the template for the first result)
      if ( is_search() ) {
        return $template;
      }
      // Get global post
      global $post;
      // Return template if post is empty
      if ( ! $post ) {
        return $template;
      }
      // Return default template if we don't have a custom one defined
      if ( ! isset( $this->templates[get_post_meta(
        $post->ID, '_wp_page_template', true
      )] ) ) {
        return $template;
      }
      // Allows filtering of file path
      $filepath = apply_filters( 'page_templater_plugin_dir_path', plugin_dir_path( __FILE__ ) );
      $file =  $filepath . get_post_meta(
        $post->ID, '_wp_page_template', true
      );
      // Just to be safe, we check if the file exist first
      if ( file_exists( $file ) ) {
        return $file;
      } else {
        echo $file;
      }
      // Return template
      return $template;
    }
  }
  add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );
} // if

