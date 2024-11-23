
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

