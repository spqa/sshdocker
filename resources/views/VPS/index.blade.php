@extends('layouts.master1')
@section('content')
    <div class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <a href="{{route('vps.create')}}" class="btn green white-text">Add</a>
                    <span class="chip">Number of VPS {{$vps->total()}}</span>
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
                        <span class="card-title">Danh sách VPS</span>
                        <table class="highlight">
                            <thead>
                            <tr>
                                <th>IP</th>
                                <th>Port</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vps as $item)
                                <tr>
                                    <td><a href="{{route('vps.show',['id'=>$item->id])}}">{{$item->ip}}</a>
                                    </td>
                                    <td>{{empty($item->port)?22:$item->port}}</td>
                                    <td> {{empty($item->username)?'root':$item->username}}</td>
                                    <td>
                                        <div class="input-field">
                                            <i class="material-icons prefix reveal-pass">remove_red_eyes</i>
                                            <input disabled value="{{$item->password}}" type="password" class=" validate">
                                        </div>
                                    </td>
                                    <td> @if($item->status=='ready')
                                             <div class="chip">
                                                 <img src="/green.png">
                                                 Ready
                                             </div>
                                             @else
                                             <div class="chip">
                                                 <img src="/red.jpg">
                                                 {{$item->status}}
                                             </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn" href="{{route('vps.reset',['id'=>$item->id])}}">Reset</a>
                                        <a class="btn" href="{{route('vps.delete',['id'=>$item->id])}}">Delete</a>
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
@section('page_script')
    <script>
        $('.reveal-pass').click(function () {
            console.log('hah');
            $(this).next("input").attr('type','text');
        });
    </script>
    @endsection