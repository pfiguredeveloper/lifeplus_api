<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCommPdfData implements FromArray,WithHeadings
{

    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function headings(): array
    {
        return [
            'name',
            'pono',
            'plan',
            'prem_due',
            'risk_date',
            'cbo',
            'adj_date',
            'prem',
            'comm',
            'comm_id',
        ];
    }

    public function array(): array
    {
        return $this->invoices;
    }
}
