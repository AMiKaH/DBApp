<?php 
     include "conn.php";
     include "queries.php";     
     $read = read();
 
 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3D SMITH Database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <!-- The form to input order information -->
     <div class="container">       
           <form action="db.php" method="post" class="center_div">                  
                <input type="text" autofocus name="name" placeholder="Customer Name">             
                <input type="text" name="description" placeholder="Description">                  
                <input type="text" name="invoice" placeholder="Invoice#">              
                <input type="date" name="date" placeholder="Due Date">
                <label for="fdm"><input type="radio" name="printer" value="FDM">FDM</label>
                <label for="sla"><input type="radio" name="printer" value="SLA">SLA</label><br/>               
                <input class="btn btn-sm btn-danger" type="submit" name="submit" value="Add Order">
           </form>           
   </div>
   <img class="logo" src="./img/logo.png" alt="LOGO" width="200px">
   <div>
        <?php runTable(); ?>
    </div>
      
    <div id="warnings">
       
   <?php  
    date_default_timezone_set("America/Los_Angeles");
    if (isset($_POST['submit'])){
        if (isset($_POST['printer'])){
            $printer = $_POST['printer'];            
        } else {
            $printer = "N/A";
        }        

        $name = $_POST['name'];
        $desc = $_POST['description'];
        $date = $_POST['date'];
        $invoice = $_POST['invoice'];
        $dateCreated = date_create(date("Y-m-d"));
        $dateCreated = $dateCreated->format('Y-m-d');  


        // in case of unauthorized access to the db page, this will prevent SQL injection.
        $name = mysqli_real_escape_string($connection, $name);
        $desc = mysqli_real_escape_string($connection, $desc);
        
        
        
        $datein = date_create($date);
        $now = date_create(date("Y-m-d"));    
        $result = $datein->format('Y-m-d');
 
                 
        include "conn.php";        
        $checkName = mysqli_query($connection, "SELECT * FROM orders WHERE name='$name'"); 
        $checkDesc = mysqli_query($connection, "SELECT * FROM orders WHERE description='$desc'");

        // Checks if the name AND order description exist in database
        // If an entry contains a name and a description that exist in DB an error message will pop up
        // Avoiding duplicate entries. 
        // Also checks if name is empty
        if(mysqli_num_rows($checkName) > 0 && mysqli_num_rows($checkDesc) > 0) {
            if (trim($name) == "") {            
                echo "Name cannot be empty!";
            } else {
                echo "Entry already exists!";  
            }
                        
        // Before entry, checks if name is empty then if due date is in the past
        } else {
            if (trim($name) == "") {            
                echo "Name cannot be empty!";
            } elseif ($now > $datein){
                echo "Date cannot be in the past!";
            } elseif (!$date){
                echo "Date cannot be empty";
            } elseif (!$printer) {
                $printer = "N/A";
            }else {
                
                $query = "INSERT INTO  orders(name, invoice, printer, description, date_created, date)";
                $query .= "VALUES('$name', '$invoice', '$printer', '$desc', '$dateCreated', '$date')";          
                $insert = mysqli_query($connection, $query); 
                echo "<meta http-equiv=\"refresh\" content=\"0\">";
                
            }
 
        }

    }    
    ?>
    </div>
    
    
    <footer><p>&copy; Copyright **** STUDIOS 2016-<?php echo date("Y") . " "?></p></footer> 

</body>
</html>