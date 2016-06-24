<?php namespace BrngyWiFi\Services\Image;

use BrngyWiFi\Modules\Visitors\Repository\VisitorsRepositoryInterface;
use BrngyWiFi\Services\Image\CreateImageDirectory;
use BrngyWiFi\Services\Image\ResizeImage;
use Intervention\Image\ImageManager as Image;

class UploadImage
{

    protected $image;
    protected $resizeImage;
    protected $createImageDirectory;
    /**
     * @var Visitors
     */
    protected $visitors;
    public function __construct(
        VisitorsRepositoryInterface $visitors,
        Image $image,
        ResizeImage $resizeImage,
        CreateImageDirectory $createImageDirectory) {
        $this->image = $image;
        $this->resizeImage = $resizeImage;
        $this->createImageDirectory = $createImageDirectory;
        $this->visitors = $visitors;
    }

    public function upload($request, $visitorsId)
    {
        $image = \Input::file('photo');

        if ($image == null) {
            return $image;
        }

        $filename = $image->getClientOriginalName();

        if (!$this->validate($image)) {
            return ['uploadImageResult' => false, 'imageName' => $filename];
        }

        $lastVisitor = $this->visitors->getLastVisitor();

        $this->createImageDirectory->createVisitorsImageDirectory($lastVisitor[0]['id']);

        $this->resizeImage->resize($image)->save(public_path('visitors-images/' . $lastVisitor[0]['id'] . '/' . $filename));

        return ['uploadImageResult' => true, 'imageName' => $filename, 'visitor_id' => $lastVisitor[0]['id']];
    }

    private function validate($image)
    {
        $validExtensions = array('jpg', 'jpeg', 'png');

        return in_array(strtolower($image->getClientOriginalExtension()), $validExtensions);
    }
}
