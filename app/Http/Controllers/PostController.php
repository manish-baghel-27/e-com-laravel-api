<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    protected function store_post(Request $request){
        // if($request->has('post_image')){
        //     $image=$request->file('post_image');
        //     $name = time().'.'.$image->getClientOriginalExtension();
        //     $image->move('images/',$name);
        //     return"success";
        // }
        // else{
        //     return"not";
        // }
        // return"default";


        $user_id = Auth::user()->id;
        
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:255',
            'sub_title'=>'required',
            'post_body'=>'required',
            'slug'=>'required',
            'is_published'=>'required|boolean',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->messages(),
            ]);
        }
        else{
            $post = new Post;
            $post->user_id= $user_id;
            $post->slug = $request->slug;
            $post->meta_title = $request-> meta_title;
            $post->meta_keyword= $request-> meta_keyword;
            $post->meta_description= $request->meta_description;
            $post->title= $request->title;
            $post->sub_title= $request->sub_title;
            $post->body= $request->post_body;
            $post->priority= $request->priority;
            $post->is_published= $request->is_published;
            $post->is_active= $request->is_active == true? '1':'0';
            $post->created_by= Auth::user()->id;
            $post->updated_by= Auth::user()->id;

            $post->save();
            $post->categories()->attach($request->category_id);

            return response()->json([
                'status'=>200,
                'post'=>$post->fresh('categories'),
                'message'=>'Post created successfully.'
            ]);
        }
    }

    public function get_posts(){
        $posts = Post::with('categories')->get();

        if($posts){
            return response()->json([
                'status'=>200,
                'posts'=>$posts,
                'message'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'error'
            ]);
        }
    }

    protected function getSinglePost($id){
        $post = Post::find($id);

        if($post){
            return response()->json([
                'status'=>200,
                'post'=>$post->fresh('categories'),
                'message'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'post not found!'
            ]);
        }
    }
}
