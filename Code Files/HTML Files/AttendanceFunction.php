<?php
   // Database connection details
   $db_server = "localhost";
   $db_user = "root";
   $db_pass = "";
   $db_name = "gsc_attendanceandpayroll4.0";

   // Create connection
   $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());

   //join query
   $sql = "
       SELECT
           i.DI_ProfileImage,
           n.DN_FName,
           n.DN_MName,
           n.DN_LName,
           n.DN_Suffix,
           d.DEL_ID,
           d.DEL_ParcelCarried,
           d.DEL_ParcelDelivered,
           d.DEL_ParcelReturned,
           d.DEL_RemittanceReciept,
           t.ATT_Date,
           a.ATT_ID,
           h.hub_Name

       FROM
           attendance a
       JOIN
           delivery_information d ON a.ATT_DeliveryID = d.DEL_ID
       JOIN
           driver_information i ON a.ATT_DriverID = i.DI_ID
       JOIN
           driver_name n ON i.DI_NameID = n.DN_ID
       JOIN
           attendance_date_type t ON a.ADT_ID = t.ADT_ID
       JOIN
           hub h ON i.DI_HubAssignedID = h.hub_ID
       ORDER BY t.ATT_Date DESC";


       $result = $conn->query($sql); 
?>