<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class ImageService
{
    protected $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function saveForAvatar(UploadedFile $data, $userId)
    {
        $ext = $data->clientExtension() ?? 'jpg';

        $this->imageManager->make($data)
            ->resize(380, 380)
            ->save(public_path('uploads/avatars/' . $userId . '-' . '380.' . $ext))
            ->resize(200, 200)
            ->save(public_path('uploads/avatars/' . $userId . '-' . '200.' . $ext))
            ->resize(100, 100)
            ->save(public_path('uploads/avatars/' . $userId . '-' . '100.' . $ext));

        return $ext;
    }
}
