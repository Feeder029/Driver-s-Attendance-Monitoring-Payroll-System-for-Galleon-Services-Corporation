<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/employeeprofile.css">
    <title> EMPLOYEE PROFILE </title>
</head>

<body>
    <?php
    include("employee_profile.php");
    ?>

   <form method="post" id="profileform" enctype="multipart/form-data">
    <!-- Profile  -->
    <img src="data:image/png;base64,<?php echo $DRV["Profile"]; ?>" alt="Profile Picture" style="width: 100px; height: 100px"> 
    <h1> <?php echo "$FullName"; ?></h1>
    <label for="image" style="cursor: pointer; color: blue; text-decoration: underline;">Edit Profile</label>
    <input type="file" name="profile" id="image" accept="image/*" style="display: none;">
    <input type="hidden" name="id" value="profileform">
    <hr>
    <hr>
   </form>

     

        <form method="post" name="id" id="Personal&Account">
        <!-- Personal & Account: JOB ONES -->
    
        <div class="Two-Textbox" >
        
        <div class="Top-Bottom">
        <h4>DRIVER ID: </h4>
        <input type="text" value="<?php echo $DRV["ID"]?>" disabled class="editable_status" id="ID" name = "DrivID">
        </div>
    
        <div class="Top-Bottom">
        <h4>UNIT TYPE: </h4>
        <select class="editable_status" name="unittype" disabled>
        <?php 
        for ($i = 0; $i < count($UnitTypes); $i++) {
            $selectedunit = ($DRV["Unit"] == $UnitTypes[$i]) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($UnitTypesID[$i]) . '"' . $selectedunit . '>' . htmlspecialchars($UnitTypes[$i]) . '</option>';
        }
        ?>
        </select>
        </div>
    
        </div>
    
        <div class="Two-Textbox">
        <div class="Top-Bottom">
        <h4> HUB: </h4>
        <select class="editable_status" name="hub" disabled>
        <?php 
        for ($i = 0; $i < count($Hub); $i++){
            $selectedunit =  ($DRV["Hub"] == $Hub[$i]) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($HubID[$i]) . '"' . $selectedunit . '>' . htmlspecialchars($Hub[$i]) . '</option>';
        }
        ?>
        </select>
        </div>
        </div>
    

        <hr>
    
        <!-- Personal & Account: PERSON -->
    
        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status">
        <h4>FIRST NAME: </h4>
        <input type="text" value="<?php echo $DRV["FN"] ?>" disabled class="editable_status"  name = "FirstName">
        </div>
    
        <div class="Top-Bottom" class="editable_status">
        <h4>LAST NAME: </h4>
        <input type="text" value="<?php echo $DRV["LN"] ?>" disabled class="editable_status" name = "LastName">
        </div>
    
        </div>
    
        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status">
        <h4>MIDDLE NAME: </h4>
        <input type="text" value="<?php echo $DRV["MN"] ?>" disabled class="editable_status"  name = "Middle">
        </div>
    
        <div class="Top-Bottom" class="editable_status">
        <h4>SUFFIX: </h4>
        <input type="text" value="<?php echo $DRV["SFX"] ?>" disabled class="editable_status" name = "Suffix">
        </div>
    
        </div>
        
        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status">
        <h4>AGE: </h4>
        <input type="text" value="<?php echo $DRV["Age"] ?>" disabled class="editable_status"  name = "Age">
        </div>
    
        <div class="Top-Bottom" class="editable_status">
        <h4>DOB: </h4>
        <input type="date" value="<?php echo $DRV["DOB"] ?>" disabled class="editable_status" name = "DOB">
        </div>
    
        </div>



        <div class="Two-Textbox">
        
        <div class="Top-Bottom">
        <h4>Gender: </h4>
        <select  id="gender" disabled class="editable_status" name="gender">
            <option value="Male" <?php echo ($DRV["Gender"] == 'Male') ? 'selected' : ''; ?> >Male</option>
            <option value="Female" <?php echo ($DRV["Gender"]  == 'Female') ? 'selected' : ''; ?> >Female</option>
            <option value="Others" <?php echo ($DRV["Gender"]  == 'Others') ? 'selected' : ''; ?> >Others</option>
        </select>
    
        </div>
        </div>
    
        <hr>
        
        <!-- Personal & Account: Address -->


        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status">
        <h4>PROVINCE: </h4>
        <select  disabled class="editable_status" name="province">
        <option value= "<?php echo $DRV["Province"] ?>"> <?php echo $DRV["Province"] ?> </option>
        </select>        
        </div>
    
        <div class="Top-Bottom" class="editable_status">
        <h4>CITY: </h4>
        <select disabled class="editable_status" name="city">
        <option value= "<?php echo $DRV["City"] ?>"> <?php echo $DRV["City"] ?> </option>
        </select>        
        </div>
    
        </div>

        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status">
        <h4> BARANGAY: </h4>
        <select  disabled class="editable_status" name="barangay">
        <option value= "<?php echo $DRV["Brgy"] ?>"> <?php echo $DRV["Brgy"] ?> </option>
        </select>        
        </div>
    
        <div class="Top-Bottom" class="editable_status">
        <h4> STREET: </h4>
        <input type="text" value="<?php echo $DRV["Street"] ?>" disabled class="editable_status"  name = "Street">
        </div>
    
        </div>

        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status">
        <h4> LOT NO: </h4>
        <input type="text" value="<?php echo $DRV["Lot"] ?>" disabled class="editable_status"  name = "Lot">   
        </div>
    
        <div class="Top-Bottom" class="editable_status">
        <h4> HOUSE NO: </h4>
        <input type="text" value="<?php echo $DRV["House"] ?>" disabled class="editable_status"  name = "House">
        </div>
    
        </div>

        <div class="Two-Textbox">

        <h4> ZIP CODE: </h4>
        <input type="text" value="<?php echo $DRV["Zip"] ?>" disabled class="editable_status"  name = "Zip">
        </div>
        </div>

        <hr>

        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status">
        <h4> GCASH NO: </h4>
        <input type="text" value="<?php echo $DRV["GC_NO"] ?>" disabled class="editable_status"  name = "GcashNo">   
        </div>
    
        <div class="Top-Bottom" class="editable_status">
        <h4> GCASH NAME: </h4>
        <input type="text" value="<?php echo $DRV["GC_Name"] ?>" disabled class="editable_status"  name = "GcashName">
        </div>
    
        </div>

        <hr>

    
        <!-- Personal & Account: Account -->
    
        <div class="Top-Bottom">
        <h4> Username: </h4>
        <input type="text" value="<?php echo $DRV["USER"]  ?>" class="editable_status" name = "User" disabled>
        </div>
    
        <div class="Top-Bottom">
        <h4> Password: </h4>
        <input type="password" value="<?php echo $DRV["PASS"] ?>" class="editable_status" disabled name = "Password">
        </div>
    
        <hr>
    
        <!-- Personal & Account: Account -->
    
        <div class="Two-Textbox">
        
        <div class="Top-Bottom">
        <input type="button" name="EDIT" value="EDIT" id="edit"/>
        </div>
    
        <div class="Top-Bottom">
        </div>
        <input type="submit" name="SAVE" value="SAVE" id="save" class="editable_status" disabled/>

        <input type="hidden" name="id" value="Personal&Account">
    
        </div>
        
        </div>
        </div>
        
        </form>

        <script src="../JS Files/Employee_Profile.js"></script>
    
    </html>
    </body>
</html>

