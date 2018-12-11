<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/11
 * Time: 14:02
 */

namespace Onmpw\JiyiLog\Commands;


use Illuminate\Console\Command;
use Onmpw\JiyiLog\JLog;

class Log extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Log {operate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log operation command; `Log backup`: Backup the logs to the database';

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
        //
        $operate = $this->argument('operate');

        /*
         * Backup today's log to the database
         */
        if($operate == 'backup'){
            // Get today's date
            $today = date("Ymd");
            $log = new JLog();
            $log->backUp($today);
        }
    }
}