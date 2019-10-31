<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends Model {

		/**
		  * resize first image
		  * @access	public
		  * @param string
		  * @return	bool
		  */
		function image_resize($orgimg, $imgname, $target_path, $arr_dimension=array()){
			if($arr_dimension){
				foreach ($arr_dimension as $key => $thumb_image_size){
					$this->make_thumb ($orgimg, $imgname, $target_path, $thumb_image_size['width'],  $thumb_image_size['height'], 'thumb_'.$key.'_');
				}
			}
		}
		function make_thumb ($orgimg,$imgname,$target_path,$width, $height, $prefix){
			$this->benchmark->mark('code_start');
			$this->createthumb ($target_path. basename($orgimg), $target_path.$prefix.basename($imgname) ,$width, $height);
			$this->benchmark->mark('code_end');
		}
		function make_thumb_new ($orgimg,$imgname,$target_path,$width, $height, $prefix){
			$this->benchmark->mark('code_start');
			$this->createthumb ($orgimg, $target_path.$prefix.basename($imgname) ,$width, $height);
			$this->benchmark->mark('code_end');
		}
		function make_video_thumb ($orgimg,$imgname,$target_path,$width, $height, $prefix){
			$new_thumb_file		=	file_get_contents(base_url()."thumb/phpThumb.php?&w=".$width."&h=".$height."&far=1&bg=000000&src=".$target_path. basename($orgimg),FILE_USE_INCLUDE_PATH);
			file_put_contents ($target_path.$prefix.basename($imgname), $new_thumb_file);
		}
		/**
		 * Function to Generate High quality Thumbnail
		 *
		 * @param unknown_type $name
		 * @param unknown_type $filename
		 * @param unknown_type $new_w
		 * @param unknown_type $new_h
		 */
		function createthumb($name ,$filename ,$new_w, $new_h){
			$file_ext		=	end(explode('.',$name));
			if (preg_match('/jpg|jpeg/',strtolower($file_ext))){
				$src_img	=	imagecreatefromjpeg($name);
			}else if (preg_match('/png/',strtolower($file_ext))){
				$src_img	=	imagecreatefrompng($name);
			}else if (preg_match('/gif/',strtolower($file_ext))){
				$src_img	=	imagecreatefromgif($name);
			}

			@$old_x		=	imageSX($src_img);
			@$old_y		=	imageSY($src_img);
			$scale 		= 	$this->scale_dimensions ($old_x, $old_y, $new_w , $new_h);
			$thumb_w	= 	$scale[0];
			$thumb_h	= 	$scale[1];
			$dst_img	=	imagecreatetruecolor($new_w,$new_h);
			$white 		= 	imagecolorallocate($dst_img, 249, 249, 249);
			//Make the background white
			imagefill($dst_img, 0, 0, $white);
			$new_x_cord	=	( (($new_w - $thumb_w)/2) > 0 ) ? floor(($new_w - $thumb_w)/2) : 0 ;
			$new_y_cord	=	( (($new_h - $thumb_h)/2) > 0 ) ? floor(($new_h - $thumb_h)/2) : 0 ;
			@imagecopyresampled($dst_img, $src_img, $new_x_cord, $new_y_cord, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);

			$file_ext = strtolower($file_ext);

			if (preg_match("/png/",$file_ext))	{
				imagepng($dst_img,$filename);
			}
			elseif(preg_match("/gif/",$file_ext))	{
				imagegif($dst_img,$filename);
			} else {
				imagejpeg($dst_img,$filename);
			}

			@imagedestroy($dst_img);
			@imagedestroy($src_img);
		}
		function scale_dimensions($w,$h,$maxw,$maxh,$stretch = FALSE) {
		    if (!$maxw && $maxh) {
		      // Width is unlimited, scale by width
		      $newh = $maxh;
		      if ($h < $maxh && !$stretch) { $newh = $h; }
		      else { $newh = $maxh; }
		      $neww = ($w * $newh / $h);
		    } elseif (!$maxh && $maxw) {
		      // Scale by height
		      if ($w < $maxw && !$stretch) { $neww = $w; }
		      else { $neww = $maxw; }
		      $newh = ($h * $neww / $w);
		    } elseif (!$maxw && !$maxh) {
		      return array($w,$h);
		    } else {
		      if ($w / $maxw > $h / $maxh) {
		        // Scale by height
		        if ($w < $maxw && !$stretch) { $neww = $w; }
		        else { $neww = $maxw; }
		        $newh = ($h * $neww / $w);
		      } elseif ($w / $maxw <= $h / $maxh) {
		        // Scale by width
		        if ($h < $maxh && !$stretch) { $newh = $h; }
		        else { $newh = $maxh; }
		        @$neww = ($w * $newh / $h);
		      }
		    }
		    return array(round($neww),round($newh));
		}

	/**
	 * Fucntion for delete image of any type
	 * @param String $type
	 * @param String $image_name
	 * @return Null
	 */
	function deleteImage($type, $image_name){
		if('' != $image_name){
			$CI 				= &get_instance();
			if('staff' == $type){
				$thumb_image_size	= $CI->config->item('staff_image_thumb_dimension');
				$image_path			= $CI->config->item ('staff_image_upload_path');
			}
			foreach ($thumb_image_size as $size => $thumb_image_size){
				$image		= 	'thumb_'.$size.'_'.$image_name;
				@unlink($image_path.$image);
			}
			@unlink($image_path.$image_name);
		}
	}
}
	