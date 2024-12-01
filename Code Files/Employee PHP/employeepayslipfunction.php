<?php
include("employee_profile.php");

$sql ="SELECT  
ASUM_DateStart as Start, 
ASUM_DateEnd as End, 
DRIVERNAMEDISPLAY (f.`DN_FName`,f.`DN_MName`,f.`DN_LName`, f.`DN_Suffix`) AS fullname,
CON_TOTPagibigContribution as Pag,  
CON_TOTPhilHealthContribution as Phil, 
CON_SSSContribution as SSS, 
CON_TotalAmount as Amount, 
ASUM_RegularDay as Reg, 
ASUM_SpecialHoliday as Spec, 
c.`DI_ID` AS ID,
ASUM_RegularHoliday as RegHol,
g.`Hub_Name` as Hub
FROM payroll a
JOIN basic_pay b ON a.`PAY_BasicPayID` = b.`BP_ID`
JOIN driver_information c ON a.`PAY_DriverID` = c.`DI_ID`
JOIN contribution d ON a.`PAY_ContributionID` = d.`CON_ID`
JOIN attendance_summary e ON e.`ASUM_ID` = b.`BP_AttendanceSumID`
JOIN driver_name f on c.`DI_NameID` = f.`DN_ID`
JOIN hub g on c.`DI_HubAssignedID` = g.`hub_ID`
where
 DI_ID = $DriverID
group by
ASUM_DateStart, DI_ID
";



?>