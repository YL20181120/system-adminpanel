<?php

namespace System\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use System\Models\File;

trait HasAttachment
{
    public static function bootHasAttachment()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }
            $model->attachments()->detach();
        });
    }


    public function attachments(): MorphToMany
    {
        return $this->morphToMany(
            File::class,
            'model',
            'model_has_attachment',
            'model_id',
            'attachment_id'
        );
    }
}
