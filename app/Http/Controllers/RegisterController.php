<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Http\Controllers\BaseController as BaseController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Validators;
use Validator;

class RegisterController extends BaseController
{


       private UserRepositoryInterface $userrepo;

       public function __construct(UserRepositoryInterface $userrepo){
         $this->userrepo=$userrepo;
       }
       /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $details=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role_id'=>$request->role_id,
        ];
   
        $input = $this->userrepo->store($details);
   
      ///  $user = User::create($input);
     
   
        return $this->sendResponse($input, 'User register successfully.');
    }
   
    public function login(Request $request)
    {try{
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createtoken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
          
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }


    public function logout(Request $request)
    {
        try {
            // Get the currently authenticated user
            $user = auth()->user();
    
            if ($user) {
                // Delete the user's current access token
                $user->currentAccessToken()->delete();
    
                return response()->json(['message' => 'Successfully logged out.'], 200);
            }
    
            return response()->json(['error' => 'User not authenticated.'.$user], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
   
}
