<?php

namespace App\Console\Commands;

use App\Services\Installer;
use Illuminate\Console\Command;

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
        if ($this->installer->isInstalled()) {
            $this->error('程序已安装！');

            return;
        }

        // 从 console 中获取信息
        $this->installer->setData($this->getData());
        $this->installer->setDataFrom('console');

        $this->installer->start();

        $this->info('Luff Installed!');

        if ($this->option('seed')) {
            $this->call('db:seed');
        }
    }

    protected function getData()
    {
        $data['site_name']   = $this->ask('站点名称：', 'Luff');
        $data['db_host']     = $this->ask('数据库服务器：', '127.0.0.1');
        $data['db_database'] = $this->ask('数据库：', 'luff');
        $data['db_username'] = $this->ask('数据库用户名：', 'homestead');
        $data['db_password'] = $this->ask('数据库密码：', 'secret');

        $data['admin_username'] = $this->ask('后台管理员账号：', 'admin');
        $data['admin_password'] = $this->ask('管理员密码：', 'admin123');
        $data['admin_email']    = $this->ask('管理员邮箱：', 'admin@luff.life');
    }
}
