var timeout = null;

/*
 * Inicialiamos el rich text
*/
var quill = new Quill('#editor', {
	modules: {
		toolbar: [
			["bold","italic","underline","strike"],
			[{ 'size': ['small','normal','large','huge'] }]
		],
	},
	theme: 'snow',
});

/*
 * Inicialiamos el konva
*/
var stage = new Konva.Stage({
	container: 'container',
	width: $('#previewContainer').width(),
	height: $('#previewContainer').height(),
});

/*
 * agregamos la capa al area de konva
*/
const layer = new Konva.Layer();
stage.add(layer);

/*
 * agragamos un area para introducir la imagen
*/
const shape = new Konva.Image({
	x: 10,
	y: 10,
	draggable: true,
	stroke: 'transparent',
	scaleX: 1 / window.devicePixelRatio,
	scaleY: 1 / window.devicePixelRatio
});
layer.add(shape);

//Disparamos el render al cargar la pagina
renderText();

// Actualizamos el canvas al cambiar la imagen
quill.on('text-change', TextUpdate);

/*
 * creamos la funcion Render
 * para renderizar el contenido del richtext 
*/
function renderText() {
	/*
	 * Convertimos el contenido del rich text a imagen canvas
	*/
	html2canvas(document.querySelector('.ql-editor')).then((canvas) => {
		/*
		 * agregamos la imagen canvas al konva
		*/
		shape.image(canvas)
	});
}

/*
 * creamos la funcion Para actualizar la imagen
 *  
*/
function TextUpdate() {
	if (timeout) { return; }

	timeout = setTimeout(function () {
		timeout = null;
		renderText();
	}, 500);
}


function ExportPDF() {
	var pdf = new jsPDF('p','pt','a4');
/*
	A4 size
	H: 297mm
	W: 210mm
*/
	Width = pdf.internal.pageSize.width;
	Ratio = 297/210;
	Height = Width * Ratio;

	pdf.addImage(
		stage.toDataURL({ pixelRatio: 1 }),
		0,
		0,
		Width,
		Height
	);

	pdf.save('canvas.pdf');
}
