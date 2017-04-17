@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <a href="{{route('container.add')}}" class="btn green white-text">Add</a>
                <span class="chip">Number of containers {{count($containers)}}</span>
            </div>
        </div>
        @if(isset($message))
        <div class="col s12">
            <div class="card-panel green">
                <p>{{$message}}</p>
            </div>
        </div>
            @endif
    </div>
    <div class="row">
        <div class="col s12">
            <table >
                <thead>
                <tr>
                    <th>name</th>
                    <th>status</th>
                    <th>type</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($containers as $container)
                    <tr>
                        <td>{{$container->Names[0]}}</td>
                        <td>{{$container->Status}}
                        <span class="chip ">{{$container->State}}</span>
                        </td>
                        <td>{{$container->Image}}</td>
                        <td> <a href="{{route('container.delete',['id'=>$container->Id])}}" class="btn red">destroy</a>
                            @if($container->State!='running')
                        <a class="btn teal" href="{{route('container.start',['id'=>$container->Id])}}">start server</a>
                                @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    @endsection