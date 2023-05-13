<?php

namespace System\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use System\Models\Traits\HasUser;
use System\Traits\HasDatetimeFormatter;

class Log extends Model
{
    protected $table = 'system_logs';

    protected $fillable = ['uri', 'user_id', 'user_agent', 'username', 'geoip', 'request', 'response', 'method'];

    use HasUser, HasDatetimeFormatter;

    protected $casts
        = [
            'request'  => 'array',
            'response' => 'array'
        ];

    /**
     * Prune all of the entries older than the given date.
     *
     * @param \DateTimeInterface $before
     * @return int
     */
    public function prune(DateTimeInterface $before)
    {
        $query = static::query()
            ->whereNotNull('created_at')
            ->where('created_at', '<', $before);

        $totalDeleted = 0;

        do {
            $deleted = $query->take(1000)->delete();

            $totalDeleted += $deleted;
        } while ($deleted !== 0);

        return $totalDeleted;
    }
}
