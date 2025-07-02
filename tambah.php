<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('Mahasiswa.php');

    // Ambil data dari form
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
    // Buat instance Mahasiswa
    $newMahasiswa = Mahasiswa::create([
        'nama' => $nama,
        'nim' => $nim,
        'kelas' => $kelas,
        'semester' => $semester,
        'durasiMengerjakan' => $durasiMengerjakan,
        'waktuMengerjakan' => $waktuMengerjakan
    ]);
    if ($newMahasiswa) {
        // Redirect ke halaman utama setelah berhasil menambah data
        header('Location: index.php');
        exit;
    } else {
        die('Gagal menambahkan data mahasiswa.');
    }
}
