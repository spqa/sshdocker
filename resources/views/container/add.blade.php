@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <form method="post">
                {!! csrf_field() !!}
                <div class="input-field col s12">
                    <input placeholder="enter domain" id="first_name" name="domain" type="text" class="validate">
                    <label for="first_name">Domain</label>
                </div>
                <div class="input-field col s12">
                    <input placeholder="chưa hoạt động" name="" id="first_name" type="text" class="validate">
                    <label for="first_name">keyword</label>
                </div>
                <div class="col s12">
                    <button class="btn green" type="submit">ok</button>
                </div>
            </form>
        </div>
    </div>
    @endsection