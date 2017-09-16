<?php

namespace App\Console\Commands;

use App\Services\Installer;
use Illuminate\Console\Command;

class UninstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luff:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall Luff';

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
        $this->info('---');

        $this->installer->removeInstalledFile();

        $this->call('migrate:reset');

        $this->info('卸载成功.');

        $this->info('---');
    }
}
