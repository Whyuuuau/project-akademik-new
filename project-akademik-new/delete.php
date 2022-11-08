<?php
if(isset($_POST["MahasiswaID"]) && !empty($_POST["MahasiswaID"])){
    require_once "config.php";
    $sql = "DELETE FROM mahasiswa_new WHERE MahasiswaID= ?";
    if ($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt,"i", $param_MahasiswaID);
        $param_MahasiswaID= trim($_POST["MahasiswaID"]);
        if (mysqli_stmt_execute($stmt)){
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something Went Wrong. Please Try Again Later.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else{
    if (empty(trim($_GET["MahasiswaID"]))){
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
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Record</title>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Mahasiswa</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="MahasiswaID" value="<?php echo trim($_GET["MahasiswaID"]); ?>"/>
                        <p>Anda Yakin Ingin Menghapus Data Ini?</p><br>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="index.php" class="btn btn-default">No</a>
                        </p>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
