<?php
session_start();
include_once 'config/koneksi.php';

if($_GET['action'] == 'login') {

    $username = mysqli_real_escape_string($konek, $_POST['username']); // Ambil value username yang dikirim dari form
    $password = mysqli_real_escape_string($konek, $_POST['password']); // Ambil value password yang dikirim dari form

    if($username == 'admin' && $password == '123') {
        $_SESSION['id'] = 0; // Set session untuk username (simpan username di session)
        $_SESSION['username'] = 'admin'; // Set session untuk username (simpan username di session)
        $_SESSION['nama'] = 'Admin'; // Set session untuk nama (simpan nama di session)
        $_SESSION['email'] = 'admin@admin.com'; // Set session untuk email (simpan email di session)
        header('Location: admin.php');
        die;
    }

    // Buat query untuk mengecek apakah ada data user dengan username dan password yang dikirim dari form
    $sql = mysqli_query($konek, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_array($sql); // Ambil datanya dari hasil query tadi

    // Cek apakah variabel $data ada datanya atau tidak
    if(!empty($data)){ // Jika tidak sama dengan empty (kosong)
        $_SESSION['id'] = $data['id']; // Set session untuk username (simpan username di session)
        $_SESSION['username'] = $data['username']; // Set session untuk username (simpan username di session)
        $_SESSION['nama'] = $data['nama']; // Set session untuk nama (simpan nama di session)
        $_SESSION['email'] = $data['email']; // Set session untuk email (simpan email di session)

        $sql = mysqli_query($konek, "SELECT * FROM profile WHERE user_id='".$_SESSION['id']."'");
        $data = mysqli_fetch_array($sql);

        if(!empty($data)){
            $_SESSION['profile'] = $data;
        }

        setcookie("message","delete",time()-1); // Kita delete cookie message

        header("location: home.php"); // Kita redirect ke halaman home.php
    }else{ // Jika $data nya kosong
        $_SESSION['error'] = "Username / Password Salah!";
        header("location: index.php"); // Redirect kembali ke halaman index.php
    }
}if($_GET['action'] == 'register') {
    $nama = mysqli_real_escape_string($konek, $_POST['nama']); // Ambil value username yang dikirim dari form
    $username = mysqli_real_escape_string($konek, $_POST['username']); // Ambil value username yang dikirim dari form
    $password = mysqli_real_escape_string($konek, $_POST['password']); // Ambil value password yang dikirim dari form
    $password_confirmation = mysqli_real_escape_string($konek, $_POST['password_confirmation']); // Ambil value password yang dikirim dari form

    if($password != $password_confirmation) {
        $_SESSION['error'] = 'Password Konfirmasi Tidak Sama!';
        header('Location: register.php');
        die;
    }

    try{
        mysqli_query($konek, "INSERT INTO user VALUES (NULL, '$username', '$password', '$nama', NULL)");
    }catch (Exception $err) {
        $_SESSION['error'] = $err->getMessage();
        header('Location: register.php');
        die;
    }

    $_SESSION['error'] = 'Berhasil Daftar, Silahkan Login.';
    header('Location: index.php');
}if($_GET['action'] == 'ubah-profil') {
    $id = $_SESSION['id'];
    $sql = mysqli_query($konek, "SELECT * FROM profile WHERE user_id = $id");
    $profil = mysqli_fetch_array($sql);

    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $status = $_POST['status'];

    $_SESSION['profile']['nama'] = $nama;
    $_SESSION['profile']['jenis_kelamin'] = $jenis_kelamin;
    $_SESSION['profile']['tanggal_lahir'] = $tanggal_lahir;
    $_SESSION['profile']['status'] = $status;
    
    if(!empty($profil)) {
        try{
            $foto = uniqid() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['foto']['tmp_name'], 'foto/' . $foto);

            mysqli_query($konek, "UPDATE profile SET foto = '$foto', jenis_kelamin = '$jenis_kelamin', tanggal_lahir = '$tanggal_lahir', status = '$status' WHERE user_id = '$id'");
            mysqli_query($konek, "UPDATE user SET nama = '$nama' WHERE id = '$id'");

            $_SESSION['nama'] = $nama;
            $sql = mysqli_query($konek, "SELECT * FROM profile WHERE user_id='".$_SESSION['id']."'");
            $data = mysqli_fetch_array($sql);

        if(!empty($data)){
            $_SESSION['profile'] = $data;
        }

            $_SESSION['error'] = 'Berhasil Mengubah Profile.';
            header('location: home.php');
            die;
        }catch(Exception $err) {
            $_SESSION['error'] = $err->getMessage();
            header('location: home.php');
            die;
        }
    }else {
        try{
            $foto = uniqid() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['foto']['tmp_name'], 'foto/' . $foto);

            mysqli_query($konek, "INSERT INTO profile VALUES (NULL, $id, '$foto', '$jenis_kelamin', '$tanggal_lahir', '$status')");
            mysqli_query($konek, "UPDATE user SET nama = '$nama' WHERE id = '$id'");

            $_SESSION['nama'] = $nama;
            $sql = mysqli_query($konek, "SELECT * FROM profile WHERE user_id='".$_SESSION['id']."'");
            $data = mysqli_fetch_array($sql);

        if(!empty($data)){
            $_SESSION['profile'] = $data;
        }

            $_SESSION['error'] = 'Berhasil Mengubah Profile.';
            header('location: home.php');
            die;
        }catch(Exception $err) {
            $_SESSION['error'] = $err->getMessage();
            header('location: home.php');
            die;
        }
    }
}else if($_GET['action'] == 'logout') {
    session_destroy();
    header('location: index.php');
    die;
}else if($_GET['action'] == 'posting') {
    try{
        $user_id = $_SESSION['id'];
        $body = mysqli_real_escape_string($konek, $_POST['body']);

        mysqli_query($konek, "INSERT INTO post VALUES (NULL, $user_id, '$body', NOW())");
        header('location: home.php');
        die;
    }catch(Exception $err) {
        $_SESSION['error'] = $err->getMessage();
        header('location: home.php');
        die;
    }
}else if($_GET['action'] == 'add-friend') {
    $friend_id = $_GET['friend_id'];
    $user_id = $_SESSION['id'];

    $data = mysqli_query($konek, "SELECT * FROM friends WHERE user_id = $user_id AND friend_id = $friend_id OR user_id = $friend_id AND friend_id = $user_id");

    if(mysqli_fetch_array($data)) {
        $_SESSION['error'] = 'Sudah Berteman!';
        header('location: home.php');
        die;
    }

    mysqli_query($konek, "INSERT INTO friends VALUES (NULL, $user_id, $friend_id)");
    $_SESSION['error'] = 'Berhasil Menambah Teman.';
    header('location: home.php');
    die;
//CRUD Admin 
}else if($_GET['action'] == 'tambah-user') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    try{
        $result = mysqli_query($konek, "INSERT INTO user VALUES (NULL, '$username', '$password', '$nama', '')");
        $_SESSION['error'] = 'Berhasil Menambahkan Data.';
        header('Location: admin.php');
    }catch (Exception $err) {
        $_SESSION['error'] = $err->getMessage();
        header('Location: admin.php');
        die;
    }
}else if($_GET['action'] == 'ubah-user') {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    try{
        $result = mysqli_query($konek, "UPDATE user SET username = '$username', password = '$password', nama = '$nama' WHERE id = $id");
        $_SESSION['error'] = 'Berhasil Mengubah Data.';
        header('Location: admin.php');
    }catch (Exception $err) {
        $_SESSION['error'] = $err->getMessage();
        header('Location: admin.php');
        die;
    }
}else if($_GET['action'] == 'hapus-user') {
    $id = $_GET['id'];

    try{
        $result = mysqli_query($konek, "DELETE FROM user WHERE id = $id");
        $_SESSION['error'] = 'Berhasil Menghapus Data.';
        header('Location: admin.php');
    }catch (Exception $err) {
        $_SESSION['error'] = $err->getMessage();
        header('Location: admin.php');
        die;
    }
}else {
    echo "<h1>403 FORBIDDEN<h1>";
}
