<?php

namespace App\Exports;

use App\MediaItem as MediaItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MediaItemExport implements FromCollection, WithHeadings
{
    private $start;
    private $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function headings(): array
    {
        return [
            'ID',
            'File Name',
            'Title',
            'Description',
            'Date',
            'Location',
            'Copyright',
            'Authorization',

            'Credit',
            'Original Creator',

            'Submitted User\'s Name',
            'Submitted User\'s Email',
            'Submitted User\'s Phone',

            'Review Status',
            'Reviewed By',
            'Reviewed At',
            'Review Comment',
        ];
    }

    public function collection()
    {
        return MediaItem::with('media')
            ->approved()
            ->range($this->start, $this->end)
            ->get()
            ->map(function ($item) {
                return [
                    $item->id,
                    $item->getFirstMedia('media')->file_name,
                    $item->title,
                    $item->description,
                    $item->original_date,
                    $item->original_location,
                    $item->copyright,
                    $item->authorization,

                    $item->credit,
                    $item->original_creator,

                    $item->submitted_users_name,
                    $item->user_email,
                    $item->phone_number,

                    $item->status,
                    $item->reviewed_by,
                    $item->reviewed_at,
                    $item->comment,
                ];
            });
    }
}
