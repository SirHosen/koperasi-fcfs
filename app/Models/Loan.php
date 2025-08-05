<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'loan_number',
        'amount',
        'duration_months',
        'interest_rate',
        'monthly_payment',
        'total_payment',
        'remaining_payment',
        'purpose',
        'status',
        'request_date',
        'approval_date',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'request_date' => 'date',
        'approval_date' => 'date',
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'remaining_payment' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
