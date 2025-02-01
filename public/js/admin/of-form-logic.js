"use strict";

function toogleOptions(){

    if($('#layout').val()=='h'){
        $('#column-container').show();
        console.log('is select');
    }
    else{
        $('#column-container').hide();
        console.log('not select');
    }
}

$(function(){
    toogleOptions();
    $('#layout').on('change',function(){
        toogleOptions();
    });
})
