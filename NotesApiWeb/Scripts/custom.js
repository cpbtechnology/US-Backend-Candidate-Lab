
function addNote() {
	var wWidth = $(window).width();
	console.log(wWidth);
	var dWidth = wWidth * 0.5;
	$("#modal-container").load("/Home/AddNote").dialog({
		width: dWidth,
		modal: true
	});
}

function editNote(id) {
	var wWidth = $(window).width();
	console.log(wWidth);
	var dWidth = wWidth * 0.5;
	$("#modal-container").load("/Home/EditNote/" + id).dialog({
		width: dWidth,
		modal: true
	});
}


function submitForm(frm) {
	if (!$(frm).valid()) { return false; }
	console.log($(frm).serialize());
	$.post($(frm).attr("action"), $(frm).serialize(), function (data) {
		if (data.success == true) {
			window.location.reload();
		} else {
			alert('An error ocurred please try again');
		}
		console.log(data);
	});
	return false;
}

function cancelForm() {
	$(this).dialog("close");
}