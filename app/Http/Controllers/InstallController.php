<?php

namespace App\Http\Controllers;

use App\Services\Installer;
use App\Contracts\Prerequisite;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InstallRequest;

class InstallController extends Controller
{
    /**
     * @var \App\Services\Installer;
     */
    protected $installer;

    protected $prerequisite;

    public function __construct(Installer $installer, Prerequisite $prerequisite)
    {
        $this->installer    = $installer;
        $this->prerequisite = $prerequisite;
    }

    public function showInstall()
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
    public function handleInstall(InstallRequest $request)
    {
        try {
            $connection = app('db.factory')->make([
                'driver'    => 'mysql',
                'host'      => $request->get('db_host'),
                'port'      => 3306,
                'database'  => $request->get('db_database'),
                'username'  => $request->get('db_username'),
                'password'  => $request->get('db_password'),
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix'    => '',
                'strict'    => true,
                'engine'    => null,
            ], 'mysql');

            $results = collect($connection->select(DB::raw('show tables')));
            $tables = [];
            array_map(function ($var) use (&$tables) {
                if (! is_object($var)) {
                    return;
                }

                $array = get_object_vars($var);

                if (! is_array($array)) {
                    return;
                }

                $tables = array_merge($tables, array_values($array));

            }, $results->all());

            cache()->flush();

            if ($results->count() && ! in_array('migrations', $tables)) {
                return back()->withErrors(['db_database' => '数据库 [ ' . $request->get('db_database') . ' ] 已经存在数据表，请先清空数据库！'])->withInput();
            }

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 7:
                    $error = ['db_database' => '数据库账号或密码错误，或数据库不存在！'];
                    break;
                case 1045:
                    $error = ['db_username' => '数据库账号或密码错误！'];
                    break;
                case 1049:
                    $error = ['db_database' => '数据库 [ ' . $request->get('db_database') . ' ] 不存在，请先创建数据库！'];
                    break;
                default:
                    $error = ['db_database' => collect($e->getMessage())->implode(', ')];
                    break;
            }

            return back()->withInput()->withErrors($error);
        }

        $this->installer->setData($request->all());
        $this->installer->setDataFrom('controller');

        $this->installer->start();

        $admin_username = $request->get('admin_username');
        $admin_password = $request->get('admin_password');

        return view('install.success', compact('admin_username', 'admin_password'));
    }
}
