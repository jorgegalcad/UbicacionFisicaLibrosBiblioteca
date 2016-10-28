//contenedor del plana
var container;
//elementos de dinujo y renderizado
var camera, scene, renderer,controls;
//plano sobre el que se dibuja
var plane;
//elementos de dinujo
var object;
var startTime;
var mouse, raycaster
//indica la opcion que se esta realizando
var opcion=-1;
//ancho del plano
var ancho;
//alto del plano
var alto;
//espacio entre el plano y su padding izquierdo
var left;
//espacio entre el plano y el top
var tope;
//objetos estante
var objectsE = [];
//offset del plano
var offset;
//estantes del plani
var estantes=[];
//codigos del plano
var codigos=[];
//estante actual
var estanteActual=null;
//codigo actual
var codigoActual=null;
//interseccion actual
var intersectActual=null;
//indice del estante actual
var indiceEstante=-1;
//indice del codigo actual
var indiceCodigo=-1;
//indice del objeto general
var indiceObjeto=-1;
//ruta de la imagen
var url;
//imagen QR
var img
var codigosQR=[];
var $selectDropdown;
var idPlanos=[];
$(document).ready(function()
{
	ancho=$('#div-plano').width();
	alto=$('#row').height();
	offset=$('#div-plano').offset();
	left=offset.left;
	tope=offset.top;
	url = $('meta[name="base_url"]').attr('content');
	img = new THREE.MeshBasicMaterial({ //CHANGED to MeshBasicMaterial
		map:new THREE.ImageUtils.loadTexture(url+"/js/qr.png")
	});
	$('select').material_select();
	$selectDropdown =
	$("#usoS")
	.empty()
	.html(' ');


	$selectDropdown.trigger('contentChanged');
	//img.map.needsUpdate = true; //ADDED
	init();
	obtenerEstantes();
	obtenerCodigos();
	getCodigosQRSinUso();
	render();
	animate();

});
$('select').on('contentChanged', function() {
	// re-initialize (update)
	$(this).material_select();
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

	opcion=3;
	/**	$('#div-plano').loading({
	message: "Cargando ..."
});
$.notify("Hola a todo",{position:"right middle",className:"success"});*/
});
$('#editar').click(function()
{
	opcion=5;
	$('#icon').html('edit');
	$('#operacion').html("Editando");

});
$('#eliminar').click(function()
{
	opcion=7;
	$('#icon').html('delete');
	$('#operacion').html("Eliminando");
});
$('#agregarE').click(function()
{
	agregarElementoEstante();
});
$('#agregarC').click(function()
{
	agregarElementoCodigo();
});
$('#habilitar').click(function()
{
	var cont=$('#valorH').text();
	if(cont=="Deshabilitar zoom")
	{
		$('#valorH').html('Habilitar zoom');
		$('#icon-hab').html('visibility');
		controls.dispose();
	}
	else {
		$('#valorH').html('Deshabilitar zoom');
		$('#icon-hab').html('visibility_off');
		controls.recargar();
	}

});
$('#actualizarE').click(function()
{
	var x=$('#coorXEstanteAct').val();
	var y=$('#coorYEstanteAct').val();;
	var ancho=$('#anchoAct').val();
	var alto=$('#altoAct').val();
	var largo=$('#largoAct').val();
	var codigo=$('#codigoAct').val();
	if(x!="" && y!="" && ancho!=""&& alto!="" && largo!="" && codigo!="")
	{
		actualizarEstanteEnServidor(x,y,ancho,alto,largo,codigo);
		$('#modalEstanteAct').closeModal();
	}

});
/**
* Inicia el renderizado
*/
function init() {
	renderer = new THREE.CanvasRenderer();
	container =document.getElementById('div-plano');


	camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 10000 );
	camera.position.set( 10, 800, 1300);
	camera.lookAt( new THREE.Vector3() );

	scene = new THREE.Scene();

	var size = 500, step = 50;

	var geometry = new THREE.Geometry();

	for ( var i = - size; i <= size; i += step ) {

		geometry.vertices.push( new THREE.Vector3( - size, 0, i ) );
		geometry.vertices.push( new THREE.Vector3(   size, 0, i ) );

		geometry.vertices.push( new THREE.Vector3( i, 0, - size ) );
		geometry.vertices.push( new THREE.Vector3( i, 0,   size ) );

	}
	geometry.computeFaceNormals ();
	geometry.computeVertexNormals ();
	var material = new THREE.LineBasicMaterial( { color: 0x000000, opacity: 0.2 } );

	var line = new THREE.LineSegments( geometry, material );
	scene.add( line );


	// plane


	raycaster = new THREE.Raycaster();
	mouse = new THREE.Vector2();

	var geometry = new THREE.PlaneBufferGeometry( 1000, 1000 );
	geometry.rotateX( - Math.PI / 2 );

	plane = new THREE.Mesh( geometry, new THREE.MeshBasicMaterial( { visible: false } ) );
	scene.add( plane );

	objectsE.push( plane );

	var material = new THREE.MeshBasicMaterial( { color: 0xff0000, wireframe: true } );

	// Lights

	var ambientLight = new THREE.AmbientLight( 0x606060 );
	scene.add( ambientLight );

	var directionalLight = new THREE.DirectionalLight( 0xffffff );
	directionalLight.position.x = Math.random() - 0.5;
	directionalLight.position.y = Math.random() - 0.5;
	directionalLight.position.z = Math.random() - 0.5;
	directionalLight.position.normalize();
	scene.add( directionalLight );

	var directionalLight = new THREE.DirectionalLight( 0x808080 );
	directionalLight.position.x = Math.random() - 0.5;
	directionalLight.position.y = Math.random() - 0.5;
	directionalLight.position.z = Math.random() - 0.5;
	directionalLight.position.normalize();
	scene.add( directionalLight );


	renderer.setClearColor( 0xf0f0f0 );
	renderer.setPixelRatio( window.devicePixelRatio );
	renderer.setSize(ancho, alto);
	container.appendChild(renderer.domElement);

	var localPlane = new THREE.Plane( new THREE.Vector3( 0, - 1, 0 ), 0.8 ),
	globalPlane = new THREE.Plane( new THREE.Vector3( - 1, 0, 0 ), 0.1 );

	object = new THREE.Mesh( geometry, material );
	object.castShadow = true;
	scene.add( object );
	var globalPlanes = [ globalPlane ],
	Empty = Object.freeze( [] );
	renderer.clippingPlanes = Empty; // GUI sets it to globalPlanes
	renderer.localClippingEnabled = true;

	// Controls

	controls = new THREE.OrbitControls( camera, renderer.domElement );
	controls.target.set( 0, 1, 0 );
	controls.update();

	//document.addEventListener( 'mousedown', onDocumentMouseDown, false );
	//document.addEventListener( 'keydown', onDocumentKeyDown, false );
	//document.addEventListener( 'keyup', onDocumentKeyUp, false );
	window.addEventListener( 'resize', onWindowResize, false );
	construirEjes();
	var axis=new THREE.AxisHelper(500);
	material = new THREE.LineBasicMaterial( { color:'#5c6bc0', opacity: 0.2 } );

	line = new THREE.LineSegments( axis, material );
	scene.add(axis);
}
/**
* Busca un posible estante en en el arreglo de estantes
* @param estante el posible estante
*/
function buscarEstante(estante)
{
	for(var i=0;i<estantes.length;i++)
	{
		if(estantes[i].cubo==estante)
		{
			return estantes[i];
		}

	}
	return null;
}
/**
* Busca un posible codigo en el arreglo de codigos
* @param codigo el posible codigo a buscar
*/
function buscarCodigo(codigo)
{
	for(var i=0;i<codigos.length;i++)
	{
		if(codigos[i].imagen==codigo)
		{
			return codigos[i];
		}

	}
	return null;
}
function onWindowResize() {

	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();

	renderer.setSize( window.innerWidth, window.innerHeight );

	render();

}

$('#div-plano').mousedown(function(event) {

	mouse.x = ( (event.clientX-left) / renderer.domElement.clientWidth ) * 2 - 1;
	mouse.y = -((event.clientY-tope) / renderer.domElement.clientHeight ) * 2 + 1;

	raycaster.setFromCamera( mouse, camera );

	var intersects = raycaster.intersectObjects( objectsE );
	var intersect = intersects[ 0 ];
	var x;
	var y;
	switch(opcion){
		case 1:
		if ( intersects.length > 0 ) {
			x=(( (event.clientX-left) / renderer.domElement.clientWidth ) * 2 - 1)*500;
			y=(-((event.clientY-tope) / renderer.domElement.clientHeight ) * 2 + 1)*500;

			$('#coorXEstante').val(intersect.point.x);
			$('#coorYEstante').val(intersect.point.z);
			$('#modalEstante').openModal();
		}
		break;
		case 2:
		$('#coorXCodigo').val(intersect.point.x);
		$('#coorYCodigo').val(intersect.point.z);
		$('#modalCodigo').openModal();
		break;
		case 3:
		if ( intersects.length > 0 ) {

			if ( intersect.object != plane ) {
				intersectActual=intersect;
				estanteActual=buscarEstante(intersect.object);
				if(estanteActual==null)
				{
					codigoActual=buscarCodigo(intersect.object);
				}
			}

		}
		break;
		case 4:
		break;
		case 5:
		if ( intersects.length > 0 ) {
			if ( intersect.object != plane ) {
				intersectActual=intersect;
				estanteActual=buscarEstante(intersect.object);
				if(estanteActual==null)
				{
					codigoActual=buscarCodigo(intersect.object);
				}
				else {
					$('#coorXEstanteAct').val(estanteActual.cubo.position.x);
					$('#coorYEstanteAct').val(estanteActual.cubo.position.z);
					$('#anchoAct').val(estanteActual.cubo.scale.x);
					$('#altoAct').val(estanteActual.cubo.scale.y);
					$('#largoAct').val(estanteActual.cubo.scale.z);
					$('#codigoAct').val(estanteActual.datos.codigo);
					$('#modalEstanteAct').openModal();
				}
			}
		}
		break;
		case 6:
		break;
		case 7:
		if ( intersects.length > 0 ) {
			if ( intersect.object != plane ) {
				//scene.remove(intersect.object );
				var indice=objectsE.indexOf( intersect.object );
				indiceObjeto=indice;
				intersectActual=intersect;
				estanteActual=buscarEstante(intersect.object);
				if(estanteActual==null)
				{
					codigoActual=buscarCodigo(intersect.object);
					if(codigoActual!=null)
					{
						indiceCodigo=codigos.indexOf(codigoActual);
						eliminarCodigoUbicado();
					}
				}
				else {
					indiceEstante=estantes.indexOf(estanteActual);
					eliminarEstante();
				}
			}
		}
		break;
		default:
		break;
	}

});
$('#div-plano').mousemove(function(e)
{
	e.preventDefault();
	if(opcion==3)
	{
		x=(( (event.clientX-left) / renderer.domElement.clientWidth ) * 2 - 1)*500;
		y=(-((event.clientY-tope) / renderer.domElement.clientHeight ) * 2 + 1)*500;
		var inte=obtenerIntersecciones(x,y);
		if(estanteActual!=null && estanteActual!=undefined)
		{

			estanteActual.cubo.position.set(inte[0].point.x,estanteActual.cubo.position.y,inte[0].point.z);
		}
		else {
			if(codigoActual!=null && codigoActual!=undefined)
			{
				codigoActual.imagen.position.set(inte[0].point.x,codigoActual.imagen.position.y,inte[0].point.z);

			}
		}
	}
});
$('#div-plano').mouseup(function(e)
{
	if(estanteActual!=null)
	{
		actualizarCoordenadasEstante(estanteActual.cubo.position.x,estanteActual.cubo.position.z);
	}
	else {
		if(codigoActual!=null)
		{
			actualizarCodigoEnServidor(codigoActual.imagen.position.x,codigoActual.imagen.position.z)
		}
	}
});
/**
* Construye etiquetas de los ejes
*/
function construirEjes()
{

	var sp = contruirSprite('#5c6bc0','Eje X',550,0,0,80,80,80,150);
	scene.add(sp);
	sp = contruirSprite('#5c6bc0','Eje -X',-550,0,0,80,80,80,150);
	scene.add(sp);
	sp = contruirSprite('#5c6bc0','Eje Y',0,0,550,80,80,80,150);
	scene.add(sp);
	sp = contruirSprite('#5c6bc0','Eje -Y',0,0,-550,80,80,80,150);
	scene.add(sp);
	sp = contruirSprite('#5c6bc0','Eje Z',0,300,0,80,80,80,150);
	scene.add(sp);
	sp = contruirSprite('#5c6bc0','Eje -Z',0,-300,0,80,80,80,150);
	scene.add(sp);

}
/**
* Construye un sprite
* @param  color  el color del texto en hexadecimal
* @param  texto  el texto a colocr en el sprite
* @param  x  coordenada en x del sprite
* @param  y   coodenada en y del sprite
* @param  z   coordenada en z del sprite
* @param ancho  ancho del sprite
* @param alto    alto de sprite
* @param largo  largo del sprite
* @param tamanioLetra   tamaño de la letra
*/
function contruirSprite(color,texto,x,y,z,ancho,alto,largo,tamanioLetra)
{
	var canvas = document.createElement('canvas');
	canvas.width = 400;
	canvas.height = 400;
	var context = canvas.getContext('2d');
	context.fillStyle = color; // CHANGED
	context.textAlign = 'center';
	context.font = tamanioLetra+'px Arial';
	context.fillText(texto, 200, 200);

	var amap = new THREE.Texture(canvas);
	amap.needsUpdate = true;

	var mat = new THREE.SpriteMaterial({
		map: amap,
		transparent: false,
		useScreenCoordinates:true,
		color: 0xffffff // CHANGED
	});

	var sp = new THREE.Sprite(mat);
	sp.position.x=x;
	sp.position.y=y;
	sp.position.z=z;
	sp.scale.set( ancho, largo, alto );
	return sp;
}
/**
* Obtiene las intersecciones entre elementos
* @param x  coordenada en x
* @param y  coordenada en y
*/
function obtenerIntersecciones(x,y)
{
	mouse.x = x/500;
	mouse.y = y/500;

	raycaster.setFromCamera( mouse, camera );

	return raycaster.intersectObjects( objectsE);
}
/**
* Construye un estante a partir de los parametros del evento del mouse7
* @param x coordenada en x, donde se pone el estante
* @param y coordenada en y, donde se pone el estante
* @param ancho  ancho del estante
* @param alto  alto del estante
* @param largo  largo del estante
* @param estante  datos del estante
*/
function construirEstanteGrafico(x,y,ancho,alto,largo,estante)
{


	var cubeGeometry = new THREE.BoxGeometry(1, 1, 1);
	var dynamicTexture	= new THREEx.DynamicTexture(512,512);
	dynamicTexture.clear('#B45F04')
	.drawText(estante.codigo, undefined, 100, 'white');
	var cubeMaterial = new THREE.MeshLambertMaterial( {map	: dynamicTexture.texture, color: '#B45F04', overdraw: 0.5 } );
	var voxel = new THREE.Mesh( cubeGeometry, cubeMaterial );
	//	voxel.position.copy( intersect.point ).add( intersect.face.normal );
	//	voxel.position.divideScalar( 50 ).floor().multiplyScalar( 50 ).addScalar( 25);
	//	voxel.position.set(voxel.position.x,alto/2,voxel.position.z);
	voxel.position.set(x,alto/2,y);
	voxel.scale.x=ancho;
	voxel.scale.y=alto;
	voxel.scale.z=largo;
	scene.add( voxel );
	objectsE.push( voxel );
	estantes.push(new Estante(voxel,dynamicTexture,estante));
	render();

}
/**
* Agrega un codigo al plano gráfico
*/
function agregarElementoCodigo()
{
	var x=$('#coorXCodigo').val();
	var y=$('#coorYCodigo').val();
	var idCodigo=$('#usoS').val();

	if(x!="" && y!="" && idCodigo!=null){
		agregarCodigoAServidor(x,y,idCodigo);
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
	var largo=$('#largo').val();
	var codigo=$('#codigo').val();
	if(x!="" && y!="" && alto!="" && ancho!="" && largo!="" && codigo!=""){
		agregarEstanteAServidor(x,y,ancho,alto,largo,codigo)
		$('#modalEstante').closeModal();
	}
}
function onDocumentKeyDown( event ) {

	switch( event.keyCode ) {

		case 16: isShiftDown = true; break;

	}

}

function onDocumentKeyUp( event ) {

	switch( event.keyCode ) {

		case 16: isShiftDown = false; break;

	}
}

function save() {

	window.open( renderer.domElement.toDataURL('image/png'), 'mywindow' );
	return false;

}

function render() {

	renderer.render( scene, camera );

}

function animate() {

	var currentTime = Date.now(),
	time = ( currentTime - startTime ) / 1000;

	requestAnimationFrame( animate );

	object.position.y = 0.8;
	object.rotation.x = time * 0.5;
	object.rotation.y = time * 0.2;
	object.scale.setScalar( Math.cos( time ) * 0.125 + 0.875 );

	renderer.render( scene, camera );

}
/**
* Representacion general de un estante
*/
function Estante(cubo,textura,datos)
{
	this.cubo=cubo;
	this.textura=textura;
	this.datos=datos;
}
/**
* Obtiene todos los estantes del plano
*/
function obtenerEstantes()
{
	$('#div-plano').loading({
		message: "Cargando Estantes..."
	});
	$.ajax(
		{
			url: "/estantes",
			type:'GET',

			success:function(response)
			{
				var estantes=response.estantes;
				estantes.forEach(function(item,i)
				{
					construirEstanteDesdeRespuesta(item);
				});
				$('#div-plano').loading('stop');
			},
			error:function(error)
			{
				$('#div-plano').loading('stop');
				$.notify("Ocurrio un error cargando los elementos",{position:"right middle",className:"error"});
			}
		}
	);
}
/**
* Construye un estante desde la respuesta del servidor
*/
function construirEstanteDesdeRespuesta(estante)
{
	var x=parseFloat(estante.coorX);
	var y=parseFloat(estante.coorY);
	var ancho=parseFloat(estante.ancho);
	var alto=parseFloat(estante.alto);
	var largo=parseFloat(estante.largo);
	var codigo=estante.codigo;
	var cubeGeometry = new THREE.BoxGeometry(1, 1, 1);
	var dynamicTexture	= new THREEx.DynamicTexture(512,512);
	dynamicTexture.clear('#B45F04')
	.drawText(codigo, undefined, 100, 'white');
	var cubeMaterial = new THREE.MeshLambertMaterial( {map	: dynamicTexture.texture, color: '#B45F04', overdraw: 0.5 } );
	var voxel = new THREE.Mesh( cubeGeometry, cubeMaterial );
	voxel.position.set(x,alto/2,y);
	voxel.scale.x=ancho;
	voxel.scale.y=alto;
	voxel.scale.z=largo;
	scene.add( voxel );
	objectsE.push( voxel );
	estantes.push(new Estante(voxel,dynamicTexture,estante));
	render();
}
/**
* Guarda un estante en el servidor, y posteriormente lo dibuja
* @param x coordenada en x, donde se pone el estante
* @param y coordenada en y, donde se pone el estante
* @param ancho  ancho del estante
* @param alto  alto del estante
* @param largo  largo del estante
* @param codigo  codigo del estante
*/
function agregarEstanteAServidor(x,y,ancho,alto,largo,codigo)
{
	$('#div-plano').loading({message:"Agregando estante..."});
	var token = $("input[name=_token]").val();
	var parametros={'_token':token,
	'coorX':x,
	'coorY':y,
	'ancho':ancho,
	'alto':largo,
	'largo':largo,
	'codigo':codigo,
	'id_plano':idPlanos[0]
};
$.ajax(
	{
		url: "/estantes",
		type:'POST',
		data:parametros,
		success:function(response)
		{

			construirEstanteGrafico(x,y,ancho,alto,largo,response.estante);
			$('#div-plano').loading('stop');
			$.notify(response.mensaje,{position:"right middle",className:"success"});
		},
		error:function(error)
		{
			$('#div-plano').loading('stop');
			$('#diverror').empty();
			$.each(error.responseJSON, function(i, val) {
				$('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
			});
			$('#modalError').openModal();

		}
	}
);
}
/**
* Actualiza las coordenadas del estante actual
* @param x  coordenada en x del estante
* @param y  coordenada en y del estante
*/
function actualizarCoordenadasEstante(x,y)
{
	if ( estanteActual!=null ) {
		$('#div-plano').loading({message:"Actualizando estante..."});
		var token = $("input[name=_token]").val();
		var parametros={'_token':token,
		_method:"PUT",
		'coorX':x,
		'coorY':y,
	};

	$.ajax(
		{
			url: "/estantes/"+estanteActual.datos.id+"/posicion",
			type:'POST',
			data:parametros,
			success:function(response)
			{
				estanteActual.cubo.position.set(x,estanteActual.cubo.position.y,y);
				estanteActual.datos=response.estante;
				$('#div-plano').loading('stop');
				$.notify(response.mensaje,{position:"right middle",className:"success"});
				estanteActual=null;
			},
			error:function(error)
			{
				estanteActual.cubo.position.set(intersectActual.point.x,estanteActual.cubo.position.y,intersectActual.point.z);
				$('#div-plano').loading('stop');
				$('#diverror').empty();
				$.each(error.responseJSON, function(i, val) {
					$('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
				});
				$('#modalError').openModal();

			}
		}
	);
}
}
/**
* Actualiza el estante
* @param x coordenada en x, donde se pone el estante
* @param y coordenada en y, donde se pone el estante
* @param ancho  ancho del estante
* @param alto  alto del estante
* @param largo  largo del estante
* @param codigo  codigo del estante
*/
function actualizarEstanteEnServidor(x,y,ancho,alto,largo,codigo)
{

	if ( intersectActual!=null ) {
		$('#div-plano').loading({message:"Actualizando estante..."});
		var token = $("input[name=_token]").val();
		var parametros={'_token':token,
		'_method':"PUT",
		'coorX':intersectActual.point.x,
		'coorY':intersectActual.point.z,
		'ancho':ancho,
		'alto':largo,
		'largo':largo,
		'codigo':codigo,
		'id_plano':idPlanos[0]
	};

	$.ajax(
		{
			url: "/estantes/"+estanteActual.datos.id,
			type:'POST',
			data:parametros,
			success:function(response)
			{
				actualizarEstanteGrafico(x,y,ancho,alto,largo,codigo);
				estanteActual.datos=response.estante;
				$('#div-plano').loading('stop');
				$.notify(response.mensaje,{position:"right middle",className:"success"});
				estanteActual=null;
			},
			error:function(error)
			{
				$('#div-plano').loading('stop');
				$('#diverror').empty();
				$.each(error.responseJSON, function(i, val) {
					$('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
				});
				$('#modalError').openModal();

			}
		}
	);
}
}
/**
* Actualiza el estante de forma gráfica
* @param x coordenada en x, donde se pone el estante
* @param y coordenada en y, donde se pone el estante
* @param ancho  ancho del estante
* @param alto  alto del estante
* @param largo  largo del estante
* @param codigo  codigo del estante
*/
function actualizarEstanteGrafico(x,y,ancho,alto,largo,codigo)
{

	estanteActual.cubo.position.set(x,alto/2,y);
	estanteActual.cubo.scale.x=ancho;
	estanteActual.cubo.scale.y=alto;
	estanteActual.cubo.scale.z=largo;
	estanteActual.textura.clear('#B45F04')
	estanteActual.textura.drawText(codigo, undefined, 100, 'white');
}
/**
* Elimina el estante actual
*/
function eliminarEstante()
{
	$('#div-plano').loading({message:"Eliminando estante..."});
	var token = $("input[name=_token]").val();
	var parametros={'_token':token,
	_method:"DELETE"
};
$.ajax(
	{
		url: "/estantes/"+estanteActual.datos.id,
		type:'POST',
		data:parametros,
		success:function(response)
		{
			objectsE.splice(indiceObjeto,1);
			estantes.splice(indiceEstante,1);
			scene.remove(intersectActual.object);
			estanteActual=null;
			indiceEstante=-1;
			intersectActual=null;
			$('#div-plano').loading('stop');
			$.notify(response.mensaje,{position:"right middle",className:"success"});
		},
		error:function(error)
		{
			$('#div-plano').loading('stop');
			$('#diverror').empty();
			$.each(error.responseJSON, function(i, val) {
				$('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
			});
			$('#modalError').openModal();

		}
	}
);
}
/**
* Representa un codigo, con su representacion gráfica y sus datos
*/
function Codigo(imagen,datos)
{
	this.imagen=imagen;
	this.datos=datos;
}
/**
* Obtiene los codigos ubicados del servidor
*/
function obtenerCodigos()
{
	$('#div-plano').loading({
		message: "Cargando Codigos..."
	});
	$.ajax(
		{
			url: "/codigosubicados",
			type:'GET',

			success:function(response)
			{
				var codigos=response.codigos;
				codigos.forEach(function(item,i)
				{
					construirCodigoDesdeRespuesta(item);
				});
				$('#div-plano').loading('stop');
			},
			error:function(error)
			{
				$('#div-plano').loading('stop');
				$.notify("Ocurrio un error cargando los elementos",{position:"right middle",className:"error"});
			}
		}
	);
}
/**
* Construye gráficamente un codigo
* @param codigo   el codigo que se va a construir
*/
function construirCodigoDesdeRespuesta(codigo)
{
	var  qr= new THREE.Mesh(new THREE.PlaneGeometry(50, 50),img);
	qr.position.set(codigo.coorX,25,codigo.coorY);
	qr.overdraw = true;
	qr.dynamic=true;
	scene.add(qr);
	objectsE.push(qr);
	codigos.push(new Codigo(qr,codigo));
}
/**
* Guarda un codigo ubicado en el servidor, y posteriormente lo dibuja
* @param x coordenada en x, donde se ubica el codigo
* @param y coordenada en y, donde se ubica el codigo
* @param idCodigo  identificador del codigo
*/
function agregarCodigoAServidor(x,y,idCodigo)
{
	$('#div-plano').loading({message:"Agregando código..."});
	var token = $("input[name=_token]").val();
	var parametros={'_token':token,
	'coorX':x,
	'coorY':y,
	'id_codigo':idCodigo,
	'id_plano':idPlanos[0]
};
$.ajax(
	{
		url: "/codigosubicados",
		type:'POST',
		data:parametros,
		success:function(response)
		{
			construirCodigoGrafico(x,y,response.codigo);
			$('#div-plano').loading('stop');
			$.notify(response.mensaje,{position:"right middle",className:"success"});
			$('#modalCodigo').closeModal();
			getCodigosQRSinUso();
		},
		error:function(error)
		{
			$('#div-plano').loading('stop');
			$('#diverror').empty();
			$.each(error.responseJSON, function(i, val) {
				$('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
			});
			$('#modalError').openModal();

		}
	}
);
}
/**
* Construye graficamente el codigo
* @param x  coordenada en x donde se va a ubicar el codigo
* @param y  coordenada en y donde se va a ubicar el codigo
* @param codigo  información del codigo a construir graficamente
*/
function construirCodigoGrafico(x,y,codigo)
{
	var  qr= new THREE.Mesh(new THREE.PlaneGeometry(50, 50),img);
	qr.position.set(x,25,y);
	qr.overdraw = true;
	qr.dynamic=true;
	scene.add(qr);
	objectsE.push(qr);
	codigos.push(new Codigo(qr,codigo));
}

/**
* Actualiza el codigo
* @param x coordenada en x, donde se ubica el codigo
* @param y coordenada en y, donde se ubica el codigo
*/
function actualizarCodigoEnServidor(x,y)
{

	if ( intersectActual!=null ) {
		$('#div-plano').loading({message:"Actualizando codigo..."});
		var token = $("input[name=_token]").val();
		var parametros={'_token':token,
		_method:"PUT",
		'coorX':x,
		'coorY':y,
	};

	$.ajax(
		{
			url: "/codigosubicados/"+codigoActual.datos.id,
			type:'POST',
			data:parametros,
			success:function(response)
			{
				actualizarCodigoGrafico(x,y);
				codigoActual.datos=response.codigo;
				codigoActual=null;
				$('#div-plano').loading('stop');
				$.notify(response.mensaje,{position:"right middle",className:"success"});
			},
			error:function(error)
			{
				codigoActual.imagen.position.set(intersectActual.point.x,codigoActual.imagen.position.y,intersectActual.point.z);
				$('#div-plano').loading('stop');
				$('#diverror').empty();
				$.each(error.responseJSON, function(i, val) {
					$('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
				});
				$('#modalError').openModal();

			}
		}
	);
}
}
/**
* Actualiza el codigo de forma gráfica
* @param x coordenada en x, donde se ubica el codigo
* @param y coordenada en y, donde se ubica el codigo
*/
function actualizarCodigoGrafico(x,y)
{

	codigoActual.imagen.position.set(x,25,y);
}
/**
* Elimina el codigo actual
*/
function eliminarCodigoUbicado()
{
	$('#div-plano').loading({message:"Eliminando codigo..."});
	var token = $("input[name=_token]").val();
	var parametros={'_token':token,
	_method:"DELETE"
};
$.ajax(
	{
		url: "/codigosubicados/"+codigoActual.datos.id,
		type:'POST',
		data:parametros,
		success:function(response)
		{
			objectsE.splice(indiceObjeto,1);
			codigos.splice(indiceCodigo,1);
			scene.remove(intersectActual.object);
			codigoActual=null;
			indiceCodigo=-1;
			intersectActual=null;
			$('#div-plano').loading('stop');
			$.notify(response.mensaje,{position:"right middle",className:"success"});
			getCodigosQRSinUso();
		},
		error:function(error)
		{
			$('#div-plano').loading('stop');
			$('#diverror').empty();
			$.each(error.responseJSON, function(i, val) {
				$('#diverror').append($('<p/>',{text:val[0],class:'white-text'}));
			});
			$('#modalError').openModal();

		}
	}
);
}
/**
* Obtiene los códigos QR que no están asignados
*/
function getCodigosQRSinUso()
{
	$.ajax(
		{
			url: "/codigossinuso",
			type:'GET',

			success:function(response)
			{
				codigosQR=response.codigos;
				idPlanos=response.planos;
				var option;
				$selectDropdown.empty().html(' ');
				for(i=0;i<codigosQR.length;i++)
				{
					option=$('<option/>',{'value':codigosQR[0].id,'text':codigosQR[0].serial_identificador});
					$selectDropdown.append(option);
				}
				$('select').material_select();
			},
			error:function(error)
			{
				$.notify("Ocurrio un error cargando los codgps QR",{position:"right middle",className:"error"});
			}
		}
	);
}
