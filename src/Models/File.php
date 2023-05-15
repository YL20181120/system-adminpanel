<?php

namespace Admin\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Admin\Models\Traits\HasUser;
use Admin\Traits\HasDatetimeFormatter;

class File extends Model
{
    use HasDatetimeFormatter;

    protected $table = 'system_files';

    protected $guarded = ['id'];

    use HasUser;

    protected $attributes
        = [
            'status' => 1
        ];


    protected static function boot()
    {
        parent::boot();

        static::deleted(function (File $file) {
            try {
                if (Storage::disk('public')->exists($file->xkey)) {
                    Storage::disk('public')->delete($file->xkey);
                }
            } catch (Exception $exception) {
                Log::error('删除文件失败:' . $exception->getMessage());
            }
        });
    }
}
