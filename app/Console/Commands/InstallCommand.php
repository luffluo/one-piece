<?php

namespace App\Console\Commands;

use App\Services\Installer;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'op:install 
                    {--seed : Indicates if the seed task should be re-run.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install One Piece';

    /**
     * @var \App\Services\Installer
     */
    protected $installer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Installer $installer)
    {
        parent::__construct();

        $this->installer = $installer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->installer->installed()) {

            $this->error('程序已安装 ...');

            return;
        }

        $this->info('安装开始 ...');

        try {
            // 从 console 中获取信息
            $this->installer
                ->setData($this->getData())
                ->setNullOutput()
                ->start();
        } catch (\Exception $e) {

            $this->error('Install failed: ' . $e->getMessage());

            return;
        }

        if ($this->option('seed')) {
            $this->call('db:seed');
        }

        $this->info('One Piece 安装成功!');
    }

    /**
     * @return array
     */
    protected function getData()
    {
        $data['app_url'] = $this->ask('站点地址', 'https://one-piece.com');

        $data['db_host']     = $this->ask('数据库地址：', 'localhost');
        $data['db_username'] = $this->ask('数据库用户名：', 'root');
        $data['db_password'] = $this->ask('数据库密码：');
        $data['db_database'] = $this->ask('数据库：', 'one-piece');
        $data['db_charset']  = $this->ask('数据库字符集：', 'utf8mb4');

        $data['admin_username'] = $this->ask('管理员账号：', 'admin');
        $data['admin_password'] = $this->ask('管理员密码：', 'admin123');
        $data['admin_email']    = $this->ask('邮件地址：', 'webmaster@yourdomain.com');

        return $data;
    }
}
