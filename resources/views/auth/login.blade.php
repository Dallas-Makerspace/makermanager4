@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="username"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                           class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                           name="username" value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{--<div class="form-group row">--}}
                            {{--<div class="col-md-6 offset-md-4">--}}
                            {{--<div class="checkbox">--}}
                            {{--<label>--}}
                            {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                    {{--{{ __('Forgot Your Password?') }}--}}
                                    {{--</a>--}}
                                </div>
                            </div>
                            <br>
                            <p><strong>Forgot your password? </strong> Primary account holders can <a
                                        href="https://accounts.dallasmakerspace.org/accounts/pwreset.php">change passwords in WHMCS</a>. Family members must have their primary account holder or an admin reset their password.</p>
                        </form>

                        <br>
                        <hr>
                        <br>

                        <h4>Maker Manager runs the Dallas Makerspace.</h4>
                        Features:
                        <ul>
                            <li>Allows us to directly link users to their billing account while allowing them to use their
                                usual login information.
                            </li>
                            <li>Request an RFID badge for yourself or your added family members.</li>
                            <li>For family member account holders, it provides a solution for creating Active Directory
                                accounts and self-servicing badges.
                            </li>
                            <li>For administrators, it provides a self documenting solution for adding badges to the access
                                control system along with an easy way to manage them.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
