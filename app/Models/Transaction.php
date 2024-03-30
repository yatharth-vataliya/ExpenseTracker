<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'transaction_type_id',
        'description',
        'item_unit',
        'item_count',
        'item_price',
        'total',
        'transaction_date',
    ];

    // protected function transactionDate(): Attribute
    // {
    //     return Attribute::make(
    //         get: function (mixed $date) {
    //             return Carbon::createFromDate($date)->timezoneIndian();
    //         },
    //         set: function (mixed $date) {
    //             return Carbon::createFromDate($date);
    //         }
    //     );
    // }
}
