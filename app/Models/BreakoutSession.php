<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BreakoutSession extends MyBaseModel
{
        /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'title'         => ['required'],
        'description'   => ['required'],
        'start_date'    => ['required', 'date'],
        'end_date'      => ['required', 'date', 'after:start_date'],
        'capacity'      => ['integer', 'min:0'],
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public $messages = [
        'capacity.integer' => 'Please ensure the max_redemption is a number.',
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

    /**
     * The attendees associated with the breakout session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attendees()
    {
        return $this->belongsToMany(\App\Models\Attendee::class);
    }
}
