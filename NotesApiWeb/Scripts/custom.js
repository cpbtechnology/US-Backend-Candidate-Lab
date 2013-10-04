
function addNote() {
	var wWidth = $(window).width();
	console.log(wWidth);
	var dWidth = wWidth * 0.5;
	$("#modal-container").load("/Home/AddNote").dialog({
		width: dWidth,
		modal: true
	});
}


function submitForm(frm) {
	if (!$(frm).valid()) { return false; }
	console.log($(frm).serialize());
	$.post($(frm).attr("action"), $(frm).serialize(), function (data) {
		
		console.log(data);
	});
	return false;
}

function cancelForm() {
	
}