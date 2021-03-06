<?php
// defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
class Background_Glsl_front{
    public function __construct()
    {
        add_action('wp_loaded', array($this, 'displayBackground'));
        // add_action( 'wp_enqueue_style', array($this,'enqueue_front_style') );
        // add_action( 'wp_enqueue_scripts', array($this,'enqueue_front_script') );
    }
    function displayBackground()
    {
        global $wpdb;
        $glslSelect = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}glsl_background WHERE used = 1");
        // echo nl2br( $glslSelect[0]->textFrag);
        ?>

        <canvas id="glslCanvas" data-fragment="<?php echo  $glslSelect[0]->textFrag ?>    
        " width="100%" height="100%" data-textures="<?php echo get_template_directory_uri().'/Shader02/05.jpg' ?>"></canvas> 
       
        <?php   
    }
    function enqueue_front_script() 
    {
        // wp_enqueue_script( 'custom_wp_admin_js', plugins_url('script/monScriptQuiVaGereMonJQueryEnFront.js', __FILE__), array( 'jquery' ) ); 
    }
    function enqueue_front_style()
    {     
        wp_enqueue_style( 'styleBgGlsl',plugins_url('css/styleBgGlsl.css', __FILE__) );   
    }
   
}
?>