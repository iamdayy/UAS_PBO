<?php
include_once 'Model.php';
class Mahasiswa extends Model
{
    // Nama field di $_SESSION yang akan digunakan sebagai "tabel" untuk model ini.
    protected static string $table = 'mahasiswa';
    public $id; // Unique identifier for each Mahasiswa
    public $nama;
    public $nim;
    public $kelas;
    public $semester;
    public $durasiMengerjakan;
    public $waktuMengerjakan;

    /**
     * Mahasiswa constructor.
     * Inisialisasi objek Mahasiswa dengan data yang diberikan.
     *
     * @param array $data Data mahasiswa yang akan diinisialisasi.
     */
    public function __construct(array $data = [])
    {
        parent::__construct(); // Memanggil konstruktor dari Model untuk memastikan sesi dimulai
        $this->id = $data['id'] ?? null; // Menggunakan null coalescing operator untuk menghindari notice
        $this->nama = $data['nama'] ?? '';
        $this->nim = $data['nim'] ?? '';
        $this->kelas = $data['kelas'] ?? '';
        $this->semester = $data['semester'] ?? '';
        $this->durasiMengerjakan = $data['durasiMengerjakan'] ?? 0;
        $this->waktuMengerjakan = $data['waktuMengerjakan'] ?? '';
    }
}
