<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS Files/employeeprofile.css?v=1.1">
    <title> EMPLOYEE PROFILE </title>
</head>

<body>
    <?php
    include("employee_profile.php");
    ?>

    <section id="Profile_Sec">

    <form method="post" id="profileform" enctype="multipart/form-data">
    <!-- Profile  -->
    <img src="data:image/png;base64,<?php echo $DRV["Profile"]; ?>" alt="Profile Picture" style="width: 300px; height: 300px"> 
    <h1> <?php echo "$FullName"; ?></h1>
    <label for="image" style="cursor: pointer; color: blue; text-decoration: underline;">Edit Profile</label>
    <input type="file" name="profile" id="image" accept="image/*" style="display: none;">
    <input type="hidden" name="id" value="profileform">
    <hr>
   </form>

    </section>


    <section id="Option">
    <div class="Two-Textbox">
        <button type="button" id="Personal&Account_Btn"> PERSONAL&ACCOUNT </button>
        <button type="button" id="Vehicles_Btn"> VEHICLES </button>
        <button type="button" id="Contacts_Btn"> CONTACTS </button>
        <button type="button" id="GovInfo_Btn"> GOVERNMENT INFO </button>
    </div>
    <hr>
</section>

<section id="Personal&Account_Section" class="content-section">

<form method="post" name="id" id="Personal&Account" action="employee_perandacc.php">
        <!-- Personal & Account: JOB ONES -->
    
        <div class="Two-Textbox" >
        
        <div class="Top-Bottom">
        <h4>DRIVER ID: </h4>
        <input type="text" value="<?php echo $DRV["ID"]?>" disabled class="editable_status_P-A" id="ID" name = "DrivID">
        </div>
    
        <div class="Top-Bottom">
        <h4>UNIT TYPE: </h4>
        <select class="editable_status_P-A" name="unittype" disabled>
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
        <select class="editable_status_P-A" name="hub" disabled>
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
        
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>FIRST NAME: </h4>
        <input type="text" value="<?php echo $DRV["FN"] ?>" disabled class="editable_status_P-A"  name = "FirstName">
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>LAST NAME: </h4>
        <input type="text" value="<?php echo $DRV["LN"] ?>" disabled class="editable_status_P-A" name = "LastName">
        </div>
    
        </div>
    
        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>MIDDLE NAME: </h4>
        <input type="text" value="<?php echo $DRV["MN"] ?>" disabled class="editable_status_P-A"  name = "Middle">
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>SUFFIX: </h4>
        <input type="text" value="<?php echo $DRV["SFX"] ?>" disabled class="editable_status_P-A" name = "Suffix">
        </div>
    
        </div>
        
        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>AGE: </h4>
        <input type="text" value="<?php echo $DRV["Age"] ?>" disabled class="editable_status_P-A"  name = "Age">
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>DOB: </h4>
        <input type="date" value="<?php echo $DRV["DOB"] ?>" disabled class="editable_status_P-A" name = "DOB">
        </div>
    
        </div>



        <div class="Two-Textbox">
        
        <div class="Top-Bottom">
        <h4>Gender: </h4>
        <select  id="gender" disabled class="editable_status_P-A" name="gender">
            <option value="Male" <?php echo ($DRV["Gender"] == 'Male') ? 'selected' : ''; ?> >Male</option>
            <option value="Female" <?php echo ($DRV["Gender"]  == 'Female') ? 'selected' : ''; ?> >Female</option>
            <option value="Others" <?php echo ($DRV["Gender"]  == 'Others') ? 'selected' : ''; ?> >Others</option>
        </select>
    
        </div>
        </div>
    
        <hr>
        
        <!-- Personal & Account: Address -->


        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>PROVINCE: </h4>
        <select  disabled class="editable_status_P-A" name="province">
        <option value= "<?php echo $DRV["Province"] ?>"> <?php echo $DRV["Province"] ?> </option>
        </select>        
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>CITY: </h4>
        <select disabled class="editable_status_P-A" name="city">
        <option value= "<?php echo $DRV["City"] ?>"> <?php echo $DRV["City"] ?> </option>
        </select>        
        </div>
    
        </div>

        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4> BARANGAY: </h4>
        <select  disabled class="editable_status_P-A" name="barangay">
        <option value= "<?php echo $DRV["Brgy"] ?>"> <?php echo $DRV["Brgy"] ?> </option>
        </select>        
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4> STREET: </h4>
        <input type="text" value="<?php echo $DRV["Street"] ?>" disabled class="editable_status_P-A"  name = "Street">
        </div>
    
        </div>

        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4> LOT NO: </h4>
        <input type="text" value="<?php echo $DRV["Lot"] ?>" disabled class="editable_status_P-A"  name = "Lot">   
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4> HOUSE NO: </h4>
        <input type="text" value="<?php echo $DRV["House"] ?>" disabled class="editable_status_P-A"  name = "House">
        </div>
    
        </div>

        <div class="Two-Textbox">

        <h4> ZIP CODE: </h4>
        <input type="text" value="<?php echo $DRV["Zip"] ?>" disabled class="editable_status_P-A"  name = "Zip">
        </div>
        </div>

        <hr>

        <div class="Two-Textbox">
        
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4> GCASH NO: </h4>
        <input type="text" value="<?php echo $DRV["GC_NO"] ?>" disabled class="editable_status_P-A"  name = "GcashNo">   
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4> GCASH NAME: </h4>
        <input type="text" value="<?php echo $DRV["GC_Name"] ?>" disabled class="editable_status_P-A"  name = "GcashName">
        </div>
    
        </div>

        <hr>

    
        <!-- Personal & Account: Account -->
    
        <div class="Top-Bottom">
        <h4> Username: </h4>
        <input type="text" value="<?php echo $DRV["USER"]  ?>" class="editable_status_P-A" name = "User" disabled>
        </div>
    
        <div class="Top-Bottom">
        <h4> Password: </h4>
        <input type="password" value="<?php echo $DRV["PASS"] ?>" class="editable_status_P-A" disabled name = "Password">
        </div>
    
        <hr>
    
        <!-- Personal & Account: Account -->
    
        <div class="Two-Textbox">
        
        <div class="Top-Bottom">
        <input type="button" name="EDIT" value="EDIT" id="edit"/>
        </div>
    
        <div class="Top-Bottom">
        </div>
        <input type="submit" name="SAVE" value="SAVE" id="save" class="editable_status_P-A" disabled/>

    
        </div>
        
        </div>
        </div>
    
</form>
</section>



<section id="Vehicles_Section" class="content-section">
<form enctype="multipart/form-data" method="POST" action="employee_vehicles.php">
    <img id="licensePreview" src="data:image/png;base64,<?php echo $DRV["DriversLicense"]; ?>" alt="Drivers License" style="width:250px; height: auto;">
    <label for="Licenses" style="cursor: pointer; color: blue; text-decoration: underline; display: none;" class="editimage">Edit Driver License</label>
    <input type="file" name="License" id="Licenses" accept="image/*" style="display: none;" onchange="previewImage(event, 'licensePreview')">

    <h4> DRIVER'S LICENSE </h4>

    <div class="LICENSECENTER">
        <?php 
        for ($i = 0; $i < count($VHC); $i++) { 
            AddDisplayVehicle($VHC,$i );
        } ?>
    </div>

    <div class="Two-Textbox">
        <div class="Top-Bottom">
            <input type="button" name="id" value="ADD" id="add_vehicle"/>
        </div>
        
        <div class="Top-Bottom">
            <input type="button" name="EDIT" value="EDIT" id="Edit_Vehicle"/>
        </div>
    
        <div class="Top-Bottom">
        </div>
        <input type="submit" name="SAVE" value="SAVE" id="save" class="editable_status_Vehicle" disabled/> 
        
        <input type="hidden" name="id" value="Vehicles">    
    </div>

    
</form>

<FORM  enctype="multipart/form-data" method="POST" action="employee_vehicles.php">
     <div id="newVehicleForm" style="display: none;" class="ColoredBackground">
    <h4 class="vehicle">NEW VEHICLE</h4>
    <label for="newPlate">Plate No:</label>
    <input type="text" name="newPlate" id="newPlate" class="textbox_vehicle" placeholder="Enter Plate Number">

    <div class="Two-Textbox center">
        <div class="Top-Bottom centered">
            <h4> OR: </h4>
            <img id="newORPreview" alt="OR" style="width:90%; height: auto;" class="ORCR">
            <label for="newOR" style="cursor: pointer; color: blue; text-decoration: underline;">Upload OR</label>
            <input type="file" name="newOR" id="newOR" accept="image/*" style="display: none;" onchange="previewImage(event, 'newORPreview')">
        </div>
        <div class="Top-Bottom centered">
            <h4> CR: </h4>
            <img id="newCRPreview" alt="CR" style="width:90%; height: auto;" class="ORCR">
            <label for="newCR" style="cursor: pointer; color: blue; text-decoration: underline;">Upload CR</label>
            <input type="file" name="newCR" id="newCR" accept="image/*" style="display: none;" onchange="previewImage(event, 'newCRPreview')">
        </div>
    </div>

    <input type="submit" name="ADD NEW VEHICLE" value="NEW_VEHICLE" id="NEW_VEHICLE" /> 
    <input type="hidden" name="id" value="NewVehicles">    
    </div>

</FORM>

</section>

<section id="Contacts_Section" class="content-section">
<form method="post" action="employee_contacts.php">
        
<div class="Top-Bottom" class="editable_status_P-A">
        <h4>EMAIL: </h4>
        <input type="text" value="<?php echo $DRV["Email"] ?>" disabled class="editable_status_Contacts"  name = "Email">
        </div>
    
        <div class="Top-Bottom" class="editable_status_P-A">
        <h4>CONTACT NO: </h4>
        <input type="text" value="<?php echo $DRV["CN"] ?>" disabled class="editable_status_Contacts" name = "Contact">
        </div>

        
<div class="Two-Textbox">
        
        <div class="Top-Bottom">
        <input type="button" name="EDIT" value="EDIT" id="edit_Contacts"/>
        </div>
    
        <div class="Top-Bottom">
        </div>
        <input type="submit" name="SAVE" value="SAVE" id="save" class="editable_status_Contacts" disabled/>    
        </div>
        
</form>
</section>

<section id="GovInfo_Section" class="content-section" >
<form method="post" action="employeegovinfo.php"  enctype="multipart/form-data">
<div class="Top-Bottom">

<div class="Top-Bottom">
        <h4>PAGIBIG NO: </h4>
        <input type="text" value="<?php echo $DRV["PagNo"]?>" disabled class="editable_status_GOV" id="ID" name = "PagibigNo">
</div>
        
<div class="Top-Bottom">
        <h4>PHILHEALTH NO: </h4>
        <input type="text" value="<?php echo $DRV["PhilNo"]?>" disabled class="editable_status_GOV" id="ID" name = "PhilHealthNo">
</div>

<div class="Top-Bottom">
        <h4>SSS NO: </h4>
        <input type="text" value="<?php echo $DRV["SSSNo"]?>" disabled class="editable_status_GOV" id="ID" name = "SSSNo">
 </div>


 <h4> BARANGAY CLEARANCE: </h4>
<img id="licensePreview" src="data:image/png;base64,<?php echo $DRV["Brgy_Clear"]; ?>" alt="Drivers License" style="width:250px; height: auto;">
<label for="Barangay" style="cursor: pointer; color: blue; text-decoration: underline; display: none;" class="editimage_clearance">Edit Barangay Clearance </label>
<input name="Brgy" type="file" id="Barangay" accept="image/*" style="display: none;" onchange="previewImage(event, 'licensePreview')"  >
        
<h4> POLICE CLEARANCE: </h4>
<img id="licensePreview" src="data:image/png;base64,<?php echo $DRV["Pol_Clear"]; ?>" alt="Drivers License" style="width:250px; height: auto;">
<label for="Police" style="cursor: pointer; color: blue; text-decoration: underline; display: none;" class="editimage_clearance">Edit Driver Clearance </label>
<input type="file" name="Pol" id="Police" accept="image/*" style="display: none;" onchange="previewImage(event, 'licensePreview')">

<h4> NBI CLEARANCE: </h4>
<img id="licensePreview" src="data:image/png;base64,<?php echo $DRV["NBI_Clear"]; ?>" alt="Drivers License" style="width:250px; height: auto;">
<label for="NBI_" style="cursor: pointer; color: blue; text-decoration: underline; display: none;" class="editimage_clearance">Edit NBI Clearance </label>
<input type="file" name="NBI" id="NBI_" accept="image/*" style="display: none;" onchange="previewImage(event, 'licensePreview')">

<div class="Two-Textbox">
        
    <div class="Top-Bottom">
        <input type="button" name="EDIT" value="EDIT" id="edit_GOV"/>
    </div>
    
    <div class="Top-Bottom">
        </div>
        <input type="submit" name="SAVE" value="SAVE" id="save" class="editable_status_GOV" disabled/>    
    </div>



</div>





</form>
</section>




     





<script src="../JS Files/Employee_Profile.js?v=1.0"></script>
    
    </html>
    </body>
</html>

