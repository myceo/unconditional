"use strict";

function toogleOptions(){

    if($('#public').val()=='1'){
        $('#option-box').show();
        console.log('is select');
    }
    else{
        $('#option-box').hide();
        console.log('not select');
    }
}

$(function(){
    toogleOptions();
    $('#public').on('change',function(){
        toogleOptions();
    });
})
