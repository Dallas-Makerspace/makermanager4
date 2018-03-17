@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Voting Status
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Supporting Members</h5>
                        <p class="card-text">As a supporting member, you do not have voting rights within the
                            organization. You can check your eligibility on the right.</p>
                        @if($votingEligibility->check())
                            <form action="/voting/enable" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Enable Voting Rights</button>
                            </form>
                        @else
                            <a href="#" class="btn btn-primary disabled">You do not meet requirements</a>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col col-lg-4">
                <h2>Eligibility</h2>
                <div class="card @if($votingEligibility->checkBillPayment()) text-white bg-success @else text-white bg-danger @endif">
                    <div class="card-body">
                        <h5 class="card-title">90 Days Paid Up</h5>
                        <p class="card-text">
                            @if($votingEligibility->checkBillPayment())
                                You have kept up on your bills for the past 90 days!
                            @else
                                You must have been a member for the immediate past 90 days to become a Regular Member.
                            @endif
                        </p>
                    </div>
                    <div class="card-footer">
                        <small>Last updated 1 mins ago</small>
                    </div>
                </div>
                <br>
                <div class="card @if($votingEligibility->checkNotAnAddon()) text-white bg-success @else text-white bg-danger @endif">
                    <div class="card-body">
                        <h5 class="card-title">Not an Addon</h5>
                        <p class="card-text">
                            @if($votingEligibility->checkNotAnAddon())
                                Your account is a full account!
                            @else
                                Members added via the Family rate will not be allowed voting rights.
                            @endif
                        </p>
                    </div>
                    <div class="card-footer">
                        <small>Last updated 1 mins ago</small>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
