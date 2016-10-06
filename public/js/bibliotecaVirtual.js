var offset;
var opcion=-1;
var estantes=new Array();
var codigos=new Array();
$(document).ready(function()
{
  $('.modal-trigger').leanModal();
  $('.collapsible').collapsible({
    accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
  });
  $('#divPlano').click(function(e)
  {
    if(opcion==1){
      offset = $(this).offset();
      var x=e.pageX - offset.left;
      var y=e.pageY - offset.top;
      $('#coorXEstante').val(x);
      $('#coorYEstante').val(y);
      $('#modalEstante').openModal();
    }
    if(opcion==2)
    {
      offset = $(this).offset();
      var x=e.pageX - offset.left;
      var y=e.pageY - offset.top;
      $('#coorXCodigo').val(x);
      $('#coorYCodigo').val(y);
      $('#modalCodigo').openModal();
    }
  });

  $('#agregarE').click(function()
  {
    agregarElementoEstante();
  });
  $('#agregarC').click(function()
  {
    agregarElementoCodigo();
  });
  $('#agregarEstante').click(function()
  {
    $('#operacion').html("Agregando estante");
    $('#icon').html('add');
    opcion=1;
  });
  $('#agregarCodigo').click(function()
  {
    $('#operacion').html("Agregando código");
    $('#icon').html('add');
    opcion=2;
  });
  $('#mover').click(function()
  {
    $('#icon').html('edit');
    $('#operacion').html("Moviendo");
  });
  $('#editar').click(function()
  {
    $('#icon').html('edit');
    $('#operacion').html("Editando");
  });
  $('#eliminar').click(function()
  {
    $('#icon').html('delete');
    $('#operacion').html("Eliminando");
  });
});
/**
* Agrega un codigo al plano gráfico
*/
function agregarElementoCodigo()
{
  var x=$('#coorXCodigo').val();
  var y=$('#coorYCodigo').val();
  if(x!="" && y!=""){
    var codigo=makeSVG('circle', {cx:x,cy:y,r:20,fill:'#3f51b5'});
    $('#divPlano').append(codigo);
    $('#modalCodigo').closeModal();
  }
}
/**
* Agrega un estanto al plano grafico
*/
function agregarElementoEstante()
{
  var x=$('#coorXEstante').val();
  var y=$('#coorYEstante').val();
  var alto=$('#alto').val();
  var ancho=$('#ancho').val();
  if(x!="" && y!="" && alto!="" && ancho!=""){
    var estante= makeSVG('rect', {x:x,y:y,width:ancho, height:alto, fill:'#5c6bc0'});
    $('#divPlano').append(estante);
    $('#modalEstante').closeModal();
  }
}
/**
* Construye un elemento gráfico
*/
function makeSVG(tag, attrs) {
  var el= document.createElementNS('http://www.w3.org/2000/svg', tag);
  for (var k in attrs)
  el.setAttribute(k, attrs[k]);
  return el;
}
/**
* Representa un codigo
*/
function Codigo()
{

}
/**
* Representa un estante
*/
function Estante()
{

}
