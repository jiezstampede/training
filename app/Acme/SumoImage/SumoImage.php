<?php

namespace Acme\SumoImage;

use Illuminate\Support\Collection;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class SumoImage extends Image
{

	/*	Upload Image is used to optimize image and create thumbnails
	 *	@param image = The instance of the image from the request
		@param filepath = Specify the path to be uploaded
		@return path = array of paths of images
		@return image = image instance of the Intervention
	 */
	public function upload($image, $filepath,$s3_active = false) {
		$s3 = Storage::disk('s3');
		$maxSize = 1900; // Max Width/Height of Image
		$mdThumbSize = 800; // Medium Thumbnail Size
		$smThumbSize = 300; // Small Thumbnail Size

		// create instance
		$img = Image::make($image->getRealPath());
		$width = $img->width();
		$height = $img->height();

		$paths = [];

		// Optimize Image Greater than $maxSize
		if ($width > $maxSize || $height > $maxSize) {
			if ($width > $height) {
				// resize the image to a width of $maxSize and constrain aspect ratio (auto height)
				$img->resize($maxSize, null, function ($constraint) {
					$constraint->aspectRatio();
				});
			} else {
				// resize the image to a height of $maxSize and constrain aspect ratio (auto width)
				$img->resize(null, $maxSize, function ($constraint) {
				    $constraint->aspectRatio();
				});
			}
		}

		$paths['main']  = $filepath . str_random(50) . '.' . $image->getClientOriginalExtension();
		if($s3_active){
	        $s3->put($paths['main'],$img->stream()->__toString(),'public');
		} else {
			$img->save($paths['main']);
		}


		// Create Medium Sized Thumbnail only if Greater than the $mdThumbSize
		if ($width > $mdThumbSize || $height > $mdThumbSize) {
			if ($width > $height) {
				// resize the image to a width of $mdThumbSize and constrain aspect ratio (auto height)
				$img->resize($mdThumbSize, null, function ($constraint) {
					$constraint->aspectRatio();
				});
			} else {
				// resize the image to a height of $mdThumbSize and constrain aspect ratio (auto width)
				$img->resize(null, $mdThumbSize, function ($constraint) {
				    $constraint->aspectRatio();
				});
			}

			$paths['medium'] = $filepath . str_random(50) . '.' . $image->getClientOriginalExtension();
			if($s3_active){
				$s3->put($paths['medium'],$img->stream()->__toString(),'public');
			} else {
				$img->save($paths['medium']);
			}
		} else {
			$paths['medium'] = $paths['main'];
		}

		// Create Small Sized Thumbnail only if Greater than the $smThumbSize
		if ($width > $smThumbSize || $height > $smThumbSize) {
			if ($width > $height) {
				// resize the image to a width of $smThumbSize and constrain aspect ratio (auto height)
				$img->resize($smThumbSize, null, function ($constraint) {
					$constraint->aspectRatio();
				});
			} else {
				// resize the image to a height of $smThumbSize and constrain aspect ratio (auto width)
				$img->resize(null, $smThumbSize, function ($constraint) {
				    $constraint->aspectRatio();
				});
			}
			$paths['small'] = $filepath . str_random(50) . '.' . $image->getClientOriginalExtension();
			if($s3_active){
				$s3->put($paths['small'],$img->stream()->__toString(),'public');
			} else {
				$img->save($paths['small']);
			}
		} else {
			$paths['small'] = $paths['main'];
		}

		$response = [];
		$response['paths'] = $paths;
		$response['image'] = $img;

		return $response;
	}


	// function for generating default image for document and unknown file extention name
	public function defaultImageProcessor($fileName,$fileType = null){

		// if $fileType isset else it will check what file type the $filename is via function fileTypeIdentifier
		if (isset($fileType)) {
		  $image_from_library = 'img/admin/file-'.$fileType.'.png';
		}else{
		  $fileType = $this->fileTypeIdentifier($fileName);
		  $image_from_library = 'img/admin/file-'.$fileType.'.png';
		}
		// check if $image_from_library is isset and if exists in storage
		if(isset($image_from_library) AND file_exists($image_from_library)) {
		  return url($image_from_library); // return image if extension name is found on arrays
		}else {
		  // generate default image for unknown extention name with extention name on image
		  $originalImage = 'img/admin/file-file.png'; // base image that will have text of extention name
		  if(file_exists($originalImage)) {
		    $im = imagecreatefrompng($originalImage);
		    imagesavealpha($im, true); // important to keep the png's transparency 
		    if(!$im) {
		      die("im is null"); // just checking if $originalImage is null after php function imagecreatefrompng
		    }
		    $font = 5; // font size
		    $top = 100; // top position
		    $left = 30; // left position
		    $type = 'png'; // image type to be use
		    $text = '.'.pathinfo($fileName, PATHINFO_EXTENSION); // text to display on image
		    imagestring($im, $font, $left, $top, $text, null);
		    ob_start(); // Let's start output buffering.
		      imagepng($im, NULL, 0); //This will normally output the image, but because of ob_start(), it won't.
		        $contents = ob_get_contents(); //Instead, output above is saved to $contents
		    ob_end_clean(); //End the output buffer.
		    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($contents); // encode the image to base64 
		    imagedestroy($im);

		    return $base64; 
		  }else {
		    return url('img/admin/file-file.png'); // default image just in case file $originalImage have an path issue 
		  }
		}
	}

	public function fileTypeIdentifier($fileName){
		$fileType = 'other'; // default file type

		// first if condition is for image, audio and video file type checking only
		$mimeType = \GuzzleHttp\Psr7\mimetype_from_filename($fileName);
		$mime = explode('/', $mimeType);
		if ($mime[0] == 'image' || $mime[0] == 'audio' || $mime[0] == 'video') {
		  $fileType = $mime[0];
		} else {
		  // else condition is for pdf, document, spreadsheet, presentation and other for unknown file type checking only
		  $extensions['pdf'] = ['pdf'];
		  $extensions['document'] = ['doc','dot','wbk','docx','docx','docm','dotm','docb'];
		  $extensions['spreadsheet'] = ['csv','xls','xlt','xlm','xlsx','xlsm','xltx','xltm','xlsb','xla','xlam','xll','xlw'];
		  $extensions['presentation'] = ['pot','pps','pptx','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];

		  $fileExtensionName = pathinfo($fileName, PATHINFO_EXTENSION);

		  foreach ($extensions as $typeName => $extensionNames) {
		    if (in_array($fileExtensionName, $extensionNames)) {
		      $fileType = $typeName;
		    }
		  }
		}

		return $fileType;
	}
}