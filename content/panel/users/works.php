<?php 
   session_start();
   
   require_once "../../../database/connect.php";
	
   // Create connection
   $connect = new mysqli($host, $db_user, $db_password, $db_name);
   mysqli_query($connect, "SET CHARSET utf8");
   mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
   
   $sort = $_SESSION['sort'];
   if($sort == ""){
      $sort = "id";
   }else if($sort == "datenew"){
      $sort = "date DESC";
   }else if($sort == "dateold"){
      $sort = "date ASC";
   }

   $login = $_SESSION['login'];
   $user_class = $_SESSION['class'];
   $user_sex = $_SESSION['sex'];
   $user_group = $_SESSION['group'];

   $sql = "SELECT * FROM works WHERE user = '$login' ORDER BY $sort";
   $result = $connect->query($sql);
?>
<style>
   .items {
      text-align: right;
      float: right;
   }

   .sended {
      background-color: #f2f2f2;
   }
   .checked {
      background-color: #d8d8d8;
   }

   .btn-w,
   .form-group {
      float: left;
      display: inline;
      margin-right: 10px;
   }

   .form-group {
      width: 150px;
   }

</style>
<div class="works-buttons">
   <button type="button" class="btn btn-outline-primary waves-effect btn-w" style="margin-right:50px;" data-toggle="modal" data-target="#addnewwork">Dodaj nowe</button>
   <!-- Modal -->
   <div class="modal fade" id="addnewwork" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Dodaj nową prace</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="./content/panel/users-php/works/add-work.php" method="post" id="anw-form">
                  <div class="form-group" style="width:100%;">
                     <label for="titleinput">Tytuł:</label>
                     <input type="text" class="form-control" name="title" id='explicit-block-txt' value='' onpaste="return false">
                     <small id="emailHelp" class="form-text text-muted">Tytuł możesz zmienić w każdej chwili</small>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
               <button type="button" class="btn btn-primary" onclick='document.getElementById("anw-form").submit();'>Stwórz nową prace</button>
            </div>
         </div>
      </div>
   </div>

   <div class="form-group">
      <select class="form-control" id="sortid">
         <option>Sortuj od:</option>
         <option value="datenew">Najnowszej</option>
         <option value="dateold">Najstarszej</option>
         <option value="status">Wysłanych</option>
      </select>
   </div>
</div><br /><br />
<hr>
<div class="container-fluid animate-bottom">
   <div class='row'>
      <?php
   if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $status = $row['status'];
        $date = $row['date'];
        $teacher = $row['teachername']; 
        $sendedbg = "";
        if($status == "wyslane"){
           $status = "Wysłane do: <b>".$teacher."</b>";
           $sendedbg = "sended";
        }else if($status == "checked"){
           $status = "Sprawdzone przez: <b>".$teacher."</b>";
           $sendedbg = "checked";  
        }
        
echo<<<END
<div id="work-card" class="col-4">
<!-- Card -->
<div class="card $sendedbg" style="margin-top:30px">

  <!-- Card content -->
  <div class="card-body">
END;
if($row['status'] != "wyslane"){
echo<<<END
    <form id="form$id" action="./content/panel/users-php/works/delete-work.php" method="POST">
       <input type="text" value="$id" name="id" style="display:none"/>
       <button type="button" onclick="delete_work($id);" class="close" aria-label="Close" data-toggle="tooltip" data-placement="top" title="Usuń">
       <i class="fas fa-trash"></i>
       </button>
    </form>
END;
}
echo<<<END
    <!-- Title -->
    <h4 class="card-title">$title</h4>
    <!-- Button -->
END;
if($row['status'] != "wyslane"){
echo<<<END
    <a href="./content/panel/users-php/works/works-edit.php?id=$id" class="btn btn-primary">Edytuj</a>
    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#sendwork$id">Wyślij</a>
END;
}else{
echo<<<END
<a href="" class="btn btn-primary" data-toggle="modal" data-target="#preview$id">Podgląd</a>

<!-- Central Modal Small -->
<div class="modal fade" id="preview$id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  
  <div class="modal-dialog modal-xl" role="document">
  <form action="./content/panel/users-php/works/send-work.php" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Podgląd pracy</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="display:contents">
         <h4 style="margin:20px auto;">$title</h4>
         <div class="form-group" style="width:60%;margin:auto;">
            <p>$content</p>
         </div>
      </div>
      <div class="modal-footer">
        <p style="display:block;position:absolute;left: 20px;">id: $id</p>
        <button type="button" class="btn btn-secondary btn" data-dismiss="modal">Zamknij</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Central Modal Small -->

END;
}
echo<<<END
    <div class="items">
       <div class="date"><small>$date</small></div>
       <div class="status"><small>$status</small></div>
    </div>
  </div>
</div>
<!-- Card -->
</div>

<!-- Central Modal Small -->
<div class="modal fade" id="sendwork$id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  
  <div class="modal-dialog" role="document">
  <form action="./content/panel/users-php/works/send-work.php" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Wyślij prace</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
         <input type="text" value="$id" name="id" style="display:none"/>
           <div class="form-group" style="width:100%;">
             <label for="exampleFormControlSelect1">Wyślij do:</label>
             <select class="form-control" name="teacher_c">
END;
         $sql_cl = "SELECT teacher, lesson, login, class_teaching FROM lessons WHERE `$user_class` = '1' AND `sex_teach` = '2' OR `sex_teach` = '$user_sex'";
         $result_cl = $connect->query($sql_cl);

         if ($result_cl->num_rows > 0) {
           // output data of each row
           while($row = $result_cl->fetch_assoc()) {
              if(strpos($row['class_teaching'], $user_class)){
               echo"<option value=".$row['login'].">".$row['teacher']." - (".$row['lesson'].")</option>";
              }
           }
         } else {
           echo "Brak nauczycieli w bazie danych";
         }
        
echo<<<END
             </select>
           </div>
           <div class="form-group" style="width:100%;">
             <label for="exampleFormControlTextarea1">Komentarz</label>
             <textarea class="form-control" name="comment" rows="10" style="min-height:200px;" onkeyup="this.value = this.value.replace(/[&*<>']/g, '')" onpaste="return false"></textarea>
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn" data-dismiss="modal">Anuluj</button>
        <button type="submit" class="btn btn-primary btn">Wyślij</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Central Modal Small -->

END;
     }
   }else{
echo<<<END

<div class="card col-12 animate-bottom">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Nie napisłeś jeszcze żadnej pracy<br /><br /><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addnewwork">Swtórz swoją pierwszą prace</button></p>
    </blockquote>
  </div>
</div>

END;
   }
?>
   </div>
</div>
<script>
   document.getElementById("explicit-block-txt").onkeypress = function(e) {
      var chr = String.fromCharCode(e.which);
      if ("></'\"".indexOf(chr) >= 0)
         return false;
   };

   function cardmedia(x) {
      var elms = document.querySelectorAll('#work-card');
      if (x.matches) { // If media query matches
         for (var i = 0; i < elms.length; i++) {
            elms[i].classList.remove('col-4');
            elms[i].classList.add('col-6');
         }
      }
      if (y.matches) {
         for (var i = 0; i < elms.length; i++) {
            elms[i].classList.remove('col-6');
            elms[i].classList.add('col-12');
         }
      }
   }

   var x = window.matchMedia("(max-width: 1300px)")
   var y = window.matchMedia("(max-width: 600px)")
   cardmedia(x) // Call listener function at run time
   x.addListener(cardmedia) // Attach listener function on state changes

   function delete_work(id) {
      Swal.fire({
         title: 'Jesteś pewny?',
         text: "Tego nie będzie można cofnąć",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Anuluj',
         confirmButtonText: 'Tak usuń!'
      }).then((result) => {
         if (result.value) {
            Swal.fire({
               title: 'Usunięto',
               text: 'Praca została usunięta',
               icon: 'success'
            }).then((result) => {
               var form = "form" + id;
               document.getElementById(form).submit();
            })
         }
      })
   }

   document.getElementById('sortid').addEventListener('change', function() {
      location.href = "?data=works&sort=" + this.value;
   });

</script>
