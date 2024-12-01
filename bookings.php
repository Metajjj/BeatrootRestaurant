<?php session_start()?>

        <?php 
    error_reporting(0);
            $_SESSION['Log out'] = $_POST['Logout'];
            //print_r($_SESSION); //
            if ($_POST['Logout']){ //Nothing = false
                 header("Location: index.php");//Redirect?
            }else{}
    error_reporting(E_ALL & ~E_NOTICE);
        ?>

<html>
    <head>
        <title>BeatRoot</title>
        <link rel=stylesheet href="style.css">
    
        <style>   
           form{
                padding: 0;
                box-shadow: none;
                margin:4px 0;
                width: auto;
                height: auto;                
            }
        
            body{
                background-image: linear-gradient(45deg, #862be2, blue, #862be2);
                padding-top: 20px;
            }
         
            #Frm{width: 80%; height: auto;
            background-color: transparent;
            box-shadow: 0px 0px 15px 3px;
            padding: 10px;margin: auto;
            }
            
            #Frm{
                display: grid;
                grid-template-areas: "ID CF CS CN TN DoA De";
                
                grid-template-columns: 1fr repeat(5,2fr) 1fr;
                grid-template-rows: 1.35fr 1fr; /*Only takes true effect when div#Frm is full*/
                
                grid-gap: 2px 0px; /*rows / col*/
                grid-auto-flow: row;
            }
            
            #Frm div{border: 1px dashed orange; padding-left: 5px;}
            
            #Return{
                margin-left:10px;
            }
            
            
        </style>
        
    </head>
    <body>
        <?php
        $mySQLi = mysqli_connect("localhost",'root','WBDB','beatroot restaurant'); //specifies database and user
        $Query = "SELECT * FROM bookings"; //specifies SQL command and table
            
        $Results = mysqli_query($mySQLi,$Query); //Puts returned results into a variable
        //echo"Results:<br>" ;
        //print_r($Results);
        //print_r($Results -> num_rows);
        
        $rows=[];
        while ($row = mysqli_fetch_array($Results)){
            $rows[]=$row;
        }


        //print_r($rows);

        ?>

        <a id="Return" style="background-color:orangered;" href=index.php>Return/Logout</a>

        <!--
        <?php echo'<p>Test<br>
            type="hidden" input name="Username" value="'.$_SESSION['User'].'"
            <br>
            type="hidden" input name="Password" value="'.$_SESSION['Pass'].'"
            </p>
        ';?>
        ->
        <?php
            echo"<pre>";
            print_r($_SESSION);
            echo"<pre>"
        ?>
        -->
        
        <div id="Frm">
                <div class="TH" style="grid-area:ID">ID</div>
                <div class="TH" style="grid-area:CF">Customer Forename</div>
                <div class="TH" style="grid-area:CS">Customer Surname</div>
                <div class="TH" style="grid-area:CN">Contact Number</div>
                <div class="TH" style="grid-area:TN">Table Number</div>
                <div class="TH" style="grid-area:DoA">Date of Appointment</div>
                <div class="TH" style="grid-area:De">Deletion Option</div>
            
            <?php
            error_reporting(0);
                $Delete = '<div>Delete '.$i[0].':id </div>';
                /*'<div>
                <form action="" method="POST">
                    <input type="hidden" value="'.$i[0].'" name="ID">
                    <input type="submit" value="Delete">
                </form>
                </div>';*/
            error_reporting(E_ALL & ~E_NOTICE);
                foreach ($rows as $i){ //$i = each individual table row
                    $cnt=0;
                    echo "<div>".$i[$cnt++]."</div> <div>".$i[$cnt++]."</div> <div>".$i[$cnt++]."</div> <div>".$i[$cnt++]."</div> <div>".$i[$cnt++]."</div> <div>".$i[$cnt++]."</div>
                    <div>
                <form action='' method='POST'>
                    <input type='hidden' value='".$i[0]."' name='ID'>
                    <input class='But' type='submit' value='Delete'>
                </form>
                </div>";
                }
            ?>  
        </div>
        
        <form action="" class="SELECT" method="POST" style="margin: auto;margin-top: 20px; width: 80%;">
            <input type="text" name="Forename" placeholder="Forename" required pattern="[A-Z]{1}[a-z]+" title="letters only & capitalise, its a name">
            <input type="text" name="Surname" placeholder="Surname" required pattern="[A-Z]{1}[a-z]+" title="letters only & capitalise, its a name">
            <input type="text" name="Contact" placeholder="032" required pattern="[+\d()] *\d+[-). ]*\d+[-). ]*\d+" title="Contact number! Allowed Formats: xxx-xxx-xxxx|xxxxxxxxxx|x xxx xxx xxxx|(xxx)xxxxxxx|xxx.xxx.xxxx|+xx xxxxx|+xxxxxxx">
            <input type="text" name="Table" placeholder="1" required pattern="[0-9]+" title="Integers only">
            <input type="text" name="DoA" placeholder="DD/MM/YYYY" required pattern="((29\/0*2)|([0-2]*[0-8]|3[0-1])\/(0*\d|1[0-2]))\/(20)?\d{2}" title="{D/M/Y}; 29days for February only; YYYY = 20xx or YY = xx; MM = 0-1x or M = x; DD=1-3x or D = x">
            
            <br><input class='But' type="submit" placeholder="Insert into database">
        </form>
        
        <!hr>
        
        <!--Delete =  DELETE FROM 'bookings' WHERE 'bookings'.'Id'='??'-->
        
        <!hr>
        <?php
                          
            if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['ID'])){
                //echo"POSTY IDY";
                
                $Query = "DELETE FROM bookings WHERE Id=".$_POST['ID'].";";
                //echo $Query;
                mysqli_query($mySQLi,$Query);
                
                //mysqli_close($mySQLi);
                
            }
        
            else if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['Forename'])||isset($_POST['Surname'])){
                $Query = "";
                $DoA = $_POST['DoA'];    //format DoA
                //echo $DoA."<br>";
                
                $DoA = "1/1/11";
                //echo substr($DoA,1,1);
                if (substr($DoA,1,1) == '/'){ //Makes sure Day is DD
                    $DoA = "0".$DoA;
                }
                //echo $DoA ."<br>";
                //echo substr($DoA,4,1);

                /*
                echo substr($DoA,0,3);
                echo "0";
                echo substr($DoA,3);
                */

                if (substr($DoA,4,1) == '/'){ //Makes sure Month is MM
                    $DoA = substr($DoA,0,3)."0".substr($DoA,3);
                }
                //echo $DoA."<br>";

                //echo strlen($DoA);
                //echo substr($DoA,-2);

                if (substr($DoA,-3,1) == '/'){ //Makes sure Year is YY
                    $DoA = substr($DoA,0,-2)."20".substr($DoA,-2);
                }
                //echo $DoA;
                $_POST['DoA'] = $DoA;
                
                //Safening data
                    $_POST['Forename'] = htmlspecialchars(trim($_POST['Forename']));
                    $_POST['Surname'] = htmlspecialchars(trim($_POST['Surname']));
                    $_POST['Contact'] = htmlspecialchars(trim($_POST['Contact']));
                    $_POST['Table'] = htmlspecialchars(trim($_POST['Table']));
                    $_POST['DoA'] = htmlspecialchars(trim($_POST['DoA']));
                //Safening data
                    
                    echo "<pre>";
                    $Query = "INSERT INTO bookings (`ID`,`First name`,`Last name`,`Contact number`,`Table number`,`Date of booking`) VALUES
                    (NULL,'".$_POST['Forename']."','".$_POST['Surname']."','".$_POST['Contact']."','".$_POST['Table']."','".$_POST['DoA']."');";
                
                    //print($Query);
                
                    echo "</pre>";
                
                    mysqli_query($mySQLi,$Query);
                
                //mysqli_close($mySQLi);
                    
            }
            
        ;?>
        
        <?php 
        
            $Update = "<p style='text-align:center;font-size:100px;
            text-shadow: 0px 0px 3px, 1px 1px 3px, 2px 2px 3px, 4px 2px 3px;
            '>UPDATING..</p>";
        
            //echo $Update;
                
                
            //echo"<hr>Affected rows: ",mysqli_affected_rows($mySQLi);
            if (mysqli_affected_rows($mySQLi) == 1){ //Can only insert or delete 1 row a time, SELECT* grabs more
                echo "<head> <meta http-equiv='Refresh' content='3'> </head>"; //Forces a refresh
                echo $Update;
            }
        
            mysqli_close($mySQLi);
                
        ?>
        
    </body>
    <script>
            document.getElementById("Frm").style.minHeight = screen.height * 0.26;
    </script>
</html>












