<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttachmentsController extends Controller
{
    public function index(Request $request, Attachment $attachment)
    {
        $query = $attachment->newQuery();

        if ($keywords = $request->get('keywords', null)) {
            $query->where('title', 'like', "%{$keywords}%");
        }

        $lists = $query->with('user')
            ->recent()
            ->paginate(20);

        return admin_view('attachments.index', compact('lists', 'keywords'));
    }

    public function edit(Request $request, Attachment $attachment)
    {
        
    }

    public function update(Request $request, Attachment $attachment)
    {
        
    }

    public function destroy(Attachment $attachment)
    {
        if (! $attachment->delete()) {
            return back()->withErrors("文件 {$attachment->title} 删除失败");
        }

        return redirect()->route('admin.attachments.index')->withSuccess("文件 {$attachment->title} 已经被删除");
    }
}
