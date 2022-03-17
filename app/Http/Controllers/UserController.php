<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserController extends Controller
{


//    public function create (Request $request)
//    {
//        $newUser = new User();
//        $newUser->fill([
//            'first_name' => $request->first_name,
//            'last_name' => $request->last_name,
//            'email' => $request->email,
//            'gender' => $request->gender,
//            'username' => $request->username,
//            'password' => bcrypt($request->password)
//        ]);
//        try {
//            $newUser->save();
//            return response()->json(['status'=>1, 'value'=>'created']);
//        } catch (Exception $e) {
//            echo $e->getMessage();
//        }
//
//
//        dd($request->all());
//    }
//
//    public function showAll (Request $request)
//    {
//        return response()->json(User::all());
//    }
//
//    public function show ($id)
//    {
//        return response()->json(User::find($id));
//    }
//
//    public function update (Request $request, $id)
//    {
//        $user = User::find($id);
//        $user->update(['email'=>$request->email]);
//    }
//
//    public function delete ($id)
//    {
//        User::find($id)->delete();
//    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        if (User::all()->isEmpty()) {
            return response()->json([
                'message' => 'No data to be shown.']);
        }
        return response()->json([
            'data' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $request['password'] = bcrypt($request['password']);
        User::create($request->all());
        return response()->json([
            'New user added successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $data = User::findOrFail($id);
            return \response()->json($data);
        } catch (\Exception $e) {
            return response()->json("Invalid id, " . $e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {

        try {
            $user = User::findOrFail($id);
            if ($request['password']) {
                $request['password'] = bcrypt($request['password']);
            }
            $user->update($request->all());
            return response()->json('Changes made successfully.');
        } catch (\Exception $e) {
            return response()->json('Invalid id, ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            return response()->json("Deleted id $id.");
        } catch (\Exception $e) {
            return response()->json("Invalid id, " . $e->getMessage());
        }
    }
}
