$(document).ready(function () {
    $("input").each(function () {
        if ($(this).val().length > 0) {
            $(this).addClass("not-empty");
        } else {
            $(this).removeClass("not-empty");
        }

        $(this).on("change", function () {
            if ($(this).val().length > 0) {
                $(this).addClass("not-empty");
            } else {
                $(this).removeClass("not-empty");
            }
        });
    });
});
