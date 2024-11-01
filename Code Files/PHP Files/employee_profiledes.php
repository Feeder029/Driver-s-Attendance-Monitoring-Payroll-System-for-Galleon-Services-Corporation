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

    <p> 
    
    
    
        <!-- Profile  -->
        <img src="data:image/png;base64,<?php echo $DRV["Profile"]; ?>" alt="Profile Picture" style="width: 100px; height: 100px"> 
        <h1> <?php echo "$FullName"?></h1>
        <label for="imageInput" style="cursor: pointer; color: blue; text-decoration: underline;"> Edit Profile </label>
        </p>
        <hr>
        <hr>
    

        <form method="post" action="">
        <!-- Personal & Account: JOB ONES -->
    
        <div class="Two-Textbox" >
        
        <div class="Top-Bottom">
        <h4>DRIVER ID: </h4>
        <input type="text" value="<?php echo $DRV["ID"]?>" disabled class="editable_status" id="ID" name = "DrivID">
        </div>
    
        <div class="Top-Bottom">
        <h4>UNIT TYPE: </h4>
        <input type="text" value="<?php echo $DRV["Unit"]?>" disabled>
        </div>
    
        </div>
    
        <div class="Two-Textbox">
        <div class="Top-Bottom">
        <h4> HUB: </h4>
        <input type="text" value="<?php echo $DRV["Hub"] ?>" disabled>
        <hr>
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
        
        <div class="Top-Bottom">
        <h4>Gender: </h4>
        <select name="gender" id="gender" disabled class="editable_status" name = "Gender">
            <option value="Male" <?php echo ($DRV["Gender"] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($DRV["Gender"]  == 'Female') ? 'selected' : ''; ?>>Female</option>
            <option value="Others" <?php echo ($DRV["Gender"]  == 'Others') ? 'selected' : ''; ?>>Others</option>
        </select>
    
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
        <input type="submit" name="SAVE" value="SAVE" id="save" onclick="Change()" class="editable_status" disabled/>
        
    
        </div>
        
        </div>
        </div>
        
        </form>
        <script src="../JS Files/Employee_Profile.js"></script>
    
    </html>
    </body>
</html>

