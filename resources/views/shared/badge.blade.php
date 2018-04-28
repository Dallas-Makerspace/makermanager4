@if(is_null($badge) || $badge->status == 'unassigned')
    <strong>Unassigned Badge</strong>
    <p>You have an available badge activation. Enter the badge number below to enable your
        access to the building.</p>

    <hr>

    <form method="post" accept-charset="utf-8" role="form" action="/badges/enable">
        @csrf

        <div class="form-group">
            <label for="badge">New Badge</label>
            <input id="badge" type="text" class="form-control" name="badge_number">
        </div>

        <button type="submit" class="btn btn-primary">Enable Badge</button>
    </form>
@elseif($badge->status == 'active')
    <strong>Badge Number:</strong> {{ $badge->number }}
    <p>Your badge is enabled and working
        without issue. Should your badge become lost, damaged or otherwise unable to be used
        then
        you can use the form below to disable your current badge. Once disabled, you can assign
        yourself a new badge.</p>

    <hr>

    <form method="post" accept-charset="utf-8" role="form" action="/badges/disable">
        @csrf

        <input type="hidden" name="badge_id" value="{{ $badge->id }}">

        <fieldset style="margin-bottom:15px;">
            <select name="reason_id" required="required" class="form-control">
                <option value="">Select a Reason for Disabling</option>
                <option value="1">Lost</option>
                <option value="2">Damaged</option>
                <option value="3">Other</option>
            </select>
        </fieldset>
        <button type="submit" class="btn btn-default">Disable Badge</button>
    </form>
@else
    <strong>Suspended Badge</strong>
    <p>Your badge is currently suspended. This is most likely due to a suspended DMS membership
        or a missed payment. Once your account is unsuspended your badge will be automatically
        reenabled.</p>
@endif
