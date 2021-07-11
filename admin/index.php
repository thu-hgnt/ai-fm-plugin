<?php
include 'register-menu.php';

add_action('admin_enqueue_scripts', 'ai_fm_load_admin_styles');
function ai_fm_load_admin_styles()
{
  wp_enqueue_style( 'ai_fm_admin_style', plugins_url( 'assets/css/style.css', __FILE__ ), AI_FM_VERSION );
  wp_enqueue_style('jquery-ui-sortable', plugins_url('assets/css/jquery-ui-1.10.3.custom.min.css', __FILE__), false, AI_FM_VERSION);
  
  wp_enqueue_media();
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('ai_fm_admin_script', plugins_url('assets/js/script.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), AI_FM_VERSION, true);
}
 