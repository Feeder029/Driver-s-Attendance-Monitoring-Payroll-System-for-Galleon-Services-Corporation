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

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("remittance-modal-3");
    const modalImage = document.getElementById("remittance-image-3");
    const closeBtn = document.querySelector(".close-3");

    document.querySelectorAll("#view-btn-3").forEach(button => {
        button.addEventListener("click", event => {
            const remittanceImage = button.getAttribute("data-image-3");
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
    const modal = document.getElementById("remittance-modal-4");
    const modalImage = document.getElementById("remittance-image-4");
    const closeBtn = document.querySelector(".close-4");

    document.querySelectorAll("#view-btn-4").forEach(button => {
        button.addEventListener("click", event => {
            const remittanceImage = button.getAttribute("data-image-4");
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
    const modal = document.getElementById("remittance-modal-5");
    const modalImage = document.getElementById("remittance-image-5");
    const closeBtn = document.querySelector(".close-5");

    document.querySelectorAll("#view-btn-5").forEach(button => {
        button.addEventListener("click", event => {
            const remittanceImage = button.getAttribute("data-image-5");
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
    const tableContainer3 = document.querySelector('.table-container-3');
    const tableContainer4 = document.querySelector('.table-container-4');
    const tableContainer5 = document.querySelector('.table-container-5');
    
    
    if (option === 'list') {
        tableContainer1.style.display = 'block';
        tableContainer2.style.display = 'none';
        tableContainer3.style.display = 'none';
        tableContainer4.style.display = 'none';
        tableContainer5.style.display = 'none';
    } else if (option === 'summary') {
        tableContainer1.style.display = 'none';
        tableContainer2.style.display = 'block';
        tableContainer3.style.display = 'none';
        tableContainer4.style.display = 'none';
        tableContainer5.style.display = 'none';
    } 
    else if (option === 'pending') {
        tableContainer1.style.display = 'none';
        tableContainer2.style.display = 'none';
        tableContainer3.style.display = 'block';
        tableContainer4.style.display = 'none';
        tableContainer5.style.display = 'none';
    } else if (option === 'accepted') {
        tableContainer1.style.display = 'none';
        tableContainer2.style.display = 'none';
        tableContainer3.style.display = 'none';
        tableContainer4.style.display = 'block';
        tableContainer5.style.display = 'none';
    } else if (option === 'denied') {
        tableContainer1.style.display = 'none';
        tableContainer2.style.display = 'none';
        tableContainer3.style.display = 'none';
        tableContainer4.style.display = 'none';
        tableContainer5.style.display = 'block';
    } else if (option === 'all') {
        tableContainer1.style.display = 'block';
        tableContainer2.style.display = 'none';
        tableContainer3.style.display = 'none';
        tableContainer4.style.display = 'none';
        tableContainer5.style.display = 'none';
    }
}

// Initialize the default view
document.addEventListener('DOMContentLoaded', () => {
    toggleTable('list');
});
