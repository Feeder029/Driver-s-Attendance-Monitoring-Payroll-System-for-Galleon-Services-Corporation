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
    const modal = document.getElementById("remittance-modal-2");
    const modalImage = document.getElementById("remittance-image-2");
    const closeBtn = document.querySelector(".close-2");

    document.querySelectorAll("#view-btn-2").forEach(button => {
        button.addEventListener("click", event => {
            const remittanceImage = button.getAttribute("data-image-2");
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

function toggleTable(option) {
    const tableContainer1 = document.querySelector('.table-container');
    const tableContainer2 = document.querySelector('.table-container-2');
    
    if (option === 'list') {
        tableContainer1.style.display = 'block';
        tableContainer2.style.display = 'none';
    } else if (option === 'summary') {
        tableContainer1.style.display = 'none';
        tableContainer2.style.display = 'block';
    }
}

// Initialize the default view
document.addEventListener('DOMContentLoaded', () => {
    toggleTable('list');
});
