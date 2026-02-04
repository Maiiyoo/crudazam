<?php
include 'koneksi_azam.php';

$siswa = mysqli_query($conn, "SELECT nis, nama_siswa FROM siswa_azam");
$mapel = mysqli_query($conn, "SELECT id_mapel, nama_mapel FROM mapel_azam");

if (isset($_POST['simpan'])) {

    $nis          = $_POST['nis'];
    $id_mapel     = $_POST['id_mapel'];
    $nilai_tugas  = (int) $_POST['nilai_tugas'];
    $nilai_uts    = (int) $_POST['nilai_uts'];
    $nilai_uas    = (int) $_POST['nilai_uas'];
    $semester     = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];

    $nilai_akhir = round(($nilai_tugas + $nilai_uts + $nilai_uas) / 3);

 
    $deskripsi = ($nilai_akhir >= 75)
        ? "Lulus / Tidak Remedial"
        : "Tidak Lulus / Remedial";

  
    $cek = mysqli_query($conn, "SELECT MAX(id_nilai) AS max_id FROM nilai_azam");
    $data = mysqli_fetch_assoc($cek);

    if (!$data['max_id']) {
        $id_nilai = "NP001";
    } else {
        $no = (int) substr($data['max_id'], 2);
        $no++;
        $id_nilai = "NP" . str_pad($no, 3, "0", STR_PAD_LEFT);
    }

    
    mysqli_query($conn, "
        INSERT INTO nilai_azam
        (id_nilai, nis, id_mapel, nilai_tugas, nilai_uts, nilai_uas,
         nilai_akhir, deskripsi, semester, tahun_ajaran)
        VALUES
        ('$id_nilai','$nis','$id_mapel','$nilai_tugas','$nilai_uts',
         '$nilai_uas','$nilai_akhir','$deskripsi','$semester','$tahun_ajaran')
    ");

    header("Location: read_azam.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Nilai</title>

<style>
*{
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, sans-serif;
}

body{
  background: #f4f6f9;
  padding: 30px;
}

.card{
  max-width: 600px;
  margin: auto;
  background: #fff;
  padding: 25px;
  border-radius: 14px;
  box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

.card h2{
  text-align: center;
  margin-bottom: 20px;
  color: #2c3e50;
}

.form-group{
  margin-bottom: 15px;
}

label{
  font-weight: 600;
  font-size: 14px;
  display: block;
  margin-bottom: 6px;
}

input, select{
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 14px;
}

input:focus, select:focus{
  outline: none;
  border-color: #3498db;
}

.btn{
  padding: 10px 16px;
  border-radius: 8px;
  border: none;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  font-size: 14px;
}

.btn-save{
  background: linear-gradient(135deg,#3498db,#2980b9);
  color: #fff;
}

.btn-back{
  background: #95a5a6;
  color: #fff;
  margin-left: 8px;
}

.btn:hover{
  opacity: .9;
}

@media(max-width: 600px){
  .card{
    padding: 20px;
  }
}
</style>
</head>

<body>

<div class="card">
<h2>➕ Tambah Nilai Siswa</h2>

<form method="POST">

  <div class="form-group">
    <label>NIS - Nama Siswa</label>
    <select name="nis" required>
      <option value="">-- Pilih Siswa --</option>
      <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
        <option value="<?= $s['nis']; ?>">
          <?= $s['nis']; ?> - <?= $s['nama_siswa']; ?>
        </option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label>Mata Pelajaran</label>
    <select name="id_mapel" required>
      <option value="">-- Pilih Mapel --</option>
      <?php while ($m = mysqli_fetch_assoc($mapel)) { ?>
        <option value="<?= $m['id_mapel']; ?>">
          <?= $m['nama_mapel']; ?>
        </option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label>Nilai Tugas</label>
    <input type="number" name="nilai_tugas" required>
  </div>

  <div class="form-group">
    <label>Nilai UTS</label>
    <input type="number" name="nilai_uts" required>
  </div>

  <div class="form-group">
    <label>Nilai UAS</label>
    <input type="number" name="nilai_uas" required>
  </div>

  <div class="form-group">
    <label>Semester</label>
    <select name="semester" id="semester">
        <option value="1">1</option>
        <option value="2">2</option>
    </select>
  </div>

  <div class="form-group">
    <label>Tahun Ajaran</label>
    <select name="tahun_ajaran" id="tahun_ajaran">
        <option value="2020 - 2021">2020 - 2021</option>
        <option value="2021 - 2022">2021 - 2022</option>
        <option value="2022 - 2023">2022 - 2023</option>
        <option value="2023 - 2024">2023 - 2024</option>
        <option value="2024 - 2025">2024 - 2025</option>
        <option value="2025 - 2026">2025 - 2026</option>
        <option value="2026 - 2027">2026 - 2027</option>
    </select>
  </div>

  <button name="simpan" class="btn btn-save">💾 Simpan</button>
  <a href="read_azam.php" class="btn btn-back">⬅ Kembali</a>

</form>
</div>

</body>
</html>
