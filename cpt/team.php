<?php

if( ! defined('ABSPATH') ) exit;

add_action('init', 'register_cpt_ai_fm_team');
function register_cpt_ai_fm_team(){
	register_post_type('ai_fm_team', array(
		'labels'             => array(
			'name'               => __('Team', 'ai-fm-team'), 
			'singular_name'      => __('Team', 'ai-fm-team'),
			'add_new'            => __('Add new', 'ai-fm-team'),
			'add_new_item'       => __('Add new team', 'ai-fm-team'),
			'edit_item'          => __('Edit new', 'ai-fm-team'),
			'new_item'           => __('New item', 'ai-fm-team'),
			'view_item'          => __('View', 'ai-fm-team'),
			'search_items'       => __('Search', 'ai-fm-team'),
			'menu_name'          => __('Team', 'ai-fm-team')
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
		'supports'           => array('title','excerpt')
	) );
}

// Declare meta boxes
add_action( 'add_meta_boxes', 'ai_fm_team_meta_box', 0 );
function ai_fm_team_meta_box() {
    add_meta_box( 'ai_fm_team_meta', __( 'Team Details', 'ai-fm-team' ), 'ai_fm_team_custom_box', 'ai_fm_team', 'normal', 'high' );
}

function ai_fm_team_custom_box( $post ) {
    wp_nonce_field( 'ai_fm_team_custom_box', 'ai_fm_team_custom_box_nonce' );
    $name = get_post_meta( $post->ID, 'name', true );
    $discount = get_post_meta( $post->ID, 'discount', true );
  ?>
<div class="custom-meta-row">
    <label for="name">Name:</label>
    <input type="text" min="0" max="100" id="name" name="name" value="<?php echo esc_attr( $name ); ?>" />
</div>
<div class="custom-meta-row">
    <label for="discount">Discount:</label>
    <input type="number" min="0" max="100" id="discount" name="discount" value="<?php echo esc_attr( $discount ); ?>" />
</div>
<?php }

add_action( 'save_post', 'save_data_ai_fm_team' );
function save_data_ai_fm_team( $post_id ) {
    if ( ! isset( $_POST['ai_fm_team_custom_box_nonce'] ) )
     return $post_id;
    $nonce = $_POST['ai_fm_team_custom_box_nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ai_fm_team_custom_box' ) )
      return $post_id;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    if ( ! current_user_can( 'edit_post', $post_id ) )
      return $post_id;

    $name = sanitize_text_field( $_POST['name'] );
    $discount = sanitize_text_field( $_POST['discount'] );

    update_post_meta( $post_id, 'name', $name );
    update_post_meta( $post_id, 'discount', $discount );
}

add_filter('manage_ai_fm_team_posts_columns' , 'ai_fm_team_posts_columns');
function ai_fm_team_posts_columns($columns) {
                return array(
                                'cb' => '<input type="checkbox" />',
                                'title' => __('Title'),
                                'discount' =>'<span class="text-center">' . __( 'Discount') . '</span>',
                                'date' =>__( 'Date')
                         );

                    return $columns;
                }

add_action('manage_posts_custom_column' , 'ai_fm_team_posts_columns_data', 10, 2);
function ai_fm_team_posts_columns_data($column, $post_id) {
    if ($column === 'discount') {
        $discount = get_post_meta( $post_id, 'discount', true );
        echo '<span class="text-center">' . $discount . '</span>';
    }
}
