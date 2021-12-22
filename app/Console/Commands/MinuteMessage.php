<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MinuteMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:minute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run every minute.';

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
     * @return int
     */
    public function handle()
    {
        echo 'This message is printed every minute';
    }
}
