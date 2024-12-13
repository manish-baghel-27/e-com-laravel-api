<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\About;
use App\Http\Traits\ImageUpload;
use Event;
use App\Events\UserRegistred;

class HomeController extends Controller
{
    use ImageUpload;

    public function index(){
        // Event::dispatch(new UserRegistred(1));
        event(new UserRegistred(1));


        $this->k ="modified";
        $this->show_message();

        return "success";
    }

    protected function get_about_us_data(){
        $about_data = About::where('is_active',1)->first();

        if($about_data){
            return response()->json([
                'status'=>200,
                'about_data'=>$about_data,
                'message'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'record not found'
            ]);
        }
    }

    protected function update_about_us(Request $request){
        $id = $request->id;
        $user_id = Auth::user()->id;
        // 
        $validator = Validator::make($request->all(),[
            'slug'=>'required|max:191',
            'title'=>'required|max:191',
            'description'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            DB::table('about_us')
            ->updateOrInsert(
                ['id' => $id],
                ['slug' => $request->slug,
                'title'=>$request->title,
                'description'=>$request->description,
                'created_by'=>$user_id,
                'updated_by'=>$user_id]
            );
            $about_record = DB::table('about_us')->first();
            return response()->json([
                'status'=>200,
                'about_record'=>$about_record,
                'message'=>'Record updated successfully.'
            ]);
        }
    }
}
