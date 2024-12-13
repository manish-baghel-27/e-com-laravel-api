<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Tag;

class TagController extends Controller
{
    protected function store_tag(Request $request){
        $user_id = Auth::user()->id;
        
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->messages(),
            ]);
        }
        else{
            $tag = new Tag;
            $tag->user_id= $user_id;
            $tag->name = $request->name;
            $tag->is_active= $request->is_active == true? '1':'0';
            $tag->created_by= $user_id;
            $tag->updated_by= $user_id;
            $tag->save();
            
            // $post->categories()->attach($request->category_id);

            return response()->json([
                'status'=>200,
                'tag'=>$tag,
                'message'=>'Tag created successfully.'
            ]);
        }
    }

    protected function getTags(){
        $tags = Tag::all();

        if($tags){
            return response()->json([
                'status'=>200,
                'tags'=>$tags,
                'message'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'error'
            ]);
        }
    }
    
    protected function getSingleTags($id){
        $tag = Tag::find($id);

        if($tag){
            return response()->json([
                'status'=>200,
                'tag'=>$tag,
                'message'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'error'
            ]);
        }
    }
}
