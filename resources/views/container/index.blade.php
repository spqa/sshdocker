@extends('layouts.master1')
@section('content')
    <div class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <a href="{{route('container.add')}}" class="btn green white-text">Add</a>
                    <span class="chip">Number of Website {{$servers->total()}}</span>
                </div>
            </div>
            @if(!empty(session('message')))
                <div class="col s12">
                    <div class="card-panel blue white-text">
                        <span>{{session('message')}}</span>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table class="highlight">
                            <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Keyword</th>
                                <th>IP</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($servers as $server)
                                <tr>
                                    <td>{{$server->name}}</td>
                                    <td>{{$server->keyword}}</td>
                                    <td>{{$server->vps->ip}}</td>
                                    <td></td>
                                    <td>
                                        <a class="btn red">delete</a>
                                        <a class="btn teal">set sunfrog id</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection