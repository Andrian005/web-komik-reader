function Modal({ title = "", url = "", id = "modal" }) {
    $("#" + id).remove();

    $("body").append(`
        <div class="modal fade" id="${id}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn btn-label-danger btn-icon" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);

    const $modal = $("#" + id);
    $modal.modal("show");

    $.get(url, function (res) {
        $modal.find(".modal-body").html(res);
    }).fail(function () {
        $modal
            .find(".modal-body")
            .html(
                '<div class="text-danger"><div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">Gagal memuat konten.</div></div>'
            );
    });
}

function showSuccess(message) {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 3000,
        extendedTimeOut: 1000,
        showDuration: 300,
        hideDuration: 1000,
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    toastr.success(message);
}

function showError(message) {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000,
        extendedTimeOut: 2000,
        showDuration: 300,
        hideDuration: 1000,
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    toastr.error(message);
}

function showErrors(errors) {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000,
        extendedTimeOut: 2000,
        showDuration: 300,
        hideDuration: 1000,
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    for (const key in errors) {
        if (errors.hasOwnProperty(key)) {
            errors[key].forEach((msg) => toastr.error(msg));
        }
    }
}

function confirmDelete(callback) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then(function (result) {
        if (result.isConfirmed) {
            if (typeof callback === "function") callback();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Data tidak jadi dihapus.", "error");
        }
    });
}
