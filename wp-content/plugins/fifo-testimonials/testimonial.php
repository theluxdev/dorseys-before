<?php 
/*
Plugin Name: FIFO Testimonials 
Plugin URI: http://www.fifolab.com.bd/plugins/fifo-testimonials/
Description: FIFO Testimonials is an easy to use Testimonial Manager that allows you to easily gather and display testimonials on your WordPress site via shortcode. 
Version: 1.0.1
Author: Monzurul Haque
Author URI: http://www.fifolab.com.bd/
License: GPL2 or Later
*/


define('FIFOLAB_VERSION', '1.0.0');
define('FIFOLAB_PLUGIN_URL', plugin_dir_url( __FILE__ ));


#} Hooks
    
 
	
	 #} general
    add_action('init', 'fifolab__init');
    add_action('admin_menu', 'fifolab__admin_menu'); #} Initialise Admin menu
	
	#} Page slugs
    global $fifolab_slugs;
    
    $fifolab_slugs['settings']         = "fifolab-settings";
	
	#} Add le admin menu
function fifolab__admin_menu() {
	global $fifolab_slugs;
    
    
    $fifolab_menu = add_submenu_page( 'edit.php?post_type=testimonial', 'Testimonial Settings', 'Settings', 'manage_options', $fifolab_slugs['settings'], 'fifolab_pages_settings', '');
  
    
}



#} Options page
function fifolab_pages_settings() {
    
    global $wpdb, $fifolab_version;    #} Req
    
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    
?><div id="sgpBod">
       
        <div class='mysearch'>
        	
        
            
                
         <?php
         	if(isset($_GET['save'])){ 
             if ($_GET['save'] == "1"){
                fifolab_html_save_settings();
             }
		    }
            if(!isset($_GET['save'])){
                fifolab_html_settings();
            }
    ?></div>
</div>
<?php
}


 function fifolab_html_settings(){
        
    global $wpdb, $fifolab_slugs;  #} Req
    
    $fifoConfig = array();
    $fifoConfig['post_per_page']    =       get_option('post_per_page');    //default factor for K
    //$fifoConfig['unamecolor']  		=       get_option('unamecolor');
    
    
    ?>
    
	 <div class="postbox">
     <form action="edit.php?post_type=testimonial&page=<?php echo $fifolab_slugs['settings']; ?>&save=1" method="post">
     
     <h3><label>Testimonial settings</label></h3>
     
     <table class="form-table" width="100%" border="0" cellspacing="0" cellpadding="6">
         
        <tr valign="top">
            <td width="25%" align="left"><strong>Testimonials per page:</strong></td>
            <td align="left"><input id=post_per_page name=post_per_page type="text" placeholder="Put the posts number here..." size="40" value = '<?php echo $fifoConfig['post_per_page']; ?>' /><i>Default value is 6</i></td>
        </tr>       
         
    </table>
    <p id="footerSub"><input class = "button-primary" type="submit" value="Save settings" /></p>
    </form>
</div>


<?php }



#} Save options changes
function fifolab_html_save_settings(){
    
    global $wpdb, $fifolab_slugs;  #} Req
    
    $fifoConfig = array();
    $fifoConfig['post_per_page'] 		=           $_POST['post_per_page'];
    
    
    #} Save down
    update_option("post_per_page", $fifoConfig['post_per_page']);
    
    #} Msg
    fifolab_html_msg(0,"Saved options");
    
    #} Run standard
    fifolab_html_settings();
    
}

#} Outputs HTML message
function fifolab_html_msg($flag,$msg,$includeExclaim=false){
    
    if ($includeExclaim){ $msg = '<div id="sgExclaim">!</div>'.$msg.''; }
    
    if ($flag == -1){
        echo '<div class="sgfail wrap">'.$msg.'</div>';
    }
    if ($flag == 0){ ?>
        <div id="message" class="updated fade below-h2"><p><strong>Settings saved!</strong></p></div>
    <?php }
    if ($flag == 1){
        echo '<div class="sgwarn wrap">'.$msg.'</div>';
    }
    if ($flag == 2){
        echo '<div class="sginfo wrap">'.$msg.'</div>';
    }
    if ($flag == 666){ ?>
        <div id="message" class="updated fade below-h2"><p><strong><?php echo $msg; ?>!</strong></p></div>
    <?php }
}


/* settings link in plugin management screen */
function fifolab_testimonials_settings_link($actions, $file) {
	global $fifolab_slugs;
	

 $actions['settings'] = '<a href="edit.php?post_type=testimonial&page=fifolab-settings">Settings</a>';
return $actions; 
}
add_filter('plugin_action_links', 'fifolab_testimonials_settings_link', 2, 2);


	
	function fifolab__init(){

 		
		wp_enqueue_style('fifolab__init', plugins_url('/css/style.css',__FILE__) );
		
		 #} Admin only
    if (is_admin()) {
        
        #} Admin CSS
        wp_enqueue_style('mysmashCSSADM', plugins_url('/css/MySmashAdmin.css',__FILE__) );
	}
 
	}

add_action( 'admin_head', 'fifolab_testimonial_post_type_icons' );
function fifolab_testimonial_post_type_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-testimonial .wp-menu-image {
            background: url(<?php echo FIFOLAB_PLUGIN_URL; ?>img/users.png) no-repeat 6px -17px !important;
        }
	#menu-posts-testimonial:hover .wp-menu-image, #menu-posts-testimonial.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }
    </style>
    
<?php
	
}

	// function: testimonial_post_type BEGIN
	function fifolab_testimonial_post_type()
	{
		// We will fill this function in the next step
	// function: testimonial_post_type END


	$labels = array(
		'name' => __('Testimonials'), 
		'singular_name' => __('Testimonial'),
		'rewrite' => array(
			'slug' => __( 'testimonial' ) 
			),
		'add_new' => _x('Add Testimonial', 'testimonial'), 
		'add_new_item' => __('Add New Testimonial'),
		'edit_item' => __('Edit Testimonial Item'),
		'new_item' => __('New Testimonial Item'),
		'all_items' => __('All Testimonials'), 
		'view_item' => __('View Testimonial'),
		'search_items' => __('Search Testimonial'), 
		'not_found' =>  __('No Testimonial Items Found'),
		'not_found_in_trash' => __('No Testimonial Items Found In Trash'),
		'parent_item_colon' => ''
	);
	
	
	// Set Up The Arguements
	$args = 
	array(
		// Pass The Array Of Labels
		'labels' => $labels, 
		
		// Display The Post Type To Admin
		'public' => true, 
		
		// Allow Post Type To Be Queried 
		'publicly_queryable' => true, 
		
		// Build a UI for the Post Type
		'show_ui' => true, 
		
		// Use String for Query Post Type
		'query_var' => true, 
		
		// Rewrite the slug
		'rewrite' => true, 
		
		// Set type to construct arguements
		'capability_type' => 'post', 
		
		// Disable Hierachical - No Parent
		'hierarchical' => false, 
		
		// Set Menu Position for where it displays in the navigation bar
		'menu_position' => null, 
		
		
		// Allow the testimonial to support a Title, Editor, Thumbnail
		'supports' => 
			array(
				'title',
				'editor'
			) 
	);
	
	// Register The Post Type
	register_post_type(__( 'testimonial' ),$args);
	
	
} // function: testimonial_post_type END


// function: testimonial_messages BEGIN
function fifolab_testimonial_messages($messages)
{	global $post;
	$messages[__( 'testimonial' )] = 
		array(
			// Unused. Messages start at index 1
			0 => '',
			
			// Change the message once updated
			1 => sprintf(__('Testimonial Updated. <a href="%s">View testimonial</a>'), esc_url(get_permalink($post->ID))),
			
			// Change the message if custom field has been updated
			2 => __('Custom Field Updated.'),
			
			// Change the message if custom field has been deleted
			3 => __('Custom Field Deleted.'),
			
			// Change the message once testimonial been updated
			4 => __('Testimonial Updated.'),
			
			// Change the message during revisions
			5 => isset($_GET['revision']) ? sprintf( __('Testimonial Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'],false)) : false,
			
			// Change the message once published
			6 => sprintf(__('Testimonial Published. <a href="%s">View Testimonial</a>'), esc_url(get_permalink($post->ID))),
			
			// Change the message when saved
			7 => __('Testimonial Saved.'),
			
			// Change the message when submitted item
			8 => sprintf(__('Testimonial Submitted. <a target="_blank" href="%s">Preview Testimonial</a>'), esc_url( add_query_arg('preview','true',get_permalink($post->ID)))),
			
			// Change the message when a scheduled preview has been made
			9 => sprintf(__('Testimonial Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Testimonial</a>'),date_i18n( __( 'M j, Y @ G:i' ),strtotime($post->post_date)), esc_url(get_permalink($post->ID))),
			
			// Change the message when draft has been made
			10 => sprintf(__('Testimonial Draft Updated. <a target="_blank" href="%s">Preview Testimonial</a>'), esc_url( add_query_arg('preview','true',get_permalink($post->ID)))),
		);
	return $messages;	
	
} // function: testimonial_messages END


// Custom meta boxes

$prefix = 'fifolab_';

$meta_box = array(
    'id' => 'fifolab',
    'title' => 'Clients Information',
    'page' => 'testimonial',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(

        array(
            'name' => 'Client Name',
            'desc' => '',
            'id' =>  '_testimonial_username',
            'type' => 'text',
            'std' => ''
        ),
		
		array(
            'name' => 'Client Gender',
            'desc' => '',
            'id' => '_gender_type',
            'type' => 'radio',
			'options' => array(
                array('name' => 'Male', 'value' => 'male'),
                array('name' => 'Female', 'value' => 'female')
            ),
            'std' => ''
        ),

        array(
            'name' => 'Company Name',
            'desc' => '',
            'id' => '_testimonial_companyname',
            'type' => 'text',
            'std' => ''
        ),
		
		array(
            'name' => 'Company URL',
            'desc' => '',
            'id' => '_testimonial_url',
            'type' => 'text',
            'std' => ''
        ),
		
		
    ),

);

add_action('admin_menu', 'fifolab_add_box');

// Add meta box
function fifolab_add_box() {
    global $meta_box;

    add_meta_box($meta_box['id'], $meta_box['title'], 'fifolab_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function fifolab_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="fifolab_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table>';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width: 97%; height: 32px; margin-bottom: 10px;" />',
                    '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea  name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
                    '<br />', $field['desc'];

                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>',
                '<br />', $field['desc'];
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input style="margin-bottom: 10px;" type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' /><span style="margin:0 15px 0 5px;">', $option['name'],'</span>';
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}

add_action('save_post', 'fifolab_save_data');

// Save data from meta box
function fifolab_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['fifolab_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}


add_action('init', 'fifolab_testimonial_post_type');
add_filter('post_updated_messages', 'fifolab_testimonial_messages');



function fifolab_testimonial_display() {
	
						// To evaluate the Offset value which will be used to calculatet he testimonial id number
						global $post;
						$count_posts = wp_count_posts('testimonial');
						$posts_per_page = get_option('post_per_page');
						
							if($posts_per_page == '')
								{
									$ppp = 6;
								}
							else
								{
									$ppp = $posts_per_page;
								}
						$count_posts->max_num_pages = ceil( $count_posts->publish / $ppp );
						$on_page = intval( get_query_var( 'paged' ) );
		
							if( $on_page == 0 ){ 
								$on_page = 1; 
							}		
						$offset = ( $on_page - 1 ) * $ppp;
						
						
						// Set the page to be pagination
						$paged = get_query_var('paged') ? get_query_var('paged') : 1;
						
						// Query Out Database
						$wpbp = new WP_Query(array( 'post_type' => 'testimonial', 'posts_per_page' => $posts_per_page, 'paged' => $paged ) ); 
						
						
						echo'<div class="testimonials component"><div class="testimonials-list">';
			
					//$offset = 6;
					$count = 1+$offset; 
						// Begin The Loop
						if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post(); 
			
                            echo'<div id="quote-'; echo $count; 
                            echo'" class="testimonial">';
							echo'<blockquote class="testimonials-text"><q>';
							 echo the_content();
							echo'</q><div class="arrow-down"></div><div class="fix">';
								$gender = get_post_meta($post->ID, "_gender_type", true);
								if (!$gender) $gender = 'male'; 
							echo'<span class="company-name ';
								if($gender == 'female') {echo "female";} else echo "male"; 
							echo'"><a target="_blank" rel="nofollow" href="';
								echo get_post_meta($post->ID, "_testimonial_url", true); 
							echo'">'; 
								$turl = get_post_meta($post->ID, "_testimonial_companyname", true); 
								if($turl){ echo $turl.",";} else echo ""; 
							echo'</a> <strong>';
							 	echo get_post_meta($post->ID, "_testimonial_username", true); 
							echo'</strong></span></div></blockquote></div>';
                            
                           		$count++; endwhile; endif; // END the Wordpress Loop
								wp_reset_query(); // Reset the Query Loop
			
							echo'</div>';
				
				
				
									  /* 
									   * Download WP_PageNavi Plugin at: http://wordpress.org/extend/plugins/wp-pagenavi/
									   * Page Navigation Will Appear If Plugin Installed or Fall Back To Default Pagination
									  */		
									  if(function_exists('wp_pagenavi'))
									  {				 
										  wp_pagenavi(array( 'query' => $wpbp ) );
										  wp_reset_postdata();	// avoid errors further down the page
									  }
									  
									
					
		
}


function fifolab_testimonial_shortcode( $atts, $content = null ) {
	
	$content = fifolab_testimonial_display();
	
	return $content;
}
add_shortcode('testimonials', 'fifolab_testimonial_shortcode');


?>
