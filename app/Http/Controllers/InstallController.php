<?php

namespace App\Http\Controllers;

use App\Services\Installer;
use App\Contracts\Detectable;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InstallRequest;

class InstallController extends Controller
{
    /**
     * @var \App\Services\Installer;
     */
    protected $installer;

    protected $detection;

    public function __construct(Installer $installer, Detectable $detection)
    {
        $this->installer = $installer;
        $this->detection = $detection;
    }

    public function showInstall()
    {
        // 检测安装环境
        if (! $result = $this->detection->check()) {

            $messages = $this->detection->getMessages();

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
            $connection = $this->installer->setData($request->all())
                ->makeConnection();

            $results = collect($connection->select(DB::raw('show tables')));
            $tables  = $this->handleTables($results->all(), 'migrations');

            if (count($tables)) {
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

        $this->installer->start();

        $username = $request->get('admin_username');
        $password = $request->get('admin_password');

        return view('install.success', compact('username', 'password'));
    }

    /**
     * 处理 show tables 查询出来的所有表
     *
     * @param array $tables 所有的表
     * @param array $except 排除某些表
     *
     * @return array|null
     */
    public function handleTables(array $tables, $except = [])
    {
        $results = array_map(function ($var) {
            if (! is_object($var)) {
                return;
            }

            $array = get_object_vars($var);

            if (! is_array($array)) {
                return;
            }

            return array_values($array);
        }, $tables);

        $results = array_flatten($results);

        return array_flip(array_except(array_flip($results), $except));
    }
}
