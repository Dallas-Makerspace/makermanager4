@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Waiver Required</div>

                    <div class="card-body">
                        <p>We were unable to find a waiver that matched the name and email address for this account. If
                            you used a different email address when filling out the waiver then enter it below and we'll
                            attempt to look up your waiver in the system.</p>

                        <form action="/waiver" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-primary" value="Recheck Waiver">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
