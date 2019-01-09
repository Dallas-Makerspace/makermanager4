@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header">Edit User: {{ $user->fullName() }}</h5>

                    <div class="card-body">
                        <form method="post" accept-charset="utf-8" role="form">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <fieldset>
                                <div class="form-group text required">
                                    <label class="control-label" for="first-name">First Name</label>
                                    <input type="text" name="first_name" required="required" maxlength="255" id="first-name" class="form-control" value="{{ $user->first_name }}">
                                </div>
                                <div class="form-group text required">
                                    <label class="control-label" for="last-name">Last Name</label>
                                    <input type="text" name="last_name" required="required" maxlength="255" id="last-name" class="form-control" value="{{ $user->last_name }}">
                                </div>
                                <div class="form-group tel required">
                                    <label class="control-label" for="phone">Phone</label>
                                    <input type="tel" name="phone" required="required" maxlength="14" id="phone" class="form-control" value="{{ $user->phone }}">
                                </div>
                                <div class="form-group email required">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="email" name="email" required="required" maxlength="255" id="email"
                                            class="form-control" value="{{ $user->email }}">
                                </div>
                                <div class="form-group text required">
                                    <label class="control-label" for="address-1">Address 1</label>
                                    <input type="text" name="address_1" required="required" maxlength="255"
                                                        id="address-1" class="form-control" value="{{ $user->address_1 }}">
                                </div>
                                <div class="form-group text">
                                    <label class="control-label" for="address-2">Address 2</label>
                                    <input type="text" name="address_2" maxlength="255" id="address-2" class="form-control" value="{{ $user->address_2 }}">
                                </div>
                                <div class="form-group text required">
                                    <label class="control-label" for="city">City</label>
                                    <input type="text" name="city" required="required" maxlength="75" id="city" class="form-control" value="{{ $user->city }}">
                                </div>
                                <div class="form-group text required">
                                    <label class="control-label" for="state">State</label>
                                    <input type="text" name="state" required="required" maxlength="30" id="state" class="form-control" value="{{ $user->state }}">
                                </div>
                                <div class="form-group text required">
                                    <label class="control-label" for="zip">Zip</label>
                                    <input type="text" name="zip" required="required" maxlength="20" id="zip" class="form-control" value="{{ $user->zip }}">
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-primary">Save User Details</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


