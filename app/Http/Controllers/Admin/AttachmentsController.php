<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttachmentRequest;

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

    public function edit(Attachment $attachment)
    {
        return admin_view('attachments.create_and_edit', compact('attachment'));
    }

    public function update(AttachmentRequest $request, Attachment $attachment)
    {
        $text                = $attachment->text;
        $text['url']         = asset($text['path']);
        $text['description'] = $request->description;

        $attachment->title = $request->title;
        $attachment->slug  = $request->slug;
        $attachment->text  = $text;

        if (! $attachment->save()) {
            return back()->withErrors("文件 {$attachment->title} 修改失败");
        }

        return redirect()->route('admin.attachments.index')->withSuccess("文件 {$attachment->title} 已经被修改");
    }

    public function destroy(Attachment $attachment)
    {
        if (! $attachment->delete()) {
            return back()->withErrors("文件 {$attachment->title} 删除失败");
        }

        return redirect()->route('admin.attachments.index')->withSuccess("文件 {$attachment->title} 已经被删除");
    }

    public function clear(Attachment $attachment)
    {
        $attachments = $attachment->newQuery()
            ->undocumented()
            ->get();

        if (! $attachments->count()) {
            return back()->withErrors('没有未归档文件被清理');
        }

        // 设置为不超时
        set_time_limit(0);

        $result = false;
        foreach ($attachments as $loopAttachment) {
            $result = $loopAttachment->deleteFile();
        }

        if (! $result) {
            return back()->withErrors('清理未归档文件失败');
        }

        $aIds = $attachments->pluck('id')->all();
        $result = $attachment->newQuery()
            ->whereIn('id', $aIds)
            ->delete();

        if (! $result) {
            return back()->withErrors('清理未归档文件失败');
        }

        return redirect()->route('admin.attachments.index')->withSuccess('未归档文件已经被清理');
    }
}
