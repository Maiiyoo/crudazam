<?php
include 'koneksi_azam.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$q = mysqli_query($conn, "SELECT * FROM nilai_azam WHERE id_nilai='$id'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
    die("Data tidak ditemukan");
}

$siswa = mysqli_query($conn, "SELECT nis, nama_siswa FROM siswa_azam");
$mapel = mysqli_query($conn, "SELECT id_mapel, nama_mapel FROM mapel_azam");

if (isset($_POST['update'])) {

    $nis          = $_POST['nis'];
    $id_mapel     = $_POST['id_mapel'];
    $nilai_tugas  = (int)$_POST['nilai_tugas'];
    $nilai_uts    = (int)$_POST['nilai_uts'];
    $nilai_uas    = (int)$_POST['nilai_uas'];
    $semester     = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];

    $nilai_akhir = round(($nilai_tugas + $nilai_uts + $nilai_uas) / 3, 2);

    $deskripsi = ($nilai_akhir >= 75)
        ? "Lulus / Tidak Remedial"
        : "Tidak Lulus / Remedial";

    mysqli_query($conn, "
        UPDATE nilai_azam SET
            nis='$nis',
            id_mapel='$id_mapel',
            nilai_tugas='$nilai_tugas',
            nilai_uts='$nilai_uts',
            nilai_uas='$nilai_uas',
            nilai_akhir='$nilai_akhir',
            deskripsi='$deskripsi',
            semester='$semester',
            tahun_ajaran='$tahun_ajaran'
        WHERE id_nilai='$id'
    ");

    header("Location: read_azam.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Nilai</title>

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

.info{
  background: #ecf6ff;
  padding: 10px;
  border-radius: 8px;
  font-size: 14px;
  margin-bottom: 15px;
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
  background: linear-gradient(135deg,#27ae60,#2ecc71);
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
<h2>✏️ Edit Nilai Siswa</h2>

<form method="POST">

  <div class="form-group">
    <label>NIS - Nama Siswa</label>
    <select name="nis" required>
      <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
        <option value="<?= htmlspecialchars($s['nis']) ?>"
          <?= $s['nis'] == $d['nis'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($s['nis']) ?> - <?= htmlspecialchars($s['nama_siswa']) ?>
        </option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label>Mata Pelajaran</label>
    <select name="id_mapel" required>
      <?php while ($m = mysqli_fetch_assoc($mapel)) { ?>
        <option value="<?= $m['id_mapel'] ?>"
          <?= $m['id_mapel'] == $d['id_mapel'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($m['nama_mapel']) ?>
        </option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label>Nilai Tugas</label>
    <input type="number" name="nilai_tugas" min="0" max="100" value="<?= $d['nilai_tugas'] ?>" required>
  </div>

  <div class="form-group">
    <label>Nilai UTS</label>
    <input type="number" name="nilai_uts" min="0" max="100" value="<?= $d['nilai_uts'] ?>" required>
  </div>

  <div class="form-group">
    <label>Nilai UAS</label>
    <input type="number" name="nilai_uas" min="0" max="100" value="<?= $d['nilai_uas'] ?>" required>
  </div>

  <div class="form-group">
    <label>Semester</label>
    <select name="semester" required>
        <option value="1" <?= $d['semester'] == 1 ? 'selected' : '' ?>>1</option>
        <option value="2" <?= $d['semester'] == 2 ? 'selected' : '' ?>>2</option>
    </select>
  </div>

  <div class="form-group">
    <label>Tahun Ajaran</label>
    <select name="tahun_ajaran" required>
        <?php
        $tahun = [
            "2020 - 2021",
            "2021 - 2022",
            "2022 - 2023",
            "2023 - 2024",
            "2024 - 2025",
            "2025 - 2026",
            "2026 - 2027"
        ];
        foreach ($tahun as $t) {
            $selected = ($t == $d['tahun_ajaran']) ? 'selected' : '';
            echo "<option value='$t' $selected>$t</option>";
        }
        ?>
    </select>
  </div>

  <div class="info">
    <b>Nilai Akhir:</b> <?= $d['nilai_akhir'] ?><br>
    <b>Deskripsi:</b> <?= $d['deskripsi'] ?>
  </div>

  <button name="update" class="btn btn-save">💾 Update</button>
  <a href="read_azam.php" class="btn btn-back">⬅ Kembali</a>

  <?php
include 'koneksi_azam.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$q = mysqli_query($conn, "SELECT * FROM nilai_azam WHERE id_nilai='$id'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
    die("Data tidak ditemukan");
}

$siswa = mysqli_query($conn, "SELECT nis, nama_siswa FROM siswa_azam");
$mapel = mysqli_query($conn, "SELECT id_mapel, nama_mapel FROM mapel_azam");

if (isset($_POST['update'])) {

    $nis          = mysqli_real_escape_string($conn, $_POST['nis']);
    $id_mapel     = mysqli_real_escape_string($conn, $_POST['id_mapel']);
    $nilai_tugas  = (int) $_POST['nilai_tugas'];
    $nilai_uts    = (int) $_POST['nilai_uts'];
    $nilai_uas    = (int) $_POST['nilai_uas'];
    $semester     = mysqli_real_escape_string($conn, $_POST['semester']);
    $tahun_ajaran = mysqli_real_escape_string($conn, $_POST['tahun_ajaran']);

    $nilai_akhir = round(($nilai_tugas + $nilai_uts + $nilai_uas) / 3, 2);

    $deskripsi = ($nilai_akhir >= 75)
        ? "Lulus / Tidak Remedial"
        : "Tidak Lulus / Remedial";

    mysqli_query($conn, "
        UPDATE nilai_azam SET
            nis='$nis',
            id_mapel='$id_mapel',
            nilai_tugas='$nilai_tugas',
            nilai_uts='$nilai_uts',
            nilai_uas='$nilai_uas',
            nilai_akhir='$nilai_akhir',
            deskripsi='$deskripsi',
            semester='$semester',
            tahun_ajaran='$tahun_ajaran'
        WHERE id_nilai='$id'
    ");

    header("Location: read_azam.php");
    exit;
}
?>

</form>
</div>

</body>
</html>
