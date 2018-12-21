<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends MyBaseModel
{
        /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'type'    => ['required'],
        'date'    => ['required', 'date'],
        'option' => ['required']
    ];


    /**
     * The event associated with breakout seesion.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo(\App\Models\Event::class);
    }

    /**
     * The user associated with breakout seesion.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
}
