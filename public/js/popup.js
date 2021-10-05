$(document).ready(function () {
    $(".popup").click(function (event) {
        if (event.target.className == "popup") {
            $(".container_harga_extra_service").empty();
            $("#nama_extra_service").val("");
            close_popup();
        }
    });

    $(".popup_freight").click(function (event) {
        if (event.target.className == "popup_freight") {
            $(".container_harga_extra_service").empty();
            $("#nama_extra_service").val("");
            close_popup_freight();
        }
    });

    $(".popup-box > span").click(function () {
        $(".container_harga_extra_service").empty();
        $("#nama_extra_service").val("");
        close_popup();

        $(".container_harga_extra_service").empty();
        $("#nama_extra_service").val("");
        close_popup();
    });

    $(".popup .button-cancel").click(function () {
        $(".container_harga_extra_service").empty();
        $("#nama_extra_service").val("");
        close_popup();
    });

    $(".popup_freight .button-cancel").click(function () {
        $("#nama_extra_service_freight").val("");
        $("#harga_extra_service_freight").val("");
        close_popup_freight();
    });

    $(".popup .button-add_extra_service").click(function () {
        var nama_extra_service = $("#nama_extra_service").val();
        var harga_extra_service_20_feet = $("#harga_extra_service_20_feet").val();
        var harga_extra_service_40_feet = $("#harga_extra_service_40_feet").val();
        var harga_extra_service_45_feet = $("#harga_extra_service_45_feet").val();
        var extra_service = document.createElement("label");
        extra_service.setAttribute("class", "label_item_extra_service");
        extra_service.setAttribute("id", nama_extra_service);
        extra_service.setAttribute("service" , "normal");
        extra_service.onclick = remove_label_extra_service;
        extra_service.style.display = "inline";
        $("#container_extra_service_custom_handling").append(extra_service);
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

    $(".popup_freight .button-add_extra_service_freight").click(function () {
        var nama_extra_service_freight = $("#nama_extra_service_freight").val();
        var harga_extra_service_freight = $("#harga_extra_service_freight").val();
        var extra_service = document.createElement("label");
        extra_service.setAttribute("class", "label_item_extra_service");
        extra_service.setAttribute("id", nama_extra_service_freight);
        extra_service.setAttribute("service", "freight");
        extra_service.onclick = remove_label_extra_service;
        extra_service.style.display = "inline";
        if($(".button-add_extra_service_freight").val() == "origin"){
            extra_service.setAttribute("service", "origin");
            $("#container_extra_service_freight_origin").append(extra_service);
            $("#"+nama_extra_service_freight).html(nama_extra_service_freight);

            if($("#hidden_nama_service_freight_origin").val() == ""){
                $("#hidden_nama_service_freight_origin").val(nama_extra_service_freight);
                $("#hidden_harga_service_freight_origin").val(harga_extra_service_freight);
            }
            else{
                $("#hidden_nama_service_freight_origin").val($("#hidden_nama_service_freight_origin").val()+ "," + nama_extra_service_freight);
                $("#hidden_harga_service_freight_origin").val($("#hidden_harga_service_freight_origin").val()+ "," + harga_extra_service_freight);
            }
        }
        else if($(".button-add_extra_service_freight").val() == "destination"){
            extra_service.setAttribute("service", "destination");
            $("#container_extra_service_freight_destination").append(extra_service);
            $("#"+nama_extra_service_freight).html(nama_extra_service_freight);

            if($("#hidden_nama_service_freight_destination").val() == ""){
                $("#hidden_nama_service_freight_destination").val(nama_extra_service_freight);
                $("#hidden_harga_service_freight_destination").val(harga_extra_service_freight);
            }
            else{
                $("#hidden_nama_service_freight_destination").val($("#hidden_nama_service_freight_destination").val()+ "," + nama_extra_service_freight);
                $("#hidden_harga_service_freight_destination").val($("#hidden_harga_service_freight_destination").val()+ "," + harga_extra_service_freight);
            }
        }

        $("#nama_extra_service_freight").val("");
        $("#harga_extra_service_freight").val("");
        close_popup_freight();
    });

    function open_popup() {
        $(".popup").css("transition", "none");
        $(".popup").css("visibility", "visible");
        $(".popup-box").css("opacity", "1");
        $(".popup-box").css("transform", "scale(1)");
    }

    function open_popup_freight() {
        $(".popup_freight").css("transition", "none");
        $(".popup_freight").css("visibility", "visible");
        $(".popup-box").css("opacity", "1");
        $(".popup-box").css("transform", "scale(1)");
    }

    function close_popup() {
        $(".popup").css("transition", "all ease-in-out 300ms");
        $(".popup").css("visibility", "hidden");
        $(".popup-box").css("opacity", "0");
        $(".popup-box").css("transform", "scale(0.3)");
    }

    function close_popup_freight() {
        $(".popup_freight").css("transition", "all ease-in-out 300ms");
        $(".popup_freight").css("visibility", "hidden");
        $(".popup-box").css("opacity", "0");
        $(".popup-box").css("transform", "scale(0.3)");
    }

    //attach popup
    $(".popupable").click(function () {
        open_popup();
    });

    $(".popupable_freight_origin").click(function () {
        $(".button-add_extra_service_freight").val("origin");
        open_popup_freight();
    });

    $(".popupable_freight_destination").click(function () {
        $(".button-add_extra_service_freight").val("destination");
        open_popup_freight();
    });

    $(".popupable_freight").click(function () {
        open_popup_freight();
    });

    function remove_label_extra_service(){
        var id = $(this).attr("id");
        if($(this).attr("service") == "normal"){
            var hidden_nama = $("#hidden_nama_extra_service").val().split(",");
            var hidden_harga_20 = $("#hidden_harga_20_feet_extra_service").val().split(",");
            var hidden_harga_40 = $("#hidden_harga_40_feet_extra_service").val().split(",");
            var hidden_harga_45 = $("#hidden_harga_45_feet_extra_service").val().split(",");
            var index = $.inArray(id,hidden_nama);
            hidden_nama.splice(index,1);
            hidden_harga_20.splice(index,1);
            hidden_harga_40.splice(index,1);
            hidden_harga_45.splice(index,1);
            $("#hidden_nama_extra_service").val(hidden_nama);
            $("#hidden_harga_20_feet_extra_service").val(hidden_harga_20);
            $("#hidden_harga_40_feet_extra_service").val(hidden_harga_40);
            $("#hidden_harga_45_feet_extra_service").val(hidden_harga_45);
            $(this).remove();
        }
        if($(this).attr("service") == "origin"){
            var hidden_nama = $("#hidden_nama_service_freight_origin").val().split(",");
            var hidden_harga = $("#hidden_harga_service_freight_origin").val().split(",");
            var index = $.inArray(id,hidden_nama);
            hidden_nama.splice(index,1);
            hidden_harga.splice(index,1);
            $("#hidden_nama_service_freight_origin").val(hidden_nama);
            $("#hidden_harga_service_freight_origin").val(hidden_harga);
            $(this).remove();
        }
        if($(this).attr("service") == "destination"){
            var hidden_nama = $("#hidden_nama_service_freight_destination").val().split(",");
            var hidden_harga = $("#hidden_harga_service_freight_destination").val().split(",");
            var index = $.inArray(id,hidden_nama);
            hidden_nama.splice(index,1);
            hidden_harga.splice(index,1);
            $("#hidden_nama_service_freight_destination").val(hidden_nama);
            $("#hidden_harga_service_freight_destination").val(hidden_harga);
            $(this).remove();
        }
    }
});
