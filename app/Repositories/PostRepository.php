<?php

namespace App\Repositories;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function index(){
      return Post::all();

    }
    public function getbyid($id){
        return Post::find($id);

    }
    public function store(array $data){
     try{   return Post::create($data);

     
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }
    public function update(array $data,$id){
        try {
            $post = Post::findOrFail($id);

           $post->update($data);
            return $post;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
  
        }
       
    }

    public function delete($id){
        return Post::where('postID',$id)->delete();
    }
}
