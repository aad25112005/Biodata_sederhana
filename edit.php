<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        //Cek apakah ada nilai yang dikirim menggunakan method GET dengan nama id_peserta
        if (isset($_GET['id_peserta'])) {
            $id_peserta = input($_GET["id_peserta"]);

            $sql = "SELECT * FROM peserta WHERE id_peserta=$id_peserta";
            $hasil = mysqli_query($kon, $sql);
            $data = mysqli_fetch_assoc($hasil);
        }

        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_peserta = htmlspecialchars($_POST["id_peserta"]);
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
                echo '<script>window.location="edit.php?act=edit"</script>';
                exit();
            }
            // Validasi nama (hanya huruf)
            if (!preg_match("/^[a-z A-Z]+$/", $nama)) {
                echo '<script>alert("Format nama tidak valid. Hanya huruf diizinkan.")</script>';
                echo '<script>window.location="tambah.php?act=tambah"</script>';
                exit();
            }

            // Validasi email (harus ada @)
            if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) {
                echo '<script>alert("Format email tidak valid. Pastikan email Anda mengandung "@".")</script>';
                echo '<script>window.location="edit.php?act=email"</script>';
                exit();
            }

            // Validasi no hp (hanya angka)
            if (!preg_match("/^[0-9]+$/", $no_hp)) {
                echo '<script>alert("Format NO HP tidak valid. Hanya angka diizinkan.")</script>';
                echo '<script>window.location="edit.php?act=edit"</script>';
                exit();
            }
            //Query update data pada tabel anggota
            $sql = "UPDATE peserta SET
			nisn='$nisn',
            nama='$nama',
            jk='$jk',
            tempat_lahir='$tempat_lahir',
            tanggal_lahir='$tanggal_lahir',
            agama='$agama',
            email='$email',
			kelas='$kelas',
			jurusan='$jurusan',
			no_hp='$no_hp',
            hobi='$hobi',
			alamat='$alamat'
			WHERE id_peserta=$id_peserta";

            //Mengeksekusi atau menjalankan query diatas
            $hasil = mysqli_query($kon, $sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($hasil) {
                header("Location:index.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
            }
        }

        ?>
        <h2 Align="center">Edit Data</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return validateInput()">

            <div class="form-group">
                <label for="nisn">NISN:</label>
                <input type="text" name="nisn" id="nisn" class="form-control" placeholder="Masukan NISN" value="<?php echo $data["nisn"]; ?>" required />
            </div>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" value="<?php echo $data["nama"]; ?>" required />
            </div>

            <div class="form-group">
                <label for="jk">Jenis Kelamin:</label><br>
                <input type="radio" name="jk" value="Laki-Laki" <?php if ($data["jk"] === "Laki-Laki") echo "checked"; ?>> Laki-Laki
                <input type="radio" name="jk" value="Perempuan" <?php if ($data["jk"] === "Perempuan") echo "checked"; ?>> Perempuan

            </div>

            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukan Tempat Lahir" value="<?php echo $data["tempat_lahir"]; ?>" required />
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" placeholder="Masukan Tanggal Lahir" value="<?php echo $data["tanggal_lahir"]; ?>" required />
            </div>

            <div class="form-group">
                <label for="agama">Agama:</label>
                <select name="agama" id="agama" class="form-control">
                    <?php
                    $agama_options = array("Islam", "Kristen Katolik", "Kristen Protestan", "Hindu", "Budha", "Konghucu");

                    // Menentukan agama yang saat ini dipilih (dari data buku yang diedit)
                    $agama_terpilih = $data["agama"];

                    // Loop melalui setiap agama
                    foreach ($agama_options as $agama) {
                        // Memeriksa apakah agama saat ini sama dengan kategori yang dipilih
                        $selected_agama = ($agama == $agama_terpilih) ? 'selected' : '';

                        // Tampilkan kategori sebagai opsi dengan mengatur selected jika agama dipilih
                        echo "<option value='$agama' $selected_agama>$agama</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" placeholder="Masukan Email" value="<?php echo $data["email"]; ?>" required />
            </div>

            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <select name="kelas" id="kelas" class="form-control">
                    <?php
                    $kelas_options = array("X", "XI", "XII");

                    // Menentukan kelas yang saat ini dipilih (dari data buku yang diedit)
                    $kelas_terpilih = $data["kelas"];

                    // Loop melalui setiap kelas
                    foreach ($kelas_options as $kelas) {
                        // Memeriksa apakah kelas saat ini sama dengan kategori yang dipilih
                        $selected_kelas = ($kelas == $kelas_terpilih) ? 'selected' : '';

                        // Tampilkan kategori sebagai opsi dengan mengatur selected jika kelas dipilih
                        echo "<option value='$kelas' $selected_kelas>$kelas</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan :</label>
                <select name="jurusan" id="jurusan" class="form-control">
                    <?php
                    $jurusan_options = array("PPLG", "ULP", "AKL", "TJKT", "MPLB");

                    // Menentukan jurusan yang saat ini dipilih (dari data buku yang diedit)
                    $jurusan_terpilih = $data["jurusan"];

                    // Loop melalui setiap jurusan
                    foreach ($jurusan_options as $jurusan) {
                        // Memeriksa apakah kelas saat ini sama dengan jurusan yang dipilih
                        $selected_jurusan = ($jurusan == $jurusan_terpilih) ? 'selected' : '';

                        // Tampilkan jurusan sebagai opsi dengan mengatur selected jika jurusan dipilih
                        echo "<option value='$jurusan' $selected_jurusan>$jurusan</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="no_hp">No HP:</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Masukan No HP" value="<?php echo $data["no_hp"]; ?>" required />
            </div>
            <div class="form-group">
                <label for="hobi">Hobi:</label><br>
                <input type="checkbox" name="hobi[]" value="Badminton" <?php if (in_array("Badminton", explode(", ", $data["hobi"]))) echo "checked"; ?> /> Badminton <br>
                <!-- <input type="checkbox" name="hobi" value="Badminton" /> Badminton <br> -->
                <input type="checkbox" name="hobi[]" value="Membaca" <?php if (in_array("Membaca", explode(", ", $data["hobi"]))) echo "checked"; ?> /> Membaca <br>
                <input type="checkbox" name="hobi[]" value="Memasak" <?php if (in_array("Memasak", explode(", ", $data["hobi"]))) echo "checked"; ?> /> Memasak <br>
                <input type="checkbox" name="hobi[]" value="Main Game" <?php if (in_array("Main Game", explode(", ", $data["hobi"]))) echo "checked"; ?> /> Main Game <br>
                <input type="checkbox" name="hobi[]" value="Berenang" <?php if (in_array("Berenang", explode(", ", $data["hobi"]))) echo "checked"; ?> /> Berenang <br>
                <input type="checkbox" name="hobi[]" value="Ngoding" <?php if (in_array("Ngoding", explode(", ", $data["hobi"]))) echo "checked"; ?> /> Ngoding <br>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea name="alamat" class="form-control" rows="5" placeholder="Masukan Alamat" required><?php echo $data["alamat"]; ?></textarea>
            </div>
            <input type="hidden" name="id_peserta" value="<?php echo $data['id_peserta']; ?>" />
            <div class="mb-3">
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php" type="submit" class="btn btn-primary">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>
