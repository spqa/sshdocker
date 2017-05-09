<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteVPSJob;
use App\Jobs\ResetVPSJob;
use App\Jobs\SetupVPSJob;
use App\Vps;
use Illuminate\Http\Request;

class VpsController extends Controller
{
    public function index(){
        $vps=Vps::orderBy('created_at','desc')->paginate(10);
        return view('VPS.index',compact('vps'));
    }

    public function store(Request $request){
        if (Vps::whereIp($request->ip)->first()){
            $vps=Vps::whereIp($request->ip)->first();
        }else{
            $vps=Vps::create($request->all());
        }
        dispatch(new SetupVPSJob($vps));
        $vps->status='progress...';
        $vps->save();
        return redirect()->route('vps.index')->with(['message'=>'Server added !']);
    }

    public function create(){
        return view('VPS.create');
    }

    public function reset_server($id){
        $vps=Vps::findOrFail($id);
        $vps->progress='Resetting...';
        $vps->save();
        dispatch(new ResetVPSJob($vps));
        return redirect()->route('vps.index');
    }

    public function delete_server($id){
        $vps=Vps::findOrFail($id);
        $vps->progress='Deleting...';
        $vps->save();
        dispatch(new DeleteVPSJob($vps));
        return redirect()->route('vps.index');
    }

    public function show($id){
         $vps=Vps::findOrFail($id);
         return view('VPS.show',compact('vps'));
    }
}
