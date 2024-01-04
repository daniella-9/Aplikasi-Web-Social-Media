<?php 
    session_start();
    require_once "func/isHasError.php";
    require_once "func/isNotLogin.php";
    require_once "config/koneksi.php";
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link rel="stylesheet" href="css/home.css">
<div class="container">
<div class="row">
<div class="col-sm-12">
<div>
<div class="content social-timeline">
<div class="">

<div class="row">
<div class="col-md-12">
    <div class="social-wallpaper">
        <div class="profile-hvr">
            <i class="icofont icofont-ui-edit p-r-10"></i>
            <i class="icofont icofont-ui-delete"></i>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-xl-3 col-lg-4 col-md-4 col-xs-12">
    <div class="social-timeline-left">
        <div class="card">
            <div class="social-profile">
                <img class="img-fluid width-100" src="<?= isset($_SESSION['profile']) ? 'foto/' . $_SESSION['profile']['foto'] : 'https://bootdey.com/img/Content/avatar/avatar7.png' ?>" alt="">
                <div class="profile-hvr m-t-15">
                    <i class="icofont icofont-ui-edit p-r-10"></i>
                    <i class="icofont icofont-ui-delete"></i>
                </div>
            </div>
            <div class="card-block social-follower">
                <h4><?= $_SESSION['nama'] ?></h4>
                <h5><?= isset($_SESSION['profile']) ? $_SESSION['profile']['status'] : '-' ?></h5>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-header-text">Teman Anda</h5>
            </div>
            <div class="card-block user-box">

                <?php 
                    $user_id = $_SESSION['id'];
                    $result1 = mysqli_query($konek, "SELECT u.nama, u.id as id_user, p.*
                    FROM friends AS f
                    LEFT JOIN user AS u ON f.user_id = u.id
                    LEFT JOIN profile AS p ON u.id = p.user_id
                    WHERE f.user_id = $user_id OR f.friend_id = $user_id");
                    $result2 = mysqli_query($konek, "SELECT u.nama, u.id as id_user, p.*
                    FROM friends AS f
                    LEFT JOIN user AS u ON f.friend_id = u.id
                    LEFT JOIN profile AS p ON u.id = p.user_id
                    WHERE f.user_id = $user_id OR f.friend_id = $user_id");
                    while($row = mysqli_fetch_array($result1)) :
                        if($row['id_user'] != $user_id) :
                ?>

                            <div class="media m-b-10">
                                <a class="media-left" href="#!">
                                    <img class="media-object img-radius" src="<?= (isset($row['user_id'])) ? 'foto/' . $row['foto'] : 'https://bootdey.com/img/Content/avatar/avatar2.png' ?>" alt="Generic placeholder image" data-toggle="tooltip" data-placement="top" title="" data-original-title="user image">
                                </a>
                                <div class="media-body">
                                    <div class="chat-header"><?= $row['nama'] ?></div>
                                    <div class="text-muted social-designation"><?= (isset($row['user_id'])) ? $row['status'] : '-' ?></div>
                                </div>
                            </div>

                <?php 
                        endif;
                    endwhile;
                ?>

                <?php 
                    while($row = mysqli_fetch_array($result2)) :
                        if($row['id_user'] != $user_id) :
                ?>

                            <div class="media m-b-10">
                                <a class="media-left" href="#!">
                                    <img class="media-object img-radius" src="<?= (isset($row['user_id'])) ? 'foto/' . $row['foto'] : 'https://bootdey.com/img/Content/avatar/avatar2.png' ?>" alt="Generic placeholder image" data-toggle="tooltip" data-placement="top" title="" data-original-title="user image">
                                </a>
                                <div class="media-body">
                                    <div class="chat-header"><?= $row['nama'] ?></div>
                                    <div class="text-muted social-designation"><?= (isset($row['user_id'])) ? $row['status'] : '-' ?></div>
                                </div>
                            </div>

                <?php 
                        endif;
                    endwhile;
                ?>
                
            </div>
        </div>
    </div>

</div>
<div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 ">

    <div class="card social-tabs">
        <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Timeline</a>
                <div class="slide"></div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#about" role="tab">Profil</a>
                <div class="slide"></div>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="friendLink" data-toggle="tab" href="#friends" role="tab">Friends</a>
                <div class="slide"></div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="proses.php?action=logout">Logout</a>
                <div class="slide"></div>
            </li>
        </ul>
    </div>

    <div class="tab-content">

        <div class="tab-pane active" id="timeline">
            <div class="row">
                <div class="col-md-12 timeline-dot">
                <div class="container bg-white rounded mb-3 p-4 border" style="width: 750px; margin: 0 0 0 auto;">
                    <div class="media">
                        <div class="media-body">
                            <form action="proses.php?action=posting" method="post">
                                <textarea rows="5" cols="5" class="form-control" name="body" placeholder="Write Something here..."></textarea>
                                <div class="text-right m-t-20"><button type="submit" class="btn btn-primary waves-effect waves-light mt-3">Post</button></div>
                            </form>
                        </div>
                    </div>
                </div>

                    <?php 
                        $temp = array();
                        $result1 = mysqli_query($konek, "SELECT u.nama, u.id as id_user, p.foto, p2.*, p2.id as p_id
                        FROM friends AS f
                        LEFT JOIN user AS u ON f.friend_id = u.id
                        LEFT JOIN profile AS p ON u.id = p.user_id
                        INNER JOIN post AS p2 ON u.id = p2.user_id
                        WHERE f.user_id = $user_id OR f.friend_id = $user_id
                        GROUP BY p2.id
                        ORDER BY p2.tanggal DESC");
                        while($row = mysqli_fetch_array($result1)) :
                            array_push($temp, $row['p_id']);
                    ?>
                
                                <div class="social-timelines p-relative">
                                    <div class="row timeline-right p-t-35">
                                        <div class="col-2 col-sm-2 col-xl-1">
                                            <div class="social-timelines-left">
                                                <img class="img-radius timeline-icon" src="<?= (isset($row['foto'])) ? 'foto/' . $row['foto'] : 'https://bootdey.com/img/Content/avatar/avatar7.png' ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="col-10 col-sm-10 col-xl-11 p-l-5 p-b-35">
                                            <div class="card">
                                                <div class="card-block post-timelines">
                                                    <div class="chat-header f-w-600"><?= $row['nama'] ?> memposting sesuatu</div>
                                                    <div class="social-time text-muted"><?= $row['tanggal'] ?></div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="timeline-details">
                                                        <p class="text-muted"><?= $row['body'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    <?php endwhile; ?>

                    <?php 
                        $result1 = mysqli_query($konek, "SELECT u.nama, u.id as id_user, p.foto, p2.*, p2.id as p_id
                        FROM friends AS f
                        LEFT JOIN user AS u ON f.user_id = u.id
                        LEFT JOIN profile AS p ON u.id = p.user_id
                        INNER JOIN post AS p2 ON u.id = p2.user_id
                        WHERE f.user_id = $user_id OR f.friend_id = $user_id
                        GROUP BY p2.id
                        ORDER BY p2.tanggal DESC");
                        while($row = mysqli_fetch_array($result1)) :
                            if(!in_array($row['p_id'], $temp)) :
                    ?>
                
                        <div class="social-timelines p-relative">
                            <div class="row timeline-right p-t-35">
                                <div class="col-2 col-sm-2 col-xl-1">
                                    <div class="social-timelines-left">
                                        <img class="img-radius timeline-icon" src="<?= (isset($row['foto'])) ? 'foto/' . $row['foto'] : 'https://bootdey.com/img/Content/avatar/avatar2.png' ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-10 col-sm-10 col-xl-11 p-l-5 p-b-35">
                                    <div class="card">
                                        <div class="card-block post-timelines">
                                            <div class="chat-header f-w-600"><?= $row['nama'] ?> memposting sesuatu</div>
                                            <div class="social-time text-muted"><?= $row['tanggal'] ?></div>
                                        </div>
                                        <div class="card-block">
                                            <div class="timeline-details">
                                                <p class="text-muted"><?= $row['body'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php 
                        endif;
                        endwhile; 
                    ?>

                </div>
            </div>
        </div>

        <!-- about -->
        <div class="tab-pane" id="about">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Informasi Biodata</h5>
                            <button id="edit-btn" type="button" class="btn btn-warning waves-effect waves-light f-right float-right"  data-toggle="modal" data-target="#ubahProfile">
                                <i class="fa fa-edit"> Ubah</i>
                            </button>
                        </div>
                        <div class="card-block">
                            <div id="view-info" class="row">
                                <div class="col-lg-6 col-md-12">
                                    <form>
                                        <table class="table table-responsive m-b-0">
                                            <tbody>
                                                <tr>
                                                    <th class="social-label b-none p-t-0">Nama Lengkap
                                                    </th>
                                                    <td class="social-user-name b-none p-t-0 text-muted"><?= $_SESSION['nama'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="social-label b-none">Jenis Kelamin</th>
                                                    <td class="social-user-name b-none text-muted"><?= (isset($_SESSION['profile'])) ? $_SESSION['profile']['jenis_kelamin'] : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="social-label b-none">Tanggal Lahir</th>
                                                    <td class="social-user-name b-none text-muted"><?= (isset($_SESSION['profile'])) ? $_SESSION['profile']['tanggal_lahir'] : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="social-label b-none">Status</th>
                                                    <td class="social-user-name b-none text-muted"><?= (isset($_SESSION['profile'])) ? $_SESSION['profile']['status'] : '-' ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ubahProfile" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahProfileLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahProfileLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="proses.php?action=ubah-profil" method="post" id="ubahProfilForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" accept="image/png,image/jpg,image/jpeg">
                    </div>
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= $_SESSION['nama'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option <?= (isset($_SESSION['profile']) && $_SESSION['profile']['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option <?= (isset($_SESSION['profile']) && $_SESSION['profile']['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="<?= (isset($_SESSION['profile'])) ? $_SESSION['profile']['tanggal_lahir'] : '' ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option <?= (isset($_SESSION['profile']) && $_SESSION['profile']['status'] == 'Online') ? 'selected' : '' ?>>Online</option>
                            <option <?= (isset($_SESSION['profile']) && $_SESSION['profile']['status'] == 'Avalible') ? 'selected' : '' ?>>Avalible</option>
                            <option <?= (isset($_SESSION['profile']) && $_SESSION['profile']['status'] == 'Unavalible') ? 'selected' : '' ?>>Unavalible</option>
                            <option <?= (isset($_SESSION['profile']) && $_SESSION['profile']['status'] == 'Offline') ? 'selected' : '' ?>>Offline</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="ubahProfilForm" class="btn btn-warning">Ubah</button>
            </div>
            </div>
        </div>
        </div>

        <div class="tab-pane" id="photos">
            <div class="card">

                <div class="card-block">
                    <div class="demo-gallery">
                        <ul id="profile-lightgallery" class="row">
                            <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12">
                                <a href="#" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="img-fluid" alt="">
                                </a>
                            </li>
                            <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12">
                                <a href="#" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="img-fluid" alt="">
                                </a>
                            </li>
                            <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12">
                                <a href="#" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="img-fluid" alt="">
                                </a>
                            </li>
                            <li class="col-md-4 col-lg-2 col-sm-6 col-xs-12">
                                <a href="#" data-toggle="lightbox" data-title="A random title" data-footer="A custom footer text">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar4.png" class="img-fluid" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane" id="friends">
            <div class="container bg-white rounded mb-3 p-4 border">
                <form action="home.php">
                    <div class="input-group">
                        <input type="text" name="key" class="form-control" placeholder="Search friends...">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="row">

            <?php 
                if(isset($_GET['key'])) : 
                $key = $_GET['key'];
                $result = mysqli_query($konek, "SELECT user.nama, user.id AS id_user, profile.*
                FROM user
                LEFT JOIN profile ON profile.user_id = user.id
                LEFT JOIN friends f1 ON f1.user_id = user.id
                LEFT JOIN friends f2 ON f2.friend_id = user.id
                WHERE
                    user.nama LIKE '%$key%'
                    AND user.id != $user_id
                    AND NOT EXISTS (
                        SELECT 1
                        FROM friends
                        WHERE
                            (user_id = $user_id AND friend_id = user.id)
                            OR (friend_id = $user_id AND user_id = user.id)
                    );");
                while($row = mysqli_fetch_array($result)) :
            ?>
                
                <div class="col-lg-12 col-xl-6">
                    <div class="card">
                        <div class="card-block post-timelines">
                            <div class="media bg-white d-flex">
                                <div class="media-left media-middle">
                                    <a href="#">
                                        <img class="media-object" width="120" src="<?= (isset($row['user_id'])) ? 'foto/' . $row['foto'] : 'https://bootdey.com/img/Content/avatar/avatar2.png' ?>" alt="">
                                    </a>
                                </div>
                                <div class="media-body friend-elipsis">
                                    <div class="f-15 f-bold m-b-5"><?= $row['nama'] ?></div>
                                    <?php if(isset($row['user_id'])) : ?>
                                        <div class="text-muted social-designation">Jenis Kelamin: <?= $row['jenis_kelamin'] ?></div>
                                        <div class="text-muted social-designation">Status: <?= $row['status'] ?></div>
                                        <div class="text-muted social-designation">Tanggal Lahir: <?= $row['tanggal_lahir'] ?></div>
                                    <?php else: ?>
                                        <div class="text-muted social-designation">Belum Menyetel Profil</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="proses.php?action=add-friend&friend_id=<?= $row['id_user'] ?>" class="btn btn-outline-primary waves-effect btn-block mt-2"><i class="icofont icofont-ui-user m-r-10"></i> Add as Friend</a>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
            <?php else: ?>
                
            <?php endif; ?>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <?php if(isset($_GET['key'])) : ?>
            <script>
                friendLink.click();
            </script>
        <?php endif; ?>
    </body>
</html>