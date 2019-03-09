
<?php
 @session_start();
                    require_once 'db.php';
                $id=$_POST["id"];
                $pwd=$_POST["password"];
                $name=$_POST["name"];


                /*echo "<p>ID: ".$id."</p>";
                echo "<p>Password: ".$pwd."</p>";
                echo "<p>Name: ".$name."</p>";*/


                //Insert Data
                $sql = "INSERT INTO member (id, pwd, name)
                VALUES ('".$id."', '".$pwd."', '".$name."')";
                //echo "<p>".$sql."</p>";

                if (mysqli_query($_SESSION['link'] , $sql)) {
                    echo "<script type='text/javascript'>";
                    echo "window.alert('創建成功，將跳轉至登入頁面');";
                    echo "window.location.href='member.html'";
                    echo "</script>"; 
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($_SESSION['link']);
                }

                ?>