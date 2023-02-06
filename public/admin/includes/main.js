$(".menu").click(function(){
    url = $(this).attr('id')+".html";
    $.get( url, function( data ) {
        $( "#sysBody" ).html( data );
    }).fail(function(xhr, status, error) {
        if(error=="Not Found"){
            html = '<div class="text-center">';
                html += '<div class="error mx-auto" data-text="404">404</div>';
                html += '<p class="lead text-gray-800 mb-5">Página não encontrada</p>';
                html += '<p class="text-gray-500 mb-0">Você está tentando acessar uma página que não existe</p>';
                html += '<a href="./">&larr; Voltar para Home</a>';
            html += '</div>';

            $( "#sysBody" ).html( html );
        }
    });
});

$("#user_name").focus(function(){
    $("#user_name").removeClass('border border-danger');
    $("#alert").hide();
});
$("#user_email").focus(function(){
    $("#user_email").removeClass('border border-danger');
    $("#alert").hide();
});
$("#user_password").focus(function(){
    $("#user_password").removeClass('border border-danger');
    $("#alert").hide();
});
$("#user_rpassword").focus(function(){
    $("#user_rpassword").removeClass('border border-danger');
    $("#alert").hide();
});

function setCookie(cname, cvalue, exdays) {
    //alert(cvalue);
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
  
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
}

