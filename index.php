<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<title>Athariq Ahmad Day</title>

<body>
    <div class="header">
        <H2 style="background-color: rgb(83, 81, 79); color:aliceblue;">BIODATA SISWA</H2>
    </div>
    <div class="container">
        <div class="cari">
            <form>
                <input class="search-form" type="text" name="keyword" id="keyword" onkeyup="cariSiswa()" placeholder="Masukkan pencarian...">
            </form>
        </div><br>
        <div>
            <br>
            <h2 align="center">DAFTAR SISWA</h2>
            <?php

            include "koneksi.php";

            //Cek apakah ada kiriman form dari method post
            if (isset($_GET['id_peserta'])) {
                $id_peserta = htmlspecialchars($_GET["id_peserta"]);

                $sql = "delete from peserta where id_peserta='$id_peserta' ";
                $hasil = mysqli_query($kon, $sql);

                //Kondisi apakah berhasil atau tidak
                if ($hasil) {
                    header("Location:index.php");
                } else {
                    echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
                }
            }
            ?>

            <a href="tambah.php" id="tambah" class="btn btn-primary" role="button">Tambah Data</a><br>

            <div class="table-responsive">
                <table class="table" rules="all" border="1" id="tableData">
                    <tr>
                        <th>No</th>
                        <TH>NISN</TH>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>No Hp</th>
                        <th>Hobi</th>
                        <th>Alamat</th>
                        <th colspan='2'>Aksi</th>
                    </tr>
                    <?php
                    include "koneksi.php";
                    if (isset($_GET['keyword'])) {
                        $sql = "SELECT * FROM peserta WHERE
                nisn LIKE '%$_GET[keyword]%' OR 
                nama LIKE '%$_GET[keyword]%' OR 
                jk LIKE '%$_GET[keyword]%' OR 
                tempat_lahir LIKE '%$_GET[keyword]%' OR 
                agama LIKE '%$_GET[keyword]%' OR 
                kelas LIKE '%$_GET[keyword]%' OR 
                jurusan LIKE '%$_GET[keyword]%' OR 
                no_hp LIKE '%$_GET[keyword]%' OR 
                hobi LIKE '%$_GET[keyword]%' OR 
                alamat LIKE '%$_GET[keyword]%'";
                    } else {
                        $sql = "SELECT * FROM peserta ORDER BY id_peserta ASC";
                    }

                    $hasil = mysqli_query($kon, $sql);
                    $no = 0;
                    while ($data = mysqli_fetch_array($hasil)) {
                        $no++;

                    ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data["nisn"]; ?></td>
                            <td><?php echo $data["nama"]; ?></td>
                            <td><?php echo $data["jk"]; ?></td>
                            <td><?php echo $data["tempat_lahir"]; ?></td>
                            <td><?php echo $data["tanggal_lahir"]; ?></td>
                            <td><?php echo $data["agama"]; ?></td>
                            <td><?php echo $data["email"]; ?></td>
                            <td><?php echo $data["kelas"];   ?></td>
                            <td><?php echo $data["jurusan"];   ?></td>
                            <td><?php echo $data["no_hp"];   ?></td>
                            <td><?php echo $data["hobi"];   ?></td>
                            <td><?php echo $data["alamat"];   ?></td>
                            <td>
                                <a href="edit.php?id_peserta=<?php echo htmlspecialchars($data['id_peserta']); ?>" class="btn btn-warning" role="button">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_peserta=<?php echo $data['id_peserta']; ?>" class="btn btn-danger" role="button">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function cariSiswa() {
            var input = document.getElementById("keyword").value;
            var table = document.getElementById("tableData");
            var baris = table.getElementsByTagName("tr");

            // Pertahankan baris pertama (header tabel) tetap terlihat
            var headerRow = baris[0];
            headerRow.style.display = "table-row";

            for (i = 1; i < baris.length; i++) { // Mulai dari 1 untuk menghindari header
                var dataCells = baris[i].getElementsByTagName("td");
                var matchFound = false;

                for (j = 0; j < dataCells.length; j++) {
                    var cellData = dataCells[j].textContent || dataCells[j].innerText;

                    if (cellData.toLowerCase().indexOf(input.toLowerCase()) > -1) {
                        matchFound = true;
                        break;
                    }
                }

                if (matchFound) {
                    baris[i].style.display = "table-row"; // Menampilkan baris yang cocok
                } else {
                    baris[i].style.display = "none"; // Menyembunyikan baris yang tidak cocok
                }
            }
        }
    </script>
</body>

</html>