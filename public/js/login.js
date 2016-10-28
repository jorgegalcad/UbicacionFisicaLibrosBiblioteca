$(document).ready(function()
{
  $('#diverror').hide();
  $('#login').click(function()
  {
    $('#diverror').hide();
    var token = $("input[name=_token]").val();
    var parametros={'_token':token,
    'email':$('#email_').val(),
    'password':$('#password_').val()};
    console.log(parametros);
    $.ajax(
      {
        url: "/login",
        type:'POST',
        data:parametros,
        success:function(response)
        {
          $('#modalIniciarSesion').closeModal();
          location.href='/home';
        },
        error:function(error)
        {
          $('#diverror').show();
          $('#diverror').empty();
          $.each(error.responseJSON, function(i, val) {
            $('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
          });
        }
      }
    );
  })

});
