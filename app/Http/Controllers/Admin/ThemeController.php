<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function showOptions()
    {
        $sidebarBlock = json_decode(option('sidebarBlock', ''), true);
        $sidebarBlock = is_array($sidebarBlock) ? $sidebarBlock : [];

        return admin_view('theme.options', compact('sidebarBlock'));
    }

    public function handleOptions()
    {
        option(['sidebarBlock', json_encode(request()->get('sidebarBlock', []))]);

        return redirect()->route('admin.theme.options')->withMessage('外观设置已经保存');
    }
}
