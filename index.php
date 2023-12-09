<?php

$host       = "localhost";
$user       = "root";
$pass       = "";
$database   = "crud";

$koneksi = mysqli_connect($host, $user, $pass, $database);

if (!$koneksi){
    echo "database tidak dapat terhubung";
}

$npm   = "";
$nama    = "";
$email  = "";
$alamat = "";
$sukses = "";
$error  = "";

if (isset($_GET['op'])){
    $op = $_GET['op'];
} else {
    $op = "";
}



if ($op == 'ubah'){
    if (isset($_GET['npm'])) {
        $npm    = $_GET['npm'];
        $query  = "select * from mahasiswa where NPM = '$npm'";
        $ubah   = mysqli_query($koneksi, $query);
        $tampil = mysqli_fetch_array($ubah);

        // Check if $tampil is not null before accessing its values
        if ($tampil) {
            $npm = $tampil['npm'];
            $nama = $tampil['nama'];
            $email = $tampil['email'];
            $alamat = $tampil['alamat'];
        } else {
            $error = "Data Tidak Ditemukan";
        }
    } else {
        $error = "NPM tidak ditemukan";
    }
}


if ($op == 'hapus'){
    $npm    = $_GET['npm'];
    $query  = "delete from mahasiswa where NPM = '$npm'";
    $hapus  = mysqli_query($koneksi, $query);
    if ($hapus) {
        $sukses = "Data Berhasil Di Hapus";
        $npm    = "";
    } else {
        $error  = "Data Gagal Di Hapus";
    }
}

if (isset($_POST['simpan'])){
    $npm    = $_POST['npm'];
    $nama    = $_POST['nama'];
    $email   = $_POST['email'];
    $alamat  = $_POST['alamat'];

    if ($npm && $nama && $email && $alamat) {
        if ($op == 'ubah'){
            $query  = "update mahasiswa set nama = '$nama', email = '$email', alamat = '$alamat' where npm = '$npm'";
            $ubah   = mysqli_query($koneksi, $query);
            if ($ubah) {
                $sukses = "Data Berhasil Di Update";
                $npm   = "";
                $nama    = "";
                $email  = "";
                $alamat = "";
            } else {
                $error  = "Data Gagal di Update";
            }
        } else {
            $query  = "insert into mahasiswa values ('$npm', '$nama', '$email', '$alamat')";
            $simpan = mysqli_query($koneksi, $query);
            if ($simpan) {
                $sukses = "Data Berhasil Di Simpan";
                $npm  = "";
                $nama    = "";
                $email  = "";
                $alamat = "";
            } else {
                $error  = "Data Gagal Di Simpan";
            }
        }
    } else {
        $error = "Silahkan Masukkan Semua Data";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto { width: 800px; }
        .card { margin-top: 10px; }
    </style>
</head>
<body>

<div class="mx-auto">
    <div class="card">
        <div class="card-header text-white bg-primary">
            Create / Edit Data
        </div>
        <div class="card-body">
            <?php
            if ($sukses){
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses; ?>
                </div>
                <?php
             }
             if ($error) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
                <?php
             }
             ?>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="npm" class="col-sm-2 col-form-label">NPM</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="npm" name="npm" value="<?php echo $npm; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">EMAIL</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">ALAMAT</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo $alamat; ?></textarea>
                    </div>
                </div>
                <div class="col-12" align="right">
                    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header text-white bg-primary">
            Data Mahasiswa
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NPM</th>
                        <th scope="col">NAMA</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">ALAMAT</th>
                        <th scope="col">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "select * from mahasiswa order by NPM asc";
                    $tampil = mysqli_query($koneksi, $query);
                    $urut = 1;
                    while ($result = mysqli_fetch_array($tampil)){
                        $npm   = $result['npm'];
                        $nama    = $result['nama'];
                        $email  = $result['email'];
                        $alamat = $result['alamat'];
                    ?>
                    <tr>
                        <th scope="row"><?php echo $urut++; ?></th>
                        <td scope="row"><?php echo $npm; ?></td>
                        <td scope="row"><?php echo $nama; ?></td>
                        <td scope="row"><?php echo $email; ?></td>
                        <td scope="row"><?php echo $alamat; ?></td>
                        <td>
                            <a href="index.php?op=ubah&npm=<?php echo $npm; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <a href="index.php?op=hapus&npm=<?php echo $npm; ?>" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')"><button type="button" class="btn btn-danger">Hapus</button></a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
