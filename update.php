<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('Mahasiswa.php');

    // Ambil data dari form
    $id = $_POST['id'] ?? null; // Ambil ID dari form
    if ($id === null) {
        die('ID mahasiswa tidak ditemukan!');
    }
    $nama = $_POST['nama'] ?? '';
    $nim = $_POST['nim'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $durasiMengerjakan = $_POST['durasiMengerjakan'] ?? 0;
    $waktuMengerjakan = $_POST['waktuMengerjakan'] ?? '';

    // Validasi input
    if (empty($nama) || empty($nim) || empty($kelas) || empty($semester) || empty($durasiMengerjakan) || empty($waktuMengerjakan)) {
        die('Semua field harus diisi!');
    }
    // Cek apakah mahasiswa dengan ID tersebut ada
    $existingMahasiswa = Mahasiswa::findById($id);
    if (!$existingMahasiswa) {
        die('Mahasiswa dengan ID tersebut tidak ditemukan!');
    }
    // Update data mahasiswa berdasarkan ID
    $updatedMahasiswa = Mahasiswa::update($id, [
        'nama' => $nama,
        'nim' => $nim,
        'kelas' => $kelas,
        'semester' => $semester,
        'durasiMengerjakan' => $durasiMengerjakan,
        'waktuMengerjakan' => $waktuMengerjakan
    ]);
    if ($updatedMahasiswa) {
        // Redirect ke halaman utama setelah berhasil mengupdate data
        header('Location: index.php');
        exit;
    } else {
        die('Gagal mengupdate data mahasiswa.');
    }
}
