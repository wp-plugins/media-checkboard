<?php 

/*
Plugin Name: Media Checkboard 
Version: 1.1.0
Description: Simple backend plugin that renders a checkerboard under PNG and GIF images so you can see alpha channel
Author: Diego Betto
Author URI: http://diegobetto.com
License: GPL 3.0
*/

if($_POST['checkerboard_hidden'] == 'Y') {
    $color1 = $_POST['checkerboard_color1'];
    update_option('checkerboard_color1', $color1);

    $color2 = $_POST['checkerboard_color2'];
    update_option('checkerboard_color2', $color2);

    $size = $_POST['checkerboard_size'];
    update_option('checkerboard_size', $size);
    ?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
    <?php
}else{
  $color1 = get_option('checkerboard_color1');
  $color2 = get_option('checkerboard_color2');
  $size = get_option('checkerboard_size');
  if($color1=='')$color1 = '#ddd';
  if($color2=='')$color1 = '#eee';
  if($size=='')$size = 40;
}

function addCss() {
  global $color1,$color2,$size;
  $sizeHalf = floor($size/2);
	echo "<style type='text/css'>
.type-image.subtype-png .thumbnail,.type-image.subtype-gif .thumbnail {
	background-color: ".$color2.";
    background-image:
      -moz-linear-gradient(45deg, ".$color1." 25%, transparent 25%), 
      -moz-linear-gradient(-45deg, ".$color1." 25%, transparent 25%),
      -moz-linear-gradient(45deg, transparent 75%, ".$color1." 75%),
      -moz-linear-gradient(-45deg, transparent 75%, ".$color1." 75%);
    background-image:
      -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.25, ".$color1." ), color-stop(.25, transparent)), 
      -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.25, ".$color1." ), color-stop(.25, transparent)),
      -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.75, transparent), color-stop(.75, ".$color1." )),
      -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.75, transparent), color-stop(.75, ".$color1." ));

    -moz-background-size:".$size."px ".$size."px;
    background-size:".$size."px ".$size."px;
    -webkit-background-size:".$size."px ".($size+1)."px; /* override value for shitty webkit */
    
    background-position:0 0, ".$sizeHalf."px 0, ".$sizeHalf."px -".$sizeHalf."px , 0px ".$sizeHalf."px ;
}</style>";
}

add_action( 'admin_head', 'addCss' );


function checkerboard_admin() {
  global $color1,$color2,$size;
  wp_enqueue_style( 'wp-color-picker' ); 
  wp_enqueue_script( 'checkerboard-script-handle', plugins_url( 'script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
?>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Media Checkerboard Options' ) . "</h2>"; ?>
     
    <form name="checkerboard_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="checkerboard_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Checkerboard Settings' ) . "</h4>"; ?>
        <p><?php _e("Background color 1: " ); ?><br /><input type="text" class="color-field" name="checkerboard_color1" value="<?php echo $color1; ?>" size="20"></p>
        <p><?php _e("Background color 2: " ); ?><br /><input type="text" class="color-field" name="checkerboard_color2" value="<?php echo $color2; ?>" size="20"></p>
        <hr />
        <p><?php _e("Size: "); ?><input type="text" name="checkerboard_size" value="<?php echo $size; ?>" size="20"> <?php _e("Pixels, ex: 10 (default 40)" ); ?></p>
     
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options' ) ?>" />
        </p>
    </form>
</div>

<?php 
}
 
function checkerboard_admin_actions() {
    add_options_page("Media Checkerboard", "Media Checkerboard", "administrator", "checkerboard_admin_display","checkerboard_admin");
}
 
add_action('admin_menu', 'checkerboard_admin_actions');

