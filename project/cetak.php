<?php
require 'fpdf.php';
include '../koneksi_azam.php';

$nis      = $_GET['nis'] ?? '';
$semester = $_GET['semester'];
$tahun    = $_GET['tahun'];

/* ================= AMBIL DATA SISWA ================= */

$whereSiswa = ($nis != '') ? "WHERE nis='$nis'" : "";

$qSiswa = mysqli_query($conn,"
    SELECT DISTINCT s.nis, s.nama_siswa, s.kelas
    FROM siswa_azam s
    JOIN nilai_azam n ON s.nis = n.nis
    WHERE n.semester='$semester'
    AND n.tahun_ajaran='$tahun'
    ".($nis != "" ? "AND s.nis='$nis'" : "")."
    ORDER BY s.kelas, s.nama_siswa
");

if(mysqli_num_rows($qSiswa) == 0){
    die('Data tidak ditemukan');
}

/* ================= PDF ================= */

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,15);

while($s = mysqli_fetch_assoc($qSiswa)){

    $pdf->AddPage();

    /* ===== HEADER ===== */
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,'LAPORAN HASIL BELAJAR SISWA',0,1,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',11);

    $pdf->Cell(40,8,'Nama'); $pdf->Cell(5,8,':');
    $pdf->Cell(60,8,$s['nama_siswa'],0,0);

    $pdf->Cell(30,8,'Semester'); $pdf->Cell(5,8,':');
    $pdf->Cell(0,8,$semester,0,1);

    $pdf->Cell(40,8,'NIS'); $pdf->Cell(5,8,':');
    $pdf->Cell(60,8,$s['nis'],0,0);

    $pdf->Cell(30,8,'Tahun Ajaran'); $pdf->Cell(5,8,':');
    $pdf->Cell(0,8,$tahun,0,1);

    $pdf->Cell(40,8,'Kelas'); $pdf->Cell(5,8,':');
    $pdf->Cell(0,8,$s['kelas'],0,1);

    $pdf->Ln(6);

    /* ===== NILAI ===== */
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,8,'A. NILAI SISWA',0,1);

    $pdf->Cell(10,8,'No',1,0,'C');
    $pdf->Cell(65,8,'Mata Pelajaran',1,0,'C');
    $pdf->Cell(25,8,'Nilai',1,0,'C');
    $pdf->Cell(90,8,'Deskripsi',1,1,'C');

    $pdf->SetFont('Arial','',10);

    $qNilai = mysqli_query($conn,"
        SELECT m.nama_mapel, n.nilai_akhir, n.deskripsi
        FROM nilai_azam n
        JOIN mapel_azam m ON n.id_mapel = m.id_mapel
        WHERE n.nis='{$s['nis']}'
        AND n.semester='$semester'
        AND n.tahun_ajaran='$tahun'
        ORDER BY m.nama_mapel
    ");

    $no = 1;
    while($n = mysqli_fetch_assoc($qNilai)){
        $pdf->Cell(10,8,$no++,1,0,'C');
        $pdf->Cell(65,8,$n['nama_mapel'],1,0);
        $pdf->Cell(25,8,$n['nilai_akhir'],1,0,'C');
        $pdf->Cell(90,8,$n['deskripsi'],1,1);
    }

    /* ===== KEHADIRAN ===== */
    $qHadir = mysqli_query($conn,"
        SELECT sakit, izin, alpha
        FROM kehadiran_azam
        WHERE nis='{$s['nis']}'
        AND semester='$semester'
        AND tahun_ajaran='$tahun'
    ");
    $hadir = mysqli_fetch_assoc($qHadir);

    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,8,'B. KEHADIRAN',0,1);

    $pdf->Cell(70,8,'Keterangan',1);
    $pdf->Cell(30,8,'Jumlah',1,1,'C');

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(70,8,'Sakit',1);
    $pdf->Cell(30,8,($hadir['sakit'] ?? 0).' Hari',1,1,'C');

    $pdf->Cell(70,8,'Izin',1);
    $pdf->Cell(30,8,($hadir['izin'] ?? 0).' Hari',1,1,'C');

    $pdf->Cell(70,8,'Alpha',1);
    $pdf->Cell(30,8,($hadir['alpha'] ?? 0).' Hari',1,1,'C');

    /* ===== TTD ===== */
    $pdf->Ln(18);
    $pdf->Cell(63,6,'Mengetahui,',0,0,'C');
    $pdf->Cell(63,6,'Wali Kelas',0,0,'C');
    $pdf->Cell(63,6,'Orang Tua / Wali',0,1,'C');

    $pdf->Ln(18);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(63,6,'Kepala Sekolah',0,0,'C');
    $pdf->Cell(63,6,'_________________',0,0,'C');
    $pdf->Cell(63,6,'_________________',0,1,'C');
}

$pdf->Output('I','rapor_siswa.pdf');
