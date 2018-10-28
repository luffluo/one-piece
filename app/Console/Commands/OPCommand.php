<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class OPCommand extends Command
{
    const VERSION = '0.0.3';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'op';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all OP commands';

    protected static $logo = <<< LOGO
   ____                ____  _              
  / __ \____  ___     / __ \(_)__  ________ 
 / / / / __ \/ _ \   / /_/ / / _ \/ ___/ _ \
/ /_/ / / / /  __/  / ____/ /  __/ /__/  __/
\____/_/ /_/\___/  /_/   /_/\___/\___/\___/ 

LOGO;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line(self::$logo);
        $this->line(sprintf('One Piece <comment>version</comment> <info>%s</info>', self::VERSION));

        $this->comment('');
        $this->comment('Available commands:');

        $this->listOPCommands();
    }

    protected function listOPCommands()
    {
        $commands = collect(Artisan::all())->mapWithKeys(function ($command, $key) {

            if (Str::startsWith($key, 'op:')) {
                return [$key => $command];
            }

            return [];
        })->toArray();

        $width = $this->getColumnWidth($commands);

        /** @var Command $command */
        foreach ($commands as $command) {
            $this->line(sprintf(" %-{$width}s %s", $command->getName(), $command->getDescription()));
        }
    }

    /**
     * @param (Command|string)[] $commands
     *
     * @return int
     */
    private function getColumnWidth(array $commands)
    {
        $widths = [];

        /* @var Command $command */
        foreach ($commands as $command) {
            $widths[] = static::strlen($command->getName());
            foreach ($command->getAliases() as $alias) {
                $widths[] = static::strlen($alias);
            }
        }

        return $widths ? max($widths) + 2 : 0;
    }

    /**
     * Returns the length of a string, using mb_strwidth if it is available.
     *
     * @param string $string The string to check its length
     *
     * @return int The length of the string
     */
    public static function strlen($string)
    {
        if (false === $encoding = mb_detect_encoding($string, null, true)) {
            return strlen($string);
        }

        return mb_strwidth($string, $encoding);
    }
}
