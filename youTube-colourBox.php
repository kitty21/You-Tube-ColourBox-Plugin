<?php
/*
	Plugin Name: You Tube ColourBox Plugin
	Plugin URI: http://geek4peace.wordpress.com/
	Description: Plugin is combination of youtube videos and jquery Lightbox. With paramaeters managable via its widget. 
	Author: Kitty2111
	Version: 1.0.0
	Author URI: http://geek4peace.wordpress.com/
*/


// We're putting the plugin's functions inside the init function to ensure the required Sidebar Widget functions are available.
	
	function widget_YouTubeColourBox_init(){
		
		function YouTubeColourBox($options){
		//Set plugin params on default. Change it form widget section.
			$transition= empty($options['transition']) ? 'elastic' : $options['transition'];
			$transitionSpeed= empty($options['transitionSpeed']) ? 550 : $options['transitionSpeed'];
			$opacity= empty($options['opacity']) ? 0.5 : $options['opacity'];
			$width= empty($options['width']) ? '100%' : $options['width'];
			$height= empty($options['opacity']) ? '100%' : $options['height'];
			$popup_width= empty($options['popup_width']) ? '640' : $options['popup_width'];
			$popup_height= empty($options['popup_height']) ? '390' : $options['popup_height'];
		//Set plugin params via javascript	
		echo '<script>jQuery.noConflict();  
    			jQuery(document).ready(function() {  
					jQuery(".youTubeGallery").colorbox({iframe:true, innerWidth:"'.$popup_width.'", innerHeight:"'.$popup_height.'", transition: "'.$transition.'", speed:"'.$transitionSpeed.'" , opacity:"'.$opacity.'"}); 
    		   });</script>';
		$videoIDs= explode(',',strip_tags(stripslashes($options['videoID'])));
		$max_loop=$options['videoCount']; //This is the desired value of Looping
		$count = 0; 
		if(!empty($options['videoID'])):  //Video check for fontend	
		 foreach($videoIDs as $videoID):
			//Fetch Data form YouTube API
							$url = "http://gdata.youtube.com/feeds/api/videos/".$videoID;
							$doc = new DOMDocument;
							$doc->load($url);
							$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
							echo $options = '<a class="youTubeGallery" href="http://www.youtube.com/embed/'.$videoID.'?rel=0&amp;wmode=transparent" title="'.$title.'"><img src="http://img.youtube.com/vi/'.$videoID.'/0.jpg" alt="'.$title.'" width="'.$width.'" height="'.$height.'" /></a><p><a class="youTubeGallery" href="http://www.youtube.com/embed/'.$videoID.'?rel=0&amp;wmode=transparent"  title="'.$title.'">'.$title.'</a></p>';
						$count++;
						if($count==$max_loop) {break;} 
		endforeach;
		else: //encourage user to get some videos
			echo $options = 'Not even a single video !!!! <br /> Please add some videos from admin section.';
		endif;
		
		}

		function widget_YouTubeColourBox($args){
			// Collect our widget's options, or define their defaults.
			$options = get_option('widget_YouTubeColourBox');
			$title = $options['title'];
			extract($args);
				echo $before_widget;
				echo $before_title;
				echo $title;
				echo $after_title;
					YouTubeColourBox($options);
				echo $after_widget;
		}
	
	// This is the function that outputs the form to let users edit
	
	function widget_YouTubeColourBox_control(){
	
		// Collect our widget options.
		$options = $newoptions = get_option('widget_YouTubeColourBox');

		// This is for handing the control form submission.
			if ( $_POST['widget_YouTubeColourBox-submit'] ){
				// Clean up control form submission options
					$newoptions['title'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-title']));
					$newoptions['videoCount'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-videoCount']));
					$newoptions['videoID'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-videoID']));
					$newoptions['width'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-width']));
					$newoptions['height'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-height']));
					$newoptions['transition'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-transition']));
					$newoptions['transitionSpeed'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-transitionSpeed']));
					$newoptions['opacity'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-opacity']));
					$newoptions['popup_width'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-popup_width']));
					$newoptions['popup_height'] = strip_tags(stripslashes($_POST['widget_YouTubeColourBox-popup_height']));
			}
		
			// If original widget options do not match control form submission options, update them.
				if ( $options != $newoptions ) 
				{
					$options = $newoptions;
					update_option('widget_YouTubeColourBox', $options);
				}
				
			$title = attribute_escape($options['title']);
			$videoCount = attribute_escape($options['videoCount']);
			$videoID = attribute_escape($options['videoID']);
			$width = attribute_escape($options['width']);
			$height = attribute_escape($options['height']);
			$transition = attribute_escape($options['transition']);
			$transitionSpeed = attribute_escape($options['transitionSpeed']);
			$opacity = attribute_escape($options['opacity']);
			$popup_width = attribute_escape($options['popup_width']);
			$popup_height = attribute_escape($options['popup_height']);?>

            <p>
                <label for="YouTubeColourBox-title"><?php _e('Title:'); ?>
                	<input class="widefat" id="widget_YouTubeColourBox-title" name="widget_YouTubeColourBox-title" type="text" value="<?php echo attribute_escape($options['title']); ?>" />
                </label>
            </p>
            <p>
                <label for="YouTubeColourBox-videoCount"><?php _e('Video count(Default 1):'); ?>
					<select name="widget_YouTubeColourBox-videoCount" id="widget_YouTubeColourBox-videoCount" style="width: 50px;" class="widefat">
                            <option value="1" <?php selected('1', $videoCount); ?>>1</option>
                            <option value="2" <?php selected('2', $videoCount); ?>>2</option>
                            <option value="3" <?php selected('3', $videoCount); ?>>3</option>
                            <option value="4" <?php selected('4', $videoCount); ?>>4</option>
                            <option value="5" <?php selected('5', $videoCount); ?>>5</option>
                            <option value="6" <?php selected('6', $videoCount); ?>>6</option>
                            <option value="7" <?php selected('7', $videoCount); ?>>7</option>
                            <option value="8" <?php selected('8', $videoCount); ?>>8</option>
                            <option value="9" <?php selected('9', $videoCount); ?>>9</option>
                            <option value="10" <?php selected('10', $videoCount); ?>>10</option>
                    </select>
                </label>
            </p>
            <p>
                <label for="YouTubeColourBox-videoID"><?php _e('Video ID  (eg: "x35AIGJaM5M" Must be Seperated by comma):', 'You-Tube'); ?>
                	<textarea rows="4" cols="25" class="widefat" id="widget_YouTubeColourBox-videoID" name="widget_YouTubeColourBox-videoID" ><?php echo $videoID; ?></textarea>
                </label>
            </p>
        <p>
            <label for="YouTubeColourBox-width"><?php _e('Width:'); ?>
            	<input class="widefat" id="widget_YouTubeColourBox-width" name="widget_YouTubeColourBox-width" type="text" value="<?php echo attribute_escape($options['width']); ?>" style="width:55px;"/>
            </label>
            <label for="YouTubeColourBox-height"><?php _e('Height:'); ?>
            	<input class="widefat" id="widget_YouTubeColourBox-height" name="widget_YouTubeColourBox-height" type="text" value="<?php echo attribute_escape($options['height']); ?>" style="width:55px;"/>
            </label>
        </p>
        <p>
            <label for="YouTubeColourBox-transition"><?php _e('Video Transition:'); ?>&nbsp;
                <select name="widget_YouTubeColourBox-transition" id="widget_YouTubeColourBox-transition" style="width:125px;" class="widefat">
                    <option value="fade" <?php selected('fade', $transition); ?>>Fade</option>
                    <option value="elastic" <?php selected('elastic', $transition); ?>>Elastic</option>
					<option value="false" <?php selected('false', $transition); ?>>None</option>
                </select>
            </label>
        </p>
            <p>
                <label for="YouTubeColourBox-transitionSpeed"><?php _e('Transition Speed: (in miliseconds)'); ?>
                	<input class="widefat" id="widget_YouTubeColourBox-transitionSpeed" name="widget_YouTubeColourBox-transitionSpeed" type="text" value="<?php echo attribute_escape($options['transitionSpeed']); ?>" />
                </label>
            </p>
            <p>
                <label for="YouTubeColourBox-opacity"><?php _e('Opacity: (1.0=Opaque, 0.0=Transparent)'); ?>
                	<input class="widefat" id="widget_YouTubeColourBox-opacity" name="widget_YouTubeColourBox-opacity" type="text" value="<?php echo attribute_escape($options['opacity']); ?>" />
                </label>
            </p>
            <p>
                <label for="YouTubeColourBox-width"><?php _e('Popup Width: (in px)'); ?>
                	<input class="widefat" id="widget_YouTubeColourBox-popup_width" name="widget_YouTubeColourBox-popup_width" type="text" value="<?php echo attribute_escape($options['popup_width']); ?>" />
                </label>
                <label for="YouTubeColourBox-height"><?php _e('Popup Height: (in px)'); ?>
                	<input class="widefat" id="widget_YouTubeColourBox-popup_height" name="widget_YouTubeColourBox-popup_height" type="text" value="<?php echo attribute_escape($options['popup_height']); ?>" />
                </label>
            </p>  
          <?php echo '<input type="hidden" id="widget_YouTubeColourBox-submit" name="widget_YouTubeColourBox-submit" value="1" />';  }

	// Registers the widget.
	register_sidebar_widget('You Tube ColourBox Widget', 'widget_YouTubeColourBox');
	
	// Registers the widget control form.
	register_widget_control('You Tube ColourBox Widget', 'widget_YouTubeColourBox_control');
	}
	
	function youtube_scripts_method() {
		//check for existing Jquery File
			if(@file_exists(TEMPLATEPATH.'/jquery.min.js')) {
				wp_enqueue_script('youtube-colourbox', plugins_url('you-tube-colourbox-plugin/js/jquery.colorbox.js'),'', '', false);
			}else{
				wp_enqueue_script( 'jquery');
				wp_enqueue_script('youtube-colourbox', plugins_url('you-tube-colourbox-plugin/js/jquery.colorbox.js'),'', '', false);
			}
		//We needs css every time altough	
				wp_enqueue_style('youtube-colourbox', plugins_url('you-tube-colourbox-plugin/style.css'), false, '', 'all'); ?>
	<?php }
add_action('wp_enqueue_scripts', 'youtube_scripts_method'); 	
add_action('plugins_loaded', 'widget_YouTubeColourBox_init');