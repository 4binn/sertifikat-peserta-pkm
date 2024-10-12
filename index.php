<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Peserta PKM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Sertifikat Peserta <br> Pengabdian Kepada Masyarakat (PKM) <br> Universitas Pamulang</h1>
        <form action="generate_certificate.php" method="POST">
            <label for="name">Nama Peserta</label>
            <input type="text" id="name" name="name" placeholder="Masukan nama">
            <input type="submit" value="Submit">
        </form>
    </div>

    <footer>
        &copy; 2024. Dibuat oleh mahasiswa ngantuk dengan kemalasan tingkat tinggi.
    </footer>

    <script>
function validateForm() {
    var name = document.getElementById("name").value;
    if (name.trim() === "") {
        alert("Nama peserta tidak boleh kosong!");
        return false; // Mencegah form dikirim
    }
    return true; // Lanjutkan submit jika valid
}
</script>

</body>
</html>
