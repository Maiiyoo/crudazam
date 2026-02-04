<?php
include 'koneksi_azam.php';

$data = mysqli_query($conn, "
  SELECT 
    nilai_azam.*,
    mapel_azam.nama_mapel,
    siswa_azam.nama_siswa
  FROM nilai_azam
  JOIN mapel_azam ON nilai_azam.id_mapel = mapel_azam.id_mapel
  JOIN siswa_azam ON nilai_azam.nis = siswa_azam.nis
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Nilai</title>

<style>
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
