<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Config\Repository;

class InstallerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luff:install 
                    {--seed : Indicates if the seed task should be re-run.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Luff';

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $data;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Repository $config)
    {
        $this->data       = new Collection();
        $this->config     = $config;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->laravel['installer']->isInstalled()) {
            $this->error('程序已安装！');
            return;
        }

        // 从 console 中获取信息
        $this->setDataFromConsole();

        // 写入数据库链接信息到 ENV
        $this->writeNewEnvironmentFileWith();

        $this->setDatabaseConfig();

        // 执行数据库迁移
        $this->installAllMigrate();

        // 写入一些信息到配置数据表
        $this->writeToOptions();

        // 创建管理员
        $this->createAdministrator();

        // Create installed file
        $this->laravel['installer']->createInstalledFile();

        $this->info('Luff Installed!');

        if ($this->option('seed')) {
            $this->call('db:seed');
        }
    }

    protected function setDataFromConsole()
    {
        $this->data->put('site_name', $this->ask('网站名称：', 'Luff'));
        $this->data->put('db_host', $this->ask('数据库服务器：', '127.0.0.1'));
        $this->data->put('db_database', $this->ask('数据库：', 'luff'));
        $this->data->put('db_username', $this->ask('数据库用户名：', 'homestead'));
        $this->data->put('db_password', $this->ask('数据库密码：', 'secret'));
        // $this->data->put('db_prefix', $this->ask('数据库表前缀：', ''));

        $this->data->put('admin_username', $this->ask('后台管理员账号：', 'admin'));
        $this->data->put('admin_password', $this->ask('管理员密码：', 'admin123'));
        $this->data->put('admin_email', $this->ask('管理员邮箱：', 'admin@luff.life'));
    }

    protected function setDatabaseConfig()
    {
        $this->config->set('database', [
            'default'     => 'mysql',
            'connections' => [
                'mysql' => [
                    'driver'    => 'mysql',
                    'host'      => $this->data->get('db_host'),
                    'port'      => 3306,
                    'database'  => $this->data->get('db_database'),
                    'username'  => $this->data->get('db_username'),
                    'password'  => $this->data->get('db_password'),
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                    'strict'    => true,
                    'engine'    => null,
                ],
            ],
        ]);
    }

    protected function installAllMigrate()
    {
        $this->call('migrate', [
            '--force' => true,
        ]);
    }

    protected function writeToOptions()
    {
        option(['site.name', $this->data->get('site_name')]);
    }

    protected function createAdministrator()
    {
        $user = new User([
            'name'  => $this->data->get('admin_username'),
            'email' => $this->data->get('admin_email'),
        ]);
        $user->setPassword($this->data->get('admin_password'));
        $user->save();
    }

    protected function writeNewEnvironmentFileWith()
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->dbConnectionReplacementPattern(),
            'DB_CONNECTION=mysql',
            file_get_contents($this->laravel->environmentFilePath())
        ));

        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->dbHostReplacementPattern(),
            'DB_HOST=' . $this->data->get('db_host'),
            file_get_contents($this->laravel->environmentFilePath())
        ));

        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->dbDatabaseReplacementPattern(),
            'DB_DATABASE=' . $this->data->get('db_database'),
            file_get_contents($this->laravel->environmentFilePath())
        ));

        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->dbUsernameReplacementPattern(),
            'DB_USERNAME=' . $this->data->get('db_username'),
            file_get_contents($this->laravel->environmentFilePath())
        ));

        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->dbPasswordReplacementPattern(),
            'DB_PASSWORD=' . $this->data->get('db_password'),
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    protected function dbConnectionReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->laravel['config']['database.default'], '/');

        return "/^DB_CONNECTION{$escaped}/m";
    }

    protected function dbHostReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->laravel['config']['database.connections.mysql.host'], '/');

        return "/^DB_HOST{$escaped}/m";
    }

    protected function dbDatabaseReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->laravel['config']['database.connections.mysql.database'], '/');

        return "/^DB_DATABASE{$escaped}/m";
    }

    protected function dbUsernameReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->laravel['config']['database.connections.mysql.username'], '/');

        return "/^DB_USERNAME{$escaped}/m";
    }

    protected function dbPasswordReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->laravel['config']['database.connections.mysql.password'], '/');

        return "/^DB_PASSWORD{$escaped}/m";
    }
}
