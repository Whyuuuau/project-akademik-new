<?php
if(isset($_GET["MahasiswaID"]) && !empty(trim($_GET["MahasiswaID"]))){
require_once "config.php";
$sql = "SELECT * FROM mahasiswa_new WHERE MahasiswaID = ?";

if($stmt = mysqli_prepare($con,$sql)){
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    $param_id = trim($_GET["MahasiswaID"]);

    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $Nama = $row["Nama"];
            $MahasiswaID = $row["MahasiswaID"];
            $Alamat = $row["Alamat"];
            $JenisKelamin = $row["JenisKelamin"];
        } else{
            header("location: error.php");
            exit();
        }
    
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else{
  header("location: error.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>View Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 800px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>Data Mahasiswa</h1>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <p class="form-control-static"><?php echo $row["Nama"]; ?></p>
                        </div>
                        <div class="form-group">
                            <label>MahasiswaID</label>
                            <p class="form-control-static"><?php echo $row["MahasiswaID"]; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <p class="form-control-static"><?php echo $row["Alamat"]; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <p class="form-control-static"><?php echo $row["JenisKelamin"]; ?></p>
                        </div>
                        <div class="form-group">
                        <p><a href="index.php" class="btn btn-primary">Back</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>