<?php

namespace App\Console\Commands;

use App\Helper\Common;
use App\Models\User;
use Illuminate\Console\Command;

class ExpireLogin extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expireLoginLink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {

        /**
         * Link expire time set to 2 hour
         */
        $date = date('Y-m-d H:i:s');
        $expireTime = Common::fixDateFormat($date, 'Y-m-d H:i:s', 'Y-m-d H:i:s', '-2 hours');
        User::where('updated_at', '<', $expireTime)->update(['hash_token' => null]);
        return 0;
    }
}
