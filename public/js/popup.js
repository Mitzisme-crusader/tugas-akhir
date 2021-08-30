$(document).ready(function () {
    $(".popup").click(function (event) {
        if (event.target.className == "popup") {
            $(".container_harga_extra_service").empty();
            $("#nama_extra_service").val("");
            close_popup();
        }
    });

    $(".popup-box > span").click(function () {
        $(".container_harga_extra_service").empty();
        $("#nama_extra_service").val("");
        close_popup();
    });

    $(".popup .button-cancel").click(function () {
        $(".container_harga_extra_service").empty();
        $("#nama_extra_service").val("");
        close_popup();
    });

    $(".popup .button-add_extra_service").click(function () {
        var nama_extra_service = $("#nama_extra_service").val();
        var harga_extra_service_20_feet = $("#harga_extra_service_20_feet").val();
        var harga_extra_service_40_feet = $("#harga_extra_service_40_feet").val();
        var harga_extra_service_45_feet = $("#harga_extra_service_45_feet").val();
        var extra_service = document.createElement("label");
        extra_service.setAttribute("class", "label_extra_service");
        extra_service.setAttribute("id", nama_extra_service);
        $(".container_extra_service").append(extra_service);
        $("#"+nama_extra_service+"").html(nama_extra_service);

        if($("#hidden_nama_extra_service").val() == ""){
            $("#hidden_nama_extra_service").val(nama_extra_service);
            $("#hidden_harga_20_feet_extra_service").val(harga_extra_service_20_feet);
            $("#hidden_harga_40_feet_extra_service").val(harga_extra_service_40_feet);
            $("#hidden_harga_45_feet_extra_service").val(harga_extra_service_45_feet);
        }
        else{
            $("#hidden_nama_extra_service").val($("#hidden_nama_extra_service").val()+ "," + nama_extra_service);
            $("#hidden_harga_20_feet_extra_service").val($("#hidden_harga_20_feet_extra_service").val()+ "," + harga_extra_service_20_feet);
            $("#hidden_harga_40_feet_extra_service").val($("#hidden_harga_40_feet_extra_service").val()+ "," + harga_extra_service_40_feet);
            $("#hidden_harga_45_feet_extra_service").val($("#hidden_harga_45_feet_extra_service").val()+ "," + harga_extra_service_45_feet);
        }

        $("#nama_extra_service").val("");
        $(".container_harga_extra_service").empty();
        close_popup();
    });

    function open_popup() {
        $(".popup").css("transition", "none");
        $(".popup").css("visibility", "visible");
        $(".popup-box").css("opacity", "1");
        $(".popup-box").css("transform", "scale(1)");
    }

    function close_popup() {
        $(".popup").css("transition", "all ease-in-out 300ms");
        $(".popup").css("visibility", "hidden");
        $(".popup-box").css("opacity", "0");
        $(".popup-box").css("transform", "scale(0.3)");
    }

    //attach popup
    $(".popupable").click(function () {
        open_popup();
    });
});
