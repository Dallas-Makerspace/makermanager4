@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Personal Storage Bin Audit</div>

                    <div class="card-body">
                        <p>Please use the scanny thing below.</p>

                        <form action="/logistics/bin-audit" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="scan">Scan Bin</label>
                                <input id="scan" type="text" class="form-control" name="scan" autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary">Do the thing!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
