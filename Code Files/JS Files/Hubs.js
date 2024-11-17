
function printTable() {
    // Get the HTML of the table
    const tableContent = document.querySelector('table').outerHTML;

    // Create a new window for printing
    const printWindow = window.open('', '', 'height=600,width=800');

    // Write the table content to the new window
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Table</title>
            <style>
                /* Add some basic styles for the printed table */
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 8px;
                    text-align: left;
                }
            </style>
        </head>
        <body>
            ${tableContent}
        </body>
        </html>
    `);

    // Close the document to apply styles
    printWindow.document.close();

    // Trigger the print dialog
    printWindow.print();
}
