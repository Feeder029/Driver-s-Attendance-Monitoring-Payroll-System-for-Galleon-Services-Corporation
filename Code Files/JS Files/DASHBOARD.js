// Data for employee performance chart
const performanceData = {
    labels: ['Alice', 'Bob', 'Charlie', 'David', 'Eve'],
    datasets: [{
        label: 'Performance Score',
        data: [85, 90, 78, 92, 88],
        backgroundColor: ['#4caf50', '#2196f3', '#ff9800', '#f44336', '#9c27b0'],
        borderColor: ['#4caf50', '#2196f3', '#ff9800', '#f44336', '#9c27b0'],
        borderWidth: 1
    }]
};

const performanceConfig = {
    type: 'bar',
    data: performanceData,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Performance Score'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Employee'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return `Score: ${tooltipItem.raw}`;
                    }
                }
            }
        }
    }
};

// Render the main bar chart
const performanceCtx = document.getElementById('performanceChart').getContext('2d');
new Chart(performanceCtx, performanceConfig);

// Data for the donut charts
const hubData = {
    labels: ['Carried', 'Delivered', 'Returned'],
    datasets: [{
        data: [45, 35, 20], // Example data, adjust as needed
        backgroundColor: ['#4caf50', '#2196f3', '#f44336'],
        borderWidth: 1
    }]
};

const hubConfig = {
    type: 'doughnut',
    data: hubData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return `${tooltipItem.label}: ${tooltipItem.raw}%`;
                    }
                }
            }
        }
    }
};

// Function to resize the chart canvas
function resizeChartCanvas(ctx, width, height) {
    ctx.canvas.width = width;
    ctx.canvas.height = height;
}

// Render each donut chart with smaller size
const hub1Ctx = document.getElementById('hub1Chart').getContext('2d');
const hub2Ctx = document.getElementById('hub2Chart').getContext('2d');
const hub3Ctx = document.getElementById('hub3Chart').getContext('2d');
const hub4Ctx = document.getElementById('hub4Chart').getContext('2d');

// Resize the canvases for the donut charts
resizeChartCanvas(hub1Ctx, 150, 150); // Smaller size
resizeChartCanvas(hub2Ctx, 150, 150);
resizeChartCanvas(hub3Ctx, 150, 150);
resizeChartCanvas(hub4Ctx, 150, 150);

// Render the resized donut charts
new Chart(hub1Ctx, hubConfig);
new Chart(hub2Ctx, hubConfig);
new Chart(hub3Ctx, hubConfig);
new Chart(hub4Ctx, hubConfig);
