@extends('layouts.master1')
@section('content')
    <div class="container">
        @if(!empty(session('message')))
            <div class="row">
                <div class="col s12 white-text">
                    <div class="card-panel red lighten-2">
                        <span>{{session('message')}}</span>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">New VPS Form</span>

                        <div class="row">
                            <form class="col s12" method="post" action="{{route('vps.store')}}">
                                {!! csrf_field() !!}
                                <div class="input-field col s6">
                                    <input id="first_name" name="ip" type="text" class="validate">
                                    <label f    or="first_name">IP</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="first_name" name="port" type="number" class="validate">
                                    <label for="first_name">Port</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="first_name" name="username" type="text" class="validate">
                                    <label for="first_name">Username</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="first_name" name="password" type="password" class="validate">
                                    <label for="first_name">Password</label>
                                </div>

                                <div class="col s12">
                                    <button id="btn-submit" class="btn green" type="submit">ok</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('page_script')

@endsection