<?php
add_action('admin_menu', 'add_ai_fm_menu');

function add_ai_fm_menu()
{

  add_menu_page('AI FM', 'AI FM', 'manage_options', 'ai-fm', 'ai_fm_dashboard');
  add_submenu_page('ai-fm', 'Dashboard', 'Dashboard', 'manage_options', 'ai-fm');
  add_submenu_page('ai-fm', 'Player', 'Player', 'manage_options', 'ai-fm-player', 'ai_fm_player');
  add_submenu_page('ai-fm', 'Team', 'Team', 'manage_options', 'ai-fm-team', 'ai_fm_team');
  add_submenu_page('ai-fm', 'User', 'User', 'manage_options', 'ai-fm-user', 'ai_fm_user');

}

function ai_fm_dashboard()
{
  require('view/dashboard.php');
}

function ai_fm_player()
{
  require('view/player.php');
}

function ai_fm_team()
{
  require('view/team.php');
}

function ai_fm_user()
{
  require('view/user.php');
}
