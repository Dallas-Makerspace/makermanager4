<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MakerManager\BadgeService;

class Badge extends Model
{
    protected $table = 'badges';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activate()
    {
        if( ! ($this->user instanceof User)) {
            throw new \Exception("Badge must be saved for a user before you can activate it.");
        }

        // Tell the chinese
        $badgeService = new BadgeService($this);
        $badgeService->activate();

        // tell the ActiveDirectory
        $this->user->bindLdapUser();
        $this->user->ldap->employee_id = $this->number;
        $this->user->ldap->save();


        $history = new BadgeHistory();
        $history->badge_id = $this->id;
        $history->badge_number = $this->number;
        $history->modified_by = auth()->check() ? auth()->user()->id : null;
        $history->changed_to = 'active';
        $history->save();


        return true;
    }

    public function deactivate($reason)
    {
        // Tell the chinese
        $badgeService = new BadgeService($this);
        $badgeService->deactivate();

        // tell the ActiveDirectory
        $this->user->bindLdapUser();
        $this->user->ldap->employee_id = null;
        $this->user->ldap->save();

        $history = new BadgeHistory();
        $history->badge_id = $this->id;
        $history->badge_number = $this->number;
        $history->modified_by = auth()->check() ? auth()->user()->id : null;
        $history->changed_to = 'unassigned';
        $history->reason = $reason;
        $history->save();

        $this->delete();

        return true;
    }

    // binary 24 bits long
    // take first octet turn that into decimal
    // take next 16 into decimal
    // remove 0's from both
    // concat
    public function chinaNumber() {
        // 64 bits total
        $value = unpack('H*', $this->number);
        $bin = base_convert($value[1], 16, 2);
        dd($bin);

        $first = bindec(substr($bin, 0, 8));
        $second = bindec(substr($bin, 8, 8 + 16));

        // take first 8 bits

        return str_replace('0', '', $first . $second);
    }
}
