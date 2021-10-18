$(document).ready(function () {
    $(this).click(function(){
        $('.error-message').empty();
    });

    $( "#select_id_customer" ).change(function() {
        $("#select_id_customer option[value='']").remove();
    });

    $( "#select_id_container" ).change(function() {
        $("#select_id_container option[value='']").remove();
    });

    $( "#select_id_port" ).change(function() {
        $("#select_id_port option[value='']").remove();
    });


    $( "#select_id_service" ).change(function() {
        $("#select_id_service option[value='']").remove();
        $("#label_extra_service_freight_origin").css("display", "none");
        $("#label_extra_service_freight_destination").css("display", "none");
        $("#label_extra_service_common").css("display", "none");
        $("#container_extra_service_custom_handling").css("display", "none");
        $("#container_extra_service_freight_origin").css("display", "none");
        $("#container_extra_service_freight_destination").css("display", "none");
        $(".input_freight").css("display","none");

        $("#hidden_nama_extra_service").val("");
        $("#hidden_harga_20_feet_extra_service").val("");
        $("#hidden_harga_40_feet_extra_service").val("");
        $("#hidden_harga_45_feet_extra_service").val("");

        $("#hidden_nama_service_freight_origin").val("");
        $("#hidden_harga_service_freight_origin").val("");
        $("#hidden_nama_service_freight_destination").val("");
        $("#hidden_harga_service_freight_destination").val("");

        if($('#select_id_service option:selected').val() == 1){
            $("#label_extra_service_common").css("display", "inline");
            $("#container_extra_service_custom_handling").css("display", "block");

            $('.jenis_pengiriman_radio').empty();
            $('.jenis_pekerjaan_radio').empty();
            add_jenis_pengiriman();
            add_jenis_pekerjaan();
        }
        else if($('#select_id_service option:selected').val() == 2){
            $(".input_freight").css("display","block");
            $("#label_extra_service_freight_origin").css("display", "inline");
            $("#label_extra_service_freight_destination").css("display", "inline");
            $("#container_extra_service_freight_origin").css("display", "block");
            $("#container_extra_service_freight_destination").css("display", "block");

            $('.jenis_pengiriman_radio').empty();
            $('.jenis_pekerjaan_radio').empty();
            add_jenis_pengiriman();
            add_jenis_pekerjaan();
        }
        else if($('#select_id_service option:selected').val() == 3){

        }
    });

    $(".jenis_angkutan").click(function(){
        var id = $(this).attr("value");
        if($("#"+id+"").prop('checked')){
            $("#"+id+"").prop('checked', false);
        }
        else{
            $("#"+id+"").prop('checked', true);
        }
    });

    $("#label_extra_service_common").click(function(){
        if($('#select_id_container option:selected').val() == 1){
            var input_harga_20_feet = document.createElement("input");
            input_harga_20_feet.setAttribute("type", "number");
            input_harga_20_feet.setAttribute("id", "harga_extra_service_20_feet");
            input_harga_20_feet.style.display = "block";
            var label_harga_20_feet = document.createElement("label");
            label_harga_20_feet.setAttribute("id", "label_harga_20_feet");
            label_harga_20_feet.setAttribute("class", "label_harga_extra_service");
            label_harga_20_feet.style.display = "block";
            $(".container_harga_extra_service").append(label_harga_20_feet);
            $("#label_harga_20_feet").html("Harga 20 feet : ");
            $("#label_harga_20_feet").append(input_harga_20_feet);

            var input_harga_40_feet = document.createElement("input")
            input_harga_40_feet.setAttribute("type", "number");
            input_harga_40_feet.setAttribute("id", "harga_extra_service_40_feet");
            input_harga_40_feet.style.display = "block";
            var label_harga_40_feet = document.createElement("label");
            label_harga_40_feet.setAttribute("id", "label_harga_40_feet");
            label_harga_40_feet.setAttribute("class", "label_harga_extra_service");
            label_harga_40_feet.style.display = "block";
            $("#label_harga_20_feet").after(label_harga_40_feet);
            $("#label_harga_40_feet").html("Harga 40 feet :");
            $("#label_harga_40_feet").append(input_harga_40_feet);

        }

        if($('#select_id_container option:selected').val() == 2){
            var input_harga_20_feet = document.createElement("input");
            input_harga_20_feet.setAttribute("type", "number");
            input_harga_20_feet.setAttribute("id", "harga_extra_service_20_feet");
            input_harga_20_feet.setAttribute("class", "harga_extra_service");
            input_harga_20_feet.style.display = "block";
            var label_harga_20_feet = document.createElement("label");
            label_harga_20_feet.setAttribute("id", "label_harga_20_feet");
            label_harga_20_feet.setAttribute("class", "label_harga_extra_service");
            label_harga_20_feet.style.display = "block";
            $(".container_harga_extra_service").append(label_harga_20_feet);
            $("#label_harga_20_feet").html("Harga 20 feet :");
            $("#label_harga_20_feet").append(input_harga_20_feet);


            var input_harga_40_feet = document.createElement("input")
            input_harga_40_feet.setAttribute("type", "number");
            input_harga_40_feet.setAttribute("id", "harga_extra_service_40_feet");
            input_harga_40_feet.setAttribute("class", "harga_extra_service");
            input_harga_40_feet.style.display = "block";
            var label_harga_40_feet = document.createElement("label");
            label_harga_40_feet.setAttribute("id", "label_harga_40_feet");
            label_harga_40_feet.setAttribute("class", "label_harga_extra_service");
            label_harga_40_feet.style.display = "block";
            $("#label_harga_20_feet").after(label_harga_40_feet);
            $("#label_harga_40_feet").html("Harga 40 feet :");
            $("#label_harga_40_feet").append(input_harga_40_feet);


            var input_harga_45_feet = document.createElement("input")
            input_harga_45_feet.setAttribute("type", "number");
            input_harga_45_feet.setAttribute("id", "harga_extra_service_45_feet");
            input_harga_45_feet.setAttribute("class", "harga_extra_service");
            input_harga_45_feet.style.display = "block";
            var label_harga_45_feet = document.createElement("label");
            label_harga_45_feet.setAttribute("id", "label_harga_45_feet");
            label_harga_45_feet.setAttribute("class", "label_harga_extra_service");
            label_harga_45_feet.style.display = "block";
            $("#label_harga_40_feet").after(label_harga_45_feet);
            $("#label_harga_45_feet").html("Harga 45 feet :");
            $("#label_harga_45_feet").append(input_harga_45_feet);
        }
    });
});

function add_jenis_pengiriman() {
    var radio_button = document.createElement("INPUT");
    radio_button.setAttribute("type", "radio");
    radio_button.setAttribute("name", "jenis_pengiriman_radio");
    radio_button.setAttribute("class", "FCL");
    radio_button.setAttribute("value", "FCL");
    $('.jenis_pengiriman_radio').append(radio_button);

    var label = document.createElement("label");
    label.setAttribute("class", "label_radio_button");
    label.setAttribute("id", "FCL");
    label.setAttribute("value", "FCL");
    $('.FCL').after(label);
    $('#FCL').html("FCL");

    $('#FCL').on("click", function(){
        var id = $(this).attr("value");
        if($("."+id+"").prop('checked')){
            $("."+id+"").prop('checked', false);
        }
        else{
            $("."+id+"").prop('checked', true);
        }
    });

    var radio_button = document.createElement("INPUT");
    radio_button.setAttribute("type", "radio");
    radio_button.setAttribute("name", "jenis_pengiriman_radio");
    radio_button.setAttribute("class", "LCL");
    radio_button.setAttribute("value", "LCL");
    $('.jenis_pengiriman_radio').append(radio_button);

    label = document.createElement("label");
    label.setAttribute("class", "label_radio_button");
    label.setAttribute("id", "LCL");
    label.setAttribute("value", "LCL");
    $('.LCL').after(label);
    $('#LCL').html("LCL");

    $('#LCL').on("click", function(){
        var id = $(this).attr("value");
        if($("."+id+"").prop('checked')){
            $("."+id+"").prop('checked', false);
        }
        else{
            $("."+id+"").prop('checked', true);
        }
    });
}

function add_jenis_pekerjaan(){
    var radio_button = document.createElement("INPUT");
    value = "common";
    radio_button.setAttribute("type", "radio");
    radio_button.setAttribute("name", "jenis_pekerjaan_radio");
    radio_button.setAttribute("class", "common");
    radio_button.setAttribute("value", "common");
    $('.jenis_pekerjaan_radio').append(radio_button);

    var label = document.createElement("label");
    label.setAttribute("class", "label_radio_button");
    label.setAttribute("id", "common");
    label.setAttribute("value", "common");
    $('.common').after(label);
    $('#common').html("common");

    $('#common').on("click", function(){
        var id = $(this).attr("value");
        if($("."+id+"").prop('checked')){
            $("."+id+"").prop('checked', false);
        }
        else{
            $("."+id+"").prop('checked', true);
        }
    });

    var radio_button = document.createElement("INPUT");
    value = "grey";
    radio_button.setAttribute("type", "radio");
    radio_button.setAttribute("name", "jenis_pekerjaan_radio");
    radio_button.setAttribute("class", "grey");
    radio_button.setAttribute("value", "grey");
    $('.jenis_pekerjaan_radio').append(radio_button);

    var label = document.createElement("label");
    label.setAttribute("class", "label_radio_button");
    label.setAttribute("id", "grey");
    label.setAttribute("value", "grey");
    $('.grey').after(label);
    $('#grey').html("grey");

    $('#grey').on("click", function(){
        var id = $(this).attr("value");
        if($("."+id+"").prop('checked')){
            $("."+id+"").prop('checked', false);
        }
        else{
            $("."+id+"").prop('checked', true);
        }
    });

    var radio_button = document.createElement("INPUT");
    value = "allin";
    radio_button.setAttribute("type", "radio");
    radio_button.setAttribute("name", "jenis_pekerjaan_radio");
    radio_button.setAttribute("class", "all_in");
    radio_button.setAttribute("value", "all_in");
    $('.jenis_pekerjaan_radio').append(radio_button);

    var label = document.createElement("label");
    label.setAttribute("class", "label_radio_button");
    label.setAttribute("id", "allin");
    label.setAttribute("value", "all_in");
    $('.all_in').after(label);
    $('#allin').html("all in");

    $('#allin').on("click", function(){
        var id = $(this).attr("value");
        if($("."+id+"").prop('checked')){
            $("."+id+"").prop('checked', false);
        }
        else{
            $("."+id+"").prop('checked', true);
        }
    });
}
