@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Badges</div>

                    <div class="card-body">
                        @if($badge->status == 'active')
                            <strong>Badge Number:</strong> {{ $badge->number }}
                            <p>Your badge is enabled and working
                                without issue. Should your badge become lost, damaged or otherwise unable to be used
                                then
                                you can use the form below to disable your current badge. Once disabled, you can assign
                                yourself a new badge.</p>
                        @elseif($badge->status == 'unassigned')
                            <strong>Unassigned Badge</strong>
                            <p>You have an available badge activation. Enter the badge number below to enable your
                                access to the building.</p>
                        @else
                            <strong>Suspended Badge</strong>
                            <p>Your badge is currently suspended. This is most likely due to a suspended DMS membership
                                or a missed payment. Once your account is unsuspended your badge will be automatically
                                reenabled.</p>
                        @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
