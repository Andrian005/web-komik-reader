function Modal({ title = "", url = "", content = "", id = "modal" }) {
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
                            ${
                                content
                                    ? content
                                    : '<div class="spinner-border text-primary" role="status"></div>'
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);

    const $modal = $("#" + id);
    $modal.modal("show");

    if (url && !content) {
        $.get(url, function (res) {
            $modal.find(".modal-body").html(res);
        }).fail(function () {
            $modal.find(".modal-body").html(`
                <div class="text-danger">
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        Gagal memuat konten.
                    </div>
                </div>
            `);
        });
    }
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

function showToast(type, message) {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: type === "error" ? 5000 : 3000,
        extendedTimeOut: 1000,
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    toastr[type](message);
}

function showError(errors) {
    Object.values(errors).flat().forEach(msg => showToast("error", msg));
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
    }).then((result) => {
        if (result.isConfirmed && typeof callback === "function") {
            callback();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Data tidak jadi dihapus.", "error");
        }
    });
}

$(function () {
    const isRtl = $("html").attr("dir") === "rtl";

    $(".select2").select2({
        dir: isRtl ? "rtl" : "ltr",
        dropdownAutoWidth: true,
        width: "100%",
    });

    $(".datepicker").datepicker({
        orientation: isRtl ? "rtl" : "ltr",
        autoclose: true,
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
    });

    $(".datepicker2").datepicker({
        dateFormat: 'mm/dd/yy',
        showSecond: true,
        controlType: 'select',
        oneLine: true,
        todayHighlight: true
    });
    $(".datepicker2").datepicker('setDate', new Date());


    $(document).on("change", "#photo", function () {
        $(this).next(".custom-file-label").html(this.files[0]?.name || "Pilih file");
    });

    $(document).on("input", "[slug-source]", function () {
        const slug = $(this).val()
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-");

        $(this).closest("form").find("[slug-target]").val(slug);
    });

    $('.number').on('input', function() {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

});

function previewPhotoModal() {
    const $input = $("#photo");
    const file = $input[0]?.files[0];
    const oldPhotoUrl = $input.data("old-photo");
    const id = "photoPreviewModal";
    const title = "Preview Gambar";

    const createImage = (src) => `
        <img src="${src}" alt="Preview"
            class="img-fluid rounded shadow"
            style="max-height: 300px; object-fit: contain;">
    `;

    if ($("#" + id).length === 0) {
        $("body").append(`
            <div class="modal fade" id="${id}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                            <button type="button" class="btn btn-label-danger btn-icon" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center" style="min-height: 200px;">
                            <div id="photoPreviewContent" class="w-100 text-center">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }

    const $modal = $("#" + id);
    const $content = $modal.find("#photoPreviewContent");

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            $content.html(createImage(e.target.result));
            $modal.modal("show");
            $modal.appendTo("body").modal("show");
        };
        reader.readAsDataURL(file);
    } else if (oldPhotoUrl) {
        $content.html(createImage(oldPhotoUrl));
        $modal.modal("show");
        $modal.appendTo("body").modal("show");
    } else {
        Swal.fire("Tidak ada gambar", "Silakan pilih gambar terlebih dahulu.", "warning");
    }
}
