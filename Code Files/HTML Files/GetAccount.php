<?php
    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "gsc_attendanceandpayroll3.0";

    // Create connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name) or die("Connection failed: " . mysqli_connect_error());

    //join query
    $sql = "
SELECT
        a.ACC_Username AS Username,
        a.ACC_Password AS Password,
        a.ACC_DateCreated AS DateCreated,
        a.ACC_AcountStatID AS Status,
       a.ACC_ID as ID,
        n.AN_FName AS FirstName,
        n.AN_MName AS MiddleName,
        n.AN_LName AS LastName,
        n.AN_Suffix AS Suffix,
        r.ARL_Role AS Role,
        NULL AS Age,
        i.AI_Contact AS Contact,
        i.AI_Email AS Email,
        NULL AS Gender,
        NULL AS DOB,
        NULL AS LicenseImg,
        NULL AS BrgyClearanceImg,
        NULL AS PoliceClearanceImg,
        NULL AS NBIClearanceImg,
        NULL AS GCashNo,
        NULL AS GCashName,
        i.AI_ProfileImg AS ProfileImage,
        NULL AS HouseNo,
        NULL AS LotNo,
        NULL AS Street,
        NULL AS Barangay,
        NULL AS City,
        NULL AS Province,
        NULL AS ZipCode,
        NULL AS UnitType,
        NULL AS HubAssigned,
        NULL AS PhilHealthNo,
        NULL AS SSSNo,
        NULL AS PagibigNo,
        'Admin' AS UserType
    FROM
        admin_information i
    JOIN
        account a ON i.AI_AccountID = a.ACC_ID
    JOIN
        admin_name n ON i.AI_AdminNameID = n.AN_ID
    JOIN
        admin_role r ON i.AI_AdminPositionID = r.ARL_ID
WHERE
    a.ACC_AcountStatID < 3

    UNION

    SELECT
        b.ACC_Username AS Username,
        b.ACC_Password AS Password,
        b.ACC_DateCreated AS DateCreated,
        b.ACC_AcountStatID AS Status,
        b.ACC_ID as ID,
        c.DN_FName AS FirstName,
        c.DN_MName AS MiddleName,
        c.DN_LName AS LastName,
        c.DN_Suffix AS Suffix,
        'Driver' AS Role,
        a.DI_Age AS Age,
        a.DI_ContactNo AS Contact,
        a.DI_Email AS Email,
        a.DI_Gender AS Gender,
        a.DI_DOB AS DOB,
        a.DI_LicenseImg AS LicenseImg,
        a.DI_BrgyClearanceImg AS BrgyClearanceImg,
        a.DI_PoliceClearanceImg AS PoliceClearanceImg,
        a.DI_NBIClearanceImg AS NBIClearanceImg,
        a.Gcash_No AS GCashNo,
        a.GCash_Name AS GCashName,
        a.DI_ProfileImage AS ProfileImage,
        d.DA_HouseNo AS HouseNo,
        d.DA_LotNo AS LotNo,
        d.DA_Street AS Street,
        d.DA_Barangay AS Barangay,
        d.DA_City AS City,
        d.DA_Province AS Province,
        d.DA_ZipCode AS ZipCode,
        e.DUT_UnitType AS UnitType,
        g.HASS_Name AS HubAssigned,
        h.GOV_PhilHealthNo AS PhilHealthNo,
        h.GOV_SSSNo AS SSSNo,
        h.GOV_PagibigNo AS PagibigNo,
        'Driver' AS UserType
    FROM
        driver_information a
    JOIN
        account b ON a.DI_AccountID = b.ACC_ID
    JOIN
        driver_name c ON a.DI_NameID = c.DN_ID
    JOIN
        driver_address d ON a.DI_AddressID = d.DA_ID
    JOIN
        driver_unit_type e ON a.DI_UnitTypeID = e.DUT_ID
    JOIN
        hub_assigned g ON a.DI_HubAssignedID = g.HASS_ID
    JOIN
        government_information h ON a.DI_GovInfoID = h.GOV_ID
WHERE
    b.ACC_AcountStatID < 3

 ORDER BY Status ASC, DateCreated DESC;";

    $result = $conn->query($sql);   

    ?>
    



