<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\FundTransactionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'reference',
        'type',
        'amount',
        'status',
        'description',
    ];

    /**
     * Get the user that owns the FundTransactions
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
