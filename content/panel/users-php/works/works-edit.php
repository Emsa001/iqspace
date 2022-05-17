<?php
   session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ./index.php');
		exit();
	}


   require_once "../../../../database/connect.php";

   $connect = @new mysqli($host, $db_user, $db_password, $db_name);
   mysqli_query($connect, "SET CHARSET utf8");
   mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

   $id =  $_GET['id'];
   $sql = "SELECT * FROM works WHERE id = $id";
   $result = $connect->query($sql);

   if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
       $title = $row['title'];
       $content = $row['content'];
     }
   }else{
      header('Location: ../../../../school.php?data=works');
   } 
?>



<!DOCTYPE html>
<html>

<head>
   <script src="https://cdn.tiny.cloud/1/jg10lpa0k78v21o4ja4sr9ukpgl6kipsc3ggq1n53qu2pa6x/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
   <!-- CSS only -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

   <!-- JS, Popper.js, and jQuery -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
   <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

   <style>
      input {
         width: 800px;
         background-color: #fcfcfc;
         border: 0;
         border-bottom: 2px solid lightgrey;
         padding: 10px;
      }

      .mob {
         display: none;
      }

      @media only screen and (max-width: 1000px) {
         .comp {
            display: none;
         }

         input {
            width: 100%;
         }

         .mob {
            display: block;
         }
      }

   </style>

</head>

<body>
   <hr>
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../../../szkola.php">Strona główna</a></li>
            <li class="breadcrumb-item"><a href="../../../../szkola.php?data=works">Prace</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
         </ol>
      </nav>
      <hr>
      <form action="./save-work.php" method="post" id="sform">
         <button type="button" onclick="save();" class="btn btn-outline-success comp" style="float:right;">Zapisz</button>
         <input type="text" value="<?php echo $title;?>" style="margin:auto;display:block;margin-bottom:20px;" placeholder="Tytuł" name="title" id='explicit-block-txt' value='' onpaste="return false"/>
         <input type="text" name="id" value="<?php echo $id;?>" style="display:none" />
         <textarea rows="50 auto" cols="75" name="content"><?php echo $content;?></textarea>
         <button type="button" onclick="save();" class="btn btn-outline-success mob" style="width:100%;margin: 50px 0 50px 0">Zapisz</button>
      </form>
   </div>
   <script>
      document.getElementById("explicit-block-txt").onkeypress = function(e) {
         var chr = String.fromCharCode(e.which);
         if ("></'\"".indexOf(chr) >= 0)
            return false;
      };

    tinymce.init({
      selector: 'textarea',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
    });

      function save() {
         Swal.fire({
            title: 'Zapisano',
            icon: 'success'
         }).then((result) => {
            if (result.value) {
               document.getElementById("sform").submit();
            }
         })
      }

   </script>
</body>

</html>
