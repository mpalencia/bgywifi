<?php namespace BrngyWiFi\Services\Image;

use Intervention\Image\ImageManagerStatic as Image;

class ResizeImage {

	public function resize($image)
	{
		return Image::make($image->getRealPath())->resize(700, null, function ($constraint) {
		    $constraint->aspectRatio();
		});
	}
}