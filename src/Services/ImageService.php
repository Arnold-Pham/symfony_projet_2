<?php

namespace App\Services;


use App\Entity\Vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ImageService extends AbstractController
{
    public function moveImage(UploadedFile $file, Vehicule $vehicule): void
    {
        $dossier_upload = $this->getParameter("upload_directory");
        $photo = md5(uniqid()) . "." . $file->guessExtension();
        $file->move($dossier_upload, $photo);
        $vehicule->setPhoto($photo);
    }

    public function delImage(Vehicule $vehicule): void
    {
        $dossier_upload = $this->getParameter("upload_directory");
        $photo = $vehicule->getPhoto();
        $oldImg = $dossier_upload . "/" . $photo;

        if (file_exists($oldImg)) {
            unlink($oldImg);
        }
    }

    public function updImage(UploadedFile $file, Vehicule $vehicule): void
    {
        $this->delImage($vehicule);
        $this->moveImage($file, $vehicule);
    }
}
