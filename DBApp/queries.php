<?php

// reading function, retrieves data from database\
date_default_timezone_set("America/Los_Angeles");

function read(){
    include "conn.php";
    
    $query2 = "SELECT * FROM orders ORDER BY date";    
    $read = mysqli_query($connection, $query2); 

    return $read;
}

// Runs the table of orders to display in the main page
function runTable(){
    include "conn.php";
    $read = read();
    ?>
       <div>
        <?php 
        // Echos HTML table by retrieving order data frm the database       
        echo "<table><tr><th class='idcell'> ID </th><th class='idcell'> Invoice </th><th class='idcell'> Printer </th><th class='name'> Name </th><th> Description </th><th class='date'> Date Created </th><th class='date'> Due Date </th><th class='delth'> Delete </th></tr>";
        while($row = mysqli_fetch_assoc($read)) {
            echo "<tr><td class='idcell'>" . $row['id'] .
                 "</td><td class='idcell'>" . $row['invoice'] .   
                 "</td><td class='idcell'>" . $row['printer'] .                
                 "</td><td class='name'>" . $row['name'] .
                 "</td><td>". $row['description'] . 
                 "</td><td class='date'>". $row['date_created'] . "</td>";
            
            $date1 = date_create(date("Y-m-d"));        ;
            $duedate = date_create($row['date']);
            // $diff = $duedate - $date1;
            $diff = date_diff($date1, $duedate);
            $diff = $diff->format('%R%a');
            
            // If due date is in the past it will be highlighted in black
            // If order is due within less than 1 day, date cell will be highlighted in red
            // If order is due within less than 3 days, date cell will be highlighted in orange
            // If order is due within less than 5 days, date cell will be highlighted in yellow     
            
            if ($diff < 0){
                echo "<td class='date black'>". $row['date'] . "</td>";
            } elseif ($diff < 1){
                echo "<td class='date red'>". $row['date'] . "</td>";  
            } else if ($diff <= 3){
                echo "<td class='date orange'>". $row['date'] . "</td>";                  
            } else if ($diff <= 5){
                echo "<td class='date yellow'>". $row['date'] . "</td>";  
            } else {
                echo "<td class='date'>". $row['date'] . "</td>"; 
            }
            
            // Delete button
            echo "<td class=\"del\"><a href='delete.php?id=". $row['id'] ."'>X</a></td></tr>";
                         
        }
        
        echo "</table>";
                
        ?>
    </div>
    <?php
}




?>