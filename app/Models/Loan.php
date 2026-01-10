<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'member_id',
        'staff_id',
        'loan_date',
        'due_date',
        'returned_at',
        'notes',
    ];

    protected $casts = [
        'loan_date'   => 'date',
        'due_date'    => 'date',
        'returned_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Loan $loan) {
            // Default loan_date = hari ini jika belum di-set
            if (empty($loan->loan_date)) {
                $loan->loan_date = now()->toDateString();
            }

            // Auto due_date = loan_date + 7 hari (kalau belum di-set)
            if (empty($loan->due_date)) {
                $loanDate = Carbon::parse($loan->loan_date);
                $loan->due_date = $loanDate->copy()->addDays(7)->toDateString();
            }
        });
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    // Helper: cek apakah terlambat (belum return dan due_date sudah lewat)
    public function isOverdue(): bool
    {
        return is_null($this->returned_at)
            && !is_null($this->due_date)
            && $this->due_date->isPast();
    }
}
