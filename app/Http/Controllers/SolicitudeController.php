<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\DB;
use App\Teacher;
class SolicitudeController extends Controller
{
    //

    public function teacher(){

        $success=false;
        $user=auth()->user();
        if(!$user->teacher){
            try{
                DB::beginTransaction();
                $user->role_id=Role::TEACHER;
                Teacher::create([
                    'user_id'=>$user->id
                ]);
                $success=true;

            } catch (\Exception $e){
                $success=$e->getMessage();
                DB::rollBack();
            }

            if($success===true){
                DB::commit();
                auth()->logout();
                auth()->loginUsingId($user->id);
                return back()->with('message',['success',__('Felicitaciones, eres profesor!')]);
            }
        }
        return back()->with('message',['danger',__('Algo ha fallado')]);
    }
}
