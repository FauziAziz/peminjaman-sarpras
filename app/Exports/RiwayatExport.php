<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatExport implements FromCollection, WithHeadings, WithMapping
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Tanggal Pinjam',
            'Peminjam',
            'Jabatan',
            'Barang',
            'Jumlah',
            'Status',
            'Tanggal Kembali',
            'Petugas Pencatat',
        ];
    }

    public function map($row): array
    {
        return [
            $row->tanggal_pinjam,
            $row->nama_peminjam,
            $row->jabatan,
            $row->nama_barang,
            $row->jumlah,
            ucfirst($row->status_peminjaman),
            $row->tanggal_kembali ?? '-',
            $row->nama_petugas,
        ];
    }
}
