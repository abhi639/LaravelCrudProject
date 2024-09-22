<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface
{
    public function index(){
        return User::all();
    }
    public function getbyid($id){
       try{ 
        return User::with('posts')->findOrFail($id);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }
    public function store(array $data){
      try{ 
       $user=User::create($data);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
      return $success;
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }

    }
    public function update(array $data,$id){
        try {
            $user = User::findOrFail($id);
            $user->update($data);
            return $user;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
        
   
     //return User::where('user_id',$id)->update($data);
    }
    public function delete($id){
    return User::where('user_id',$id)->delete();
    }
     
   
}
