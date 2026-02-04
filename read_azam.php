<?php
include 'koneksi_azam.php';

// Ambil data untuk dropdown filter
$mapel = mysqli_query($conn, "SELECT id_mapel, nama_mapel FROM mapel_azam ORDER BY nama_mapel ASC");

// Tangkap filter dari form
$filter_nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$filter_mapel = isset($_GET['mapel']) ? $_GET['mapel'] : '';
$filter_semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

// Query data dengan filter
$query = "
  SELECT 
    nilai_azam.*,
    mapel_azam.nama_mapel,
    siswa_azam.nama_siswa
  FROM nilai_azam
  JOIN mapel_azam ON nilai_azam.id_mapel = mapel_azam.id_mapel
  JOIN siswa_azam ON nilai_azam.nis = siswa_azam.nis
  WHERE 1=1
";

if($filter_nama) $query .= " AND siswa_azam.nama_siswa LIKE '%$filter_nama%'";
if($filter_mapel) $query .= " AND nilai_azam.id_mapel = '$filter_mapel'";
if($filter_semester) $query .= " AND nilai_azam.semester = '$filter_semester'";
if($filter_tahun) $query .= " AND nilai_azam.tahun_ajaran = '$filter_tahun'";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Nilai</title>
<style>
/* CSS sama seperti sebelumnya */
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, sans-serif;
}

body{
  background: #f4f6f9;
  padding: 30px;
  color: #2c3e50;
}

.header{
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.header h2{
  font-size: 24px;
}

.btn{
  padding: 10px 16px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  transition: .3s;
}

.btn-add{
  background: linear-gradient(135deg,#3498db,#2980b9);
  color: #fff;
}

.btn-add:hover{
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(52,152,219,.4);
}

.btn-edit{
  background: #f1c40f;
  color: #000;
}

.btn-delete{
  background: #e74c3c;
  color: #fff;
}

.btn-edit:hover,
.btn-delete:hover{
  opacity: .8;
}

.table-box{
  background: #fff;
  border-radius: 12px;
  padding: 15px;
  box-shadow: 0 10px 25px rgba(0,0,0,.08);
  overflow-x: auto;
}

table{
  width: 100%;
  border-collapse: collapse;
}

table th{
  background: #2c3e50;
  color: #fff;
  padding: 12px;
  font-size: 14px;
  text-align: center;
}

table td{
  padding: 10px;
  font-size: 14px;
  text-align: center;
  border-bottom: 1px solid #eee;
}

table tr:nth-child(even){
  background: #f9fbfd;
}

table tr:hover{
  background: #eef5ff;
}

.aksi a{
  margin: 0 3px;
}

/* Filter form */
.filter-box{
  margin-bottom: 20px;
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.filter-box input, .filter-box select{
  padding: 6px 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.filter-box button{
  padding: 8px 16px;
  border-radius: 6px;
  border: none;
  background: #3498db;
  color: #fff;
  cursor: pointer;
  font-weight: 600;
}

.filter-box a{
  padding: 8px 16px;
  border-radius: 6px;
  background: #e74c3c;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  text-align: center;
}

@media(max-width: 768px){
  table th, table td{
    font-size: 12px;
    padding: 8px;
  }
}
</style>
</head>

<body>

<div class="header">
  <h2>📊 Data Nilai Siswa</h2>
  <div>
    <a href="create_azam.php" class="btn btn-add">+ Tambah Nilai</a>
    <a href="cetak_form.php" class="btn btn-add">🖨 Cetak Nilai</a>
  </div>
</div>

<!-- Filter Form -->
<div class="filter-box">
  <form method="GET" style="display:flex; flex-wrap:wrap; gap:10px;">
    <input type="text" name="nama" placeholder="Cari Nama Siswa..." value="<?= $filter_nama ?>">
    
    <select name="mapel">
      <option value="">-- Pilih Mapel --</option>
      <?php while($m = mysqli_fetch_assoc($mapel)): ?>
        <option value="<?= $m['id_mapel'] ?>" <?= ($m['id_mapel']==$filter_mapel)?'selected':'' ?>><?= $m['nama_mapel'] ?></option>
      <?php endwhile; ?>
    </select>
    
    <select name="semester">
      <option value="">-- Pilih Semester --</option>
      <option value="1" <?= ($filter_semester=='1')?'selected':'' ?>>1</option>
      <option value="2" <?= ($filter_semester=='2')?'selected':'' ?>>2</option>
    </select>
    
    <select name="tahun">
  <option value="">-- Pilih Tahun Ajaran --</option>
  <?php 
  $tahun_awal = 2015; // mulai dari 2015
  $tahun_ini = date('Y');
  for($i=$tahun_ini; $i>=$tahun_awal; $i--):
    $tahun_ajaran = ($i-1) . " - " . $i; // misal 2020-2021
  ?>
    <option value="<?= $tahun_ajaran ?>" <?= ($filter_tahun==$tahun_ajaran)?'selected':'' ?>>
      <?= $tahun_ajaran ?>
    </option>
  <?php endfor; ?>
</select>

    
    <button type="submit">Filter</button>
    <a href="data_nilai.php">Reset</a>
  </form>
</div>

<div class="table-box">
<table>
<tr>
  <th>No</th>
  <th>NIS</th>
  <th>Nama Siswa</th>
  <th>Mapel</th>
  <th>Tugas</th>
  <th>UTS</th>
  <th>UAS</th>
  <th>Nilai Akhir</th>
  <th>Deskripsi</th>
  <th>Semester</th>
  <th>Tahun</th>
  <th>Aksi</th>
</tr>

<?php $no=1; while($d = mysqli_fetch_assoc($data)): ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $d['nis'] ?></td>
  <td><?= $d['nama_siswa'] ?></td>
  <td><?= $d['nama_mapel'] ?></td>
  <td><?= $d['nilai_tugas'] ?></td>
  <td><?= $d['nilai_uts'] ?></td>
  <td><?= $d['nilai_uas'] ?></td>
  <td><strong><?= $d['nilai_akhir'] ?></strong></td>
  <td><?= $d['deskripsi'] ?></td>
  <td><?= $d['semester'] ?></td>
  <td><?= $d['tahun_ajaran'] ?></td>
  <td class="aksi">
    <a href="update_azam.php?id=<?= $d['id_nilai'] ?>" class="btn btn-edit">Edit</a>
    <a href="delete_azam.php?id=<?= $d['id_nilai'] ?>" 
       class="btn btn-delete"
       onclick="return confirm('Hapus data ini?')">Hapus</a>
  </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
