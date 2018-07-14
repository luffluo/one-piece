<?php

namespace App\Observers;

use App\Models\Attachment;

class AttachmentObserver
{
    public function creating(Attachment $attachment)
    {
        $attachment->type = Attachment::TYPE;
    }

    public function deleted(Attachment $attachment)
    {
        $attachment->deleteFile();
    }
}
