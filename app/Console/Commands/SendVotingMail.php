<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SendVotingMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:voting-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send voting mail to members';

    protected $lob;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(\Lob\Lob $lob)
    {
        parent::__construct();

        $this->lob = $lob;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('username', 'clone1018')->get();

        $from = [
            'name' => 'Dallas Makerspace',
            'address_line1' => '1825 Monetary Lane',
            'address_line2' => 'Suite 104',
            'address_city' => 'Carrollton',
            'address_zip' => '75006',
            'address_state' => 'TX',
            'address_country' => 'US'
        ];

        foreach($users as $user) {
            $this->lob->letters()->create(array(
                'description'           => 'Dallas Makerspace Board of Election 2018 Voting',
                'to[name]'              => $user->fullName(),
                'to[address_line1]'     => $user->address_1,
                'to[address_line2]'     => $user->address_2,
                'to[address_city]'      => $user->city,
                'to[address_zip]'       => $user->zip,
                'to[address_state]'     => $user->state,
                'to[address_country]'   => 'US',
                'from[name]'            => $from['name'],
                'from[address_line1]'   => $from['address_line1'],
                'from[address_line2]'   => $from['address_line2'],
                'from[address_city]'    => $from['address_city'],
                'from[address_zip]'     => $from['address_zip'],
                'from[address_state]'   => $from['address_state'],
                'from[address_country]' => 'US',
                'file'                  => '<html style="padding-top: 3in; margin: .5in;">HTML Letter for {{name}}</html>',
                'color'                 => false
            ));

        }
    }
}
