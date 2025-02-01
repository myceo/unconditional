$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let base = $('head').find('base').first().attr('href');
let msgBox ='#loginMsg';
$('#appLoginForm').on('submit',function(e){
    e.preventDefault();
    console.log('Login proceed');
    let img = '<div class="text-center"><img height="50" width="50" src="'+base+'/img/ajax-loader.gif" /></div>';
    $(msgBox).html(img);
    let username = $('#appLoginField').val();
    let action = $(this).attr('action');
    $.post(action, {username:username}, function(response){
        $(msgBox).html('');
        console.log(response);
        if(response.status==true){
            window.location.replace(response.url);
        }
        else{
            $(msgBox).html(response.message);
        }

    });

});

$('#appLoginField').autoComplete({
    resolverSettings: {
        url: base+'/site-search'
    }
});

