<?php
/*
Plugin Name: Lacolley Glsl background 
Description: Plugin for save Glsl code in DB and display this code in Background
Version: 0.1
Author: Tlacolley
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Lacolley_Glsl_Background_Plugin{
    public function __construct()
    {

        include_once plugin_dir_path(__FILE__).'/display-admin-plugin.php';
        $displayAdmin =  new Background_Glsl_admin();

        register_activation_hook(__FILE__, array('Glsl_background_plugin', 'install'));
        
        add_action('admin_menu', array($displayAdmin, "add_admin_menu"));

        include_once plugin_dir_path(__FILE__).'/display-front-plugin.php';
        
        $displayFront =  new Background_Glsl_front();
        // Brancher se Hook dans le footer Verifier comment mettre le wp_enqueue en true pour le footer
        add_action( 'wp_enqueue_scripts', array($displayFront,'test_enqueue_script') );
        add_action( 'wp_enqueue_scripts', array($displayFront,'test_enqueue_style') );
        

        register_uninstall_hook(__FILE__, array('Glsl_background_plugin', 'uninstall'));

    }
    
//Funtion Install/ Creation DB

    public static function install()
    {
        global $wpdb;
        $query = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."glsl_background (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, textFrag TEXT)";
        $wpdb->query($query);
    }
  

  public static function uninstall()
  {
        global $wpdb;
        $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."glsl_background";
        $wpdb->query($query);
  }







}
new Lacolley_Glsl_Background_Plugin();

?>