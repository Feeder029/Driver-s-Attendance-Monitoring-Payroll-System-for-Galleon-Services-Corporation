document.addEventListener("DOMContentLoaded", () => {
    // Toggle visibility of the add-hub-container
    const addHubButton = document.getElementById("add-hub-btn");
    const addHubContainer = document.getElementById("add-hub-container");

    // Initially hide the add-hub-container
    addHubContainer.style.display = "none";

    // Add event listener for "ADD HUB" button
    addHubButton.addEventListener("click", () => {
        if (addHubContainer.style.display === "none") {
            addHubContainer.style.display = "block";
        } else {
            addHubContainer.style.display = "none";
        }
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
});


document.addEventListener("DOMContentLoaded", () => {
    const popoverContainer = document.querySelector(".popover-container");

    window.editRow = function (button) {
        // Get the row of the clicked button
        const row = button.closest("tr");

        // Get the data from the row
        const hubId = row.cells[0].textContent.trim();
        const hubName = row.cells[1].textContent.trim();
        const hubAddress = row.cells[2].textContent.trim();
        const [barangay, city, province, zipcode] = hubAddress.split(",").map(item => item.trim());
        const rate = row.cells[3].textContent.trim();

        // Populate the form fields in the popover-container
        popoverContainer.querySelector('input[name="hub_id"]').value = hubId;
        popoverContainer.querySelector('input[name="name"]').value = hubName;
        popoverContainer.querySelector('input[name="barangay"]').value = barangay;
        popoverContainer.querySelector('input[name="city"]').value = city;
        popoverContainer.querySelector('input[name="province"]').value = province;
        popoverContainer.querySelector('input[name="zipcode"]').value = zipcode;
        popoverContainer.querySelector('input[name="rate"]').value = rate;

        // Display the popover-container
        popoverContainer.style.display = "block";
    };

    // Close popover functionality
    const closeButton = popoverContainer.querySelector('button[name="close_popover"]');
    closeButton.addEventListener("click", (e) => {
        e.preventDefault();
        popoverContainer.style.display = "none";
    });
});



