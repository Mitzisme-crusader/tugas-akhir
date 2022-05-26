$(document).ready(function () {
    $( "#option_container" ).change(function() {
        if($('#option_container option:selected').val() == "FCL"){
            $("#input_LCL").css("display", "none");
            $("#input_FCL").css("display", "block");
        }
        if($('#option_container option:selected').val() == "LCL"){
            $("#input_LCL").css("display", "block");
            $("#input_FCL").css("display", "none");
        }
    });

    $("input").each(function () {
        $(this).on("change", function () {
            if ($(this).val().length > 0) {
                $(this).addClass("not-empty");
            } else {
                $(this).removeClass("not-empty");
            }
        });
    });
});
