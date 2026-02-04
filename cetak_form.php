<?php
include 'koneksi_azam.php';

$siswa = mysqli_query($conn,"SELECT * FROM siswa_azam");

$tahun_ajaran = mysqli_query($conn,"
  SELECT DISTINCT tahun_ajaran 
  FROM nilai_azam 
  ORDER BY tahun_ajaran DESC
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Filter Cetak Rapor</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
    }

    .container {
      width: 420px;
      margin: 80px auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
    }

    label {
      font-weight: bold;
    }

    select, button {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 15px;
    }

    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Filter Cetak Rapor</h2>

  <form action="project/cetak.php" method="GET">

    <label>Nama Siswa</label>
    <select name="nis">
      <option value="">-- Semua Siswa --</option>
      <?php while($s = mysqli_fetch_assoc($siswa)): ?>
        <option value="<?= $s['nis'] ?>">
          <?= $s['nama_siswa'] ?> (<?= $s['kelas'] ?>)
        </option>
      <?php endwhile; ?>
    </select>

    <label>Semester</label>
    <select name="semester" required>
      <option value="">-- Pilih Semester --</option>
      <option value="1">Semester 1</option>
      <option value="2">Semester 2</option>
    </select>

    <label>Tahun Ajaran</label>
    <select name="tahun" required>
      <option value="">-- Pilih Tahun Ajaran --</option>
      <?php while($t = mysqli_fetch_assoc($tahun_ajaran)): ?>
        <option value="<?= $t['tahun_ajaran'] ?>">
          <?= $t['tahun_ajaran'] ?>
        </option>
      <?php endwhile; ?>
    </select>

    <button type="submit">Cetak PDF</button>
  </form>
</div>

</body>
</html>
