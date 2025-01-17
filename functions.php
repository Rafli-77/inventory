<?php 

$conn = mysqli_connect("localhost", "root", "", "tugasweb6_inventori"); //3307

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;
    
    $nama_user = htmlspecialchars($data['nama_user']);
    $nama_barang = htmlspecialchars($data['nama_barang']);
    $stok = htmlspecialchars($data['stok']);
   
    $keterangan = htmlspecialchars($data['keterangan']);
    

    //upload gambar
    $gambarArray = upload();
    if(!$gambarArray){
        return false;
    }
    // Convert array of file names to a comma-separated string
    $gambar = implode(',', $gambarArray);
    

    $query = "INSERT INTO inventori (nama_user, nama_barang, stok,  keterangan, gambar) 
VALUES ('$nama_user','$nama_barang', '$stok',  '$keterangan', '$gambar')";

    
    mysqli_query($conn, $query);
    

    return mysqli_affected_rows($conn);


         
}


function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM inventori WHERE id = $id");
    return mysqli_affected_rows($conn);
}


function upload(){
    $uploadedFiles = $_FILES['gambar']; // Get the uploaded files array

    $uploadedFileNames = []; // Array to store the uploaded file names

    foreach ($uploadedFiles['name'] as $key => $name) {
        $ukuranFIle = $uploadedFiles['size'][$key];
        $error = $uploadedFiles['error'][$key];
        $tmpName = $uploadedFiles['tmp_name'][$key];

        // Skip if there's no file uploaded
        if($error === 4){
            continue;
        }

        // Check if the uploaded file is an image
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4', 'webm', 'ogg'];
        $ekstensiGambar = pathinfo($name, PATHINFO_EXTENSION);
        $ekstensiGambar = strtolower($ekstensiGambar);

        if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
            echo "<script>alert('File $name is not an image!');</script>";
            continue;
        }

        // Check if the file size is too large
        if($ukuranFIle > 100000000){
            echo "<script>alert('File $name is too large!');</script>";
            continue;
        }

        // Generate a unique file name
        $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

        // Move the uploaded file to the destination folder
        if(move_uploaded_file($tmpName, 'img/' . $namaFileBaru)){
            $uploadedFileNames[] = $namaFileBaru; // Store the file name
        }
    }

    return $uploadedFileNames; // Return an array of uploaded file names
}

function ubah($data){
    global $conn;

    $id = $data["id"];
    
    $nama_user = htmlspecialchars($data['nama_user']);
    $nama_barang = htmlspecialchars($data['nama_barang']);
    $stok = htmlspecialchars($data['stok']);
   
    $keterangan = htmlspecialchars($data['keterangan']);
    
    $gambarLama = htmlspecialchars($data['gambarLama']);

    //cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    } else{
        $gambarArray = upload();
        $gambar = implode(',', $gambarArray);
        
    }
   

    $query = "UPDATE inventori SET
                nama_user = '$nama_user',
                nama_barang = '$nama_barang',
                stok = '$stok',
                
                keterangan = '$keterangan',
                gambar = '$gambar'
            WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}



function cari($keyword){
    // SELECT DISTINCT inventori.id, inventori.title, inventori.content, inventori.gambar, userinfo.username, userinfo.profile_picture
    //       FROM inventori
    //       INNER JOIN userinfo ON inventori.user_email = userinfo.user_email

    //tambahkan ke versi 2
    $query = "SELECT * FROM inventori  
              WHERE  inventori.nama_user LIKE '%$keyword%'
                 OR inventori.nama_barang LIKE '%$keyword%'
                 
          ";

    return query($query);
}







?>