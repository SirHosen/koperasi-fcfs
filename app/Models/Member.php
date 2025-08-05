<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_number',
        'nik',
        'birth_date',
        'gender',
        'occupation',
        'monthly_income',
        'join_date',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'monthly_income' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function getCurrentBalance()
    {
        $lastSaving = $this->savings()->latest('transaction_date')->first();
        return $lastSaving ? $lastSaving->balance : 0;
    }
}
