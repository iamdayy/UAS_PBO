<?php

/**
 * Class SessionModel
 *
 * Kelas dasar generik untuk mensimulasikan Model dengan $_SESSION.
 * Dirancang untuk diperluas oleh model spesifik (misalnya Mahasiswa, User).
 */
class Model
{

    // Nama field di $_SESSION yang akan digunakan sebagai "tabel" untuk model ini.
    // HARUS di-override di kelas turunan!
    protected static string $table = '';

    // Nama kunci yang berfungsi sebagai primary key untuk setiap data.
    protected static string $primaryKey = 'id';

    /**
     * Memastikan sesi dimulai dan "tabel" untuk model ini ada di sesi.
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (empty(static::$table)) {
            throw new Exception("Property \$table harus didefinisikan di kelas turunan " . static::class);
        }

        if (!isset($_SESSION[static::$table]) || !is_array($_SESSION[static::$table])) {
            $_SESSION[static::$table] = [];
        }
    }

    /**
     * Mengambil semua data dari "tabel" ini.
     *
     * @return array
     */
    public static function all(): array
    {
        // Pastikan sesi sudah dimulai
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Pastikan property $table sudah didefinisikan
        if (empty(static::$table)) {
            throw new Exception("Property \$table harus didefinisikan di kelas turunan " . static::class);
        }

        // Mengembalikan semua data dari $_SESSION
        return $_SESSION[static::$table] ?? [];
    }

    /**
     * Menemukan data berdasarkan primary key.
     *
     * @param mixed $id Nilai primary key.
     * @return array|null
     */
    public static function findById(mixed $id): ?array
    {
        foreach (static::all() as $data) {
            if (isset($data[static::$primaryKey]) && $data[static::$primaryKey] == $id) {
                return $data;
            }
        }
        return null;
    }


    /**
     * Menemukan semua data berdasarkan kriteria tertentu.
     *
     * @param string $key Kunci kolom.
     * @param mixed $value Nilai yang dicari.
     * @return array
     */
    public static function find(string $key, mixed $value): array
    {
        $results = [];
        // dapatkan data yang memiliki kunci mirip dengan nilai yang diberikan
        // seperti 'LIKE' dalam SQL
        foreach (static::all() as $data) {
            if (isset($data[$key])) {
                // ubah perbandingan menjadi case-insensitive
                $data[$key] = strtolower($data[$key]);
                $value = strtolower($value);
                // menggunakan strpos untuk mencari substring
                if (strpos($data[$key], $value) !== false) {
                    $results[] = $data;
                }
            }
        }
        return $results;
    }

    /**
     * Membuat data baru.
     * Otomatis menambahkan primary key jika belum ada.
     *
     * @param array $data data baru.
     * @return array|null data yang dibuat, atau null jika gagal (misalnya primary key duplikat).
     */
    public static function create(array $data): ?array
    {
        // Membuat instance sementara untuk memastikan konstruktor dipanggil
        $instance = new static();

        if (!isset($data[static::$primaryKey])) {
            // Jika primary key belum ada, buat yang baru
            // Gunakan uniqid untuk membuat primary key unik
            $data[static::$primaryKey] = uniqid(static::$table . '_');
        } else {
            // Jika primary key sudah ada, cek duplikasi
            if (static::findById($data[static::$primaryKey])) {
                return null; // Primary key duplikat
            }
        }
        // Pastikan data adalah array
        if (!is_array($data)) {
            throw new InvalidArgumentException("Data harus berupa array.");
        }
        $_SESSION[static::$table][] = $data;
        return $data;
    }

    /**
     * Memperbarui data berdasarkan primary key.
     *
     * @param mixed $id Nilai primary key data yang akan diperbarui.
     * @param array $newData Data baru untuk data.
     * @return bool True jika berhasil diperbarui, false jika tidak ditemukan.
     */
    public static function update(mixed $id, array $newData): bool
    {
        // Membuat instance sementara untuk memastikan konstruktor dipanggil
        $instance = new static();

        $datas = static::all();
        foreach ($datas as $index => $data) {
            if (isset($data[static::$primaryKey]) && $data[static::$primaryKey] == $id) {
                // Pastikan primary key tidak diubah melalui fungsi update ini
                if (isset($newData[static::$primaryKey]) && $newData[static::$primaryKey] != $id) {
                    return false; // Tidak bisa mengubah primary key melalui update
                }
                $_SESSION[static::$table][$index] = array_merge($data, $newData);
                return true;
            }
        }
        return false;
    }

    /**
     * Menghapus data berdasarkan primary key.
     *
     * @param mixed $id Nilai primary key data yang akan dihapus.
     * @return bool True jika berhasil dihapus, false jika tidak ditemukan.
     */
    public static function delete(mixed $id): bool
    {
        // Membuat instance sementara untuk memastikan konstruktor dipanggil
        $instance = new static();

        $datas = static::all();
        foreach ($datas as $index => $data) {
            if (isset($data[static::$primaryKey]) && $data[static::$primaryKey] == $id) {
                array_splice($_SESSION[static::$table], $index, 1);
                return true;
            }
        }
        return false;
    }
}
