@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Your Family</div>
                <div class="card-body">
                    You ain't got none.
                </div>
            </div>
            <div class="card">
                <div class="card-header">Your Groups</div>
                <ul class="list-group list-group-flush">
                    @foreach($user->ldap->getGroups() as $group)
                        <li class="list-group-item">{{ $group->getName() }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
