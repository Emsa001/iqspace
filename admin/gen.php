<?php
/*
   session_start();

   $host = "evelinka99.atthost24.pl";
   $db_user = "5795";
   $db_password = 'Hy44#AB@xqQWg';

   $connect = new mysqli($host, $db_user, $db_password, '5795_100school');
   mysqli_query($connect, "SET CHARSET utf8");
   mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

   $sql = "SELECT * FROM teachers";
   $result = $connect->query($sql);
echo "<script>let accs = [];</script>";

       function genacc(){
echo<<<END

<script>
    function randn(){
     return Math.floor(Math.random()*9000) + 10000;
    } 
     function makeid(length) {
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for ( var i = 0; i < length; i++ ) {
         result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
     }
   for(var i = 0; i < 200 ; i++){
           var s = 100 + '' + randn();
       if(!accs.includes(s)){
         console.log(i + 1+ '.' + s + ':' + makeid(8));
           accs.push(s);
       }
   }
</script>

END;
       }

   if ($result->num_rows > 0) {
      function rand_str() {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $randomstr = '';
         for ($i = 0; $i < random_int(8, 10); $i++) {
            $randomstr .= $characters[rand(0, strlen($characters) - 1)];
         }
         return $randomstr;
      }
      for($i = 0; $i < 10; $i++){
       echo rand_str().' - '.md5(rand_str()).'<br />';  
      }
       while($row = $result->fetch_assoc()) {
          
          $login = "100".rand(10000,99999);
          if($row['login'] == $login){
             echo "Jest już takie konto<br />";
          }else{
            if($row['login'] == ''){
               $pass = rand_str();
               $passmd5 = md5($pass);
               $sql2 = "UPDATE teachers SET login='$login', password='$passmd5' WHERE login = '' LIMIT 1";
               if ($connect->query($sql2) === TRUE) {
                 echo $row['name']." ".$row['surname'].' - '.$login.":".$pass."<br />";  
               } else {
                 echo "Error updating record: " . $conn->error;
               }
            }  
          }
       }
   } else {
       echo "0 results";
   }
*/

?>