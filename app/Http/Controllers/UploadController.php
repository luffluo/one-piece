<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class UploadController extends Controller
{
    public function handleUpload(Request $request, ImageUploadHandler $handler, Attachment $attachment)
    {
        $file = $request->img;
        if (empty($file)) {
            return response()->json([
                'code'    => 500,
                'message' => 'Error',
                'data'    => [],
            ], 500);
        }

        $cid = $request->get('cid', null);

        $result = $handler->save($file, 'posts', $cid);

        if (! $result) {
            return response()->json([
                'code'    => 500,
                'message' => 'Error',
                'data'    => [],
            ], 500);
        }

        $attachment->title     = $result['name'];
        $attachment->text      = $result;
        $attachment->user_id   = auth()->user()->id;
        $attachment->parent_id = $cid ?? 0;

        if (! $attachment->save()) {
            return response()->json([
                'code'    => 500,
                'message' => 'Error',
                'data'    => [],
            ], 500);
        }

        return [
            'code' => 200,
            'data' => [
                'url' => asset($result['path']),
            ],
        ];
    }
}
