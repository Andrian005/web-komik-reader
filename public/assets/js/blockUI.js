function blockUI(target) {
    $(target).block({
        message:
            '\n        <div class="spinner-grow text-success"></div>\n        <h1 class="blockui blockui-title">Processing...</h1>\n      ',
        timeout: 1e3,
    });
}

function unblockUI(target) {
    $(target).unblock();
}

$("#datatable").on("preXhr.dt", function () {
    blockUI("#datatable");
});

$("#datatable").on("xhr.dt", function () {
    unblockUI("#datatable");
});
