<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $logedUser = $request->user();

        $perPage = $request->limit ?? 10;
        return User::paginate($perPage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        // dd($request->all());

        try {
            DB::beginTransaction();

            $password = !empty($request->password) ? Hash::make($request->password) : Hash::make('password');
            $email_verified_at = now();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => $email_verified_at,
                'password' => $password,
            ]);

            DB::commit();

            return response()->json([
                'user' => $user,
                'message' => 'User created successfully',
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'message' => 'Error: ' . $th->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $user = User::with(['fundTransactions'])->find($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ], 404);
        }

        $limit = $request->limit ?? 10;
        $transactions = $user->fundTransactions()->paginate($limit);

        return response()->json([
            'user' => $user,
            'transactions' => $transactions,
            'message' => 'User found',
        ], 200);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'user' => $user,
            'message' => 'User retrieved',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        try {
            $user->update($request->all());
            return response()->json($user, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Error: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
