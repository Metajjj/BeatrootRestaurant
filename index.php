<?php session_start()?>
<html>
    <head>
        <title>BeatRoot</title>
        <link rel=stylesheet href="style.css">
        
    <style>
        
        body{padding-top: 20px;}
        
        #Frm{width:50%;
            margin: auto;
            box-shadow: 1px 1px 3px 3px;}
        
        form{
            min-width: 2px;
            height: auto;
            box-shadow: none;
        }
        
        #Intro .But{margin-right: 110px; }
        
        .centralise{
            text-align: center;
        }
        
        .forward form{
            min-width:2px;
            margin: auto;
            /*figure out how to make forms same row*/
        }
        
        ..centralise form, input{border:2px red dotted;}
        
    </style>
        
</head>

    <body>
        <?php
        $mySQLi = mysqli_connect("localhost",'root','WBDB','beatroot restaurant'); //specifies database and user
        $Query = "SELECT * FROM users"; //specifies SQL command and table

            
        $Results = mysqli_query($mySQLi,$Query); //Puts returned results into a variable
        
        mysqli_close($mySQLi);
        //echo"Results:<br>" ;
        //print_r($Results);
        //print_r($Results -> num_rows);
        
        echo"<pre>";
        $rows=[];
        while ($row = mysqli_fetch_array($Results)){
            $rows[]=$row;
        }
         //Clean way of putting results into object arrays
        //print_r($rows);
        //echo"<br>";
        //$i=0;
        //print($rows[$i++]['Username']." ".$rows[$i++]['Username']); //Successfully prints username, turn into function
        //secho"<br>";
        
        error_reporting(0);
            $_POST['Username'] = htmlspecialchars(trim($_POST['Username']));
            $_POST['Password'] = htmlspecialchars(trim($_POST['Password']));
        error_reporting(E_ALL & ~E_NOTICE);

        foreach ($rows as $a => $key){
            //print($key['Username']); //prints out every username iteratally.
        /*    print_r($key);print_r($_POST);
            print($key['Username'] ." vs ". $_POST['Username']);echo"<hr>"; //$key value appearing twice??
         */   
            //$key === "" or 1==1; doesnt work.. sql injection proof?
            if ($key['Username'] === $_POST['Username'] && $key['Password'] === $_POST['Password']){
                $_SESSION['User'] = $_POST['Username'];
                $_SESSION['Pass'] = $_POST['Password'];
                break;
                //print("Session Data added;"); //it works, session not being affected??
            } else{
                $_SESSION=[];
            }
            
        }

        //print($_SESSION['User']);
        echo"</pre>";
        //echo"<hr>";
        //print_r($_POST);
        //print_r($_SESSION);
        ?>
        
        <div class="centralise" id="Frm">
            
                <br>
                <?php
                error_reporting(0);
                if ($_SESSION['User'] == ""){
                    echo"<p>Confirm identity before being granted the assossiated priveledges.</p>";
                }
                else{
                    echo"
                                        
                        <p style='margin-bottom:0px;'>Welcome ".$_SESSION['User']."!</p>
                        <hr style='width:120px;'>
                        <div class='Forward'>
                        <form method='POST' action='bookings.php'>
                            <input type='hidden' value='".$_SESSION['User']."' name='Username'>
                            <input type='hidden' value='".$_SESSION['Pass']."' name='Password'>
                            <input type='hidden' value='' name='Logout'>
                            <input class='But' type='submit' value='Proceed!'>
                        </form>
                        
                        <form method='POST' action='bookings.php'>
                            <input type='hidden' value='' name='Username'>
                            <input type='hidden' value='' name='Password'>
                            <input type='hidden' value='true' name='Logout'>
                            <input class='But' type='submit' value='Log out'>
                        </form>
                        </div>
                                      
                    ";
                }
                error_reporting(E_ALL & ~E_NOTICE);
                ?>
            
                <hr>
            <form action="" method="POST" id="Intro">
                <label for=Un>Username:</label>
                <input id="Un" type="text" placeholder="Username" name="Username">
                <br><br>
                <label for=Ps>Password:</label>
                <input id="Ps" type="password" placeholder="P@s$w0rD" name="Password">
                <br><br>
                <input class="But" type="submit" value="Login" style="margin-left: 120px;">
            </form>
        </div>
    
    </body>
        
    <script>
            document.getElementById("Frm").style.maxHeight = screen.height * 0.66;
            document.getElementById("Intro").style.maxHeight = screen.height * 0.5;
    </script>
    
</html>

