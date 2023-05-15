<?php

namespace Admin\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Admin\Models\Contact;
use Admin\Models\Task;

class ContactExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function query()
    {
        return Contact::query()
            ->where('task_id', $this->task->id);
    }

    /**
     * @param Contact $row
     * @return array
     */
    public function map($row): array
    {
        return [
            sprintf('%s %s', $row->countryCode, $row->nationalNumber),
            $row->whatsapp_checked,
            $row->whatsapp_checked_at,
        ];
    }

    public function headings(): array
    {
        return [
            'National Number',
            'Whats APP Registered',
            'Checked At'
        ];
    }
}
