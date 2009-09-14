<?php
/*
Plugin Name: Spacializer Widget
Plugin URI: http://www.plexav.com/2009/spacializer-widget/
Description: User Controlled SoundMixing and Lightshow Widget
Author: Kenneth Stein - based on work by Seb Chevrel
Version: .2
Author URI: http://www.plexav.com

	
*/

function spacializer_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') ||
			!function_exists('register_widget_control') )
				return;

function spacializer_control() {
	$options = $newoptions = get_option('spacializer');
	if ( $_POST['spacializer-submit'] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST['spacializer-title']));
		$newoptions['height'] = strip_tags(stripslashes($_POST['spacializer-height']));
		$newoptions['width'] = strip_tags(stripslashes($_POST['spacializer-width']));
		}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('spacializer', $options);
	}
?>
			<div style="text-align:right" >
			<a href="http://www.plexav.com/">Compliments of Plexav.com</a>
			<label for="spacializer-title" style="line-height:35px;display:block;">Widget Title: <input type="text" id="spacializer-title" name="spacializer-title" value="<?php echo htmlspecialchars($options['title'], true); ?>" /></label>
			<label for="spacializer-height" style="line-height:35px;display:block;">Widget Height:<input type="text" id="spacializer-height" name="spacializer-height" value="<?php echo htmlspecialchars($options['height'], true); ?>" /></label>
			<label for="spacializer-width" style="line-height:35px;display:block;">Widget Width: <input type="text" id="spacializer-width" name="spacializer-width" value="<?php echo htmlspecialchars($options['width'], true); ?>" /></label>
			<input type="hidden" name="spacializer-submit" id="spacializer-submit" value="1" />
			</div>
		<?php
		}

	// This function prints the sidebar widget
	function spacializer($args) {
			extract($args);
			$defaults = array('title' => 'Spacializer', 'height' => '240px', 'width' => '160px');
			$options = (array) get_option('spacializer');
			foreach ( $defaults as $key => $value )
				if ( !isset($options[$key]) )
				$options[$key] = $defaults[$key];


        $widgetheight = $options['height'];
		$widgetwidth = $options['width'];
		$title = $options['title'];

		echo $before_widget . $before_title . $title . $after_title; ?>

    	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0" width="<?php echo $widgetwidth; ?>" height="<?php echo $widgetheight; ?>" id="spacializer.swf">
		        	          <param name="movie" value="/wp-content/plugins/spacializer/spacializer.swf" />
			                  <param name="menu" value="false" />
			                  <param name="wmode" value="opaque" />
			                  <param name="quality" value="best" />
			                  <param name="scale" value="exactfit" />
		          			  <embed src="/wp-content/plugins/spacializer/spacializer.swf" menu="false" quality="best" scale="exactfit" wmode="opaque" width="<?php echo $widgetwidth; ?>" height="<?php echo $widgetheight; ?>" name="spacializer.swf" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>

		<?php echo $after_widget; ?>
		<div style="visibility:hidden;"><a href="http://www.plexav.com/tagspace-plugin-wordpress/" rel="index,follow">tagspace widget plugin from Plexav and Ken Stein</a></div>
		
				<?php }

	// This registers the widget.

	register_sidebar_widget('Spacializer', 'spacializer');
	register_widget_control('Spacializer', 'spacializer_control', 250, 250);
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'spacializer_init');
?>