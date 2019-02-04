<?php
// defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
class Background_Glsl_admin{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        // add_action( 'wp_enqueue_script', array($this,'enqueue_admin_style') );

    }
    function enqueue_admin_style()
    {     
        wp_enqueue_style( 'styleBgGlslAdmin',plugins_url('css/adminBgGlsl.css', __FILE__) ); 
          
    }
    public function add_admin_menu()
    {
        add_menu_page('Glsl_Background_Plugin', 'Glsl_Background_Plugin', 'manage_options', 'glsl_background', array($this, 'menu_html'));
    }
    public function menu_html()
    {
        global $wpdb;
          ?>
          <!-- Display admin form for save code Glsl  -->
        <section class="adminPluginBgGlslCanvas">
            <h1><?php echo get_admin_page_title()?></h1>
            <div>
                <h2> Save your Glsl Here  </h2>
                <form id="formBgGlslPlugin" enctype="multipart/form-data" action="" method="post">
                    <label for="nameFrag">Name of file</label>
                    <input type="text" name="nameFrag">
                    <label for="textFrag">Your Code Here</label>
                    <textarea name="textFrag" id="textFragInput" cols="100%" rows="25" ></textarea>
                    <button type="submit">Submit</button>
                </form>

                <?php
                    //  Verification Form and Save DB 
                    if (isset($_POST['textFrag']) && !empty($_POST['textFrag'])&& !empty($_POST['nameFrag'])) {
                        global $wpdb;
                        $name = $_POST['nameFrag'];
                        $textFrag = $_POST['textFrag'];
                        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}glsl_background WHERE name = '$name'");
                        if (is_null($row)) {     
                            $wpdb->insert("{$wpdb->prefix}glsl_background", array('name' => $name, 'textFrag'=>$textFrag));
                            echo 'Code uploaded successfully';
                        }
                        else {
                            echo 'This name is use. Choose another';
                        } 
                    }
                    else{
                        echo 'You should enter a  name !!';
                    } ?>
            </div>
            <div>
                    <?php
                    //  Query Glsl saved and display List of them 
                    $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}glsl_background");
                    if (!empty($result)) {
                        ?>
                        <!-- Section display list in admin plugin section  -->
                        <h3>List Glsl File :</h3>
                        <form id="formSelectBg" action="" method="post">
                            <select name="selectBG"> <?php
                                foreach ($result as $row):?>
                                    <option value="<?php echo $row->name ?>"><?php echo $row->name ?></option>
                                <?php endforeach;?>
                            </select>
                            <button id="btnSelectBG" type="submit">Select BG</button>
                        </form>

                        <?php
                    //  Verification Form and Save DB 

                    if (isset($_POST['selectBG']) && !empty($_POST['selectBG'])) {

                        global $wpdb;

                        $optionSelect = $_POST['selectBG'];

                        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}glsl_background WHERE used = 1");

                        if($row){
                            
                        //    Change Boolean True to False for old Background 
                            $query =  "UPDATE {$wpdb->prefix}glsl_background SET used = 0 WHERE id = '{$row->id}'";
                            $wpdb->query($query);

                        // Set Boolean true for new background selected
                            $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}glsl_background WHERE name = '{$optionSelect}'");
                            $query =  "UPDATE {$wpdb->prefix}glsl_background SET used = '1' WHERE id = '{$row->id}'";
                            $wpdb->query($query);

                            //  Finir le choix dans la db Du backGround 
                        }
                        else{
                        
                            $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}glsl_background WHERE name = '{$optionSelect}'");

                            $query =  "UPDATE {$wpdb->prefix}glsl_background SET used = '1' WHERE id = '{$row->id}'";

                            $wpdb->query($query);
                        

                        // var_dump($row->name);
                        }


                    }

                    //  
                    $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}glsl_background WHERE used = 1");
                    // var_dump($row[0])
                        ?>

                        <p>The current Background is : <?php echo $row->name;?></p>
                        
                        

            
            </div>
        </section>
         <?php
          }
    }
}
