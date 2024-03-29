<?php

namespace App\Handlers;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    protected $allowedExts = [];

    protected $defaultExt = 'jpg';

    protected $folderPrefix = 'uploads/images';

    public function __construct()
    {
        $this->allowedExts = config('image.allowed_exts', []);
    }

    public function save(UploadedFile $file, $folder = null, $filePrefix = null, $maxWidth = false)
    {
        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?? $this->defaultExt;

        if (! in_array($extension, $this->allowedExts)) {
            return false;
        }

        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21
        // 文件夹切割能让查找效率更高。
        $folderName = $this->folderPrefix;
        if ($folder) {
            $folderName .= DIRECTORY_SEPARATOR . $folder;
        }
        $folderName .= DIRECTORY_SEPARATOR . date('Ym') . DIRECTORY_SEPARATOR . date('d');

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = ($filePrefix ? $filePrefix . '_' : '') . time() . '_' . str_random(10) . '.' . $extension;

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径
        // 值如：/home/vagrant/Code/one-piece/public/uploads/images/avatars/201709/21
        $uploadPath = public_path() . DIRECTORY_SEPARATOR . $folderName;

        $file->move(str_finish($uploadPath, DIRECTORY_SEPARATOR), $filename);

        if ($maxWidth && 'gif' !== $extension) {
            $this->reduceSize($uploadPath . DIRECTORY_SEPARATOR . $filename, $maxWidth);
        }

        return [
            'name' => $file->getClientOriginalName(),
            'path' => $folderName . DIRECTORY_SEPARATOR . $filename,
            'size' => 0,
            'type' => $extension,
            'mime' => $file->getClientMimeType(),
        ];
    }

    /**
     * 用于裁剪图片
     *
     * @param $filePath
     * @param $maxWidth
     */
    public function reduceSize($filePath, $maxWidth)
    {
        // 先实例化，传参是文件的磁盘物理路径
        /* @var $image \Intervention\Image\Image */
        $image     = Image::make($filePath);
        $oriWidth  = $image->getWidth();
        $oriHeight = $image->getHeight();

        $maxHeight = null;
        // 高度和宽度谁大按照谁来缩放，另一个等比例
        switch ($oriWidth <=> $oriHeight) {
            case -1:
                $maxHeight = $maxWidth;
                $maxWidth  = null;
                break;
        }

        $image->resize($maxWidth, $maxHeight, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        $image->save();
    }

    /**
     * 获取允许的后缀
     *
     * @return array
     */
    public function getAllowedExts()
    {
        return $this->allowedExts;
    }

    public function getAllowedExtsString($glue = ',')
    {
        return implode($glue, $this->allowedExts);
    }
}
