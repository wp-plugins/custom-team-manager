<?php/*  Custom post - Management Team */function cmt_team_manager() {  $labels = array(    'name'               => _x( 'Management Team', 'cmt-management-team' ),    'singular_name'      => _x( 'Management Team', 'cmt-management-team' ),    'add_new'            => _x( 'Add New Member', 'member' ),    'add_new_item'       => __( 'Add New Member' ),    'edit_item'          => __( 'Edit Member' ),    'new_item'           => __( 'New Member' ),    'all_items'          => __( 'All Members' ),    'view_item'          => __( 'View Member' ),    'search_items'       => __( 'Search Members' ),    'not_found'          => __( 'No Member found' ),    'not_found_in_trash' => __( 'No Member found in the Trash' ),     'parent_item_colon'  => '',    'menu_name'          => 'Management Team'  );  $args = array(    'labels'        => $labels,    'description'   => 'Team Members Add',    'public'        => true,    'menu_position' => 25,    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),    'has_archive'   => true  );  register_post_type( 'cmt-management-team', $args ); }add_action( 'init', 'cmt_team_manager' );//Check if "Post Types Order" plugin is installed or notadd_action('admin_init', 'cmt_pto_init');function cmt_pto_init(){    // if - in wp-admin and class of CPTOrderPosts not found	    if (!class_exists('Post_Types_Order_Walker') && current_user_can('manage_options')){        // message function created on a fly...         $msg = create_function('', 'echo "<div class=\"updated\"><p>Post Types Order plugin is recommended to reorder your members.</p></div>";');        // and finaly notice!         add_action('admin_notices', $msg);    }}// Add meta box for Role of memberadd_action( 'add_meta_boxes', 'cmt_member_role_box' );function cmt_member_role_box() {    add_meta_box(         'cmt_member_role_box',        'Role of Member',        'cmt_member_role_box_content',        'cmt-management-team',        'normal',        'high'    );}function cmt_get_meta($meta_name, $post){	$meta_data = get_post_meta($post->ID, $meta_name, true);	//var_dump($meta_data);	if( !empty($meta_data) )		$save_meta = $meta_data;	else		$save_meta = '';		return $save_meta;}function cmt_member_role_box_content( $post ) {  echo '<label for="cmt_member_role">Role of Member</label>';  $input_value = cmt_get_meta('cmt_member_role', $post);    echo ' <input type="text" id="cmt_member_role" name="cmt_member_role" placeholder="Enter Member Role" 		value="'.$input_value.'"/>';}add_action( 'save_post', 'cmt_member_role_box_save' );function cmt_member_role_box_save( $post_id ) {  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )   return;  if ( 'page' == $_POST['post_type'] ) {    if ( !current_user_can( 'edit_page', $post_id ) )    return;  } else {    if ( !current_user_can( 'edit_post', $post_id ) )    return;  }  $member_role= $_POST['cmt_member_role'];  update_post_meta( $post_id, 'cmt_member_role', $member_role);}// Add meta box for facebook linkadd_action( 'add_meta_boxes', 'cmt_member_facebook_box' );function cmt_member_facebook_box() {    add_meta_box(         'cmt_member_facebook_box',        'Facebook Profile Link',        'cmt_member_facebook_box_content',        'cmt-management-team',        'normal',        'high'    );}function cmt_member_facebook_box_content( $post ) {  echo '<label for="cmt_member_facebook">Facebook Profile Link</label>';  $input_value = cmt_get_meta('cmt_member_facebook', $post);  echo '<input type="text" id="cmt_member_facebook" name="cmt_member_facebook" placeholder="eg. https://www.facebook.com/" value="'.$input_value. '"/>';}add_action( 'save_post', 'cmt_member_facebook_box_save' );function cmt_member_facebook_box_save( $post_id ) {  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )   return;    if ( 'page' == $_POST['post_type'] ) {    if ( !current_user_can( 'edit_page', $post_id ) )    return;  } else {    if ( !current_user_can( 'edit_post', $post_id ) )    return;  }  $member_facebook= $_POST['cmt_member_facebook'];  update_post_meta( $post_id, 'cmt_member_facebook', $member_facebook);}// Add meta box for twitter linkadd_action( 'add_meta_boxes', 'cmt_member_twitter_box' );function cmt_member_twitter_box() {    add_meta_box(         'cmt_member_twitter_box',        'Twitter Profile Link',        'cmt_member_twitter_box_content',        'cmt-management-team',        'normal',        'high'    );}function cmt_member_twitter_box_content( $post ) {  echo '<label for="cmt_member_twitter">Twitter Profile Link</label>';  $input_value = cmt_get_meta('cmt_member_twitter', $post);  echo '<input type="text" id="cmt_member_twitter" name="cmt_member_twitter" placeholder="eg. https://www.twitter.com/" value="'.$input_value. '"/>';}add_action( 'save_post', 'cmt_member_twitter_box_save' );function cmt_member_twitter_box_save( $post_id ) {  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )   return;    if ( 'page' == $_POST['post_type'] ) {    if ( !current_user_can( 'edit_page', $post_id ) )    return;  } else {    if ( !current_user_can( 'edit_post', $post_id ) )    return;  }  $member_twitter= $_POST['cmt_member_twitter'];  update_post_meta( $post_id, 'cmt_member_twitter', $member_twitter);}// Add meta box for linkedin of memberadd_action( 'add_meta_boxes', 'cmt_member_linkedin_box' );function cmt_member_linkedin_box() {    add_meta_box(         'cmt_member_linkedin_box',        'Linkedin Profile Link',        'cmt_member_linkedin_box_content',        'cmt-management-team',        'normal',        'high'    );}function cmt_member_linkedin_box_content( $post ) {  echo '<label for="cmt_member_linkedin">Linkedin Profile Link</label>';  $input_value = cmt_get_meta('cmt_member_linkedin', $post);  echo '<input type="text" id="cmt_member_linkedin" name="cmt_member_linkedin" placeholder="eg. https://www.linkedin.com/" value="'.$input_value. '"/>';}add_action( 'save_post', 'cmt_member_linkedin_box_save' );function cmt_member_linkedin_box_save( $post_id ) {  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )   return;    if ( 'page' == $_POST['post_type'] ) {    if ( !current_user_can( 'edit_page', $post_id ) )    return;  } else {    if ( !current_user_can( 'edit_post', $post_id ) )    return;  }  $member_linkedin= $_POST['cmt_member_linkedin'];  update_post_meta( $post_id, 'cmt_member_linkedin', $member_linkedin);}?>