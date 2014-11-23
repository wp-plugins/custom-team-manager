<?php
//shortcode for team-members page
function ibn_custom_team_members($atts, $content = null) {
	extract(shortcode_atts(array(
		'num_cols' => 4,
		), $atts));

?>
<div id="id-cmt-wrapper" class="cmt-wrapper mobile">
	<div class="cmt-members">
		<?php if( !empty($content) ) { ?>
			<header class="cmt-header">
					<h1 class="cmt-title"><?php echo $content; ?></h1>
			</header>
		<?php } 

		$mem_per_page = get_option( 'cmt_mem_per_page' );

		if(!empty($mem_per_page)){ $per_page = $mem_per_page; } else{ $per_page = -1; }
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'cmt-management-team',
			'posts_per_page' => $per_page,
			'paged' => $paged
		);
		query_posts( $args );
		if( have_posts() ) {
			$loop = 1;
			$column = 4;
			$lastcolumn = 3;
		while( have_posts() ) {	the_post();
		?>
		
		<?php 
			if($loop%2!=0 && $loop !=1) { $cls=" clearPad"; }
			else{ $cls=""; }
			if($loop == $column){ $cls.=" firstCol"; $column=$column + 3; }								
			if($loop == $lastcolumn){ $cls.=" lastCol"; $lastcolumn=$lastcolumn + 3; }								
			
		?>
		<div class="col-one-fourth<?php echo $cls; ?>">					
			<?php 
			// check if single page or not.
			$profile_single = get_option( 'cmt_single_page' );
			
			
			if($profile_single == 0){  // is not single page
				$profile_link = get_post_permalink();
			}else{	// is single page.
				//which page to show profiles.
				$cmt_profile_page = get_option( 'cmt_profile_page' );
				$name = get_the_title();
				$link = preg_replace('/\s+/', '-', $name); 
				$page_slug = get_permalink( $cmt_profile_page['page_id'], false );
				
				$profile_link = $page_slug.'/#'.$link;
				
		
			}
			
			if( has_post_thumbnail() ){ ?>
				<a href="<?php echo $profile_link; ?>"><?php the_post_thumbnail('full'); ?></a>
			<?php } ?>
			<a href="<?php echo $profile_link; ?>"><h4 class="cmt-name"><?php the_title(); ?></h4></a>
			<p><strong><em>
			  <?php
				  // If we are in a loop we can get the post ID easily
				  $role = get_post_meta( get_the_ID(), 'cmt_member_role', true );
				  echo $role;
			  ?>
			</em></strong></p>
			<?php the_excerpt(); ?>
			<a class="cmt-full-profile" href="<?php echo $profile_link; ?>">Full Profile ...</a>
		</div>
			
		<?php $loop++; ?>
		<?php  }	// endwhile - of the loop. ?>
		<div class="clear"></div>

		<?php if(!get_option( 'cmt_ajax_load' )){ cmt_team_members_nav(); } ?>
<?php	
/**
 * Load More members with AJAX if cmt_ajax_load is true
 */
 
 $ajax_load_result = get_option( 'cmt_ajax_load' );

 if($ajax_load_result){

 	// Add code to index pages.  && $post_type == 'cmt-management-team'
 	if( !is_admin()  ) {	
 		// Queue JS and CSS
 		wp_enqueue_script(
 			'cmt-load-more-members',
 			plugin_dir_url( dirname(__FILE__)  ) . 'js/cmt-load-more-members.js',
 			array('jquery'),
 			'2.3.2',
 			true
 		);
 	
		$count_posts = wp_count_posts('cmt-management-team');
		$published_posts = $count_posts->publish; 		
 		// What page are we on? And what is the pages limit?

		$mem_per_page = get_option( 'cmt_mem_per_page' );
		$max = 0;
		if(!empty($mem_per_page)){
			$max = $published_posts / $mem_per_page;
			if($published_posts % $mem_per_page != 0) { $max = $max + 1; }
		}
 		$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
		
 		// Add some parameters for the JS.
 		wp_localize_script(
 			'cmt-load-more-members',
 			'cmt_data',
 			array(
 				'startPage' => $paged,
 				'maxPages' => $max,
 				'nextLink' => next_posts($max, false)
 			)
 		);
 	}
 }
 ?>
 
 
		<?php
		}else{	// end if
			echo 'There is no member added yet. Please add members through Management Team on Dashboard.';
		} 	
		?>
		<?php wp_reset_query(); ?>
		
				
	</div><!-- #cmt-content -->
</div><!-- #id-cmt-wrapper -->
<?php
}
function register_shortcodes(){
   add_shortcode('team-members', 'ibn_custom_team_members');
}
add_action( 'init', 'register_shortcodes');


//shortcode for team-members-profile page
function ibn_custom_team_members_profile($atts, $content = null) {
	extract(shortcode_atts(array(
		'num_cols' => 4,
		), $atts));

?>
<div id="id-cmt-wrapper" class="cmt-wrapper">
	<div id="cmt-content">
		<?php if( !empty($content) ) { ?>
			<header class="cmt-header">
					<h1 class="cmt-title"><?php echo $content; ?></h1>
			</header>
		<?php } ?>
		<div id="cmt-profile-content">
		
			<?php 		
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'cmt-management-team',
				'posts_per_page' => -1,
				'paged' => $paged
			);
			query_posts( $args );
			if( have_posts() ) {
				$loop = 1;
				$column = 1;
				while( have_posts() ) {  the_post();
			?>			
		
			<?php 
			
			$name = get_the_title(); 
			$link = preg_replace('/\s+/', '-', $name); 
			?>
			<div id="<?php echo $link; ?>" class="cmt_profile">
				<?php if( has_post_thumbnail() ){ ?>
					<div class="cmt_profile_pic">					
						  <?php the_post_thumbnail('full alignleft'); ?>
					</div>
				<?php } ?>
				<strong><span style="font-size: 12.0pt; color: #1f497d; display: block; padding-top: 5px;"><?php the_title(); ?></span></strong>
				<strong><span style="font-size: 10.0pt; color: #1f497d;"><em>
				<?php
					  // If we are in a loop we can get the post ID easily
					  $role = get_post_meta( get_the_ID() , 'cmt_member_role', true );
					  echo $role;
				  ?></em></span></strong>

				<?php the_content(); ?>
				<div class="clear"></div>
				
				<?php
					//Show member's facebook
				$facebook = get_post_meta( get_the_ID() , 'cmt_member_facebook', true );					  
				if( !empty($facebook) ){  ?>
					<a target="_blank" title="Facebook Profile" href="<?php echo $facebook; ?>"><span style="font-size: small;"><img class="cmt-social" src="<?php echo plugins_url( 'images/facebook.png', dirname(__FILE__)  ); ?>" alt="" width="40" height="40" border="0" /></span></a>
				
				<?php } ?>
				
				
				<?php
					//Show member's twitter
				$twitter = get_post_meta( get_the_ID() , 'cmt_member_twitter', true );					  
				if( !empty($twitter) ){  ?>
					<a target="_blank" title="Twitter Profile" href="<?php echo $twitter; ?>"><span style="font-size: small;"><img class="cmt-social" src="<?php echo plugins_url( 'images/twitter.png', dirname(__FILE__)  ); ?>" alt="" width="40" height="40" border="0" /></span></a>
				
				<?php } ?>
				
				<?php
					//Show member's linkedin
				$linkedin = get_post_meta( get_the_ID() , 'cmt_member_linkedin', true );					  
				if( !empty($linkedin) ){  ?>
					<a target="_blank" title="LinkedIn Profile" href="<?php echo $linkedin; ?>"><span style="font-size: small;"><img class="cmt-social" src="<?php echo plugins_url( 'images/linkedin.png', dirname(__FILE__)  ); ?>" alt="" width="40" height="40" border="0" /></span></a>
				
				<?php } ?>
			</div>
			<div class="clear"></div>
			<?php  }	// end of the loop. 
			}else{	// end if
				echo 'There is no member added yet. Please add members through Management Team on Dashboard.';
			} 	
			?>
			<?php wp_reset_query(); ?>
		</div>
				
	</div><!-- #content -->
</div><!-- #primary -->
<?php
}
function register_shortcodes_members_profile(){
   add_shortcode('team-members-profile', 'ibn_custom_team_members_profile');
}
add_action( 'init', 'register_shortcodes_members_profile');

// to show some content
function cmt_content_func( $atts, $content="" ) {
     echo "$content";
}
add_shortcode( 'cmt-content', 'cmt_content_func' );

?>