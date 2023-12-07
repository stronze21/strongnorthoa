<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAgreementGift extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    protected $fillable = [
        'order_agreement_id',
        'product_id',
        'item_price',
        'item_qty',
        'item_total',
        'type',
        'status',
        'remarks',
        'released',
        'returned',
        'tblset_id',
    ];

    public function detail()
    {
        return $this->belongsTo(OrderAgreement::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
