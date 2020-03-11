<?php

session_start();

if(!isset($_SESSION['Cxyzwet']))
 {
   header('location:index.php');
 };

require 'db/config.php';

$IMemoID=$_GET['m-id'];

$Queryer ="SELECT * FROM imemo_images WHERE IMemoMID='$IMemoID' ORDER BY IMEMIMGID ASC";
$Resulter = $conn->query($Queryer);
 

$MAX_C= "SELECT (SELECT COUNT(*) FROM imemo_images WHERE IMemoMID='$IMemoID') AS MEMMAX";
$MXRESULT = $conn->query($MAX_C);
$MXROW = $MXRESULT->fetch_assoc();
$MXROW=$MXROW['MEMMAX']+1;

if(isset($_POST['update']))
{


$uq = $IMemoID.$MXROW;
$target_dir = "../uploads/memo-image/"; //directory details


$imageFileType = pathinfo($_FILES["mimage"]["name"],PATHINFO_EXTENSION); //image type(png or jpg etc)

$SupportedImage = array('gif', 'jpg', 'jpeg','png');

if (in_array($imageFileType, $SupportedImage)) {


$target=$target_dir.$uq.time().'.'.$imageFileType;
$target_file = $uq.time().'.'.$imageFileType; //full path

if (move_uploaded_file($_FILES["mimage"]["tmp_name"], $target)) {

$Query="INSERT INTO imemo_images(IMemoMID, MMImages) VALUES('$IMemoID', '$target_file')";

if ($conn->query($Query) === TRUE) {


header("location:memo-images.php?m-id=$IMemoID");

}

else
{

echo "<script language='javascript'>alert('Error Try Again')</script>";

}

}

else
{

echo "<script language='javascript'>alert('Upload Error')</script>";

}

}

else
{

echo "<script language='javascript'>alert('Unsupported File Type')</script>";

}



};




?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Internal | Circulars & Policies</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>

<?php include 'partials/sidebar.php'?>

      <div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Circulars & Policies</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Circulars & Policies Images</h4>
                  </div>


                

                  <div class="card-body">

                   <form method="POST"  enctype="multipart/form-data">


                    <div class="row">

                    <?php while($Rower = $Resulter->fetch_assoc())
                    {
                    ?>

                    <div class="col-sm-3 col-md-3">

                    <img src="../uploads/memo-image/<?php echo $Rower['MMImages']; ?>" width="200"><br><br>
                    <a href="delete-memimage.php?mimg-id=<?php echo $Rower['IMEMIMGID']; ?>" onclick="return confirm('Are you sure?')"><p><strong>Delete</strong></p></a>

                    </div>

                    <?php }; ?>
                      

                    </div><br><br>


                    <div class="form-group row mb-4">


                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Update Image (Size: 600 * 900 Px)</label>
                      
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="mimage" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary" type="submit" name="update">Update</button>
                      </div>
                    </div>

                  </form>
                  </div>

                </div>
              </div>
            </div>

        </section>

      </div>


  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
