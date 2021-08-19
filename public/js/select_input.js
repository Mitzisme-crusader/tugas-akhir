$(document).ready(function () {
    $(this).click(function(){
        $('.error-message').empty();
    });

    $( "#select_id_customer" ).change(function() {
        $(".select_id_customer option[value='']").remove();
    });

    $( "#select_container" ).change(function() {
        $("#select_container option[value='']").remove();
    });

    $( "#select_port" ).change(function() {
        $("#select_port option[value='']").remove();
    });


    $( "#select_id_service" ).change(function() {
        $("#select_id_service option[value='']").remove();
        if($('#select_id_service option:selected').val() == 1){
            $('.jenis_pengiriman_radio').empty();
            $('.jenis_pekerjaan_radio').empty();
            add_jenis_pengiriman();
            add_jenis_pekerjaan();

        }
        else if($('#select_id_service option:selected').val() == 2){

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
