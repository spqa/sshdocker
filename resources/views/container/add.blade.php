@extends('layouts.master1')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <main class="middle-content" style="width: 100% !important;">
            @if(!empty(session('message')))
                <div class="row ">
                    <div class="col s12 white-text">
                        <div class="card-panel red lighten-2">
                            <span>{{session('message')}}</span>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row ">
                {{--<div class="col s12">--}}
                    {{--<div class="card white">--}}
                        {{--<div class="card-content">--}}
                            {{--<form method="post">--}}
                                {{--{!! csrf_field() !!}--}}
                                {{--<div class="input-field col s12">--}}
                                    {{--<input id="first_name" name="domain" type="text" class="validate">--}}
                                    {{--<label for="first_name">Domain</label>--}}
                                {{--</div>--}}
                                {{--<div class="input-field col s12">--}}

                                    {{--<select name="vps_id">--}}
                                        {{--@foreach($vps as $item)--}}
                                            {{--<option value="{{$item->id}}">{{$item->ip}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                    {{--<label>Choose VPS</label>--}}
                                {{--</div>--}}
                                {{--<div class="input-field col s12">--}}
                                    {{--<div class="chips chips-placeholder"></div>--}}
                                {{--</div>--}}
                                {{--<input id="keyword" type="hidden" name="keyword" value="">--}}

                                {{--<div class="col s12">--}}
                                    {{--<button id="btn-submit" class="btn green" type="submit">ok</button>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}

                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Input fields</span><br>
                            <div class="row">
                                <form class="col s12" method="post">
                                    {!! csrf_field() !!}
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input placeholder="domain" id="first_name" name="domain" type="text" class="validate">
                                            <label for="first_name" class="active">Domain</label>
                                        </div>
                                        <div class="input-field col s6">

                                        <select name="vps_id">
                                        @foreach($vps as $item)
                                        <option value="{{$item->id}}">{{$item->ip}}</option>
                                        @endforeach
                                        </select>
                                        <label>Choose VPS</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="last_name" name="keyword" type="text" class="validate">
                                            <label for="last_name">Keyword</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @endsection
        @section('page_script')
            <script>
                $(document).ready(function () {
                    $('select').material_select();
                });
                $keyword = $('.chips');

                $keyword.material_chip();
                $('.chips-placeholder').material_chip({
                    placeholder: 'Enter a keyword',
                    secondaryPlaceholder: '+keyword',
                });

                $keyword.on('chip.delete', function (e, chip) {
                    $('#keyword').val('');
                    $.each($keyword.material_chip('data'), function (index, value) {
                        $('#keyword').val($('#keyword').val() + value.tag + ',');
                    });
                    console.log();
                }).on('chip.add', function (e, chip) {
                    console.log($keyword.material_chip('data'));
                    $('#keyword').val('');
                    $.each($keyword.material_chip('data'), function (index, value) {
                        $('#keyword').val($('#keyword').val() + value.tag + ',');
                    });

                });
            </script>
@endsection