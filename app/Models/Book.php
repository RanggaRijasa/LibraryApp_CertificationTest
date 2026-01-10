<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['isbn','title','author','year','stock'];

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }
}
