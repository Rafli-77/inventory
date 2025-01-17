<?php 
require 'functions.php';

// Ambil data dari URL
$id = $_GET['id'];

// Query data inventori berdasarkan ID
$inventori = query("SELECT * FROM inventori WHERE id = $id")[0];

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'feed.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'feed.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Styled file input */
        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            text-align: center;
            background: #e9ecef;
            font-weight: bold;
        }

        .custom-file-label:hover {
            background: #dee2e6;
        }

        /* Image preview styling */
        .gallery-item img {
            max-width: 100px;
            border-radius: 5px;
            margin: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center mb-4">Edit Inventori</h3>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $inventori['id']; ?>">
        <input type="hidden" name="gambarLama" value="<?= $inventori['gambar']; ?>">

        <div class="mb-3">
            <label for="nama_user" class="form-label">Nama User:</label>
            <input type="text" class="form-control" name="nama_user" id="nama_user" required value="<?= $inventori['nama_user']; ?>">
        </div>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang:</label>
            <input type="text" class="form-control" name="nama_barang" id="nama_barang" required value="<?= $inventori['nama_barang']; ?>">
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok:</label>
            <input type="number" class="form-control" name="stok" id="stok" required value="<?= $inventori['stok']; ?>">
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan:</label>
            <textarea class="form-control" name="keterangan" id="keterangan" required><?= $inventori['keterangan']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini:</label> <br>
            <div class="d-flex flex-wrap">
                <?php $gambarArray = explode(',', $inventori['gambar']); ?>
                <?php foreach ($gambarArray as $gambar): ?>
                    <div class="gallery-item">
                        <img src="img/<?= $gambar ?>" class="img-thumbnail">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Gambar Baru:</label>
            <input type="file" name="gambar[]" id="gambar" class="custom-file-input" multiple required>
            <label for="gambar" class="custom-file-label">Pilih Gambar</label>
        </div>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    // File input label update
    document.getElementById('gambar').addEventListener('change', function() {
        let fileNames = [...this.files].map(file => file.name).join(', ');
        this.nextElementSibling.innerText = fileNames || 'Pilih Gambar';
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
