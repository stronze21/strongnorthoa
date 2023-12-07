<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\BookingUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CopyUserAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy user table to accounts table';

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
        $users = BookingUser::all();
        foreach($users as $user){
            $updated = User::updateOrCreate(
                        [
                            'id' => $user->user_id
                        ],
                        [
                            'name' => $user->full_name,
                            'email' => $user->email,
                            'password' => Hash::make($user->password),
                        ]
                    );
        }
    }
}
