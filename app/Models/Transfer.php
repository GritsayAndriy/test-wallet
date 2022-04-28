<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = ['from_id', 'to_id', 'amount'];

    public function scopeByWalletId($query, $walletId)
    {
        return $query->where('from_id', $walletId)
            ->orWhere('to_id', $walletId)
            ->with(['from.user', 'to.user']);
    }

    public function from()
    {
        return $this->belongsTo(Wallet::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(Wallet::class, 'to_id');
    }
}
