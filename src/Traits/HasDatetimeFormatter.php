<?php

namespace Admin\Traits;

trait HasDatetimeFormatter
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->getDateFormat());
    }
}
