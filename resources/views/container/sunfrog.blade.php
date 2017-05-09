@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            @if(!empty(session('message')))
            <div class="col s12">
                <div class="card-panel blue lighten-1 white-text">
                    <span>{{session('message')}}</span>
                </div>
            </div>
            @endif
            <div class="col s12">
                <form method="post" >
                    {{csrf_field()}}
                    <div class="input-field">
                        <label>Sunfrog ID</label>
                        <input value="{{$result}}" name="sunfrog" type="text" required>
                    </div>
                    <div class="input-field">
                        <button class="btn teal" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection