<?php

namespace App\Http\Controllers\Api;

use App\Models\Administrators;
use App\Models\Repair;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function question(Request $request){

        $data = $request->all();
        //$data = $request->validated();
        //dd($data);
        //$user_id = Auth::id();
        if(isset($data['question'])){
            $data['question'] = e($data['question']);
        }
        if(isset($data['satisfaction'])){
            $data['satisfaction'] = e($data['satisfaction']);
        }
        if(isset($data['administrator'])){
            $data['administrator'] = e($data['administrator']);
        }
        $administrator_id  = Administrators::where('name',$data['administrator'])->first()->id;

        Repair::create([
            'user_id' => 1,
            'question' => $data['question'],
            'administrator_id' => $administrator_id,
            'satisfaction' => $data['satisfaction']
        ]);
        return redirect()->route();
    }

    //public function answer(Repair $repair,Request $request){
     public function answer($id,Request $request){
        $repair = Repair::find($id);
        $answer = e($request->get('answer'));
        $repair->update([
            'answer' => $answer
        ]);
        $administrator = Administrators::where('id',$repair->administrator_id)->first();
        $satisfaction = $repair->satisfaction;

        $administrator->count++;
        if($satisfaction==3){
            $administrator->praise++;
        }
        if($satisfaction==2){
            $administrator->general++;
        }
        if($satisfaction==1){
            $administrator->bad++;
        }
        $administrator->save();

    die;
        return redirect()->route();
    }
}
