<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id',
        'address',
        'payment_method',
        'total_price',
        'shipping_price',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }
}
