<?php

namespace System\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use System\Models\Log;

/**
 * Class PruneSystemLog
 * @author Jasmine <youjingqiang@gmail.com>
 */
class PruneSystemLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:prune-logs
                        {--hours=24 : The number of hours to retain batch data}';


    protected static $defaultName = 'system:prune-logs';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $instance = new Log;
        $instance->prune(Carbon::now()->subHours($this->option('hours')));
    }
}
