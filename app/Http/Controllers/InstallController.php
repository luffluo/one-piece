<?php

namespace App\Http\Controllers;

use App\Contracts\Prerequisite;
use App\Http\Requests\InstallRequest;

class InstallController extends Controller
{
    /**
     * @var \App\Services\Installer;
     */
    protected $installer;

    protected $prerequisite;

    public function __construct(Prerequisite $prerequisite)
    {
        $this->installer    = app('installer');
        $this->prerequisite = $prerequisite;
    }

    public function showPage()
    {
        // 检测安装环境
        if (! $result = $this->prerequisite->check()) {

            $messages = $this->prerequisite->getMessages();

            return view('install.check', compact('result', 'messages'));
        }


        return view('install.install');
    }

    /**
     * @param InstallRequest $request
     */
    public function handle(InstallRequest $request)
    {
        $this->installer->setData($request->all());
        $this->installer->setDataFrom('controller');

        $this->installer->start();

        $admin_username = $request->get('admin_username');
        $admin_password = $request->get('admin_password');

        return view('install.success', compact('admin_username', 'admin_password'));
    }
}
