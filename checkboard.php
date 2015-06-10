<?php 

/*
Plugin Name: Media Checkboard 
Version: 1.0.2
Description: Simple backend plugin that renders a checkerboard under PNG and GIF images so you can see alpha channel
Author: Diego Betto
Author URI: http://diegobetto.com
License: GPL 3.0
*/


function addCss() {
	echo "<style type='text/css'>
.type-image.subtype-png .thumbnail,.type-image.subtype-gif .thumbnail {
    background-image:
      -moz-linear-gradient(45deg, #ddd 25%, transparent 25%), 
      -moz-linear-gradient(-45deg, #ddd 25%, transparent 25%),
      -moz-linear-gradient(45deg, transparent 75%, #ddd 75%),
      -moz-linear-gradient(-45deg, transparent 75%, #ddd 75%);
    background-image:
      -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.25, #ddd ), color-stop(.25, transparent)), 
      -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.25, #ddd ), color-stop(.25, transparent)),
      -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.75, transparent), color-stop(.75, #ddd )),
      -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.75, transparent), color-stop(.75, #ddd ));

    -moz-background-size:40px 40px;
    background-size:40px 40px;
    -webkit-background-size:40px 41px; /* override value for shitty webkit */
    
    background-position:0 0, 20px 0, 20px -20px , 0px 20px ;
}</style>";
}

add_action( 'admin_head', 'addCss' );