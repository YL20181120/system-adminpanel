<?php

namespace System\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use System\Models\User;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
