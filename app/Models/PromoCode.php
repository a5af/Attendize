<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends MyBaseModel
{
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount',
        'max_redemption',
        'start_date',
        'end_date',
    ];

    /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'code'          => ['required'],
        'discount'        => ['required', 'numeric', 'min:0'],
        'start_date'    => ['date'],
        'end_date'      => ['date', 'after:start_date'],
        'max_redemption' => ['integer', 'min:0'],
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public $messages = [
        'discount.numeric'         => 'The price must be a valid number (e.g 12.50)',
        'max_redemption.integer' => 'Please ensure the max_redemption is a number.',
    ];

    /**
     * The event associated with promo-code.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo(\App\Models\Event::class);
    }

    /**
     * The orders associated with promo-code.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(\App\Models\Order::class);
    }

}