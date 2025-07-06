<?php
include_once 'Mahasiswa.php';
// cek apakah ada query string 'search' di URL
if (isset($_GET['search'])) {
    // jika ada, ambil nilainya
    // dan simpan dalam variabel $search
    $search = $_GET['search'];
    // ambil data mahasiswa berdasarkan pencarian
    // dengan mencari di beberapa field
    $data = Mahasiswa::find('nama', $search);
    if (empty($data)) {
        $data = Mahasiswa::find('nim', $search);
    }
    if (empty($data)) {
        $data = Mahasiswa::find('kelas', $search);
    }
    if (empty($data)) {
        $data = Mahasiswa::find('semester', $search);
    }
    if (empty($data)) {
        $data = []; // Jika tidak ada data yang ditemukan, set data ke array kosong
    }
} else {
    // jika tidak ada, ambil semua data mahasiswa
    $data = Mahasiswa::all(); // Mengambil semua data mahasiswa dari session
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>
        Daftar Mahasiswa
        <?php
        if (isset($_GET['search'])) {
            echo ' - Hasil Pencarian: ' . htmlspecialchars($_GET['search']);
        }
        ?>
    </title>
</head>

<body>

    <p class="text-center mt-5">Daftar Mahasiswa</p>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="list-tab"
                data-bs-toggle="tab"
                data-bs-target="#list"
                type="button"
                role="tab"
                aria-controls="list"
                aria-selected="true">
                list
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="crud-tab"
                data-bs-toggle="tab"
                data-bs-target="#crud"
                type="button"
                role="tab"
                aria-controls="crud"
                aria-selected="false">
                crud
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="formPencarian-tab"
                data-bs-toggle="tab"
                data-bs-target="#formPencarian"
                type="button"
                role="tab"
                aria-controls="formPencarian"
                aria-selected="false">
                Form Pencarian
            </button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div
            class="tab-pane active"
            id="list"
            role="tabpanel"
            aria-labelledby="list-tab">
            <!-- Tampilkan Data Mahasiswa -->
            <div class="container mt-3">
                <div class="row">
                    <?php foreach ($data as $mahasiswa) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $mahasiswa['nama']; ?></h5>
                                    <p class="card-text">NIM: <?php echo $mahasiswa['nim']; ?></p>
                                    <p class="card-text">Kelas: <?php echo $mahasiswa['kelas']; ?></p>
                                    <p class="card-text">Semester: <?php echo $mahasiswa['semester'];   ?></p>
                                    <p class="card-text">Waktu Mengerjakan: <?php echo $mahasiswa['waktuMengerjakan']; ?></p>
                                    <p class="card-text">Durasi Mengerjakan: <?php echo $mahasiswa['durasiMengerjakan']; ?> menit</p>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div
            class="tab-pane"
            id="crud"
            role="tabpanel"
            aria-labelledby="crud-tab">
            <!-- Form Tambah Mahasiswa -->
            <div class="container mt-4">
                <form action="./tambah.php" method="POST" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="text" name="nim" class="form-control" placeholder="NIM" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="text" name="kelas" class="form-control" placeholder="Kelas" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="number" name="semester" class="form-control" placeholder="Semester" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="number" name="durasiMengerjakan" class="form-control" placeholder="Durasi Mengerjakan" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="text" name="waktuMengerjakan" class="form-control" placeholder="Waktu Mengerjakan" required>
                        </div>
                        <div class="col-md-1 mb-2">
                            <button type="submit" class="btn btn-success w-100">Tambah</button>
                        </div>
                    </div>
                </form>

                <!-- Tampilkan Data Mahasiswa -->
                <div class="row">
                    <?php foreach ($data as $mahasiswa) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $mahasiswa['nama']; ?></h5>
                                    <p class="card-text">NIM: <?php echo $mahasiswa['nim']; ?></p>
                                    <p class="card-text">Kelas: <?php echo $mahasiswa['kelas']; ?></p>
                                    <p class="card-text">Semester: <?php echo $mahasiswa['semester']; ?></p>
                                    <p class="card-text">Waktu Mengerjakan: <?php echo $mahasiswa['waktuMengerjakan']; ?></p>
                                    <p class="card-text">Durasi Mengerjakan: <?php echo $mahasiswa['durasiMengerjakan']; ?> menit</p>
                                    <!-- Update Button -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $mahasiswa->nim; ?>">
                                        Update
                                    </button>

                                    <!-- Delete Button -->
                                    <!-- /**
                                    * Formulir untuk menghapus data mahasiswa.
                                    *
                                    * - Mengirim permintaan POST ke 'hapus.php' dengan ID mahasiswa yang akan dihapus.
                                    * - Menggunakan input tersembunyi untuk menyimpan ID mahasiswa.
                                    * - Tombol submit memiliki konfirmasi sebelum menghapus data.
                                    * - Menggunakan kelas Bootstrap untuk tampilan tombol.
                                    */ -->
                                    <form action="./hapus.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $mahasiswa['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                            Delete
                                        </button>
                                    </form>

                                    <!-- Update Modal -->
                                    <!-- /**
                                    * Modal Form untuk Update Data Mahasiswa
                                    *
                                    * Modal ini dibuat secara dinamis untuk setiap mahasiswa berdasarkan NIM.
                                    *
                                    * Fitur:
                                    * - Menampilkan modal Bootstrap untuk mengubah data mahasiswa.
                                    * - Field form: Nama, Kelas, Semester, Durasi Mengerjakan, dan Waktu Mengerjakan.
                                    * - Menggunakan metode POST ke 'update.php'.
                                    * - Field tersembunyi untuk 'id' dan 'nim' agar data yang diubah tepat.
                                    * - Setiap input sudah terisi data mahasiswa saat ini.
                                    * - ID modal dan elemen form unik berdasarkan NIM mahasiswa.
                                    * - Terdapat tombol batal (tutup modal) dan simpan (submit perubahan).
                                    *
                                    * Variabel:
                                    * @var object|array $mahasiswa Data mahasiswa (object/array) berisi:
                                    * - id (int|string): ID unik mahasiswa
                                    * - nim (string): Nomor Induk Mahasiswa
                                    * - nama (string): Nama mahasiswa
                                    * - kelas (string): Kelas
                                    * - semester (int): Semester
                                    * - durasiMengerjakan (int): Durasi mengerjakan (menit)
                                    * - waktuMengerjakan (string): Waktu mengerjakan
                                    */ -->
                                    <div class="modal fade" id="updateModal-<?php echo $mahasiswa->nim; ?>" tabindex="-1" aria-labelledby="updateModalLabel-<?php echo $mahasiswa->nim; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="./update.php" method="POST" class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel-<?php echo $mahasiswa['nama'] ?>">Update Mahasiswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $mahasiswa['id']; ?>">
                                                    <input type="hidden" name="nim" value="<?php echo $mahasiswa['nim']; ?>">
                                                    <div class="mb-3">
                                                        <label for="nama-<?php echo $mahasiswa['nim']; ?>" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="nama-<?php echo $mahasiswa['nim']; ?>" name="nama" value="<?php echo $mahasiswa['nama']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kelas-<?php echo $mahasiswa['nim']; ?>" class="form-label">Kelas</label>
                                                        <input type="text" class="form-control" id="kelas-<?php echo $mahasiswa['nim']; ?>" name="kelas" value="<?php echo $mahasiswa['kelas']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="semester-<?php echo $mahasiswa['nim']; ?>" class="form-label">Semester</label>
                                                        <input type="number" class="form-control" id="semester-<?php echo $mahasiswa['nim']; ?>" name="semester" value="<?php echo $mahasiswa['semester']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="durasiMengerjakan-<?php echo $mahasiswa['nim']; ?>" class="form-label">Durasi Mengerjakan (menit)</label>
                                                        <input type="number" class="form-control" id="durasiMengerjakan-<?php echo $mahasiswa['nim']; ?>" name="durasiMengerjakan" value="<?php echo $mahasiswa['durasiMengerjakan']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="waktuMengerjakan-<?php echo $mahasiswa['nim']; ?>" class="form-label">Waktu Mengerjakan</label>
                                                        <input type="text" class="form-control" id="waktuMengerjakan-<?php echo $mahasiswa['nim']; ?>" name="waktuMengerjakan" value="<?php echo $mahasiswa['waktuMengerjakan']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div
            class="tab-pane"
            id="formPencarian"
            role="tabpanel"
            aria-labelledby="formPencarian-tab">
            <!-- Cari Mahasiswa -->
            <div class="container mt-4">
                <form action="" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Mahasiswa..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <!-- Tampilkan Data Mahasiswa -->
            <div class="container mt-4">
                <div class="row">
                    <?php foreach ($data as $mahasiswa) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $mahasiswa['nama']; ?></h5>
                                    <p class="card-text">NIM: <?php echo $mahasiswa['nim']; ?></p>
                                    <p class="card-text">Kelas: <?php echo $mahasiswa['kelas']; ?></p>
                                    <p class="card-text">Semester: <?php echo $mahasiswa['semester']; ?></p>
                                    <p class="card-text">Waktu Mengerjakan: <?php echo $mahasiswa['waktuMengerjakan']; ?></p>
                                    <p class="card-text">Durasi Mengerjakan: <?php echo $mahasiswa['durasiMengerjakan']; ?> menit</p>

                                </div>
                            </div>
                        </div>

                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer untuk mereset sesi -->
    <footer class="text-center mt-5">
        <form action="" method="post" style="display:inline;">
            <button type="submit" name="clear_session" class="btn btn-warning btn-sm">Clear Session</button>
        </form>
        <?php
        if (isset($_POST['clear_session'])) {
            session_unset();
            session_destroy();
            echo "<script>window.location.href = window.location.pathname;</script>";
        }
        ?>
        <p>&copy; 2023 UAS PBO</p>
    </footer>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>