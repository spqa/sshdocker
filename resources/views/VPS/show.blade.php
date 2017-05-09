@extends('layouts.master1')
@section('content')
    <div class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <pre>{{$vps->progress}}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection