<?php

namespace Admin\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Admin\Models\Contact;
use Admin\Models\Task;

class ContactImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function model(array $row)
    {
        if (!phone("{$row['countrycode']} {$row['nationalnumber']}")->isValid()) {
            return null;
        }
        return new Contact([
            'task_id'        => $this->task->id,
            'user_id'        => $this->task->user_id,
            'countryCode'    => $row['countrycode'],
            'nationalNumber' => preg_replace("/\s|　/", "", $row['nationalnumber']),
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }
}
