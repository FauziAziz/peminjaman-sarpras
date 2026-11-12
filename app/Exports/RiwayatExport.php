<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatExport implements FromArray, WithHeadings, WithMapping
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID Peminjaman',
            'Tanggal Pinjam',
            'Peminjam',
            'Jabatan',
            'Nama Barang',
            'Jumlah',
            'Status',
            'Tanggal Kembali',
            'Petugas'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id_peminjaman,
            $row->tanggal_pinjam,
            $row->nama_peminjam,
            $row->jabatan,
            $row->nama_barang,
            $row->jumlah,
            $row->status_peminjaman,
            $row->tanggal_kembali,
            $row->nama_petugas,
        ];
    }
}
