function togglePayslip(tabOption){
    const payrollTab = document.querySelector('.table-container');
    const payslipTab = document.querySelector('.payslip-container');
    const createPayslipBtn = document.getElementById('createPayslipBtn');
    const sendBtn = document.getElementById('sendBtn');
    const allowanceBtn = document.getElementById('allowance');
    const cancelBtn = document.getElementById('cancelBtn');

    if(tabOption === 'payslip'){
        createPayslipBtn.style.display = 'none';
        allowanceBtn.style.display = 'none'
        sendBtn.style.display = 'inline-block';
        cancelBtn.style.display = 'inline-block';

        payrollTab.style.display = 'none';
        payslipTab.style.display = 'flex';
    } else if (tabOption === 'payroll'){
        payrollTab.style.display = 'block';
        payslipTab.style.display = 'none';
    } else if(tabOption === 'cancel'){
        createPayslipBtn.style.display = 'inline-block';
        allowanceBtn.style.display = 'inline-block'
        sendBtn.style.display = 'none';
        cancelBtn.style.display = 'none';

        payrollTab.style.display = 'block';
        payslipTab.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    togglePayslip('payroll');
});

// Print the table functionality
    window.printTable = function (title = "Table Data") {
        // Get the table element
        const table = document.querySelector("table");
        if (!table) {
            alert("No table found to print!");
            return;
        }

        // Temporarily hide the "Actions" column in the print output (not affecting the HTML)
        const thElements = table.querySelectorAll("thead th");
        const tdElements = table.querySelectorAll("tbody td");

        // Find the index of the "Actions" column
        const actionsColumnIndex = Array.from(thElements).findIndex(th => th.textContent.trim() === "Actions");

        // Temporarily hide the Actions column for printing
        if (actionsColumnIndex !== -1) {
            thElements[actionsColumnIndex].style.display = "none"; // Hide header for Actions column
            tdElements.forEach(td => {
                if (td.cellIndex === actionsColumnIndex) {
                    td.style.display = "none"; // Hide data in Actions column
                }
            });
        }

        // Create a new window for printing
        const printWindow = window.open("", "", "height=600,width=800");

        // Write the table content to the new window
        printWindow.document.write(`
            <html>
            <head>
                <title>Printed Table</title>
                <style>
                    body {
                        font-family: 'Poppins', sans-serif;
                        margin: 20px;
                        color: #333;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    table, th, td {
                        border: 1px solid #333;
                    }
                    th {
                        background-color: #003135;
                        color: white;
                        padding: 10px;
                        text-transform: uppercase;
                    }
                    td {
                        padding: 8px;
                        text-align: left;
                        background-color: #f9f9f9;
                    }
                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }
                    tr:hover {
                        background-color: rgba(0, 49, 53, 0.1);
                    }
                    h1 {
                        text-align: center;
                        color: #003135;
                        margin-bottom: 20px;
                    }
                </style>
            </head>
            <body>
                <h1>${title}</h1>
                ${table.outerHTML}
            </body>
            </html>
        `);

        // Close the document to apply styles
        printWindow.document.close();

        // Wait for the content to load and then trigger the print dialog
        printWindow.onload = () => {
            printWindow.print();
            printWindow.close();

            // Restore the "Actions" column visibility after printing
            if (actionsColumnIndex !== -1) {
                thElements[actionsColumnIndex].style.display = ""; // Restore header
                tdElements.forEach(td => {
                    if (td.cellIndex === actionsColumnIndex) {
                        td.style.display = ""; // Restore data
                    }
                });
            }
        };
    };


    function updatePayslipData(id, name, gcash, netPay, unitType, regDay, spechDay, reghDay, totRegAmount, totSpechAmount, totReghAmount, allowance, grossPay, sss, philhealth, pagibig, totReduction, hub) {
        // Update payslip driver information
        document.querySelector('.payslip-driver .driver-data h4:nth-child(1)').innerText = "NAME: " + name;
        document.querySelector('.payslip-driver .driver-data h4:nth-child(2)').innerText = "DRIVER ID: " + id;
        document.querySelector('.payslip-driver .driver-data h4:nth-child(3)').innerText = "HUB: " + hub;
        document.querySelector('.payslip-driver .driver-data h4:nth-child(4)').innerText = "UNIT TYPE: " + unitType;
 
    
        // Update the earnings and deductions with dynamic values
        document.querySelector('.earning-left #earning-table').innerHTML = `
            <tr>
                <th>DAYS</th>
                <th>AMOUNT</th>
            </tr>
            <tr>
                <td>${regDay}</td>
                <td>₱ ${totRegAmount}</td>
            </tr>
            <tr>
                <td>${spechDay}</td>
                <td>₱ ${totSpechAmount}</td>
            </tr>
            <tr>
                <td>${reghDay}</td>
                <td>₱ ${totReghAmount}</td>
            </tr>
        `;

        document.querySelector('.earning-right .earning-data h4:nth-child(4)').innerText = "ALLOWANCE: ₱ " + allowance;
        document.querySelector('.earning-right .earning-data h4:nth-child(5)').innerText = "TOTAL GROSS PAY: ₱ " + grossPay;
        
        // Deductions placeholder
        document.querySelector('.deductions-data h4:nth-child(1)').innerText = "SSS: ₱ " + sss;
        document.querySelector('.deductions-data h4:nth-child(2)').innerText = "PHILHEALTH: ₱ " + philhealth;
        document.querySelector('.deductions-data h4:nth-child(3)').innerText = "PAGIBIG: ₱ " + pagibig;
        document.querySelector('.deductions-data h4:nth-child(4)').innerText = "TOTAL DEDUCTIONS: ₱ " + totReduction;
        document.querySelector('.payslip-deductions .deductions-data h4:nth-child(5)').innerText = "NET PAY: ₱ " + netPay;
    }
    
    