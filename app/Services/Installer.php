<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Config\Repository;
use Symfony\Component\Console\Output\NullOutput;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;

class Installer
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var \Illuminate\Support\Collection|null
     */
    protected $data;

    /**
     * 数据的来源
     * console 从命令行输入的
     * controller 从控制器获取的
     *
     * @var string
     */
    protected $dataFrom;

    public function __construct(Application $app, Repository $config)
    {
        $this->app    = $app;
        $this->config = $config;
        $this->data   = new Collection;
    }

    /**
     * 设置数据的来源
     *
     * @param string $source
     */
    public function setDataFrom($source)
    {
        $this->dataFrom = $source;
    }

    /**
     * Get installed file full name
     *
     * @return string
     */
    public function getInstalledFile()
    {
        return $this->app->storagePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'installed';
    }

    /**
     * Application is installed
     *
     * @return bool
     */
    public function installed()
    {
        if ($this->app->bound('installed')) {
            return true;
        }

        if (! $this->installedFileExists()) {
            return false;
        }

        $this->app->instance('installed', true);

        return true;
    }

    /**
     * Installed file exists
     *
     * @return bool
     */
    public function installedFileExists()
    {
        return file_exists($this->getInstalledFile());
    }

    /**
     * Create installed file
     *
     * @return bool
     */
    public function createInstalledFile()
    {
        return touch($this->getInstalledFile());
    }

    /**
     * 删除安装文件
     *
     * @return bool
     */
    public function removeInstalledFile()
    {
        return unlink($this->getInstalledFile());
    }

    /**
     * 把获取的数据存到 data 属性
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data->put('db_host', $data['db_host']);
        $this->data->put('db_database', $data['db_database']);
        $this->data->put('db_username', $data['db_username']);
        $this->data->put('db_password', $data['db_password']);

        $this->data->put('admin_username', $data['admin_username']);
        $this->data->put('admin_password', $data['admin_password']);
        $this->data->put('admin_email', $data['admin_email']);
    }


    /**
     * @return \Illuminate\Database\Connection
     */
    public function makeConnection(array $data)
    {
        return $this->app['db.factory']->make([
            'driver'    => 'mysql',
            'host'      => $data['db_host'],
            'port'      => 3306,
            'database'  => $data['db_database'],
            'username'  => $data['db_username'],
            'password'  => $data['db_password'],
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
        ], 'mysql');
    }

    /**
     * Execute install
     */
    public function start()
    {
        // 写入数据库链接信息到 ENV
        $this->writeNewEnvironmentFileWith();

        $this->setDatabaseConfig();

        // 执行数据库迁移
        $this->executeAllMigrations();

        // 初始化系统数据，添加一些默认数据
        $this->initLuff();

        // Create installed file
        $this->createInstalledFile();

        $this->resetDataToNull();
    }

    /**
     * 设置数据库信息到 Config 对象里
     */
    public function setDatabaseConfig()
    {
        $this->config->set('database.default', 'mysql');

        $this->config->set('database.connections.mysql', [
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
        ]);
    }

    /**
     * 执行数据迁移，安装所有的数据表
     */
    public function executeAllMigrations()
    {
        $kernel = $this->app[ConsoleKernelContract::class];

        if ($this->dataFrom === 'console') {
            $kernel->call('migrate', [
                '--force' => true,
            ]);
        } else {
            $kernel->call('migrate', [
                '--force' => true,
            ], new NullOutput);
        }
    }

    public function initLuff()
    {
        // 全局变量
        $options          = $this->config->get('option');
        $insert           = [];
        foreach ($options as $key => $value) {
            $insert[] = [
                'name'    => $key,
                'value'   => $value,
                'user_id' => 0,
            ];
        }
        option()->table()->insert($insert);

        // 初始化标签
        $tag        = new Tag;
        $tag->name  = '默认';
        $tag->slug  = 'default';
        $tag->count += 1;
        $tag->save();

        // 初始用户
        $user = new User([
            'name'  => $this->data->get('admin_username'),
            'email' => $this->data->get('admin_email'),
        ]);
        $user->setPassword($this->data->get('admin_password'));
        $user->save();

        // 初始化文章
        $post          = new Post;
        $post->title   = '欢迎使用 Luff';
        $post->text    = '如果您看到这篇文章, 表示您的 blog 已经安装成功.';
        $post->type    = Post::TYPE;
        $post->user_id = $user->id;
        $post->save();

        // 初始化文章标签关系
        $post->tags()->sync([$tag->id]);
    }

    /**
     * 把一些信息写入到 .env 文件
     */
    public function writeNewEnvironmentFileWith()
    {
        file_put_contents($this->app->environmentFilePath(), preg_replace(
            $this->dbConnectionReplacementPattern(),
            'DB_CONNECTION=mysql',
            file_get_contents($this->app->environmentFilePath())
        ));

        file_put_contents($this->app->environmentFilePath(), preg_replace(
            $this->dbHostReplacementPattern(),
            'DB_HOST=' . $this->data->get('db_host'),
            file_get_contents($this->app->environmentFilePath())
        ));

        file_put_contents($this->app->environmentFilePath(), preg_replace(
            $this->dbDatabaseReplacementPattern(),
            'DB_DATABASE=' . $this->data->get('db_database'),
            file_get_contents($this->app->environmentFilePath())
        ));

        file_put_contents($this->app->environmentFilePath(), preg_replace(
            $this->dbUsernameReplacementPattern(),
            'DB_USERNAME=' . $this->data->get('db_username'),
            file_get_contents($this->app->environmentFilePath())
        ));

        file_put_contents($this->app->environmentFilePath(), preg_replace(
            $this->dbPasswordReplacementPattern(),
            'DB_PASSWORD=' . $this->data->get('db_password'),
            file_get_contents($this->app->environmentFilePath())
        ));
    }

    protected function dbConnectionReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->config['database.default'], '/');

        return "/^DB_CONNECTION{$escaped}/m";
    }

    protected function dbHostReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->config['database.connections.mysql.host'], '/');

        return "/^DB_HOST{$escaped}/m";
    }

    protected function dbDatabaseReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->config['database.connections.mysql.database'], '/');

        return "/^DB_DATABASE{$escaped}/m";
    }

    protected function dbUsernameReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->config['database.connections.mysql.username'], '/');

        return "/^DB_USERNAME{$escaped}/m";
    }

    protected function dbPasswordReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->config['database.connections.mysql.password'], '/');

        return "/^DB_PASSWORD{$escaped}/m";
    }

    /**
     * 把 data 属性赋值为 null
     */
    public function resetDataToNull()
    {
        $this->data = null;
    }
}
