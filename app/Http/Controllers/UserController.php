<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserController extends Controller
{
    public function create(Request $request)
    {
//        dd($request->user['first_name']);
//        $user = new User();
//        $user->first_name = $request->user['first_name'];
//        $user->last_name = $request->user['last_name'];
//        $user->email = $request->user['email'];
//        $user->gender = $request->user['gender'];
//        $user->password = $request->user['password'];
//        $user->save();

//        $user = new User($request->user['first_name'],$request->user['last_name'],$request->user['email'],$request->user['gender'],$request->user['password']);
//        dd($request->all());

//        User::create($request->user);
//        User::create([
//            'first_name' => $request->user['first_name'],
//            'last_name' => $request->user['last_name'],
//            'email' => $request->user['email'],
//            'gender' => $request->user['gender'],
//            'password' => $request->user['password'],
//        ]);



        try {
            $inputs = $request->user;
            $inputs['password'] = bcrypt($request->user['password']);
            $obj = new User();
            $obj->fill($inputs);
            $obj->save();
            return response()->json(['message' => 'succes', 'status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 0], 500);
        }
    }

    public function showAll()
    {
        return response()->json([
            'message' => 'success',
            'status' => 1,
            'items' => User::all()
            ]);
    }

    public function find($id)
    {
        return response()->json([
            'message' => 'success',
            'status' => 1,
            'items' => User::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $updates = $request->user;
            if (array_key_exists('password', $updates)) {
                $updates['password'] = bcrypt($updates['password']);
            }
            $user->fill($updates);
            $user->update();
            return response()->json(['message' => 'succes', 'status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 0], 500);
        }
    }

    public function delete($id)
    {
        User::destroy($id);
        return response()->json([
            'message' => 'success',
            'status' => '1'
        ]);
    }
}
