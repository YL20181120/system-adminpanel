<?php

namespace Admin\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Admin\Models\User;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
