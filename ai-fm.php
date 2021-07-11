<?php

/**
 * Plugin Name: AI Football Manager
 * Plugin URI: https:/ftyzip.com
 * Description: The football game allow you manager a dream team.
 * Version: 1.0.0
 * Author: Thu NT
 * Author URI: https:/ftyzip.com
 */

include 'admin/index.php';
include 'cpt/player.php';
include 'cpt/team.php';
include 'cpt/user.php';

define( 'AI_FM_VERSION', '1.0.0' );

define( 'AI_FM_TEXT_DOMAIN', 'AI-FM' );

define( 'AI_FM_PLUGIN', __FILE__ );

define( 'AI_FM_PLUGIN_BASENAME', plugin_basename( AI_FM_PLUGIN ) );

define( 'AI_FM_PLUGIN_NAME', trim( dirname( AI_FM_PLUGIN_BASENAME ), '/' ) );

define( 'AI_FM_PLUGIN_DIR', untrailingslashit( dirname( AI_FM_PLUGIN ) ) );
