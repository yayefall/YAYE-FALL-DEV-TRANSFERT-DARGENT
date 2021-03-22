<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Request;

class UserService
{

    /**
     * put image of user
     * @param Request $request
     * @return array|false|resource
     */


    public function uploadImage( $request){
        $photo = $request->files->get("photo");
        if($photo)
        {
            $photoBlob = fopen($photo->getRealPath(),"rb");
            return $photoBlob;
        }
        return null;
    }
    public function validate(){
        return true;
    }



}
