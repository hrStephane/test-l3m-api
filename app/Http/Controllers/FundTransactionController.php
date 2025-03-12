<?php

namespace App\Http\Controllers;

use App\Models\FundTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        if ($request->has('user_id')) {
            return FundTransaction::with('user')
                                   ->where('user_id', $request->user_id)
                                   ->paginate($limit);
        }

        return FundTransaction::with('user')->paginate($limit);
    }

    public function getAuthedUserTransactions(Request $request)
    {
        $user = $request->user();
        $limit = $request->limit ?? 10;

        if (!$user) {
            return response()->json([
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        return $user->fundTransactions()->paginate($limit);

    }

    public function getTransactionsByUser($id, Request $request)
    {
        $limit = $request->limit ?? 10;
        return FundTransaction::with('user')
                                ->where('user_id', $id)
                                ->paginate($limit);
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
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,failed',
            'description' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $fundTransaction = FundTransaction::create([
                'user_id' => $request->user_id,
                'reference' => \Illuminate\Support\Str::uuid(),
                'type' => $request->type,
                'amount' => $request->amount,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            // dd($fundTransaction);

            DB::commit();

            return response()->json([
                'data' => $fundTransaction,
                'message' => 'Transaction created successfully',
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),

            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $transaction = FundTransaction::with('user')->find($id);

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found',
            ], 404);
        }

        return response()->json([
            'data' => $transaction,
            'message' => 'Transaction retrieved successfully',

        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundTransaction $FundTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FundTransaction $FundTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundTransaction $FundTransaction)
    {
        //
    }
}
