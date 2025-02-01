"use strict";

function toogleOptions(){

    if($('#type').val()=='select' || $('#type').val()=='radio'){
        $('#option-container').show();
        console.log('is select');
    }
    else{
        $('#option-container').hide();
        console.log('not select');
    }
}

$(function(){
    toogleOptions();
    $('#type').on('change',function(){
        toogleOptions();
    });
})
