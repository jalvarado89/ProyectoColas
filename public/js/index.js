'use strict';
$(document).ready(function() {
	$('.action').click(function(event) {
		hide_elements2();
		show_elements2();
	});
	$('.inaction').click(function(event) {
		show_elements1();
		hide_elements1();
	});
});

function validar() {
	if(('.action').value){
		document.getElementById("Partes").value = "0";
	}

	if(('.inaction').value){
		document.getElementById("PartesMinutos").value = "0";
	}
}

function hide() {
	$('#ocultar2').hide();
	$('.ocultar2').hide();
	document.getElementById("PartesMinutos").value = "0";
	document.getElementById("Partes").value = "0";
}

function hide_elements1() {
	$('#ocultar1').hide();
	$('.ocultar1').hide();
}

function show_elements1() {
	$('#ocultar2').show();
	$('.ocultar2').show();
}

function hide_elements2() {
	$('#ocultar1').show();
	$('.ocultar1').show();
}

function show_elements2() {
	$('#ocultar2').hide();
	$('.ocultar2').hide();
}