<?php  
require 'functions.php';

$inventories = query('SELECT * FROM inventori');

if( isset($_POST['cari'])){
    $inventories = cari($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventori Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Smooth transition for UI elements */
        * {
            transition: all 0.3s ease-in-out;
        }

        body {
            display: flex;
            background-color: #f8f9fa;
            color: #212529;
            height: 100vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 250px;
            background: #ffffff;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1050; /* Ensures it's above navbar */
            transition: transform 0.3s ease-in-out;
        }

        .sidebar a {
            text-decoration: none;
            color: #212529;
            display: block;
            padding: 12px;
            font-weight: bold;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #0d6efd;
            color: white;
        }

        .content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }

        /* Navbar Styling */
        .navbar {
            background: #ffffff;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Align navbar content */
        .navbar .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar form {
            flex-grow: 1; /* Make the search bar take the remaining space */
        }

        /* Table Styling */
        .table-container {
            overflow-x: auto;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .img-thumbnail {
            max-width: 60px;
            border-radius: 5px;
        }

        /* Responsive Sidebar (For Mobile) */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                position: absolute;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                width: 100%;
            }
            .menu-toggle {
                display: block;
            }
            .navbar .container-fluid {
                flex-direction: row; /* Ensure horizontal layout */
                align-items: center;
            }
        }

        /* Floating action button */
        .fab {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #0d6efd;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .fab:hover {
            background: #0b5ed7;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4 class="text-center mb-3">📦 Inventori</h4>
        <a href="feed.php">📊 Dashboard</a>
        <a href="tambah.php">➕ Tambah Inventori</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Hamburger Menu (Visible on mobile only) -->
                <button class="btn btn-outline-primary menu-toggle d-lg-none">☰</button>

                <!-- Navbar Brand -->
                <a class="navbar-brand ms-3" href="feed.php">Dashboard</a>

                <!-- Search Form (aligned to the right) -->
                <form action="feed.php" method="post" class="d-flex ms-auto">
                    <input class="form-control me-2" type="search" placeholder="Search..." name="keyword">
                    <button type="submit" class="btn btn-primary" name="cari">🔍 Search</button>
                </form>
            </div>
        </nav>

        <!-- Table -->
        <div class="table-container mt-4">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Tanggal Masuk</th>
                        <th>Keterangan</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($inventories as $index => $row): ?>
                        <tr>
                            <td><?= $index+1 ?></td>
                            <td><?= $row['nama_user'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['stok'] ?></td>
                            <td><?= $row['tanggal_masuk'] ?></td>
                            <td><?= $row['keterangan'] ?></td>
                            <td>
                                <?php 
                                $gambarArray = explode(',', $row['gambar']);
                                foreach ($gambarArray as $gambar): ?>
                                    <img src="img/<?= $gambar ?>" class="img-thumbnail">
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <a href="ubah.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Ubah</a>
                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">🗑️ Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Floating Action Button -->
    <button class="fab" onclick="location.href='tambah.php'">➕</button>

    <script>
        // Toggle Sidebar for Mobile
        document.querySelector(".menu-toggle").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("show");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
