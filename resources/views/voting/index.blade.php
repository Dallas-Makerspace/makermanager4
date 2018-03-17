@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Voting Rights</div>

                    <div class="card-body">
                        <strong>Registered to Vote!</strong>
                        <p>Woo, you're allowed to vote!</p>

                        <hr>
                        <form action="/voting/disable" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Disable Voting Rights</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
