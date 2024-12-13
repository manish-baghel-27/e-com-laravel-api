<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected function store_category(Request $request){
        $validator = Validator::make($request->all(),[
            'meta_title'=>'required|max:191',
            'slug'=>'required|max:191',
            'category_name'=>'required|max:191',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->messages(),
            ]);
        }
        else{
            $category = new Category;
            $category->meta_title = $request->meta_title;
            $category->meta_keywords = $request-> meta_keywords;
            $category->meta_desription= $request-> meta_desription;
            $category->slug= $request->slug;
            $category->name= $request->category_name;
            $category->description= $request->description;
            $category->is_active= $request->status == true? '1':'0';
            $category->created_by= Auth::user()->id;
            $category->updated_by= Auth::user()->id;
            $category->save();
            return response()->json([
                'status'=>200,
                'category'=>$category,
                'message'=>'Category added successfully.'
            ]);
        }
    }

    protected function view_category(){
        $categories = Category::all();
        return response()->json([
            'status'=>200,
            'categories'=>$categories
        ]);
    }

    protected function edit_category($id){
        $category = Category::find($id);
        if($category){
            return response()->json([
                'status'=>200,
                'category'=>$category
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'category not found!'
            ]);
        }
    }

    protected function update_category(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'meta_title'=>'required|max:191',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $category = Category::find($id);
            if ($category) {
                $category->meta_title = $request->meta_title;
                $category->meta_keywords = $request-> meta_keywords;
                $category->meta_desription= $request-> meta_desription;
                $category->slug= $request->slug;
                $category->name= $request->name;
                $category->description= $request->description;
                $category->is_active= $request->is_active == true? '1':'0';
                $category->created_by= Auth::user()->id;
                $category->updated_by= Auth::user()->id;
                $category->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Category added successfully.'
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Category not found.'
                ]);
            }
        }
    }

    protected function delete_category($id){
        $category = Category::find($id);
        if($category){
            $category->delete();
            return response()->json([
                'status'=>200,
                'message'=>'category deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'category not found'
            ]);
        }
    }
}
