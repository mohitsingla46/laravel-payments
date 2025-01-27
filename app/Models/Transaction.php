<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'stripe_transaction_id',
        'currency',
        'amount',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
