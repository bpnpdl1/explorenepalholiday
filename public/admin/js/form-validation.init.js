!function () {
    "use strict";

    document.addEventListener("submit", function (event) {
        var form = event.target.closest("form.needs-validation");

        if (!form) {
            return;
        }

        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        form.classList.add("was-validated");
    }, true);
}();
