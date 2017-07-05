<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallRequest;

class InstallController extends Controller
{
    /**
     * @var \App\Installer;
     */
    protected $installer;

    public function __construct()
    {
        $this->installer = app('installer');
    }

    public function showPage()
    {
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
