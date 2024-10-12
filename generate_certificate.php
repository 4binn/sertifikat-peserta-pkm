<?php
require('fpdf/fpdf.php');

// Konfigurasi database
/* $host = 'localhost';  // Host database
$dbname = 'certificate_pkm';  // Nama database
$username = 'root';  // Username database
$password = '';  // Password database */

// Buat koneksi ke database
//$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
/*if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name']; */

      // Cek apakah field name kosong
      if (empty(trim($_POST["name"]))) {
        echo "Nama peserta tidak boleh kosong!";
        exit; // Hentikan eksekusi jika nama kosong
    } else {
        $name = htmlspecialchars(trim($_POST["name"])); 

        // Mengonversi nama menjadi huruf kapital
        $name = strtoupper(htmlspecialchars(trim($_POST["name"])));

    // Cek apakah jumlah peserta sudah mencapai 50
    $result = $conn->query("SELECT COUNT(*) AS total FROM certificates");
    $row = $result->fetch_assoc();
    
    if ($row['total'] >= 50) {
        die("Kuota pembuatan sertifikat sudah penuh. Maksimal 50 orang.");
    }

    // Jika belum mencapai 50, buat sertifikat
    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();


    // Buat objek PDF
    $pdf = new FPDF('L', 'mm', 'A4'); // A4 landscape
    $pdf->AddPage();

    // Tambahkan gambar latar (template sertifikat)
    $pdf->Image('assets/certificate_template.png', 0, 0, 297, 210); // Path relative ke gambar template

    // Atur warna teks
    $pdf->SetTextColor(33, 37, 41); // Warna teks: dark grey

      // Tambahkan jarak vertikal setelah subjudul
      $pdf->Ln(70); // Tambahkan spasi vertikal yang cukup di sini

    // Atur ukuran font berdasarkan panjang nama
    if (strlen($name) > 30) {
        $pdf->SetFont('Times', 'B', 26); // Font lebih kecil untuk nama panjang
    } else {
        $pdf->SetFont('Times', 'B', 30); // Font besar untuk nama pendek
    }

    // Tambahkan nama peserta di bawah subjudul
    $pdf->Cell(0, 20, $name, 0, 1, 'C'); // Nama peserta di bawah subjudul

    // Tambahkan teks bawah sertifikat
    $pdf->SetFont('Arial', '', 18); // Ukuran teks sedang untuk teks pendukung
    $pdf->Ln(10); // Spasi atas

    // Output sertifikat sebagai file PDF yang bisa didownload
    $pdf->Output('D', 'certificate.pdf');

    // Buat folder 'certificates' jika belum ada
    if (!file_exists('certificates')) {
        mkdir('certificates', 0777, true);
    }

    // Simpan sertifikat dalam folder 'certificates' dengan nama file unik
    $file_name = 'certificate_' . time() . '.pdf';
    $file_path = 'certificates/' . $file_name;
    $pdf->Output('F', $file_path); // Simpan file PDF ke dalam folder

    // Simpan data sertifikat ke database
    $stmt = $conn->prepare("INSERT INTO certificates (participant_name, creation_date, certificate_file) VALUES (?, NOW(), ?)");
    $stmt->bind_param("ss", $name, $file_name);

    if ($stmt->execute()) {
        echo "Sertifikat berhasil dibuat dan disimpan di $file_path!";
    } else {
        echo "Gagal menyimpan data ke database.";
    }

    $stmt->close();
}

$conn->close();
?>
