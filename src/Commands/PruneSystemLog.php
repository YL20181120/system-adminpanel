<?php

namespace Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Admin\Models\Log;

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
    protected $signature = 'admin:prune-logs
                        {--hours=24 : The number of hours to retain batch data}';


    protected static $defaultName = 'admin:prune-logs';
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
