<?php
require_once "config.php";
$Nama = $Alamat = $JenisKelamin = "";
$Nama_err = $Alamat_err = $JenisKelamin_err = "";
if (isset($_POST["MahasiswaID"]) && !empty($_POST["MahasiswaID"])) {
    $MahasiswaID = $_POST["MahasiswaID"];
    $input_Nama = trim($_POST["Nama"]);
    if (empty($input_Nama)) {
        $Nama_err = "Please Enter A Valid Name!";
    } elseif (!filter_var($input_Nama, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $Nama_err = "Please Enter A Valid Name!";
    } else {
        $Nama = $input_Nama;
    }

    $input_Alamat = trim($_POST["Alamat"]);
    if (empty($input_Alamat)) {
        @$Alamat_err = "Please Enter Summary Of Alamat!";
    } else {
        $Alamat = $input_Alamat;
    }

    $input_JenisKelamin = trim($_POST["JenisKelamin"]);
    if (empty($input_JenisKelamin)) {
        @$JenisKelamin_err = "Please Enter Summary Of JenisKelamin!";
    } else {
        $JenisKelamin = $input_JenisKelamin;
    }

    if (empty($Nama_err) && empty($Alamat_err) && empty($JenisKelamin_err)){
        $sql = "UPDATE mahasiswa_new SET Nama=?, Alamat=?, JenisKelamin=? WHERE MahasiswaID=? ";
        if ($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_Nama, $param_Alamat, $param_JenisKelamin, $MahasiswaID);
            $param_Nama = $Nama;
            $param_Alamat = $Alamat;
            $param_JenisKelamin = $JenisKelamin;
            $param_MahasiswaID = $MahasiswaID;
            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
                exit();
            } else {
                echo "Something Went Wrong. Please Try Again Later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($con);
} else{
    if (isset($_GET["MahasiswaID"]) && !empty(trim($_GET["MahasiswaID"]))){
        $MahasiswaID = trim($_GET["MahasiswaID"]);
        $sql = "SELECT * FROM mahasiswa_new WHERE MahasiswaID = ?";
        if ($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_MahasiswaID);
            $param_MahasiswaID = $MahasiswaID;
            if (mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $Nama = $row["Nama"];
                    $Alamat = $row["Alamat"];
                    $JenisKelamin = $row["JenisKelamin"];
                } else{
                    header("location: error.php");
                    exit();
                }
            } else{
                echo "Oops! Something Went Wrong. Please Try Again Later.";
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else{
        header("location: error.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, miMahasiswaIDum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h2>Update Mahasiswa</h2>
            </div>
            <p>Silahkan Isi Form Dibawah Ini Kemudian Submit Untuk Update Data Mahasiswa</p>
            <form action="<?php echo htmlspecialchars(basename($_SERVER["REQUEST_URI"])); ?>" method="post">
                <div class="form-group <?php echo (!empty($Nama_err)) ? 'has-error' : ''; ?>">
                    <label>Nama</label>
                    <input type="text" name="Nama" class="form-control" value="<?php echo $Nama; ?>">
                    <span class="help-block"><?php echo $Nama_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($Alamat_err)) ? 'has-error' : ''; ?>">
                    <label>Alamat</label>
                    <input type="text" name="Alamat" class="form-control" value="<?php echo $Alamat; ?>">
                    <span class="help-block"><?php echo $Alamat_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($JenisKelamin_err)) ? 'has-error' : ''; ?>">
                    <label>Jenis Kelamin</label>
                    <input type="text" name="JenisKelamin" class="form-control" value="<?php echo $JenisKelamin; ?>">
                    <span class="help-block"><?php echo $JenisKelamin_err;?></span>
                </div>
                <input type="hidden" name="MahasiswaID" value="<?php echo $MahasiswaID; ?>"/>
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
