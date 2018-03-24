@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="text-center">
            <h1>Welcome, {{ $user->fullName() }}!</h1>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header text-white @if($user->ad_active)  bg-success @else bg-danger @endif">{{ $user->fullName() }}</h5>

                    <div class="card-body">
                        <table class="table table-user-information">
                            <tbody>
                            <tr>
                                <td>Join date:</td>
                                <td>{{ $user->created }} - {{ (new \Carbon\Carbon())->diffForHumans(new \Carbon\Carbon($user->created), true) }}</td>
                            </tr>
                            <tr>
                                <td>Home Address</td>
                                <td>
                                    {{ $user->address_1 }} {{ $user->address_2 }}<br>
                                    {{ $user->city }}, {{ $user->state }} {{ $user->zip }}
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>{{ $user->phone }}</td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-primary">Edit</a>
                                <a href="/admin/users/{{ $user->id }}/sync" class="disabled btn btn-outline-primary">Sync</a>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Badge</div>
                    <div class="card-body">
                        @if($user->badge)
                            @if($user->badge->status == 'active')
                                <div class="text-center">
                                    <h5>{{ ucwords($user->badge->status) }}</h5>
                                    <h3 class="@if($user->badge->status == 'active') text-success @endif">{{ $user->badge->number }}</h3>
                                </div>
                            @else
                                <strong>{{ $user->badge->status }}: </strong> {{ $user->badge->number }}
                            @endif
                        @else
                            <p>No badges found.</p>
                        @endif
                            <div class="text-center">
                                <a href="/badges" class="btn btn-primary btn-sm">Change Badge</a>
                            </div>
                    </div>
                </div>

                <br>

                @if($user->family->isNotEmpty())
                <div class="card">
                    <div class="card-header">Family</div>
                    <table class="table mb-0">
                        @foreach($user->family as $family)
                            <tr>
                                <td><a href="/admin/users/{{ $family->id }}">{{ $family->fullName() }}</a></td>
                                <td>{{ $family->ad_active ? 'Active' : 'Inactive' }}</td>
                                <td>{{ $family->badge->number }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <br>
                @elseif(! is_null($user->user_id))
                    <a href="/admin/users/{{ $user->user_id }}" class="btn btn-lg btn-outline-primary btn-block">Go to Main Account</a>
                    <br>
                @endif

                <div class="card">
                    <div class="card-header">Active Directory Groups</div>
                    <ul class="list-group list-group-flush">
                        @foreach($user->getLdapGroupsByParent() as $group)
                            <li class="list-group-item" data-toggle="tooltip" data-placement="left" title="{{ $group->getDescription() }}">{{ $group->getName() }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
