// Function to toggle visibility of details
function toggleDetails() {
    const detailsContent = document.getElementById("details-content");
    const button = document.querySelector(".details-button");

    if (detailsContent.style.display === "none" || detailsContent.style.display === "") {
        detailsContent.style.display = "block";
        button.textContent = "Hide Details ▲";
    } else {
        detailsContent.style.display = "none";
        button.textContent = "Details ▼";
    }
}

// Function to generate PDF
document.querySelector('.download-button').addEventListener('click', generatePayslipPDF);

function generatePayslipPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Retrieve content from the payslip section
    const name = document.querySelector('.driver-info p strong') ? document.querySelector('.driver-info p strong').nextSibling.nodeValue.trim() : "Not provided";
    
    const idNoElement = document.querySelector('.driver-info p:nth-child(2)');
    const idNo = idNoElement ? idNoElement.innerText.replace(/.*ID NO.:\s*/, '').trim() : "Not provided";

    const hubElement = document.querySelector('.driver-info p:nth-child(3)');
    const hub = hubElement ? hubElement.innerText.replace(/.*Hub:\s*/, '').trim() : "Not provided";

    const regDay = document.querySelector('.earnings .row:nth-child(1) .days')?.innerText || "Not provided";
    const regDayAmount = document.querySelector('.earnings .row:nth-child(1) .amount')?.innerText || "Not provided";
    const sholiday = document.querySelector('.earnings .row:nth-child(2) .days')?.innerText || "Not provided";
    const sholidayAmount = document.querySelector('.earnings .row:nth-child(2) .amount')?.innerText || "Not provided";
    const rholiday = document.querySelector('.earnings .row:nth-child(3) .days')?.innerText || "Not provided";
    const rholidayAmount = document.querySelector('.earnings .row:nth-child(3) .amount')?.innerText || "Not provided";
    const totalEarnings = document.querySelector('.total-earnings')?.innerText || "Not provided";
    const sss = document.querySelector('.deductions .row:nth-child(1) .amount')?.innerText || "Not provided";
    const philHealth = document.querySelector('.deductions .row:nth-child(2) .amount')?.innerText || "Not provided";
    const pagibig = document.querySelector('.deductions .row:nth-child(3) .amount')?.innerText || "Not provided";
    const totalDeductions = document.querySelector('.total-deductions')?.innerText || "Not provided";
    const netPay = document.querySelector('.net-pay-amount')?.innerText || "Not provided";

    // Set company name, title, and styles
    doc.setFont("helvetica", "bold");
    doc.setFontSize(20);
    doc.text("Galleon Services Corporation", 20, 20); // Company name

    doc.line(10, 25, 200, 25); // Horizontal line under company namess
    
    doc.setFontSize(18);
    doc.text("Payslip", 20, 40); // Payslip title

    // Personal Information
    doc.setFontSize(14);
    doc.setFont("helvetica", "normal");
    doc.text(`Name: ${name}`, 20, 50);
    doc.text(`ID No.: ${idNo}`, 20, 60);
    doc.text(`Hub: ${hub}`, 20, 70);

    // Line Break
    doc.line(10, 75, 200, 75);

    // Earnings Section
    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text("Earnings", 20, 90);
    doc.setFont("helvetica", "normal");
    doc.setFontSize(12);
    doc.text(`REG DAY: ${regDay} days - ${regDayAmount}`, 20, 105);
    doc.text(`S. HOLIDAY: ${sholiday} days - ${sholidayAmount}`, 20, 115);
    doc.text(`R. HOLIDAY: ${rholiday} days - ${rholidayAmount}`, 20, 125);
    doc.text(`Total Earnings: ${totalEarnings}`, 20, 135);

    // Line Break
    doc.line(10, 140, 200, 140);

    // Deductions Section
    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text("Deductions", 20, 155);
    doc.setFont("helvetica", "normal");
    doc.setFontSize(12);
    doc.text(`SSS: ${sss}`, 20, 170);
    doc.text(`PhilHealth: ${philHealth}`, 20, 180);
    doc.text(`Pagibig: ${pagibig}`, 20, 190);
    doc.text(`Total Deductions: ${totalDeductions}`, 20, 200);

    // Line Break
    doc.line(10, 205, 200, 205);

    // Net Pay Section
    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text(`Net Pay: ${netPay}`, 20, 220);

    // Footer
    doc.setFontSize(10);
    doc.setFont("helvetica", "normal");
    doc.text("Generated on: " + new Date().toLocaleDateString(), 20, 235);
    doc.text("Thank you for your service!", 20, 245);

    // Save the PDF
    doc.save('payslip.pdf');
}
