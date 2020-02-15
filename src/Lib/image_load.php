<?php
// image.class.php

// *************************************************************************
// *                                                                       *
// * (c) 2008-2010 Wolf Software Limited <info@wolf-software.com>          *
// * All Rights Reserved.                                                  *
// *                                                                       *
// * This program is free software: you can redistribute it and/or modify  *
// * it under the terms of the GNU General Public License as published by  *
// * the Free Software Foundation, either version 3 of the License, or     *
// * (at your option) any later version.                                   *
// *                                                                       *
// * This program is distributed in the hope that it will be useful,       *
// * but WITHOUT ANY WARRANTY; without even the implied warranty of        *
// * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
// * GNU General Public License for more details.                          *
// *                                                                       *
// * You should have received a copy of the GNU General Public License     *
// * along with this program.  If not, see <http://www.gnu.org/licenses/>. *
// *                                                                       *
// *************************************************************************

class image_load
{
  private $class_name        = "Image";
  private $class_version     = "1.3.1";
  private $class_author      = "Wolf Software";
  private $class_source      = "http://www.wolf-software.com/Downloads/image_class";

  private $original          = "";
  private $image             = "";
  private $image_type        = "";
 
  function __construct(){}
  public function class_name()
    {
      return $this->class_name;
    }

  public function class_version()
    {
      return $this->class_version;
    }

  public function class_author()
    {
      return $this->class_author;
    }

  public function class_source()
    {
      return $this->class_source;
    }

  public function load($filename)
    {
      //if (file_exists($filename))
        {
          $image_info = getimagesize(($filename));

          $this->image_type = $image_info[2];
		  //print_r($image_info);
		  
          if ($this->image_type == IMAGETYPE_JPEG)
            {
              $this->image = imagecreatefromjpeg(($filename));
            }
          elseif ($this->image_type == IMAGETYPE_GIF)
            {
              $this->image = imagecreatefromgif(($filename));
            }
          elseif ($this->image_type == IMAGETYPE_PNG)
            {
              $this->image = imagecreatefrompng(($filename));
            }
          $this->original = $this->image;
          return true;
        }
     /* else
        {
          return false;
        }*/
    }

  public function build($image_stream)
    {
      $this->image = imagecreatefromstring($image_stream);
      $this->original = $this->image;
    }

  public function revert()
    {
      $this->image = $this->original;
    }

  public function save($filename, $compression=100, $permissions=null)
    {
      if ($this->image_type == IMAGETYPE_JPEG)
        {
          imagejpeg($this->image, $filename, $compression);
        }
      elseif ($this->image_type == IMAGETYPE_GIF)
        {
          imagegif($this->image, $filename);         
        }
      elseif ($this->image_type == IMAGETYPE_PNG)
        {
          imagepng($this->image, $filename);
        }
      else
        {
          imagepng($this->image, $filename);
        }
      if ($permissions != null)
        {
          chmod($filename, $permissions);
        }
    }

  public function save_jpeg($filename, $compression=100, $permissions=null)
    {
      imagejpeg($this->image, $filename, $compression);
      if ($permissions != null)
        {
          chmod($filename, $permissions);
        }
    }

  public function save_gif($filename, $permissions=null)
    {
      imagegif($this->image, $filename);         
      if ($permissions != null)
        {
          chmod($filename, $permissions);
        }
    }

  public function save_png($filename, $permissions=null)
    {
      imagepng($this->image, $filename);         
      if ($permissions != null)
        {
          chmod($filename, $permissions);
        }
    }

  public function output($quality = 100)
    {
      if ($this->image_type == IMAGETYPE_JPEG)
        {
          header('Content-Type: image/jpeg');
          imagejpeg($this->image,NULL,$quality);
        }
      elseif ($this->image_type == IMAGETYPE_GIF)
        {
          header('Content-Type: image/gif');
          imagegif($this->image);
        }
      elseif ($this->image_type == IMAGETYPE_PNG)
        {
          header('Content-Type: image/png');
          imagepng($this->image);
        }
      else 
        {
          header('Content-Type: image/png');
          imagepng($this->image);
        }
    }

  public function output_jpeg()
    {
      header('Content-Type: image/jpeg');
      imagejpeg($this->image);
    }

  public function output_gif()
    {
      header('Content-Type: image/gif');
      imagegif($this->image);
    }

  public function output_png()
    {
      header('Content-Type: image/png');
      imagepng($this->image);
    }

  public function output_raw()
    {
      ob_start();

      if ($this->image_type == IMAGETYPE_JPEG)
        {
          imagejpeg($this->image);
        }
      elseif ($this->image_type == IMAGETYPE_GIF)
        {
          imagegif($this->image);
        }
      elseif ($this->image_type == IMAGETYPE_PNG)
        {
          imagepng($this->image);
        }
      $contents = ob_get_contents();
      ob_end_clean();

      return $contents;
    }

  public function output_raw_jpeg()
    {
      ob_start();
      imagejpeg($this->image);
      $contents = ob_get_contents();
      ob_end_clean();
      return $contents;
    }

  public function output_raw_gif()
    {
      ob_start();
      imagegif($this->image);
      $contents = ob_get_contents();
      ob_end_clean();
      return $contents;
    }

  public function output_raw_png()
    {
      ob_start();
      imagepng($this->image);
      $contents = ob_get_contents();
      ob_end_clean();
      return $contents;
    }

  public function convert_to_jpeg()
    {
      if ($this->image_type == IMAGETYPE_JPEG)
        return;

      ob_start();
      imagejpeg($this->image);
      $contents = ob_get_contents();
      ob_end_clean();

      $this->image = imagecreatefromstring($contents);
      $this->image_type = IMAGETYPE_JPEG;
    }

  public function convert_to_gif()
    {
      if ($this->image_type == IMAGETYPE_GIF)
        return;

      ob_start();
      imagegif($this->image);
      $contents = ob_get_contents();
      ob_end_clean();

      $this->image = imagecreatefromstring($contents);
      $this->image_type = IMAGETYPE_GIF;
    }

  public function convert_to_png()
    {
      if ($this->image_type == IMAGETYPE_PNG)
        return;

      ob_start();
      imagepng($this->image);
      $contents = ob_get_contents();
      ob_end_clean();

      $this->image = imagecreatefromstring($contents);
      $this->image_type = IMAGETYPE_PNG;
    }

  public function get_width()
    {
      return imagesx($this->image);
    }

  public function get_height()
    {
      return imagesy($this->image);
    }

  public function resize_to_height($height)
    {
      $ratio = $height / $this->get_height();
      $width = $this->get_width() * $ratio;

      $this->resize($width, $height);
    }

  public function resize_to_width($width)
    {
      $ratio = $width / $this->get_width();
      $height = $this->get_height() * $ratio;

      $this->resize($width, $height);
    }

  public function scale($scale)
    {
      $width = $this->get_width() * $scale/100;
      $height = $this->get_height() * $scale/100; 
      $this->resize($width, $height);
    }

  public function resize($width, $height)
    {
      $new_image = imagecreatetruecolor($width, $height);
	  
	  imagealphablending($new_image, false);
      imagesavealpha($new_image,true);
      $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
	  
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->get_width(), $this->get_height());
      $this->image = $new_image;   
    }
  public function resizeWidthHeight($width, $height)
	{
	  
     
	  $width_source = $this->get_width();
	  $height_source =  $this->get_height();
      $w_ratio = $width / $width_source;
      $h_ratio = $height  / $height_source;
	  $resize_width = $width;
	  $resize_height = $height;
	  if($w_ratio < 1 &&  $h_ratio < 1)
	  {
		  if($w_ratio > $h_ratio)
		  {
		  	$resize_width = $width_source * $h_ratio;
			$resize_height = $height_source * $h_ratio;
		  }
		  else
		  {
		  	 $resize_width = $width_source * $w_ratio;
			 $resize_height = $height_source * $w_ratio;
		  }
	  }
	  else
	  {
		  if($w_ratio >= 1 && $h_ratio >= 1)
		  {
		  	$resize_width = $width_source;
			$resize_height = $height_source;
		  }
		  else if($w_ratio >= 1 && $h_ratio < 1 )
		  {
			 $resize_width = $width_source * $h_ratio;
			 $resize_height = $height_source * $h_ratio;
		  }
		  else if($w_ratio < 1 && $h_ratio >= 1)
		  {
			 $resize_width = $width_source * $w_ratio;
			 $resize_height = $height_source * $w_ratio;
		  }
	  }
	  $new_image = imagecreatetruecolor($resize_width, $resize_height);
	  
	  imagealphablending($new_image, false);
      imagesavealpha($new_image,true);
      $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      imagefilledrectangle($new_image, 0, 0, $resize_width, $resize_height, $transparent);
	  
	  imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $resize_width, $resize_height, $this->get_width(), $this->get_height());
	  
	  $this->image = $new_image;    
	}
	function getSizeResizeCrop($width, $height, $cur_width, $cur_height)
	{
		$ratio_width = $cur_width / $width;
		$ratio_height = $cur_height/$height;
		if($ratio_width < $ratio_height)
		{
			$widthResize = $width;
			$heightResize = ceil($cur_height / $ratio_width);
		}
		else
		{
			$heightResize = $height;
			$widthResize = ceil($cur_width / $ratio_height);
		}
		
		return array($widthResize, $heightResize);
	}
    public function crop($width, $height)
    {
		$width_crop = $width;
		$height_crop = $height;
		
		list($width_resize, $height_resize) = $this->getSizeResizeCrop($width, $height,$this->get_width(),$this->get_height());
		$new_image = imagecreatetruecolor($width_resize, $height_resize);
		
		imagealphablending($new_image, false);
        imagesavealpha($new_image,true);
        $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
        imagefilledrectangle($new_image, 0, 0, $width_crop, $height_crop, $transparent);
		
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width_resize, $height_resize, $this->get_width(), $this->get_height());
		$this->image = $new_image;
		
		$newWidth = ($width_crop >= $width_resize) ? $width_resize : $width_crop;
		$newHeight = ($height_crop >= $height_resize) ? $height_resize : $height_crop;
		
		$startWidth = ceil(($width_resize - $newWidth) / 2);
		if($startWidth < 0)
		{
			$startWidth = 0;
		}
		$startHeight = ceil(($height_resize - $newHeight) / 2);		
		if($startHeight < 0)
		{
			$startHeight = 0;
		}
		
		$newImage = imagecreatetruecolor($newWidth, $newHeight);
		
		imagealphablending($newImage, false);
        imagesavealpha($newImage,true);
        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
        imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
		
		imagecopyresampled($newImage, $this->image, 0, 0, $startWidth, $startHeight, $width_crop, $height_crop, $width_crop, $height_crop);
		$this->image = $newImage;	
	  
	  
	 /* $new_image = imagecreatetruecolor($width, $height);
      $wm = $this->get_width() / $width;
      $hm = $this->get_height() / $height;
      $h_height = $height / 2;
      $w_height = $width / 2;

      if ($this->get_width() > $this->get_height())
        {
          $adjusted_width = $this->get_width() / $hm;
          $half_width = $adjusted_width / 2;
          $int_width = $half_width - $w_height;

          imagecopyresampled($new_image, $this->image, -$int_width, 0, 0, 0, $adjusted_width, $height, $this->get_width(), $this->get_height());
        }
      elseif (($this->get_width() < $this->get_height()) || ($this->get_width() == $this->get_height()))
        {
          $adjusted_height = $this->get_height() / $wm;
          $half_height = $adjusted_height / 2;
          $int_height = $half_height - $h_height;

          imagecopyresampled($new_image, $this->image, 0, -$int_height, 0, 0, $width, $adjusted_height, $this->get_width(), $this->get_height());
        }
      else
        {
          imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->get_width(), $this->get_height());
        }
      $this->image = $new_image;*/
    }

  public function add_text($string)
    {
      $extra = 10 + (strlen($string) * 6);
      $x = $this->get_width() - $extra;
      if (x < 0)
        {
          $x = 0;
        }
      $y = $this->get_height() - 20;

      $text_color = imagecolorallocate($this->image, 0, 0, 0);
      imagestring ($this->image, 2, $x, $y, $string, $text_color);
    }
	public function add_watermark_image( $pathToImage , $d_x , $d_y )
    {
        $imgToMerge = null;        
        list( $width_img_to_merge , $height_img_to_merge ,$type_1 )=@getimagesize($pathToImage);
        
        switch ($type_1)
        {
            case IMAGETYPE_JPEG:
                $imgToMerge = imagecreatefromjpeg($pathToImage);
            break;
            case IMAGETYPE_GIF:
                $imgToMerge = imagecreatefromgif($pathToImage);
            break;
            case IMAGETYPE_PNG: 
                $imgToMerge = imagecreatefrompng($pathToImage);            
            break; 
        }
        imagealphablending($this->image,true);
        imagecopymerge($this->image, $imgToMerge, $d_x, $d_y, 0, 0, 0,  $width_img_to_merge , $height_img_to_merge );
        $rs = imagecopy( $this->image , $imgToMerge ,  $d_x ,$d_y ,  0 , 0 , $width_img_to_merge, $height_img_to_merge );
        if($rs)        return true;        
        return false;
    }
  public function add_watermark($string)
    {
      $extra = 15 + (strlen($string) * 6);
      $x = $this->get_width() - $extra;
      if (x < 0)
        {
          $x = 0;
        }
      $y = $this->get_height() - 5;

      $image = imagecreatetruecolor($this->get_width(), $this->get_height());
      imagecopyresampled($image, $this->image, 0, 0, 0, 0, $this->get_width(), $this->get_height(), $this->get_width(), $this->get_height());
      $rectangle_colour = imagecolorallocatealpha($image, 0, 0, 0, 40);
      imagefilledrectangle($image, $x-10, $this->get_height()-20, $this->get_width(), $this->get_height(), $rectangle_colour);
      $text_colour = imagecolorallocate($image, 255, 255, 225);

      if (function_exists('imagettftext'))
        {
          $font = '/usr/share/fonts/truetype/msttcorefonts/arial.ttf';
          $font_size = 10;
          imagettftext($image, $font_size, 0, $x, $y, $text_colour, $font, $string);
        }
      $this->image = $image;
    }
}

?>
