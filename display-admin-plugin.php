<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class Background_Glsl_admin{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }


  public function add_admin_menu()
  {
      add_menu_page('Glsl_background_plugin', 'Glsl_background_plugin', 'manage_options', 'glsl_background', array($this, 'menu_html'));
  }

    public function menu_html()
    {
        global $wpdb;
          ?>
          <!-- Display admin form for save code Glsl  -->
        <section class="adminPluginBgGlslCanvas">
        <h1><?php echo get_admin_page_title()?></h1>
        <h2> Plugin Background Glsl  </h2>
    
        <h3>Past Your Code Here </h3>
        <form id="formBgGlslPlugin" enctype="multipart/form-data" action="" method="post">
            <label for="nameFrag">Name of file</label>
            <input type="text" name="nameFrag">
            <label for="textFrag">Your Code Here</label>
            <textarea name="textFrag" id="textFragInput" cols="100%" rows="25" ></textarea>
    
            <button type="submit">Submit</button>
        </form>
        </section>
    
    <?php
        //  Verification Form and Save DB 
        if (isset($_POST['textFrag']) && !empty($_POST['textFrag'])&& !empty($_POST['nameFrag'])) {
            global $wpdb;
            $name = $_POST['nameFrag'];
            $textFrag = $_POST['textFrag'];
    
            $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}backgroundGlsl WHERE name = '$name'");
        
            if (is_null($row)) {     
                $wpdb->insert("{$wpdb->prefix}backgroundGlsl", array('name' => $name, 'textFrag'=>$textFrag));
                echo 'Code uploaded successfully';
            }
            else {
                echo 'This name is use. Choose another';
            } 
        }
        else{
            echo 'You should enter a  name !!';
        } 
    
        //  Query Glsl saved and display List of them 
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}backgroundGlsl");
      
        if (!empty($result)) {
            ?>
            <!-- Section display list in admin plugin section  -->
            <h3>List Glsl File :</h3>
            <form id="formSelectBg" action="" method="post">
                <select> <?php
                    foreach ($result as $row):?>
                        <option value="<?php echo $row->name ?>"><?php echo $row->name ?></option>
                    <?php endforeach;?>
                </select>
                <button id="btnSelectBG" type="submit">Select BG</button>
            </form>
         <?php
          }
    }
    



}
?>