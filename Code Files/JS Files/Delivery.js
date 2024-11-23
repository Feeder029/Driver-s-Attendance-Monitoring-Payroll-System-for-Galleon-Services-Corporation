
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("remittance-modal");
        const modalImage = document.getElementById("remittance-image");
        const closeBtn = document.querySelector(".close");

        document.querySelectorAll("#view-btn").forEach(button => {
            button.addEventListener("click", event => {
                const remittanceImage = button.getAttribute("data-image");
                modalImage.src = remittanceImage;
                modal.style.display = "block";
            });
        });

        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        window.addEventListener("click", event => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const driverSection = document.getElementById("DriverSection");
        const hubSection = document.getElementById("HubSection");
        const dateSection = document.getElementById("DateSection");
        const options = document.querySelectorAll(".dropdown-category input[name='option']");
    
        // Function to show the correct section based on the selected option
        const toggleSections = (selectedOption) => {
            if (selectedOption === "dd-driver") {
                driverSection.style.display = "block";
                hubSection.style.display = "none";
                dateSection.style.display = "none";
            } else if (selectedOption === "dd-hub") {
                driverSection.style.display = "none";
                dateSection.style.display = "none";
                hubSection.style.display = "block";
            } else if (selectedOption === "dd-date") {
                driverSection.style.display = "none";
                hubSection.style.display = "none";
                dateSection.style.display = "block";
            }
        };
    
        // Attach event listeners to each radio button
        options.forEach((option) => {
            option.addEventListener("change", (event) => {
                toggleSections(event.target.id); // Pass the selected radio button's ID
            });
        });
    
        // Show the correct section on page load
        const selectedOption = document.querySelector(".dropdown-category input[name='option']:checked");
        if (selectedOption) {
            toggleSections(selectedOption.id);
        }

    });
    