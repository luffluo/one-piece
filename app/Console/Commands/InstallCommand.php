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
    protected $description = 'Install the One Piece';

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

            $this->comment('');
            $this->error('The One Piece already installed...');
            $this->comment('');

            return;
        }

        $this->comment('');
        $this->info('Install start...');
        $this->comment('');

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

        $this->comment('');
        $this->info('One Piece is Okay now!');
        $this->comment('');
    }

    /**
     * @return array
     */
    protected function getData()
    {
        $data['app_url'] = $this->ask('Site Url', 'https://one-piece.com');

        $data['db_host']     = $this->ask('Database Host：', 'localhost');
        $data['db_username'] = $this->ask('Database Username：', 'root');
        $data['db_password'] = $this->ask('Database Password：');
        $data['db_database'] = $this->ask('Database Name：', 'one-piece');
        $data['db_charset']  = $this->ask('Database Charset：', 'utf8mb4');

        $data['admin_username'] = $this->ask('Admin Username：', 'admin');
        $data['admin_password'] = $this->ask('Admin Password：', 'admin123');
        $data['admin_email']    = $this->ask('Email：', 'webmaster@yourdomain.com');

        return $data;
    }
}
