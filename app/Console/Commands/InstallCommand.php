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
    protected $signature = 'luff:install 
                    {--seed : Indicates if the seed task should be re-run.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Luff';

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

            $this->info('---');
            $this->error('程序已安装！');
            $this->info('---');

            return;
        }

        // 从 console 中获取信息
        $this->installer->setData($this->getData())
            ->setNullOutput();

        $this->info('---');

        $this->installer->start();

        $this->info('Luff 安装成功!');

        $this->info('---');

        if ($this->option('seed')) {
            $this->call('db:seed');
        }
    }

    protected function getData()
    {
        $data['db_host']     = $this->ask('数据库地址：', 'localhost');
        $data['db_username'] = $this->ask('数据库用户名：', 'root');
        $data['db_password'] = $this->ask('数据库密码：');
        $data['db_database'] = $this->ask('数据库：', 'luff');
        $data['db_charset']  = $this->ask('数据库字符集：', 'utf8mb4');

        $data['admin_username'] = $this->ask('管理员账号：', 'admin');
        $data['admin_password'] = $this->ask('管理员密码：', 'admin123');
        $data['admin_email']    = $this->ask('邮件地址：', 'webmaster@yourdomain.com');
    }
}
