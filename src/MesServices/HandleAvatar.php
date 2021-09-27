<?php

namespace App\MesServices;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class HandleAvatar
{
    protected $slugger;
    protected $containerBag;
    

    public function __construct(SluggerInterface $slugger, ContainerBagInterface $containerBag)
    {
        $this->slugger = $slugger;
        $this->containerBag = $containerBag;
    }

    public function SaveImage($avatarFile, object $object)
    {
        $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFilename);
        $uniqFileName = $safeFileName .'-'. uniqid() .'.'. $avatarFile->guessExtension();

        $avatarFile->move(
            $this->containerBag->get('app_avatar_directory'),
            $uniqFileName
        );

        $object->setAvatarUser('avatar/' .$uniqFileName);        
    }

    public function editImage($avatarFile, object $object, $vintageImage)
    {
        $this->SaveImage($avatarFile, $object);

        $this->deleteImage($vintageImage);
    }

    public function deleteImage($vintageImage)
    {
        if($vintageImage)
        {
            $pathToVintageImage = $this->containerBag->get('app_avatar_directory') ."/..". $vintageImage;

            if(file_exists($pathToVintageImage))
            {
                unlink($pathToVintageImage);
            }
        }        
    }
}