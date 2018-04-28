@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Create New Family Member
                    </div>
                    <div class="card-body">
                        <p>Complete all the fields below to create a new family member account. You can then assign them a badge.</p>
                        <form method="post" accept-charset="utf-8" role="form" action="/family">
                            @csrf
                            <fieldset>
                                <div class="form-group text required">
                                    <label class="control-label" for="first-name">First Name</label>
                                    <input type="text" name="first_name" required="required" maxlength="255" id="first-name" class="form-control">
                                </div>
                                <div class="form-group text required">
                                    <label class="control-label" for="last-name">Last Name</label>
                                    <input type="text" name="last_name" required="required" maxlength="255" id="last-name" class="form-control">
                                </div>
                                <div class="form-group tel required">
                                    <label class="control-label" for="phone">Phone</label>
                                    <input type="tel" name="phone" required="required" maxlength="14" id="phone" class="form-control">
                                </div>
                                <div class="form-group email required">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="email" name="email" required="required" maxlength="255" id="email" class="form-control">
                                </div>
                                <div class="form-group text required">
                                    <label class="control-label" for="username">Username</label>
                                    <input type="text" name="username" required="required" maxlength="255" id="username" class="form-control">
                                    <div class="help-block">Must be all lowercase. Automatically converted to all
                                        lowercase if capitals are used. This username is for access to Maker Manager,
                                        the wiki, virtual machines and more.
                                    </div>
                                </div>
                                <div class="form-group password required">
                                    <label class="control-label" for="password">Password</label>
                                    <input type="password" name="password" required="required" minlength="6" id="password" class="form-control">
                                    <div class="help-block">A minimum of 6 characters are required.</div>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-default">Create Family Member</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop