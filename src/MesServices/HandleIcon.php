<?php

namespace App\MesServices;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class HandleIcon
{
    protected $slugger;
    protected $containerBag;
    

    public function __construct(SluggerInterface $slugger, ContainerBagInterface $containerBag)
    {
        $this->slugger = $slugger;
        $this->containerBag = $containerBag;
    }

    public function SaveImage($imageIcon, object $object)
    {
        $originalFilename = pathinfo($imageIcon->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFilename);
        $uniqFileName = $safeFileName .'-'. uniqid() .'.'. $imageIcon->guessExtension();

        $imageIcon->move(
            $this->containerBag->get('app_icons_directory'),
            $uniqFileName
        );

        $object->setImagePathUrl('icons/' .$uniqFileName);        
    }

    public function editImage($imageIcon, object $object, $vintageImage)
    {
        $this->saveImage($imageIcon, $object);

        $this->deleteImage($vintageImage);
    }

    public function deleteImage($vintageImage)
    {
        if($vintageImage)
        {
            $pathToVintageImage = $this->containerBag->get('app_icons_directory') ."/..". $vintageImage;

            if(file_exists($pathToVintageImage))
            {
                unlink($pathToVintageImage);
            }
        }        
    }
}