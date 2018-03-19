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

        exit ('got here');

        // tell the ActiveDirectory
        $this->user->ldap->employee_id = '';
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
}
