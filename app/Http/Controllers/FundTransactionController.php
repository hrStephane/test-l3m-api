<?php

namespace App\Http\Controllers;

use App\Models\FundTransaction;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $transaction = FundTransaction::with('user')->find($id);
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
