<!DOCTYPE html>
<html>

<head>
    <title>Form Pendaftaran Siswa</title>
    <script>
        function validateInput() {
            var nisn = document.getElementById("nisn").value;

            if (!/^\d{10}$/.test(nisn)) {
                alert("NISN harus terdiri dari 10 angka.");
                return false;
            }

            return true;
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="container">
        <?php
        //Include file koneksi, untuk koneksikan ke database
        include "koneksi.php";

        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nisn = input($_POST["nisn"]);
            $nama = input($_POST["nama"]);
            $jk = input($_POST["jk"]);
            $tempat_lahir = input($_POST["tempat_lahir"]);
            $tanggal_lahir = input($_POST["tanggal_lahir"]);
            $agama = input($_POST["agama"]);
            $email = input($_POST["email"]);
            $kelas = input($_POST["kelas"]);
            $jurusan = input($_POST["jurusan"]);
            $no_hp = input($_POST["no_hp"]);
            $hobi = isset($_POST["hobi"]) ? implode(", ", $_POST["hobi"]) : '';
            $alamat = input($_POST["alamat"]);

            // Validasi nisn (hanya angka)
            if (!preg_match("/^[0-9]+$/", $nisn)) {
                echo '<script>alert("Format NISN tidak valid. Hanya angka diizinkan.")</script>';
                echo '<script>window.location="tambah.php?act=tambah"</script>';
                exit();
            }
            // Validasi nama (hanya huruf)
            if (!preg_match("/^[a-z A-Z]+$/", $nama)) {
                echo '<script>alert("Format nama tidak valid. Hanya huruf diizinkan.")</script>';
                echo '<script>window.location="tambah.php?act=tambah"</script>';
                exit();
            }

            // Cek apakah nisn sudah ada dalam database
            $sql_check = "SELECT nisn FROM peserta WHERE nisn = '$nisn'";
            $result_check = $kon->query($sql_check);

            if ($result_check->num_rows > 0) {
                echo '<script>alert("NISN sudah ada dalam database.Mohon gunakan NISN lain.")</script>';
                echo '<script>window.location="tambah.php?act=tambah"</script>';
                exit();
            }
            // Cek apakah email sudah ada dalam database
            $sql_check = "SELECT email FROM peserta WHERE email = '$email'";
            $result_check = $kon->query($sql_check);

            if ($result_check->num_rows > 0) {
                echo '<script>alert("email sudah ada dalam database.Mohon gunakan email lain.")</script>';
                echo '<script>window.location="tambah.php?act=tambah"</script>';
                exit();
            }

            // Validasi email (harus ada @)
            if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) {
                // echo "Format email tidak valid. Pastikan email Anda mengandung '@'.";
                echo '<script>alert("Format email tidak valid. Pastikan email Anda mengandung "@".")</script>';
                echo '<script>window.location="tambah.php?act=email"</script>';
                exit();
            }

            // Validasi no hp (hanya angka)
            if (!preg_match("/^[0-9]+$/", $no_hp)) {
                echo '<script>alert("Format NO HP tidak valid. Hanya angka diizinkan.")</script>';
                echo '<script>window.location="tambah.php?act=tambah"</script>';
                exit();
            }

            //Query input menginput data kedalam tabel anggota
            //INSERT INTO `peserta` (`nisn`, `nama`, `jk`, `tempat_lahir`, `tanggal_lahir`, `agama`, `email`, `kelas`, `jurusan`, `no_hp`, `alamat`) VALUES ('$nisn', '$nama', '$jk', ' $tempat_lahir', '$tanggal_lahir', '$agama', '$email', '$kelas', '$jurusan', '$no_hp', '$alamat');
            $sql = "INSERT INTO `peserta` (`nisn`, `nama`, `jk`, `tempat_lahir`, `tanggal_lahir`, `agama`, `email`, `kelas`, `jurusan`, `no_hp`, `hobi`, `alamat`) 
        VALUES ('$nisn', '$nama', '$jk', '$tempat_lahir', '$tanggal_lahir', '$agama', '$email', '$kelas', '$jurusan', '$no_hp', '$hobi', '$alamat')";

            //Mengeksekusi/menjalankan query diatas
            $hasil = mysqli_query($kon, $sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($hasil) {
                header("Location:index.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
            }
        }
        ?>
        <h2 Align="center">Tambah Data</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" onsubmit="return validateInput()">
            <div class="form-group">
                <label for="nisn">NISN:</label>
                <input type="text" maxlength="10" id="nisn" name="nisn" class="form-control" placeholder="Masukan NISN" required />
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required />
            </div>
            <div class="form-group">
                <label for="jk">Jenis Kelamin:</label><br>
                <input type="radio" name="jk" value="Laki-Laki">Laki-Laki
                <input type="radio" name="jk" value="Perempuan">Perempuan
            </div>
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukan Tempat Lahir" required />
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" placeholder="Masukan Tanggal Lahir" required />
            </div>
            <div class="form-group">
                <label for="agama">Agama:</label>
                <select name="agama" id="agama" class="form-control">
                    <option value="Islam">Islam</option>
                    <option value="Kristen Katolik">Kristen Katolik</option>
                    <option value="Kristen Protestan">Kristen Protestan</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" placeholder="Masukan Email" required />
            </div>
            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <select name="kelas" id="kelas" class="form-control">
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan :</label>
                <select name="jurusan" id="jurusan" class="form-control">
                    <option value="PPLG">PPLG</option>
                    <option value="ULP">ULP</option>
                    <option value="AKL">AKL</option>
                    <option value="TJKT">TJKT</option>
                    <option value="MPLB">MPLB</option>
                </select>
            </div>

            <div class="form-group">
                <label for="no_hp">No HP:</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Masukan No HP" required />
            </div>
            <div class="form-group">
                <label for="hobi">Hobi:</label><br>
                <input type="checkbox" name="hobi[]" value="Badminton" <?php if (isset($hobi) && in_array("Badminton", explode(", ", $hobi))) echo "checked"; ?> /> Badminton <br>
                <input type="checkbox" name="hobi[]" value="Membaca" <?php if (isset($hobi) && in_array("Membaca", explode(", ", $hobi))) echo "checked"; ?> /> Membaca <br>
                <input type="checkbox" name="hobi[]" value="Memasak" <?php if (isset($hobi) && in_array("Memasak", explode(", ", $hobi))) echo "checked"; ?> /> Memasak <br>
                <input type="checkbox" name="hobi[]" value="Main Game" <?php if (isset($hobi) && in_array("Main Game", explode(", ", $hobi))) echo "checked"; ?> /> Main Game <br>
                <input type="checkbox" name="hobi[]" value="Berenang" <?php if (isset($hobi) && in_array("Berenang", explode(", ", $hobi))) echo "checked"; ?> /> Berenang <br>
                <input type="checkbox" name="hobi[]" value="Ngoding" <?php if (isset($hobi) && in_array("Ngoding", explode(", ", $hobi))) echo "checked"; ?> /> Ngoding <br>

            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea name="alamat" class="form-control" rows="5" placeholder="Masukan Alamat" required></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" type="submit" class="btn btn-primary">Batal</a>
        </form>
    </div>

</body>

</html>