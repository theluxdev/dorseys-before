<?php
/**
 * @version   2.14 January 5, 2013
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
/*
Plugin Name: RokBox
Plugin URI: http://www.rockettheme.com
Description: RokBox, the successor of our popular RokZoom plugin, is a mootools powered JavaScript slideshow that allows you to quickly and easily display multiple media formats including images, videos (video sharing services also) and music.
Author: RocketTheme, LLC
Version: 2.14
Author URI: http://www.rockettheme.com
License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// No Direct Access
defined('ABSPATH') or die('Restricted access');

// RokBox defaults
global $rokbox_plugin_path, $rokbox_plugin_url;
if(!is_multisite()) {
	$rokbox_plugin_path = dirname($plugin);
} else {
	if(!empty($network_plugin)) {
		$rokbox_plugin_path = dirname($network_plugin);
	} else {
		$rokbox_plugin_path = dirname($plugin);
	}
}
$rokbox_plugin_url = WP_PLUGIN_URL.'/'.basename($rokbox_plugin_path);

function rokbox_options() {
	
	$rokbox_options = array(
	
		'theme' => 'light',
		'thumb_system' => 'default',
		'custom_theme' => 'sample',
		'custom_settings' => '0',
		'transition' => 'Quad.easeOut',
		'duration' => '200',
		'chase' => '40',
		'frame-border' => '20',
		'content-padding' => '0',
		'arrows-height' => '35',
		'effect' => 'quicksilver',
		'captions' => '1',
		'captionsDelay' => '800',
		'scrolling' => '0',
		'keyEvents' => '1',
		'overlay_background' => '#000000',
		'overlay_opacity' => '0.85',
		'overlay_duration' => '200',
		'overlay_transition' => 'Quad.easeInOut',
		'width' => '640',
		'height' => '460',
		'autoplay' => 'true',
		'controller' => 'true',
		'bgcolor' => '#f3f3f3',
		'ytautoplay' => '0',
		'ythighquality' => '0',
		'vimeoColor' => '00adef',
		'vimeoPortrait' => '0',
		'vimeoTitle' => '0',
		'vimeoFullScreen' => '1',
		'vimeoByline' => '0'
		
	);
	
	add_option('rokbox_options', $rokbox_options);
}

add_action('init','rokbox_options');

// Load Language

load_plugin_textdomain('rokbox', false, basename($rokbox_plugin_path).'/languages/');

// MooTools Init

add_action('init','rokbox_mootools_init',-50);
function rokbox_mootools_init(){
	global $rokbox_plugin_path, $rokbox_plugin_url;
	wp_register_script( 'mootools.js', $rokbox_plugin_url.'/js/mootools.js');
	wp_enqueue_script('mootools.js');
}

// Register Settings

function rokbox_register() {
	register_setting('rokbox_options_array', 'rokbox_options');
}

if(is_admin()) {

add_action('admin_init', 'rokbox_register');

}

// Add Settings

function rokbox_settings_add($links) {
	$settings_link = '<a href="plugins.php?page=rokbox-settings">'.__('Settings').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}

function rokbox_settings_action() {
	$plugin = plugin_basename(__FILE__); 
	add_filter('plugin_action_links_'.$plugin, 'rokbox_settings_add');
}

add_action('admin_menu', 'rokbox_settings_action');

// Add scripts

if(!is_admin()) {

	function rokbox_script() {
		global $rokbox_plugin_path, $rokbox_plugin_url;
		global $rokbox_render_config;
	
		$option = get_option('rokbox_options');
		$theme = $option['theme'];

		$remoteFolder = $rokbox_plugin_url.'/themes';
		$localFolder =  $rokbox_plugin_path.'/themes';
		
		if($theme == 'custom') $theme = trim($option['custom_theme']);
		$config_exists = file_exists($localFolder . "/$theme/rokbox-config.js");
		
		wp_register_style('rokbox-style.css', $remoteFolder.'/'.$theme.'/rokbox-style.css');
		wp_register_script('rokbox.js', $rokbox_plugin_url.'/rokbox.js');
		
		wp_enqueue_style('rokbox-style.css');
	
		// Load style for ie6 or ie7 if exist
	
		$iebrowser = getBrowser();
		if ($iebrowser) {
			if (file_exists($localFolder . "/$theme/rokbox-style-ie$iebrowser.php")) {
				wp_register_style('rokbox-style-ie'.$iebrowser.'.php', $remoteFolder.'/'.$theme.'/rokbox-style-ie'.$iebrowser.'.php');
				wp_enqueue_style('rokbox-style-ie'.$iebrowser.'.php');
			}
			elseif (file_exists($localFolder . "/$theme/rokbox-style-ie$iebrowser.css")) {
				wp_register_style('rokbox-style-ie'.$iebrowser.'.css', $remoteFolder.'/'.$theme.'/rokbox-style-ie'.$iebrowser.'.css');
				wp_enqueue_style('rokbox-style-ie'.$iebrowser.'.css');
			}
		}
		
		wp_enqueue_script('rokbox.js');
	
	}
	
	function rokbox_script_inline() {
		global $rokbox_plugin_path, $rokbox_plugin_url;
		global $rokbox_render_config;
	
		$option = get_option('rokbox_options');
		$theme = $option['theme'];

		$remoteFolder = $rokbox_plugin_url.'/themes';
		$localFolder =  $rokbox_plugin_path.'/themes';
		
		if($theme == 'custom') $theme = trim($option['custom_theme']);
		$config_exists = file_exists($localFolder . "/$theme/rokbox-config.js");
	
		echo '<script type="text/javascript">var rokboxPath = "'.$rokbox_plugin_url.'/";</script>'."\n";
		
		if($config_exists && $option['custom_settings'] != '1') :
			echo '<script type="text/javascript" src="'.$remoteFolder.'/'.$theme.'/rokbox-config.js"></script>'."\n";
		else :
			loadManualConfiguration($theme);
			echo $rokbox_render_config;
		endif;
	
	}

	add_action('wp_head', 'rokbox_script', 7);
	add_action('wp_head', 'rokbox_script_inline');
	
}

// Init the shortcodes

function rokbox_shortcode($atts, $content = null) {
	global $rokbox_plugin_path, $rokbox_plugin_url;
	$site_path = get_bloginfo('wpurl');
	$local_path = substr_replace(ABSPATH, '', -1);
	
	extract(shortcode_atts(array(
		'title' => '',
		'album' => '',
		'text' => '',
		'thumb' => '',
		'class' => '',
		'imgclass' => '',
		'size' => '',
		'twidth' => '150',
		'theight' => '100'
	), $atts));
	
	$isimage = 0;
	$is_wildcard = 0;
	$last3 = strtolower(substr($content, -3));
	$last4 = strtolower(substr($content, -4));
	$wildcard_check = strtolower(substr($content, -1));
	
	if($wildcard_check == '*') : $is_wildcard = 1; endif;
	
	$option = get_option('rokbox_options');
	
	// Default vars
	
	$content = trim($content);
	$display = '';
	$title = strip_tags($title);
	
	if($class != '') :	$link_class = $class; elseif($album != '') : $link_class = $album; else : $link_class = 'rokbox-image'; endif;
	if($size != '') : $size = '['.$size.']'; endif;
	if($album != '') : $album = '('.$album.')'; endif;

	if($is_wildcard) {
	
		$content = strtolower(substr_replace($content, '', -1));
		$cut_url = str_replace($site_path, $local_path, $content);
		$found_images = array();
		
		if ($handle = @opendir($cut_url)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					$ext = strtolower(substr($file, strrpos($file, '.') + 1));
					if ($ext == 'gif' || $ext == 'bmp' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
						array_push($found_images, $content.$file);
					}
				}
			}
			closedir($handle);

		}
		
	}
	
	if ($last3 == "jpg" || $last3 == "png" || $last3 == "bmp" || $last3 == "gif" || $last4 == "jpeg") :
		$isimage = 1;
	endif;
	
	$generate_rokbox = '';
	
	if ($is_wildcard) {
	
		foreach($found_images as $image) {
	
			if($option['thumb_system'] == 'default') :
			
				$img = rokbox_resize('', $image, $twidth, $theight, true);
						
				$generate_rokbox .= '<a rel="rokbox'.$size.$album.'" title="'.$title.'" href="'.$image.'" class="'.$link_class.'"><img src="'.$img['url'].'" alt="'.$title.'" class="'.$imgclass.'" /></a>';
			
			else :
		
				$generate_rokbox .= '<a rel="rokbox'.$size.$album.'" title="'.$title.'" href="'.$image.'" class="'.$link_class.'"><img src="'.$rokbox_plugin_url.'/thumb.php?src='.$image.'&amp;w='.$twidth.'&amp;h='.$theight.'&amp;zc=1&amp;q=75" alt="'.$title.'" class="'.$imgclass.'" /></a>';
					
			endif;
					
		}
		
	} else { 
	
		if($thumb != '') {
		
			$generate_rokbox = '<a rel="rokbox'.$size.$album.'" title="'.$title.'" href="'.$content.'" class="'.$link_class.'"><img src="'.$thumb.'" alt="'.$title.'" class="'.$imgclass.'" /></a>';
	
		} elseif($text != '') {
		
			$generate_rokbox = '<a rel="rokbox'.$size.$album.'" title="'.$title.'" href="'.$content.'" class="'.$link_class.'">'.$text.'</a>';
		
		} elseif($text == '' && !$isimage) {
		
			$text = 'Click me!';
			
			$generate_rokbox = '<a rel="rokbox'.$size.$album.'" title="'.$title.'" href="'.$content.'" class="'.$link_class.'">'.$text.'</a>';
		
		} elseif($isimage) {
		
			if($option['thumb_system'] == 'default') :
			
				$img = rokbox_resize('', $content, $twidth, $theight, true);
						
				$generate_rokbox = '<a rel="rokbox'.$size.$album.'" title="'.$title.'" href="'.$content.'" class="'.$link_class.'"><img src="'.$img['url'].'" alt="'.$title.'" class="'.$imgclass.'" /></a>';
			
			else :
		
				$generate_rokbox = '<a rel="rokbox'.$size.$album.'" title="'.$title.'" href="'.$content.'" class="'.$link_class.'"><img src="'.$rokbox_plugin_url.'/thumb.php?src='.$content.'&amp;w='.$twidth.'&amp;h='.$theight.'&amp;zc=1&amp;q=75" alt="'.$title.'" class="'.$imgclass.'" /></a>';
					
			endif;
		
		}
	
	}
	
	return $generate_rokbox;
	
}

add_shortcode('rokbox', 'rokbox_shortcode');

// Manual Configuration

function loadManualConfiguration($theme) {

	global $rokbox_render_config;

	$option = get_option('rokbox_options');
	
	$config = "
	if (typeof(RokBox) !== 'undefined') {
		window.addEvent('domready', function() {
			var rokbox = new RokBox({
				'className': 'rokbox',
				'theme': '".$theme."',
				'transition': Fx.Transitions.".$option['transition'].",
				'duration': ".$option['duration'].",
				'chase': ".$option['chase'].",
				'frame-border': ".$option['frame-border'].",
				'content-padding': ".$option['content-padding'].",
				'arrows-height': ".$option['arrows-height'].",
				'effect': '".$option['effect']."',
				'captions': ".$option['captions'].",
				'captionsDelay': ".$option['captionsDelay'].",
				'scrolling': ".$option['scrolling'].",
				'keyEvents': ".$option['keyEvents'].",
				'overlay': {
					'background': '".$option['overlay_background']."',
					'opacity': ".$option['overlay_opacity'].",
					'duration': ".$option['overlay_duration'].",
					'transition': Fx.Transitions.".$option['overlay_transition']."
				},
				'defaultSize': {
					'width': ".$option['width'].",
					'height': ".$option['height']."
				},
				'autoplay': '".$option['autoplay']."',
				'controller': '".$option['controller']."',
				'bgcolor': '".$option['bgcolor']."',
				'youtubeAutoplay': ".$option['ytautoplay'].",
				'youtubeHighQuality': ".$option['ythighquality'].",
				'vimeoColor': '".$option['vimeoColor']."',
				'vimeoPortrait': ".$option['vimeoPortrait'].",
				'vimeoTitle': ".$option['vimeoTitle'].",
				'vimeoFullScreen': ".$option['vimeoFullScreen'].",
				'vimeoByline': ".$option['vimeoByline']."
			});
		});
	};";
	
	$rokbox_render_config = '<script type="text/javascript">'.$config."\n".'</script>'."\n";

}

// Identify browser

if(!function_exists('getBrowser')) {

	function getBrowser() {
	
		$agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : false;
		$ie_version = false;
				
		if (preg_match("/msie/", $agent) && !preg_match("/opera/", $agent)){
			$val = explode(" ",stristr($agent, "msie"));
			$ver = explode(".", $val[1]);
			$ie_version = $ver[0];
			$ie_version = preg_replace("#[^0-9,.,a-z,A-Z]#i", "", $ie_version);
		}
		
		return $ie_version;
	
	}

}

// Plugin settings button

function rokbox_menu() {
	add_plugins_page('RokBox', 'RokBox', 'activate_plugins', 'rokbox-settings', 'rokbox_settings_showup');  
}

add_action('admin_menu', 'rokbox_menu', 9);

function rokbox_admin_css() {
	global $rokbox_plugin_path,$rokbox_plugin_url;
	?>
	<style type="text/css">
	#icon-rokbox {
		background: url(<?php echo $rokbox_plugin_url.'/rokbox_big.png'; ?>) no-repeat 0 0;
	}
	.rokbox-table table tr {height: 35px;}
	.rokbox-table table td {vertical-align: middle;}
	#rokbox-debug {background:#DEDEDE;border: 1px solid #D1D1D1; margin-top: 20px; padding: 0 15px; font-size: 80%; color: #333; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;}
	</style>

<?php }

if(is_admin() && (isset($_GET['page']) && $_GET['page'] == 'rokbox-settings')) {
	add_action('admin_head', 'rokbox_admin_css');
}

// RokBox settings page

function rokbox_settings_showup() {
	
	global $rokbox_plugin_path, $rokbox_plugin_url;
	$option = get_option('rokbox_options');
	
	if(isset($_GET['updated']) == 'true') { ?><div id="message" class="updated fade"><p><?php _e('RokBox settings saved.', 'rokbox'); ?></p></div><?php } ?>
	
	<div class="wrap">
		<div class="icon32" id="icon-rokbox"><br></div>
		<h2>RokBox</h2><br />
		
		<div style="margin: 0 auto; width: 50%;" class="rokbox-table">
		
			<form method="post" action="options.php">
				<?php settings_fields('rokbox_options_array'); ?>
				
				<table cellspacing="0" class="widefat fixed">
					<thead>
						<tr>
							<th></th>
							<th>
								<input type="submit" class="button" value="<?php _e('Save Changes', 'rokbox'); ?>" style="padding: 3px; float: right;" />
							</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th></th>
							<th>
								<input type="submit" class="button" value="<?php _e('Save Changes', 'rokbox'); ?>" style="padding: 3px; float: right;" />
							</th>
						</tr>
					</tfoot>
					<tbody>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Thumbnails Generator', 'rokbox'); ?></b></td>
							<td>
								<select id="thumb_system" name="rokbox_options[thumb_system]">
									<option value="default" <?php if ($option['thumb_system'] == "default") : ?>selected="selected"<?php endif; ?>><?php _e('Default', 'rokbox'); ?></option>
									<option value="phpthumb" <?php if ($option['thumb_system'] == "phpthumb") : ?>selected="selected"<?php endif; ?>><?php _e('PHPThumb', 'rokbox'); ?></option>
								</select>
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Preset Themes', 'rokbox'); ?></b></td>
							<td>
								<select id="theme" name="rokbox_options[theme]">
									<option value="clean" <?php if ($option['theme'] == "clean") : ?>selected="selected"<?php endif; ?>><?php _e('Clean', 'rokbox'); ?></option>
									<option value="light" <?php if ($option['theme'] == "light") : ?>selected="selected"<?php endif; ?>><?php _e('Light', 'rokbox'); ?></option>
									<option value="dark" <?php if ($option['theme'] == "dark") : ?>selected="selected"<?php endif; ?>><?php _e('Dark', 'rokbox'); ?></option>
									<option value="mynxx" <?php if ($option['theme'] == "mynxx") : ?>selected="selected"<?php endif; ?>>Mynxx</option>
									<option value="custom" <?php if ($option['theme'] == "custom") : ?>selected="selected"<?php endif; ?>><?php _e('Custom', 'rokbox'); ?></option>
								</select>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Custom Theme', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="custom_theme" type="text" size="20" maxlength="255" name="rokbox_options[custom_theme]" value="<?php echo $option['custom_theme']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Use Custom Settings', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="custom_settings1" type="radio" <?php if ($option['custom_settings'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[custom_settings]"/>
								<label for="custom_settings1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="custom_settings2" type="radio" <?php if ($option['custom_settings'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[custom_settings]"/>
								<label for="custom_settings2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('RokBox Default Width', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="width" type="text" size="20" maxlength="255" name="rokbox_options[width]" value="<?php echo $option['width']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('RokBox Default Height', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="height" type="text" size="20" maxlength="255" name="rokbox_options[height]" value="<?php echo $option['height']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('RokBox Transition Effect', 'rokbox'); ?></b>
							</td>
							<td>
								<select id="transition" name="rokbox_options[transition]">
									<option value="linear" <?php if ($option['transition'] == "linear") : ?>selected="selected"<?php endif; ?>>linear</option>
									<option value="Quad.easeOut" <?php if ($option['transition'] == "Quad.easeOut") : ?>selected="selected"<?php endif; ?>>Quad.easeOut</option>
									<option value="Quad.easeIn" <?php if ($option['transition'] == "Quad.easeIn") : ?>selected="selected"<?php endif; ?>>Quad.easeIn</option>
									<option value="Quad.easeInOut" <?php if ($option['transition'] == "Quad.easeInOut") : ?>selected="selected"<?php endif; ?>>Quad.easeInOut</option>
									<option value="Cubic.easeOut" <?php if ($option['transition'] == "Cubic.easeOut") : ?>selected="selected"<?php endif; ?>>Cubic.easeOut</option>
									<option value="Cubic.easeIn" <?php if ($option['transition'] == "Cubic.easeIn") : ?>selected="selected"<?php endif; ?>>Cubic.easeIn</option>
									<option value="Cubic.easeInOut" <?php if ($option['transition'] == "Cubic.easeInOut") : ?>selected="selected"<?php endif; ?>>Cubic.easeInOut</option>
									<option value="Quart.easeOut" <?php if ($option['transition'] == "Quart.easeOut") : ?>selected="selected"<?php endif; ?>>Quart.easeOut</option>
									<option value="Quart.easeIn" <?php if ($option['transition'] == "Quart.easeIn") : ?>selected="selected"<?php endif; ?>>Quart.easeIn</option>
									<option value="Quart.easeInOut" <?php if ($option['transition'] == "Quart.easeInOut") : ?>selected="selected"<?php endif; ?>>Quart.easeInOut</option>
									<option value="Quint.easeOut" <?php if ($option['transition'] == "Quint.easeOut") : ?>selected="selected"<?php endif; ?>>Quint.easeOut</option>
									<option value="Quint.easeIn" <?php if ($option['transition'] == "Quint.easeIn") : ?>selected="selected"<?php endif; ?>>Quint.easeIn</option>
									<option value="Quint.easeInOut" <?php if ($option['transition'] == "Quint.easeInOut") : ?>selected="selected"<?php endif; ?>>Quint.easeInOut</option>
									<option value="Expo.easeOut" <?php if ($option['transition'] == "Expo.easeOut") : ?>selected="selected"<?php endif; ?>>Expo.easeOut</option>
									<option value="Expo.easeIn" <?php if ($option['transition'] == "Expo.easeIn") : ?>selected="selected"<?php endif; ?>>Expo.easeIn</option>
									<option value="Expo.easeInOut" <?php if ($option['transition'] == "Expo.easeInOut") : ?>selected="selected"<?php endif; ?>>Expo.easeInOut</option>
									<option value="Circ.easeOut" <?php if ($option['transition'] == "Circ.easeOut") : ?>selected="selected"<?php endif; ?>>Circ.easeOut</option>
									<option value="Circ.easeIn" <?php if ($option['transition'] == "Circ.easeIn") : ?>selected="selected"<?php endif; ?>>Circ.easeIn</option>
									<option value="Circ.easeInOut" <?php if ($option['transition'] == "Circ.easeInOut") : ?>selected="selected"<?php endif; ?>>Circ.easeInOut</option>
									<option value="Sine.easeOut" <?php if ($option['transition'] == "Sine.easeOut") : ?>selected="selected"<?php endif; ?>>Sine.easeOut</option>
									<option value="Sine.easeIn" <?php if ($option['transition'] == "Sine.easeIn") : ?>selected="selected"<?php endif; ?>>Sine.easeIn</option>
									<option value="Sine.easeInOut" <?php if ($option['transition'] == "Sine.easeInOut") : ?>selected="selected"<?php endif; ?>>Sine.easeInOut</option>
									<option value="Back.easeOut" <?php if ($option['transition'] == "Back.easeOut") : ?>selected="selected"<?php endif; ?>>Back.easeOut</option>
									<option value="Back.easeIn" <?php if ($option['transition'] == "Back.easeIn") : ?>selected="selected"<?php endif; ?>>Back.easeIn</option>
									<option value="Back.easeInOut" <?php if ($option['transition'] == "Back.easeInOut") : ?>selected="selected"<?php endif; ?>>Back.easeInOut</option>
									<option value="Bounce.easeOut" <?php if ($option['transition'] == "Bounce.easeOut") : ?>selected="selected"<?php endif; ?>>Bounce.easeOut</option>
									<option value="Bounce.easeIn" <?php if ($option['transition'] == "Bounce.easeIn") : ?>selected="selected"<?php endif; ?>>Bounce.easeIn</option>
									<option value="Bounce.easeInOut" <?php if ($option['transition'] == "Bounce.easeInOut") : ?>selected="selected"<?php endif; ?>>Bounce.easeInOut</option>
									<option value="Elastic.easeOut" <?php if ($option['transition'] == "Elastic.easeOut") : ?>selected="selected"<?php endif; ?>>Elastic.easeOut</option>
									<option value="Elastic.easeIn" <?php if ($option['transition'] == "Elastic.easeIn") : ?>selected="selected"<?php endif; ?>>Elastic.easeIn</option>
									<option value="Elastic.easeInOut" <?php if ($option['transition'] == "Elastic.easeInOut") : ?>selected="selected"<?php endif; ?>>Elastic.easeInOut</option>
								</select>
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Duration', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="duration" type="text" size="20" maxlength="255" name="rokbox_options[duration]" value="<?php echo $option['duration']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Chase', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="chase" type="text" size="20" maxlength="255" name="rokbox_options[chase]" value="<?php echo $option['chase']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Type of Animation', 'rokbox'); ?></b>
							</td>
							<td>
								<select id="transition" name="rokbox_options[effect]">
									<option value="fade" <?php if ($option['effect'] == "fade") : ?>selected="selected"<?php endif; ?>><?php _e('Fade', 'rokbox'); ?></option>
									<option value="quicksilver" <?php if ($option['effect'] == "quicksilver") : ?>selected="selected"<?php endif; ?>>QuickSilver</option>
									<option value="growl" <?php if ($option['effect'] == "growl") : ?>selected="selected"<?php endif; ?>><?php _e('Growl', 'rokbox'); ?></option>
									<option value="explode" <?php if ($option['effect'] == "explode") : ?>selected="selected"<?php endif; ?>><?php _e('Explode', 'rokbox'); ?></option>
								</select>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Borders Width', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="frame-border" type="text" size="20" maxlength="255" name="rokbox_options[frame-border]" value="<?php echo $option['frame-border']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Content Padding', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="content-padding" type="text" size="20" maxlength="255" name="rokbox_options[content-padding]" value="<?php echo $option['content-padding']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Arrows Height', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="arrows-height" type="text" size="20" maxlength="255" name="rokbox_options[arrows-height]" value="<?php echo $option['arrows-height']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Show Captions', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="captions1" type="radio" <?php if ($option['captions'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[captions]"/>
								<label for="captions1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="captions2" type="radio" <?php if ($option['captions'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[captions]"/>
								<label for="captions2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Captions Delay', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="captionsDelay" type="text" size="20" maxlength="255" name="rokbox_options[captionsDelay]" value="<?php echo $option['captionsDelay']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Follow when Scrolling', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="scrolling1" type="radio" <?php if ($option['scrolling'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[scrolling]"/>
								<label for="scrolling1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="scrolling2" type="radio" <?php if ($option['scrolling'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[scrolling]"/>
								<label for="scrolling2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Enable Keys', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="keyEvents1" type="radio" <?php if ($option['keyEvents'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[keyEvents]"/>
								<label for="keyEvents1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="keyEvents2" type="radio" <?php if ($option['keyEvents'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[keyEvents]"/>
								<label for="keyEvents2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Overlay Background', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="overlay_background" type="text" size="20" maxlength="255" name="rokbox_options[overlay_background]" value="<?php echo $option['overlay_background']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Overlay Opacity', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="overlay_opacity" type="text" size="20" maxlength="255" name="rokbox_options[overlay_opacity]" value="<?php echo $option['overlay_opacity']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Overlay Duration', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="overlay_duration" type="text" size="20" maxlength="255" name="rokbox_options[overlay_duration]" value="<?php echo $option['overlay_duration']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Transition Overlay Effect', 'rokbox'); ?></b>
							</td>
							<td>
								<select id="transition" name="rokbox_options[overlay_transition]">
									<option value="linear" <?php if ($option['overlay_transition'] == "linear") : ?>selected="selected"<?php endif; ?>>linear</option>
									<option value="Quad.easeOut" <?php if ($option['overlay_transition'] == "Quad.easeOut") : ?>selected="selected"<?php endif; ?>>Quad.easeOut</option>
									<option value="Quad.easeIn" <?php if ($option['overlay_transition'] == "Quad.easeIn") : ?>selected="selected"<?php endif; ?>>Quad.easeIn</option>
									<option value="Quad.easeInOut" <?php if ($option['overlay_transition'] == "Quad.easeInOut") : ?>selected="selected"<?php endif; ?>>Quad.easeInOut</option>
									<option value="Cubic.easeOut" <?php if ($option['overlay_transition'] == "Cubic.easeOut") : ?>selected="selected"<?php endif; ?>>Cubic.easeOut</option>
									<option value="Cubic.easeIn" <?php if ($option['overlay_transition'] == "Cubic.easeIn") : ?>selected="selected"<?php endif; ?>>Cubic.easeIn</option>
									<option value="Cubic.easeInOut" <?php if ($option['overlay_transition'] == "Cubic.easeInOut") : ?>selected="selected"<?php endif; ?>>Cubic.easeInOut</option>
									<option value="Quart.easeOut" <?php if ($option['overlay_transition'] == "Quart.easeOut") : ?>selected="selected"<?php endif; ?>>Quart.easeOut</option>
									<option value="Quart.easeIn" <?php if ($option['overlay_transition'] == "Quart.easeIn") : ?>selected="selected"<?php endif; ?>>Quart.easeIn</option>
									<option value="Quart.easeInOut" <?php if ($option['overlay_transition'] == "Quart.easeInOut") : ?>selected="selected"<?php endif; ?>>Quart.easeInOut</option>
									<option value="Quint.easeOut" <?php if ($option['overlay_transition'] == "Quint.easeOut") : ?>selected="selected"<?php endif; ?>>Quint.easeOut</option>
									<option value="Quint.easeIn" <?php if ($option['overlay_transition'] == "Quint.easeIn") : ?>selected="selected"<?php endif; ?>>Quint.easeIn</option>
									<option value="Quint.easeInOut" <?php if ($option['overlay_transition'] == "Quint.easeInOut") : ?>selected="selected"<?php endif; ?>>Quint.easeInOut</option>
									<option value="Expo.easeOut" <?php if ($option['overlay_transition'] == "Expo.easeOut") : ?>selected="selected"<?php endif; ?>>Expo.easeOut</option>
									<option value="Expo.easeIn" <?php if ($option['overlay_transition'] == "Expo.easeIn") : ?>selected="selected"<?php endif; ?>>Expo.easeIn</option>
									<option value="Expo.easeInOut" <?php if ($option['overlay_transition'] == "Expo.easeInOut") : ?>selected="selected"<?php endif; ?>>Expo.easeInOut</option>
									<option value="Circ.easeOut" <?php if ($option['overlay_transition'] == "Circ.easeOut") : ?>selected="selected"<?php endif; ?>>Circ.easeOut</option>
									<option value="Circ.easeIn" <?php if ($option['overlay_transition'] == "Circ.easeIn") : ?>selected="selected"<?php endif; ?>>Circ.easeIn</option>
									<option value="Circ.easeInOut" <?php if ($option['overlay_transition'] == "Circ.easeInOut") : ?>selected="selected"<?php endif; ?>>Circ.easeInOut</option>
									<option value="Sine.easeOut" <?php if ($option['overlay_transition'] == "Sine.easeOut") : ?>selected="selected"<?php endif; ?>>Sine.easeOut</option>
									<option value="Sine.easeIn" <?php if ($option['overlay_transition'] == "Sine.easeIn") : ?>selected="selected"<?php endif; ?>>Sine.easeIn</option>
									<option value="Sine.easeInOut" <?php if ($option['overlay_transition'] == "Sine.easeInOut") : ?>selected="selected"<?php endif; ?>>Sine.easeInOut</option>
									<option value="Back.easeOut" <?php if ($option['overlay_transition'] == "Back.easeOut") : ?>selected="selected"<?php endif; ?>>Back.easeOut</option>
									<option value="Back.easeIn" <?php if ($option['overlay_transition'] == "Back.easeIn") : ?>selected="selected"<?php endif; ?>>Back.easeIn</option>
									<option value="Back.easeInOut" <?php if ($option['overlay_transition'] == "Back.easeInOut") : ?>selected="selected"<?php endif; ?>>Back.easeInOut</option>
									<option value="Bounce.easeOut" <?php if ($option['overlay_transition'] == "Bounce.easeOut") : ?>selected="selected"<?php endif; ?>>Bounce.easeOut</option>
									<option value="Bounce.easeIn" <?php if ($option['overlay_transition'] == "Bounce.easeIn") : ?>selected="selected"<?php endif; ?>>Bounce.easeIn</option>
									<option value="Bounce.easeInOut" <?php if ($option['overlay_transition'] == "Bounce.easeInOut") : ?>selected="selected"<?php endif; ?>>Bounce.easeInOut</option>
									<option value="Elastic.easeOut" <?php if ($option['overlay_transition'] == "Elastic.easeOut") : ?>selected="selected"<?php endif; ?>>Elastic.easeOut</option>
									<option value="Elastic.easeIn" <?php if ($option['overlay_transition'] == "Elastic.easeIn") : ?>selected="selected"<?php endif; ?>>Elastic.easeIn</option>
									<option value="Elastic.easeInOut" <?php if ($option['overlay_transition'] == "Elastic.easeInOut") : ?>selected="selected"<?php endif; ?>>Elastic.easeInOut</option>
								</select>
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Autoplay', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="autoplay1" type="radio" <?php if ($option['autoplay'] == "true") : ?>checked="checked"<?php endif; ?> value="true" name="rokbox_options[autoplay]"/>
								<label for="autoplay1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="autoplay2" type="radio" <?php if ($option['autoplay'] == "false") : ?>checked="checked"<?php endif; ?> value="false" name="rokbox_options[autoplay]"/>
								<label for="autoplay2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('YouTube Autoplay', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="ytautoplay1" type="radio" <?php if ($option['ytautoplay'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[ytautoplay]"/>
								<label for="ytautoplay1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="ytautoplay2" type="radio" <?php if ($option['ytautoplay'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[ytautoplay]"/>
								<label for="ytautoplay2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('YouTube High Quality (HD)', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="ythighquality1" type="radio" <?php if ($option['ythighquality'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[ythighquality]"/>
								<label for="ythighquality1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="ythighquality2" type="radio" <?php if ($option['ythighquality'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[ythighquality]"/>
								<label for="ythighquality2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Controller', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="controller1" type="radio" <?php if ($option['controller'] == "true") : ?>checked="checked"<?php endif; ?> value="true" name="rokbox_options[controller]"/>
								<label for="controller1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="controller2" type="radio" <?php if ($option['controller'] == "false") : ?>checked="checked"<?php endif; ?> value="false" name="rokbox_options[controller]"/>
								<label for="controller2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Background Color', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="bgcolor" type="text" size="20" maxlength="255" name="rokbox_options[bgcolor]" value="<?php echo $option['bgcolor']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Vimeo Color', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="vimeoColor" type="text" size="20" maxlength="255" name="rokbox_options[vimeoColor]" value="<?php echo $option['vimeoColor']; ?>" />
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Vimeo Portrait', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="vimeoPortrait1" type="radio" <?php if ($option['vimeoPortrait'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[vimeoPortrait]"/>
								<label for="vimeoPortrait1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="vimeoPortrait2" type="radio" <?php if ($option['vimeoPortrait'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[vimeoPortrait]"/>
								<label for="vimeoPortrait2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Vimeo Title', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="vimeoTitle1" type="radio" <?php if ($option['vimeoTitle'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[vimeoTitle]"/>
								<label for="vimeoTitle1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="vimeoTitle2" type="radio" <?php if ($option['vimeoTitle'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[vimeoTitle]"/>
								<label for="vimeoTitle2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="iedit">
							<td>
								<b><?php _e('Vimeo Fullscreen', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="vimeoFullScreen1" type="radio" <?php if ($option['vimeoFullScreen'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[vimeoFullScreen]"/>
								<label for="vimeoFullScreen1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="vimeoFullScreen2" type="radio" <?php if ($option['vimeoFullScreen'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[vimeoFullScreen]"/>
								<label for="vimeoFullScreen2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
						<tr valign="middle" class="alternate iedit">
							<td>
								<b><?php _e('Vimeo Byline', 'rokbox'); ?></b>
							</td>
							<td>
								<input id="vimeoByline1" type="radio" <?php if ($option['vimeoByline'] == "1") : ?>checked="checked"<?php endif; ?> value="1" name="rokbox_options[vimeoByline]"/>
								<label for="vimeoByline1"><?php _e('Yes', 'rokbox'); ?></label>&nbsp;&nbsp;
								<input id="vimeoByline2" type="radio" <?php if ($option['vimeoByline'] == "0") : ?>checked="checked"<?php endif; ?> value="0" name="rokbox_options[vimeoByline]"/>
								<label for="vimeoByline2"><?php _e('No', 'rokbox'); ?></label>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			
			<div id="rokbox-debug">
				<h3><?php _e('Debug Information', 'rokbox'); ?></h3>
				<?php
				
				_e('GD2 Library Present: ', 'rokbox');
				
				if (extension_loaded('gd') && function_exists('gd_info')) {
					echo '<span style="color: #177F08; font-weight: bold;">'.__('YES', 'rokbox').'</span>';
				} else {
					echo '<span style="color: #C30C0C; font-weight: bold;">'.__('NO', 'rokbox').'</span>';
				}
				
				echo '<br />';
				_e('Cache Directory Writeable: ', 'rokbox');
				
				if (is_writeable($rokbox_plugin_path . '/cache')) {
					echo '<span style="color: #177F08; font-weight: bold;">'.__('YES', 'rokbox').'</span><br /><br />';
				} else {
					echo '<span style="color: #C30C0C; font-weight: bold;">'.__('NO', 'rokbox').'</span><br /><br />';
				} ?>
			</div>
		
		</div>
		
	</div><br />

<?php
 
}

// Experimental image resize

/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Example of use :
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = rokbox_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
 
if(!function_exists('rokbox_resize')) {
	function rokbox_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {
	
		global $rokbox_plugin_path, $rokbox_plugin_url;
	
		// this is an attachment, so we have the ID
		if ( $attach_id ) {
		
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path = get_attached_file( $attach_id );
		
		// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			
			$file_path = parse_url( $img_url );
			$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
			
			//$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
			
			$orig_size = @getimagesize( $file_path );
			
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
		
		$file_info = pathinfo( $file_path );
		$extension = '.'. $file_info['extension'];
	
		// the image path without the extension
		$no_ext_path = $rokbox_plugin_path.'/cache/'.$file_info['filename'];
	
		$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
	
		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ( $image_src[1] > $width || $image_src[2] > $height ) {
	
			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
			if ( file_exists( $cropped_img_path ) ) {
	
				$default_url = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
				$cropped_img_url = str_replace(dirname($image_src[0]), $rokbox_plugin_url.'/cache', $default_url);
				
				$vt_image = array (
					'url' => $cropped_img_url,
					'width' => $width,
					'height' => $height
				);
				
				return $vt_image;
			}
	
			// $crop = false
			if ( $crop == false ) {
			
				// calculate the size proportionaly
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;		
	
				// checking if the file already exists
				if ( file_exists( $resized_img_path ) ) {
				
					$default_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
					$resized_img_url = str_replace(dirname($image_src[0]), $rokbox_plugin_url.'/cache', $default_url);
	
					$vt_image = array (
						'url' => $resized_img_url,
						'width' => $proportional_size[0],
						'height' => $proportional_size[1]
					);
					
					return $vt_image;
				}
			}
	
			// no cache files - let's finally resize it
			$new_img_path = image_resize( $file_path, $width, $height, $crop, '', $rokbox_plugin_path.'/cache' );
			$new_img_size = getimagesize( $new_img_path );
			$default_url = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
			$new_img = str_replace(dirname($image_src[0]), $rokbox_plugin_url.'/cache', $default_url);
	
			// resized output
			$vt_image = array (
				'url' => $new_img,
				'width' => $new_img_size[0],
				'height' => $new_img_size[1]
			);
			
			return $vt_image;
		}
	
		// default output - without resizing
		$vt_image = array (
			'url' => $image_src[0],
			'width' => $image_src[1],
			'height' => $image_src[2]
		);
		
		return $vt_image;
	}
}

?>