document.addEventListener("DOMContentLoaded", () => {

    const alerts = document.querySelectorAll(".alert, .error-box, .success-box");

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = "0.4s";
            alert.style.opacity = "0";

            setTimeout(() => alert.remove(), 500);
        }, 3000); 
    });

});
