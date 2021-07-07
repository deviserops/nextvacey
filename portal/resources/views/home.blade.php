@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                        <hr>
                        {{ __('You cannot use Auth::user() / auth()->user(), because this use database connectivity.') }}
                        <br>
                        {{ __('To use the auth user data, you can access from - $authUser - variable!') }}
                        <hr>
                        <pre>
                        {{print_r($profile)}}
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
