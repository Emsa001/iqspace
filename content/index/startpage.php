<?php 
   session_start(); 


	$host = "evelinka99.atthost24.pl";
	$db_user = "5795_adm_iqspace";
	$db_password = "Ej024iduTXPIt";
	$db_name = "5795_adm_iqspace";
   // Create connection
   $connect = new mysqli($host, $db_user, $db_password, $db_name);
   mysqli_query($connect, "SET CHARSET utf8");
   mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

   //GLOBAL
   $sql = "SELECT * FROM adm_startpage";
   $result = $connect->query($sql);

   $sql_p1 = "SELECT * FROM adm_startpage WHERE `type` = 'post1'";
   $result_p1 = $connect->query($sql_p1);

   $sql_p2 = "SELECT * FROM adm_startpage WHERE `type` = 'post2'";
   $result_p2 = $connect->query($sql_p2);
?>
        <div class="container animate-bottom">

		  
<?php 
   if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
       $post_type = $row['type'];
       $post_title = $row['title'];
       $post_small_title = $row['small_title'];  
       $post_content = $row['content'];
       $post_date= $row['date'];
        
        
       if($post_type == "jumbotron"){
echo<<<END
<div class="jumbotron p-4 p-md-5 text-white rounded bg-dark startpage-bigbanner">
   <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">$post_title</h1>
      <p class="lead my-3">$post_content</p>
      <p class="lead mb-0"><a href="#" class="text-white font-weight-bold" onclick="onas()" style="text-decoration:underline">$post_date</a></p>
   </div>
</div>

END;
       }
     }
   }
   if ($result_p1->num_rows > 0) {
     // output data of each row
     echo"<div class='row mb-2'>";
     while($row_p1 = $result_p1->fetch_assoc()) {
       $post_title_p1 = $row_p1['title'];
       $post_small_title_p1  = $row_p1['small_title'];  
       $post_content_p1  = $row_p1['content'];
       $post_date_p1 = $row_p1['date'];
       
echo<<<END
   <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
         <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary">$post_title_p1</strong>
            <h3 class="mb-0">$post_small_title_p1</h3>
            <div class="mb-1 text-muted">$post_content_p1</div>
            <p class="card-text mb-auto">$post_date_p1</p>
         </div>
         <div class="col-auto d-none d-lg-block">
            <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Kulibrus</title><rect width="100%" height="100%" fill="#55595c"></rect></svg>
         </div>
      </div>
   </div>
END;
        
     }
      echo"</div>";
   }
?>

			