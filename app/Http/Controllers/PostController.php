<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Classes\ApiResponseClass;
use App\Http\Resources\PostResources;
use App\Http\Resources\UserResources;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Http\Request;
use AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{     
    private  PostRepositoryInterface $postrepo;
    public function __construct(PostRepositoryInterface $postrepo){
       $this->postrepo=$postrepo;
    }
   
    public function index()
    {
        
        try{
        $posts= $this->postrepo->index();
        
      //  return response()->json( $posts, 201);
        return ApiResponseClass::sendResponse( PostResources::collection($posts),'',200);
    }   catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {try{
        

        Gate::authorize('create-delete-posts');
        $details=[
      'title'=>$request->title,
         'details'=>$request->details,
         'user_id'=>$request->user_id
        ];   

        $post=$this->postrepo->store($details);
      // return response()->json( $post, 201);
      return ApiResponseClass::sendResponse(new PostResources($post),'User Added Successful',201);
    }
     catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }
    
    public function show(Request $request)
    {try{
        $posts= $this->postrepo->getbyid($request->header('id'));
        
      //  return response()->json( $posts, 201);
        return ApiResponseClass::sendResponse( new PostResources($posts),'',201);
    }   catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $details=[
            'title'=>$request->title,
               'details'=>$request->details,
               'user_id'=>$request->user_id
              ];   

        try{
            $post=$this->postrepo->update($details,$request->header('id'));
     return ApiResponseClass::sendResponse(new PostResources($post),'Post Updated',201);
        }
        catch(\Exception $ex){
            return response()->json(['error' => $ex->getMessage()], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->postrepo->delete($request->header('id'));

        return ApiResponseClass::sendResponse('Post','Post Delete Successful',201);
    }
}
