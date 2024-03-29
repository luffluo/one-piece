<?php

namespace App\Services;

use Exception;
use App\Models\Tag;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InstallException;
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
     * Artisan console 是否输出信息
     * 默认不输出执行命令行信息
     *
     * @var bool
     */
    protected $nullOutput = true;

    public function __construct(Application $app, Repository $config)
    {
        $this->app    = $app;
        $this->config = $config;
        $this->data   = new Collection;
    }

    /**
     * @param bool $output
     *
     * @return $this
     */
    public function setNullOutput(bool $output = false)
    {
        $this->nullOutput = $output;

        return $this;
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
        return @unlink($this->getInstalledFile());
    }

    /**
     * 把获取的数据存到 data 属性
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data->put('app_url', $data['app_url']);

        $this->data->put('db_host', $data['db_host']);
        $this->data->put('db_database', $data['db_database']);
        $this->data->put('db_username', $data['db_username']);
        $this->data->put('db_password', $data['db_password']);
        $this->data->put('db_charset', $data['db_charset']);

        $this->data->put('admin_username', $data['admin_username']);
        $this->data->put('admin_password', $data['admin_password']);
        $this->data->put('admin_email', $data['admin_email']);

        return $this;
    }

    /**
     * @return \Illuminate\Database\Connection
     */
    public function makeConnection()
    {
        return $this->app['db.factory']->make([
            'driver'    => 'mysql',
            'host'      => $this->data->get('db_host'),
            'port'      => 3306,
            'database'  => $this->data->get('db_database'),
            'username'  => $this->data->get('db_username'),
            'password'  => $this->data->get('db_password'),
            'charset'   => $this->data->get('db_charset'),
            'collation' => $this->data->get('db_charset') . '_general_ci',
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
        try {
            // 写入数据库链接信息到 ENV
            $this->writeNewEnvironmentFileWith();

            $this->setDatabaseConfig();

            // 执行数据库迁移
            $this->installMigrations();

            // 初始化系统数据，添加一些默认数据
            $this->initOnePiece();

            // Create installed file
            $this->createInstalledFile();

            $this->resetDataToNull();
        } catch (\Exception $e) {
            throw new InstallException($e->getMessage());
        }
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
            'charset'   => $this->data->get('db_charset'),
            'collation' => $this->data->get('db_charset') . '_general_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
        ]);
    }

    /**
     * 执行数据迁移，安装所有的数据表
     */
    public function installMigrations()
    {
        $kernel = $this->app[ConsoleKernelContract::class];

        if ($this->nullOutput) {
            $kernel->call('migrate', [
                '--force' => true,
            ], new NullOutput);
        } else {
            $kernel->call('migrate', [
                '--force' => true,
            ]);
        }
    }

    public function resetMigrations()
    {
        $kernel = $this->app[ConsoleKernelContract::class];

        if ($this->nullOutput) {
            $kernel->call('migrate:reset', [
                '--force' => true,
            ], new NullOutput);
        } else {
            $kernel->call('migrate:reset', [
                '--force' => true,
            ]);
        }
    }

    /**
     * @return void
     */
    public function initOnePiece()
    {
        try {

            DB::beginTransaction();

            // 全局变量
            // 初始化默认全局变量
            $options = [
                'title'               => config('app.name'),
                'keywords'            => config('app.name') . ',laravel,php,blog',
                'description'         => 'Learn to Live in the Present Moment.',
                'comment_date_format' => 'Y-m-d H:i:s',
                'comments_list_size'  => 10,
                'comments_page_size'  => 20,
                'comments_show'       => ['comments_page_break'],
                'post_date_format'    => 'Y-m-d',
                'posts_list_size'     => 10,
                'page_size'           => 20,
                'sidebar_block'       => ['show_recent_posts', 'show_recent_comments', 'show_tag', 'show_archive', 'show_other'],
                'defaultTag'          => 1,
            ];

            foreach ($options as $key => $value) {
                setting()->set($key, $value);
            }

            // 初始用户
            $user = new User;
            $user->forceFill([
                'name'  => $this->data->get('admin_username'),
                'email' => $this->data->get('admin_email'),
                'group' => 'administrator',
            ]);
            $user->setPassword($this->data->get('admin_password'));
            $user->updateLoggedAt();
            $user->save();

            // 初始化标签
            $tag              = new Tag;
            $tag->name        = '默认标签';
            $tag->slug        = 'default';
            $tag->description = '只是一个默认标签';
            $tag->count       += 1;
            $tag->save();

            // 初始化文章
            $post        = new Post;
            $post->title = '欢迎使用 ' . config('app.name');
            $post->text  = '如果您看到这篇文章, 表示您的 blog 已经安装成功.';
            $post->type  = Post::TYPE;
            $post->user()->associate($user->id);
            $post->save();

            // 初始化文章标签关系
            $post->tags()->sync($tag->id);

            // 初始化评论
            $comment       = new Comment;
            $comment->text = '欢迎加入 ' . config('app.name') . ' 大家族';
            $comment->user()->associate($user->id);
            $comment->owner()->associate($post->user_id);
            $post->comments()->save($comment);

            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();

            $this->resetMigrations();

            logger()->error(
                $e->getMessage(),
                [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            throw new InstallException($e->getMessage());
        }
    }

    /**
     * 把一些信息写入到 .env 文件
     */
    public function writeNewEnvironmentFileWith()
    {
        file_put_contents($this->app->environmentFilePath(), preg_replace(
            $this->appUrlReplacementPattern(),
            'APP_URL=' . $this->data->get('app_url'),
            file_get_contents($this->app->environmentFilePath())
        ));

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

    protected function appUrlReplacementPattern()
    {
        $escaped = preg_quote('=' . $this->config['app.url'], '/');

        return "/^APP_URL{$escaped}/m";
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
