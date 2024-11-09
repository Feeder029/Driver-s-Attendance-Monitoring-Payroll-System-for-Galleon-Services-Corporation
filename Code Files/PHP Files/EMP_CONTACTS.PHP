<!-- contacts-form.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Information</title>
  <link rel="stylesheet" href="../CSS Files/CONTACTS.CSS"> <!-- Link to your CSS file -->
</head>
<body>
<?php
  include("employee_profile.php");
    ?> 

  <!-- Contacts Form Section -->
  <div id="contacts" class="form-section">
  <form method="post" action="employee_contacts.php">

    <h2>Contacts</h2>

    <!-- Contacts Form Fields -->
    <section id="contacts-info" class="info-section">
      <label for="email">Email:</label>
      <input type="email" id="email" value="<?php echo $DRV["Email"] ?>" disabled class="editable_status_Contacts"  name = "Email" required>

      <label for="contact-number">Contact Number:</label>
      <input type="tel" id="contact-number" value="<?php echo $DRV["CN"] ?>" disabled class="editable_status_Contacts" name = "Contact" required>
      </section>

    <!-- Edit and Save Buttons -->
    <div class="button-container">
    <button type="button" onclick="editContacts()" name="EDIT" value="EDIT" id="edit">Edit</button>
    <button type="button" onclick="BackContacts()" name="BACK" value="BACK" id="back" style="display: none;">Back</button>  
    <button type="submit" onclick="saveContacts()" value="SAVE" id="save" style="display: none;">Save</button>
    </div>

  </form>
  </div>

</body>
</html>
