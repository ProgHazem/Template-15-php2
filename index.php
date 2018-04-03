<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php echo '<h1>Guest Book</h1>';
              echo '<hr />';
                define("SER_Name", "localhost");
                define("USER_Name", "root");
                define("Pass", "");
                define("DB_Name", "guestbook");
                $conn = mysqli_connect(SER_Name,USER_Name,Pass,DB_Name);
                if ($conn) {
                //    echo 'Selecting Database Is Ok';
                    $quer = mysqli_query($conn, "SELECT * FROM guestbook");
                    $query_rows = mysqli_num_rows($quer);
                    if ($query_rows > 0) {
                        if (!$quer){
                //        echo 'Query is Not Ok!!'. mysqli_error($conn);
                     }
                     while ($row = mysqli_fetch_assoc($quer)) {
                         $id = $row['id']; 
                         $name =  $row['name'];
                         //$name_lo = strtolower($name);
                         $email = $row['email'];
                         //$email_up = strtoupper($row['email']);
                         /*$len = strlen($email);
                         $i = 0;
                         while ($i < $len){
                             $x = substr($email, $i, 1);
                             if ($x != '@'){
                                 $email = 'Incorrect Email';
                             }
                             $i++;
                         }*/
                         $message = $row['message'];
                         $message_30 = substr($message, 0, 30);
                         $message_30 .= nl2br(strip_tags($message));
                         $date = $row['date'];
                         $time = $row['time'];
                         if($id%2 == 0){
                             $col = '#69F3AD';
                         } else {
                            $col = "#FFFFFF";
                         }
                         $pass = strrev($name). strrev(substr($email, 0, 5));
                         echo "<table border=0 bgcolor='$col'>"
                         . '<tr><td><b>Posted By : '.$name. "[$email] on [$date] at [$time]"."<br/>"."your Password is: $pass".'</b></td></tr>'
                         .'<tr><td>'."$message".'</td></tr>'
                         .'<br>'
                                 . '</table>';
                //         echo "$id - $name - $email - $message - $date - $time";
                     }
                    } else {
                        echo 'You Are The First Visitor';
                    }
                     
                     $submit = isset($_POST['submit']);
                     if ($submit){
                        $name = htmlspecialchars($_POST['name']);
                        if (!$name){
                            //echo 'Please Enter Your Name!';
                        }elseif (is_numeric($name)) {
                            //echo 'Please Enter Valid Name Without Number!';
                        }elseif (strlen($name)<7) {
                            //echo 'Please Enter Your Name Grater than 7 char';
                        }
                        $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
                        $message = htmlspecialchars($_POST['message']);
                        $date = date('y-m-d');
                        $time = date("h:i:s");
                        if (isset($name)&&isset($email)&&isset($message)){
                            $emaillower = strtolower($email);
                            $sql = "INSERT INTO guestbook (name, email, message, date, time)VALUES ('$name', '$email', '$emaillower', '$date', '$time')";

                            if (mysqli_query($conn, $sql)) {
                                echo 'Please Wait few Second... '
                                . '<meta http-equiv="refresh" content="5"';
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }                            
                        }else{
                            echo 'Please Enter This Feilds';
                        }
                     }
                }
                                            mysqli_close($conn);


              echo '<hr />';
              #FORM CODE
            $mainpage = $_SERVER['PHP_SELF']; 
            echo '<form method="POST" action="index.php">';
                         echo '<table border=0 width=100%>'
                         . '<tr><td width=15%>Enter Your Name:</td><td><input type="text" name="name" maxlength="40" required /></td></tr>'
                         . '<tr><td width=15%>Enter Your Email:</td><td><input type="email" name="email" maxlength="40" required/></td></tr>'
                         . '<tr><td valign="top" width=15%>Enter Your Message:</td><td><textarea name="message" cols="25" rows="4" required></textarea></td></tr>'
                         . '<tr><td valign="top" width=15%></td><td><input type="submit" name="submit" value="POST" />&nbsp;&nbsp;<input type="reset" name="reset" value="CLEAR" /></td></tr>'
                         .'</table>' 
                         .'</form>';
        ?>
    </body>
</html>
