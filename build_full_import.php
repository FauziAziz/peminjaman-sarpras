<?php
require 'vendor/autoload.php';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load('docs/import data/Kategori Barang.xlsx');

// Sheet 0: Ruangan & Kategori
$sheet0 = $spreadsheet->getSheet(0);
$rows0 = $sheet0->toArray();

$ruangan = [];
foreach ($rows0 as $idx => $row) {
    if ($idx > 5 && $idx < 65) {
        $c1 = isset($row[1]) ? trim((string)$row[1]) : '';
        $c2 = isset($row[2]) ? trim((string)$row[2]) : '';
        if (is_numeric($c1) && !empty($c2)) {
            $ruangan[] = $c2;
        }
    }
}

// Sheet 1: Data Inventaris
$sheet1 = $spreadsheet->getSheet(1);
$rows1 = $sheet1->toArray();

$inventaris = [];
foreach ($rows1 as $idx => $row) {
    if ($idx > 6) {
        $nama = isset($row[1]) ? trim((string)$row[1]) : '';
        $merek = isset($row[2]) ? trim((string)$row[2]) : '';
        $jumlahStr = isset($row[3]) ? trim((string)$row[3]) : '0';
        $kondisiRaw = isset($row[7]) ? strtolower(trim((string)$row[7])) : 'baik';
        $lokasi = isset($row[8]) ? trim((string)$row[8]) : '';
        $keterangan = isset($row[11]) ? trim((string)$row[11]) : '';

        if (!empty($nama)) {
            $jumlah = is_numeric($jumlahStr) ? intval($jumlahStr) : 1;
            $kondisi = 'baik';
            if (str_contains($kondisiRaw, 'rr') || str_contains($kondisiRaw, 'ringan')) {
                $kondisi = 'rusak ringan';
            } elseif (str_contains($kondisiRaw, 'rb') || str_contains($kondisiRaw, 'berat')) {
                $kondisi = 'rusak berat';
            }

            $fullName = $nama . ($merek !== '' ? ' - ' . $merek : '');

            $inventaris[] = [
                'nama' => $fullName,
                'jumlah' => $jumlah,
                'kondisi' => $kondisi,
                'lokasi' => $lokasi,
                'keterangan' => $keterangan,
            ];
        }
    }
}

$sql = "USE peminjaman_sarpras;\n\n";

// Kategori
$sql .= "-- Kategori\n";
$sql .= "INSERT IGNORE INTO kategori (id_kategori, nama_kategori, kode_kategori) VALUES (1, 'Elektronik', 'ELK');\n";
$sql .= "INSERT IGNORE INTO kategori (id_kategori, nama_kategori, kode_kategori) VALUES (2, 'Perabotan', 'PRB');\n";
$sql .= "INSERT IGNORE INTO kategori (id_kategori, nama_kategori, kode_kategori) VALUES (3, 'Alat Praktik/Lab', 'LAB');\n";
$sql .= "INSERT IGNORE INTO kategori (id_kategori, nama_kategori, kode_kategori) VALUES (4, 'Olahraga', 'OLG');\n\n";

// Ruang
$sql .= "-- Ruang\n";
$ruanganUnik = array_values(array_unique($ruangan));
foreach ($ruanganUnik as $idx => $rg) {
    $kode = "RNG-" . str_pad($idx + 1, 3, '0', STR_PAD_LEFT);
    $rgEsc = str_replace("'", "''", $rg);
    $sql .= "INSERT IGNORE INTO ruang (nama_ruang, kode_ruang) VALUES ('$rgEsc', '$kode');\n";
}
$sql .= "\n";

// Inventaris
$sql .= "-- Inventaris\n";
foreach ($inventaris as $idx => $inv) {
    $kodeInv = "IMP-" . str_pad($idx + 1, 4, '0', STR_PAD_LEFT);
    $namaEsc = str_replace("'", "''", $inv['nama']);
    $ketEsc = str_replace("'", "''", $inv['keterangan']);
    $lokasiEsc = str_replace("'", "''", $inv['lokasi']);

    // Tentukan kategori sederhana
    $idKat = 3; // default LAB / Alat Praktik
    $namaLower = strtolower($inv['nama']);
    if (str_contains($namaLower, 'laptop') || str_contains($namaLower, 'komputer') || str_contains($namaLower, 'printer') || str_contains($namaLower, 'ac') || str_contains($namaLower, 'tv') || str_contains($namaLower, 'kamera') || str_contains($namaLower, 'proyektor') || str_contains($namaLower, 'speaker') || str_contains($namaLower, 'lcd')) {
        $idKat = 1; // Elektronik
    } elseif (str_contains($namaLower, 'meja') || str_contains($namaLower, 'kursi') || str_contains($namaLower, 'lemari') || str_contains($namaLower, 'papan') || str_contains($namaLower, 'sofa') || str_contains($namaLower, 'loker')) {
        $idKat = 2; // Perabotan
    } elseif (str_contains($namaLower, 'bola') || str_contains($namaLower, 'net') || str_contains($namaLower, 'matras') || str_contains($namaLower, 'raket') || str_contains($namaLower, 'stik')) {
        $idKat = 4; // Olahraga
    }

    $sql .= "INSERT IGNORE INTO inventaris (kode_inventaris, nama, id_kategori, id_ruang, jumlah, kondisi, keterangan, tanggal_register, id_petugas) ";
    $sql .= "VALUES ('$kodeInv', '$namaEsc', $idKat, (SELECT id_ruang FROM ruang WHERE nama_ruang = '$lokasiEsc' LIMIT 1), {$inv['jumlah']}, '{$inv['kondisi']}', '$ketEsc', '2026-01-01', 1);\n";
}

file_put_contents('docs/import data/import_data.sql', $sql);
echo "Berhasil membuat SQL import! Total Ruang: " . count($ruanganUnik) . ", Total Inventaris: " . count($inventaris) . "\n";
