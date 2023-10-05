<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        window.addEventListener('load', function(){
        
        });

        function deleteContent(){
        
            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this imaginary file!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                swal("Poof! Your imaginary file has been deleted!", {
                  icon: "success",
                });
                return willDelete;
              } else {
                return willDelete;
              }
            });
        }
        </script>
</head>
<body>
    <a onclick = "return deleteContent()">Delete</a>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
.swal2-deny{
  color: white !important;
    background-color: red !important;
}

.swal2-confirm{
  background-color: #11d0e9 !important;
  color: white !important;
  box-shadow: none !important;
}

.swal-footer{
  text-align: center;
}
      </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

    <script>
        window.addEventListener('load', function(){
        });
        
        function pop(){
          swal.fire({
  title: 'Are you 18 years or older?',
  showDenyButton: true,
  showCancelButton: false,
  confirmButtonText: `Yes`,
  denyButtonText: `No`,
  allowOutsideClick: false,
}).then((result) => {
  if (result.isConfirmed) {
    <?php $_SESSION['age_confirm'] = "Yes_18"; ?>
  //  swal.close();
  } if (result.isDenied) {
   <?php $_SESSION['age_confirm'] = "No_18"; ?>
    // window.history.go(-1);
  }
});
        
        }

        //   .then((willDelete) => {
        //     if (willDelete) {
        //       document.getElementById("main_div").style.display = "block";
        //     } else {
        //       document.getElementById("main_div").style.display = "none";
        //     }
        //   });
       
        </script>
</head>

<?php
      if(isset($_SESSION['age_confirm']) && $_SESSION['age_confirm'] == "Yes_18"){
      ?>
      <script>
  swal.close();
        </script>
      <?php
      }
      else if(isset($_SESSION['age_confirm']) && ($_SESSION['age_confirm'] == "No_18" || $_SESSION['age_confirm'] == '')){
      ?>
         <script>
  pop();
        </script>
      <?php
      }
      ?>




<body>
<div id="main_div">
<h1> Hello User.</h1>
<br>
<h3>Welcome to our website.</h3>
      </div>
</body>
</html>