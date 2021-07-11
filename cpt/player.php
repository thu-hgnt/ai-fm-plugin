<?php

if (!defined('ABSPATH')) exit;

add_action('init', 'register_cpt_ai_fm_player');
function register_cpt_ai_fm_player()
{
  register_post_type('ai_fm_player', array(
    'labels'             => array(
      'name'               => __('Player', 'ai-fm-player'),
      'singular_name'      => __('Player', 'ai-fm-player'),
      'add_new'            => __('Add new', 'ai-fm-player'),
      'add_new_item'       => __('Add new player', 'ai-fm-player'),
      'edit_item'          => __('Edit new', 'ai-fm-player'),
      'new_item'           => __('New item', 'ai-fm-player'),
      'view_item'          => __('View', 'ai-fm-player'),
      'search_items'       => __('Search', 'ai-fm-player'),
      'menu_name'          => __('Player', 'ai-fm-player')
    ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array('title', 'excerpt')
  ));
}

add_action('add_meta_boxes', 'ai_fm_player_meta_box', 0);
function ai_fm_player_meta_box()
{
  add_meta_box('ai_fm_player_detail_meta', __('Player Detail', 'ai-fm-player'), 'ai_fm_player_detail_render', 'ai_fm_player', 'normal', 'high');
  add_meta_box('ai_fm_player_rating_meta', __('Player Rating', 'ai-fm-player'), 'ai_fm_player_rating_render', 'ai_fm_player', 'normal', 'high');
}

function ai_fm_player_detail_render($post)
{
  wp_nonce_field('ai_fm_player_detail_box', 'ai_fm_player_detail_box_nonce');
  $face_img = get_post_meta($post->ID, 'face_img', true);
  $name = get_post_meta($post->ID, 'name', true);
  $shirt_name = get_post_meta($post->ID, 'shirt_name', true);
  $shirt_number = get_post_meta($post->ID, 'shirt_number', true);
  $nationality = get_post_meta($post->ID, 'nationality', true);
  $height = get_post_meta($post->ID, 'height', true);
  $weight = get_post_meta($post->ID, 'weight', true);
  $age = get_post_meta($post->ID, 'age', true);
  $positions = get_post_meta($post->ID, 'positions', true);
  $register_position = get_post_meta($post->ID, 'register_position', true);

  $positions_array = array(
    'cf' => 'CF',
    'ss' => 'SS',
    'lw' => 'LW',
    'rw' => 'RW',
    'cam' => 'CAM',
    'cm' => 'CM',
    'cdm' => 'CDM',
    'lm' => 'LM',
    'rm' => 'RM',
    'rb' => 'RB',
    'lb' => 'LB',
    'cb' => 'CB',
    'gk' => 'GK',
  );

  $countries = file_get_contents(plugins_url('ai-fm/data/countries.json'));
  $countries_array = json_decode($countries, true);

?>
  <div id="player-detail">
    <div class="left">
      <div id="photo-item">
        <?php if ($face_img) { ?>
          <img src="<?php echo esc_url($face_img); ?>" class="sv-prev-thumb sv-individual-thumb" id="photo-preview" />
        <?php } else { ?>
          <img src="<?php echo plugins_url('ai-fm/admin/assets/img/player-placeholder.jpg'); ?>" class="sv-prev-thumb sv-individual-thumb" id="photo-preview" />
        <?php } ?>
      </div>
      <a href="#" id="addPhotoBtn">Replace photo</a>
      <input type="hidden" value="<?php echo esc_url($face_img); ?>" name="face_img" id="itemPhoto" readonly />
    </div>
    <div class="right">
      <div class="custom-meta-row">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo esc_attr($name); ?>" />
      </div>
      <div class="custom-meta-row">
        <label for="shirt_name">Shirt Name:</label>
        <input type="text" id="shirt_name" name="shirt_name" value="<?php echo esc_attr($shirt_name); ?>" />
      </div>
      <div class="custom-meta-row">
        <label for="shirt_number">Shirt Number:</label>
        <input type="number" min="0" max="99" id="shirt_number" name="shirt_number" value="<?php echo esc_attr($shirt_number); ?>" />
      </div>
      <div class="custom-meta-row">
        <label for="nationality">Nationality:</label>
        <select name="nationality" id="player-nation" value="<?php echo esc_attr($nationality); ?>">
          <?php
          foreach ($countries_array as $item) {
            echo '<option value="' . $item['code'] . '" ' .  ($item['code'] == $nationality ? 'selected' : '') . '>' . $item['name'] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="custom-meta-row">
        <label for="height">Height (cm):</label>
        <input type="number" min="0" max="" id="height" name="height" value="<?php echo esc_attr($height); ?>" />
      </div>
      <div class="custom-meta-row">
        <label for="weight">Weight (kg):</label>
        <input type="number" min="0" max="" id="weight" name="weight" value="<?php echo esc_attr($weight); ?>" />
      </div>
      <div class="custom-meta-row">
        <label for="age">Age:</label>
        <input type="number" min="0" max="38" id="age" name="age" value="<?php echo esc_attr($age); ?>" />
      </div>
      <div class="custom-meta-row">
        <label for="positions">Positions:</label>
        <div id="player-postions">
          <?php
          $player_positions = explode(",", $positions);
          foreach ($positions_array as $key => $value) {
            echo '<span><input type="checkbox" id="position-' . $key . '" name="position-' . $key . '"  value="' . $value . '"' .  (in_array($key, $player_positions) ? 'checked' : '') . ' />';
            echo '<label for="position-' . $key . '">' . $value . '</label></span>';
          }
          ?>
          <input type="hidden" name="positions" value="<?php echo esc_attr($positions); ?>" />
        </div>
      </div>
      <div class="custom-meta-row">
        <label for="register_position">Register Position:</label>
        <select name="register_position" value="<?php echo esc_attr($register_position); ?>">
          <?php
          foreach ($positions_array as $key => $value) {
            echo '<option value="' . $key . '" ' .  ($key == $register_position ? 'selected' : '') . '>' . $value . '</option>';
          }
          ?>
        </select>
      </div>
    </div>
  </div>
<?php }

function ai_fm_player_rating_render($post)
{
  wp_nonce_field('ai_fm_player_rating_box', 'ai_fm_player_rating_box_nonce');
  $index = get_post_meta($post->ID, 'index', true);
?>
  <div id="player-rating">
    <div class="custom-meta-row">
      <label for="name">General:</label>
      <input type="number" min="0" max="100" name="general" value="<?php echo esc_attr($index['general']); ?>" />
    </div>
    <div class="custom-meta-row">
      <label for="name">Attack:</label>
      <input type="number" min="0" max="100" name="attack" value="<?php echo esc_attr($index['attack']); ?>" />
    </div>
    <div class="custom-meta-row">
      <label for="name">Pass/Dribble:</label>
      <input type="number" min="0" max="100" name="pass_dribble" value="<?php echo esc_attr($index['pass_dribble']); ?>" />
    </div>
    <div class="custom-meta-row">
      <label for="name">Defence:</label>
      <input type="number" min="0" max="100" name="defence" value="<?php echo esc_attr($index['defence']); ?>" />
    </div>
    <div class="custom-meta-row">
      <label for="name">Goalkeeper:</label>
      <input type="number" min="0" max="100" name="goalkeeper" value="<?php echo esc_attr($index['goalkeeper']); ?>" />
    </div>
  </div>
<?php }

add_action('save_post', 'save_data_ai_fm_player');
function save_data_ai_fm_player($post_id)
{
  if (!isset($_POST['ai_fm_player_detail_box_nonce']))
    return $post_id;
  $nonce = $_POST['ai_fm_player_detail_box_nonce'];
  if (!wp_verify_nonce($nonce, 'ai_fm_player_detail_box'))
    return $post_id;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return $post_id;
  if (!current_user_can('edit_post', $post_id))
    return $post_id;

  $face_img = sanitize_text_field($_POST['face_img']);
  $name = sanitize_text_field($_POST['name']);
  $shirt_name = sanitize_text_field($_POST['shirt_name']);
  $shirt_number = sanitize_text_field($_POST['shirt_number']);
  $nationality = sanitize_text_field($_POST['nationality']);
  $height = sanitize_text_field($_POST['height']);
  $weight = sanitize_text_field($_POST['weight']);
  $age = sanitize_text_field($_POST['age']);
  $positions = sanitize_text_field($_POST['positions']);
  $register_position = sanitize_text_field($_POST['register_position']);

  $general = sanitize_text_field($_POST['general']);
  $attack = sanitize_text_field($_POST['attack']);
  $pass_dribble = sanitize_text_field($_POST['pass_dribble']);
  $defence = sanitize_text_field($_POST['defence']);
  $goalkeeper = sanitize_text_field($_POST['goalkeeper']);
  $index = array(
    'general' => $general,
    'attack' => $attack,
    'pass_dribble' => $pass_dribble,
    'defence' => $defence,
    'goalkeeper' => $goalkeeper
  );

  update_post_meta($post_id, 'face_img', $face_img);
  update_post_meta($post_id, 'name', $name);
  update_post_meta($post_id, 'shirt_name', $shirt_name);
  update_post_meta($post_id, 'shirt_number', $shirt_number);
  update_post_meta($post_id, 'nationality', $nationality);
  update_post_meta($post_id, 'height', $height);
  update_post_meta($post_id, 'weight', $weight);
  update_post_meta($post_id, 'age', $age);
  update_post_meta($post_id, 'positions', $positions);
  update_post_meta($post_id, 'register_position', $register_position);
  update_post_meta($post_id, 'index', $index);
}

add_filter('manage_ai_fm_player_posts_columns', 'ai_fm_player_posts_columns');
function ai_fm_player_posts_columns($columns)
{
  return array(
    'cb' => '<input type="checkbox" />',
    'title' => __('Title'),
    'name' => __('Name'),
    'nationality' => __('Nationality'),
    'height' => __('Height'),
    'weight' => __('Weight'),
    'age' => __('Age'),
    'date' => __('Date')
  );

  return $columns;
}
