<?php
/**
* Plugin Name: Voter Guide
* Plugin URI: 
* Description: Voter Guide is a free WordPress plugin giving your site visitor an easy way to find United States US senators and representatives.
* Version: 1.0
* Author: Loft
* Author URI: 
**/ 
if ( !defined('ABSPATH') ) exit();
define('DAB_PATH_URL', plugin_dir_url(__FILE__));
define('DAB_PATH', plugin_dir_path(__FILE__));
define('DAB_PATH_BASE', plugin_dir_path(__FILE__));
defined('DAB_QUESTIONNARIE') or define('DAB_QUESTIONNARIE', 'dab-questionnaire');
register_activation_hook( __FILE__, 'dab_install' );
require_once(ABSPATH . 'wp-admin/includes/file.php');
define( 'CUSTOM_METABOXES_DIR', DAB_PATH_URL .'/admin/metaboxes' );
require_once('inc/admin_function.php');
function dab_install()
{
	update_option('dab_cache', 1);
	update_option('dab_cache_time', 30);
	update_option('dab_themes', 'modern');
	//update_option('dab_select_choice' , 'all');
	update_option('dab_photos_last_modified', '1307992245');
	update_option('dab_options', array(0=>'title', 1=>'first_name', 2=>'last_name', 3=>'picture', 4=>'chamber', 5=>'state_rank', 6=> 'state_name', 7=> 'website', 8=> 'contact_form'));
}
add_action( 'admin_menu','register_my_custom_menu_page');
function register_my_custom_menu_page() {
	
	$iconURL= DAB_PATH_URL .'assets/img/dashicons-dab.png';
	add_menu_page('Dab', 'DAB', 'manage_options', 'dab-productions','dashboard_page',$iconURL);
	add_submenu_page('dab-productions', 'Settings', 'Settings', 'manage_options', 'dab-settings','setting_page'); 
	add_submenu_page('dab-productions', 'Questionnaire', 'Questionnaire', 'manage_options', 'edit.php?post_type='.DAB_QUESTIONNARIE); 
}	

function dashboard_page(){
	// include page	
	require_once(DAB_PATH.'inc/dashboard.php');
}
function setting_page(){
	// include page
	require_once(DAB_PATH.'inc/setting_page.php');
}
add_action('init', 'init');
function init(){
	// include page
	require_once(DAB_PATH.'inc/shortcode/form-shortcode.php');
	require_once(DAB_PATH.'inc/templates/single-dab-questionnaire.php');
}


add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
  function load_admin_styles() {
	wp_enqueue_style( 'admin_css_dab', DAB_PATH_URL . 'assets/css/admin_style.css', false, '1.0.0' );
	wp_enqueue_script( 'admin_jsdab', DAB_PATH_URL . 'assets/js/admin_dab.js', false, '1.0.0' );
  }  
add_action( 'wp_enqueue_scripts', 'load_dab_styles' );
  function load_dab_styles() {
	  wp_enqueue_script('jquery');
	wp_enqueue_style( 'main_css_dab', DAB_PATH_URL . 'assets/css/dab_style.css', false, '1.0.0' );
	wp_enqueue_script( 'main_jsdab', DAB_PATH_URL . 'assets/js/dab_script.js', false, '1.0.0' );
	//wp_enqueue_script('google_map_api', 'https://maps.googleapis.com/maps/api/js?key=' . , array('jquery'), false, true ) ;
	?>
	<script type="text/javascript">
		var ajaxurl = <?php echo json_encode( admin_url( "admin-ajax.php" ) ); ?>;      
		var security = <?php echo json_encode( wp_create_nonce( "dab-special-string" ) ); ?>;
	</script>
	<?php 
  }  
 add_action( 'admin_init', 'register_dab_plugin_settings' );


function register_dab_plugin_settings() {
	//register our settings
	register_setting( 'dab-plugin-settings-group', 'new_option_name' );
	register_setting( 'dab-plugin-settings-group', 'some_other_option' );
	register_setting( 'dab-plugin-settings-group', 'option_etc' );	
	register_setting( 'dab-plugin-settings-group', 'term_dab_option' );	
//register our settings
	register_setting( 'dab-form-question-group', 'field_option_name' );
}
add_action('init', 'register_questionnaire_post_types');
function register_questionnaire_post_types()
        {

            $post_type = DAB_QUESTIONNARIE;
            $slug = 'voter-guide';
            $name = $singular_name = 'Questionnaire List';

            if (post_type_exists($post_type)) {
                return;
            }
            $fat_event_setting = get_option('dab-questionnaire_setting');
            $slug = isset($fat_event_setting['dab-questionnaire_slug']) && $fat_event_setting['dab-questionnaire_slug'] ? $fat_event_setting['dab-questionnaire_slug'] : $slug;

            register_post_type($post_type,
                array(
                    'label' => esc_html__('Questionnaire List', 'dab-questionnaire'),
                    'description' => esc_html__('Questionnaire Description', 'dab-questionnaire'),
                    'labels' => array(
                        'name' => $name,
                        'singular_name' => $singular_name,
                        'menu_name' => ucfirst($name),
                        'parent_item_colon' => esc_html__('Parent Item:', 'dab-questionnaire'),
                        'all_items' => sprintf(esc_html__('All %s', 'dab-questionnaire'), $name),
                        'view_item' => esc_html__('View Questionnaire', 'dab-questionnaire'),
                        'add_new_item' => sprintf(esc_html__('Add New  %s', 'dab-questionnaire'), $name),
                        'add_new' => esc_html__('Add Questionnaire', 'dab-questionnaire'),
                        'edit_item' => esc_html__('Edit ', 'dab-questionnaire'),
                        'update_item' => esc_html__('Update Questionnaire', 'dab-questionnaire'),
                        'search_items' => esc_html__('Search Questionnaire', 'dab-questionnaire'),
                        'not_found' => esc_html__('Not found', 'dab-questionnaire'),
                        'not_found_in_trash' => esc_html__('Not found in Trash', 'dab-questionnaire'),
                    ),
                    'supports' => array('title', 'thumbnail'),
                    'public' => true,
                    'show_ui' => true,
                    '_builtin' => false,
                    'has_archive' => true,
					'show_in_menu' => 'edit.php?page=voter-guide',
                    'exclude_from_search' => true,
                    'menu_icon' => 'dashicons-calendar-alt',
                    'hierarchical' => true,
                    'rewrite' => array('slug' => $slug, 'with_front' => true),
                )
            );

            $flush_rewrite = get_option('dab_flush_rewrite',0);
            if($flush_rewrite!=1){
                flush_rewrite_rules();
                update_option('dab_flush_rewrite',1);
            }
 }

add_filter( 'single_template', 'dab_custom_post_type_template' );
function dab_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'dab-questionnaire' ) {
          $single_template = DAB_PATH.'inc/templates/single-dab-questionnaire.php';
     }
     return $single_template;
  
}	

