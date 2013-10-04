function addNote() {
	var wWidth = $(window).width();
	console.log(wWidth);
	var dWidth = wWidth * 0.5;
	$("#modal-container").load("/Home/AddNote").dialog({
		width: dWidth,
		modal: true
	});
}