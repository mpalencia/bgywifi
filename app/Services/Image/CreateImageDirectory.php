<?php namespace BrngyWiFi\Services\Image;

class CreateImageDirectory
{

    public function createVisitorsImageDirectory($visitorsId)
    {
        if (!is_dir('visitors-images/' . $visitorsId)) {
            return mkdir('visitors-images/' . $visitorsId, 0777);
        }

    }
}
