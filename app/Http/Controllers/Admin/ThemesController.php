<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThemesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function showOption()
    {
        $sidebarBlock = setting('sidebar_block');

        return admin_view('themes.option', compact('sidebarBlock'));
    }

    public function handleOption(Request $request)
    {
        setting(['sidebar_block' => $request->get('sidebarBlock', [])]);

        return redirect()->route('admin.themes.option')->withMessage('外观设置已经保存');
    }
}
