<?php

namespace App\Observers;

use App\Models\Attachment;

class AttachmentObserver
{
    public function deleted(Attachment $attachment)
    {
        $attachment->deleteFile();
    }
}
