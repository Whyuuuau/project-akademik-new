<?php
require_once "config.php";
$nama = $Alamat = $JenisKelamin = "";
$nama_err = $Alamat_err = $JenisKelamin_err =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_nama = trim($_POST["nama"]);
    if (empty($input_nama)){
        $nama_err = "Please Enter A Valid Name!";
    } elseif (!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Please Enter A Valid Name!";
    } else{
        $nama = $input_nama;
    }

    $input_Alamat = trim($_POST["Alamat"]);
    if (empty($input_Alamat)){
        @$Alamat_err = "Please Enter Summary Of Alamat!";
    } else{
        $Alamat = $input_Alamat;
    }

    $input_JenisKelamin = trim($_POST["JenisKelamin"]);
    if (empty($input_JenisKelamin)){
        @$JenisKelamin_err = "Please Enter Summary Of JenisKelamin!";
    } else{
        $JenisKelamin = $input_JenisKelamin;
    }

    if (empty($nama_err) && empty($Alamat_err) && empty($JenisKelamin_err)) {
        $sql = "INSERT INTO mahasiswa_new (nama, Alamat, JenisKelamin) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_nama, $param_Alamat, $param_JenisKelamin);
            $param_nama = $nama;
            $param_Alamat = $Alamat;
            $param_JenisKelamin = $JenisKelamin;
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
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, miMahasiswa_IDum-scale=1.0">
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
                    <h2>Tambah Mahasiswa</h2>
                </div>
                <p>Silahkan Isi Form Dibawah Ini Kemudian Submit Untuk Menambahkan Data Mahasiswa</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                        <span class="help-block"><?php echo $nama_err;?></span>
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
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
