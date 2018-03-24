<?php

namespace App\Console\Commands;

use App\LogVotingMail;
use App\User;
use Illuminate\Console\Command;
use MakerManager\VotingEligibility;

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
        $users = User::where('user_id', NULL)
            ->where('ad_active', true)
            ->where('address_1', '<>', '')
            ->get();

        $from = [
            'name' => 'Dallas Makerspace',
            'address_line1' => '1825 Monetary Lane',
            'address_line2' => 'Suite 104',
            'address_city' => 'Carrollton',
            'address_zip' => '75006',
            'address_state' => 'TX',
            'address_country' => 'US'
        ];

        $message = <<<HEREDOC
<html>
<head>
<meta charset="UTF-8">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<title>Lob.com Sample 8.5x11 Letter</title>
<style>
  *, *:before, *:after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  body {
    width: 8.5in;
    height: 11in;
    margin: 0;
    padding: 0;
  }

  .page {
    page-break-after: always;
    position: relative;
    width: 8.5in;
    height: 11in;
  }

  .page-content {
    position: absolute;
    width: 8.125in;
    height: 10.625in;
    left: 0.1875in;
    top: 0.1875in;
  }

  .text {
    position: relative;
    left: 20px;
    top: 20px;
    width: 6in;
    font-family: 'Open Sans';
    font-size: 30px;
  }
  .letter-content {
    padding: 0.5in;
  }

  #return-address-window {
    position: absolute;
    left: .625in;
    top: .5in;
    width: 3.25in;
    height: .875in;
  }


  #return-logo {
    position: absolute;
    left: .07in;
    top: .02in;
    width: 2.05in;
    height: .3in;
  }

  #recipient-address-window {
    position: absolute;
    left: .625in;
    top: 1.7in;
    width: 4in;
    height: 1in;
  }


</style>
</head>

<body>
  <div class="page">
    <div class="page-content">
      <div class="text" style="top: 3in">
        
      </div>
    </div>
    <div id="return-address-window">
      <div id="return-logo">
        
      </div>
      <div id="return-address-text">
        
      </div>
    </div>
    <div id="recipient-address-window">
      <div id="recipient-address-text">
        
      </div>
    </div>
  </div>
  <div class="page">
    <div class="page-content">
      <div class="letter-content">
        <p>Dear Members,</p>
        
        <p>
          It's time to elect our annual Board of Directors. The Dallas Makerspace's 
          annual meeting has been set to occur on April 12, 2018 starting at 8:00PM. This election 
          will include selecting the 2018 Board of Directors, and any other matters 
          properly submitted for a vote by the membership (none currently submitted). 
          Electronic voting will end at 12:00 PM on April 12th.  In-person and proxy 
          voting will end at 9:30 PM. Electronic voting will include all matters 
          submitted to be included for a vote at the Annual Meeting.  Results of 
          the election will be announced that night.
          </p>
        
        <p>
          A list of the current candidates and their Statements of Intent can be 
          found at: https://dallasmakerspace.org/wiki/Category:2018_Statements_of_Intent
          </p>
        <p>
          If you are not registered to vote, and want to do so in the upcoming 
          election, you can register online at http://votingrights.dallasmakerspace.org or 
          can register by emailing: accounts@dallasmakerspace.org. You must have been 
          a member in good standing 90 days prior to registering and be the primary 
          account member.
          </p>
        
        <p>
          If you do not plan on voting, please keep in mind that every registered 
          voter that doesn’t show up (or send a proxy) makes it more difficult to 
          meet quorum for the election. You can also remove your voting rights online
          at http://votingrights.dallasmakerspace.org or by emailing accounts@dallasmakerspace.org
          </p>
        
        <p>
          This year there are several critical issues coming up that will need to 
          be decided by the 2018 Board.  We urge you to learn the candidates 
          positions on these important topics and vote accordingly.
          </p>
        
        <p>
          Thanks for being part of the Dallas Makerspace! See you at the election.
          </p>
        
        <p>Sincerely yours,</p>
        
        <p>The 2017 Board of Directors</p>
      </div>
    </div>
  </div>
</body>

</html>
HEREDOC;

        foreach($users as $user) {
            $resp = $this->lob->letters()->create(array(
                'double_sided' => true,
                'description'           => 'Dallas Makerspace Board of Election 2018 Voting',
                'to[name]'              => "Member of the Dallas Makerspace",
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
                'file'                  => $message,
                'color'                 => false
            ));

            LogVotingMail::create([
                'user_id' => $user->id,
                'lob_id' => $resp['id'],
                'expected_delivery_date' => $resp['expected_delivery_date']
            ]);

            $this->info("Sent Mail to {$user->username}");
        }
    }
}
