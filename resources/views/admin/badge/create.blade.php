@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Add One Off Badge
                    </div>
                    <div class="card-body">
                        <p>
                            One off badges are not tied to any specific user in the system. These are intended to be used
                            for employees, contractors and other people who need access to DMS, but don't otherwise hold
                            a membership.
                        </p>
                        <form method="post" accept-charset="utf-8" role="form" action="/admin/badges">
                            @csrf
                            <fieldset>
                                <div class="form-group text">
                                    <label class="control-label" for="description">Description</label>
                                    <input type="text" name="description" maxlength="255" id="description" class="form-control" autofocus>
                                </div>
                                <div class="form-group text">
                                    <label class="control-label" for="number">Badge Number</label>
                                    <input type="text" name="number" maxlength="255" id="number" class="form-control">
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-primary">Create One Off Badge</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
