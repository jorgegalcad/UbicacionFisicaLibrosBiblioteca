$(document).ready(function()
{
   $('.modal-trigger').leanModal();
  $('#boton').click(function()
  {
    obtenerEstantes();
  });
  $('#agregar').click(function()
  {
    agregarEstante();
  });
});
/**
* Obtiene todos los estantes del plano
*/
function obtenerEstantes()
{
  $.ajax(
    {
      url: "/estantes",
      type:'GET',

      success:function(response)
      {
        console.log(response);
      },
      error:function(error)
      {
        console.log(error);
      }
    }
  );
}

function agregarEstante()
{
  var token = $("input[name=_token]").val();
  var parametros={'_token':token,
  'coorX':100};
  $.ajax(
    {
      url: "/estantes",
      type:'POST',
      data:parametros,
      success:function(response)
      {
        console.log(response);
      },
      error:function(error)
      {
        $('#diverror').empty();
        $.each(error.responseJSON, function(i, val) {
          $('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
        });
         $('#modalError').openModal();
      }
    }
  );
}
