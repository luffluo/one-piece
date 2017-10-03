<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function showOptions()
    {
        $sidebarBlock = sidebar_block();

        return admin_view('theme.options', compact('sidebarBlock'));
    }

    public function handleOptions()
    {
        option(['sidebar_block', json_encode(request()->get('sidebarBlock', []))]);

        return redirect()->route('admin.theme.options')->withMessage('外观设置已经保存');
    }
}
