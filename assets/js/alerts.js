document.addEventListener('DOMContentLoaded', function () {
    // Cierra automáticamente el alerta con clase "alert-fixed" después de 5 segundos
    setTimeout(function () {
        var alertElement = document.querySelector('.alert-fixed');
        if (alertElement) {
            var alertInstance = bootstrap.Alert.getOrCreateInstance(alertElement);
            alertInstance.close();
        }
    }, 5000);
});
