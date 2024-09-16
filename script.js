document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('myModal');
    var openModalBtn = document.getElementById('openModal');
    var closeModalBtns = document.querySelectorAll('[data-bs-dismiss="modal"]');

    // Open the modal
    openModalBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        var modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

    // Close the modal
    closeModalBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        });
    });
});
