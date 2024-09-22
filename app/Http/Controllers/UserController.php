<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Resources\UserResources;
use App\Interfaces\Interfaces\PostRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

      private UserRepositoryInterface $userrepo;

     // private PostRepositoryInterface $postrepo;
    public function __construct(UserRepositoryInterface $userrepo){
     $this->userrepo=$userrepo;
     
    }

   public function index(){
   
   $data=$this->userrepo->index();
  // return response()->json( $data, 201);

   return ApiResponseClass::sendResponse(UserResources::collection($data),'',200);
}
public function store(Request $request){
    $details=[
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password
    ]; 
    //return response()->json( $request, 201);
    
    try{
         DB::beginTransaction();

         $user = $this->userrepo->store($details);
         DB::commit();
       

         return ApiResponseClass::sendResponse(new UserResources($user),'User Create Successful',201);

    }catch(\Exception $ex){
        return ApiResponseClass::rollback($ex->getMessage());
    }

    // $user = User::create($request->all());
    // return response()->json( $user, 201);
}
public function show(Request $request){
     //$user=$this->userrepo->getbyid($id);
    $user=$this->userrepo->getbyid($request->header('id'));
    return response()->json( $user, 201);
   //  return ApiResponseClass::sendResponse(new UserResources($user),'',200);
}

public function update(Request $request){
    $details=[
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password
    ];
    
    
    try{

  $user = $this->userrepo->update($details,$request->header('id'));
    // return response()->json( $user, 201);
        return ApiResponseClass::sendResponse(new UserResources($user),'User Updated Successful',201);

   }catch(\Exception $ex){
       return ApiResponseClass::rollback($ex->getMessage());
   }


}
public function destroy(Request $request)
    {
         $this->userrepo->delete($request->header('id'));

        return ApiResponseClass::sendResponse('Product Delete Successful','',204);
    }

}
