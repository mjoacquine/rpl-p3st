// P3ST Client Side Core System Script
document.addEventListener("DOMContentLoaded", function () {
    // 1. Auto dismiss alert dalam 4 detik agar tidak mengganggu space dashboard
    const alertList = document.querySelectorAll('.alert');
    alertList.forEach(function (alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 4000);
    });

    console.log("P3ST System Core Interface: Sync & Ready.");
});