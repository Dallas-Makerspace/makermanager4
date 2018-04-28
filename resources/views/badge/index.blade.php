@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Badges</div>

                    <div class="card-body">
                        @include('shared.badge', ['badge' => $badge])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row justify-content-center">

            @foreach(auth()->user()->unusedFamilyBadges() as $badge)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Family Badges</div>

                    <div class="card-body">

                            @include('shared.badge', ['badge' => $badge])


                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
