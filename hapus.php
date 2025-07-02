<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('Mahasiswa.php');

    // Ambil ID dari form
    $id = $_POST['id'] ?? null; // Ambil ID dari form
    if ($id === null) {
        die('ID mahasiswa tidak ditemukan!');
    }

    // Hapus data mahasiswa berdasarkan ID
    $deleted = Mahasiswa::delete($id);
    if ($deleted) {
        // Redirect ke halaman utama setelah berhasil menghapus data
        header('Location: index.php');
        exit;
    } else {
        die('Gagal menghapus data mahasiswa.');
    }
}
