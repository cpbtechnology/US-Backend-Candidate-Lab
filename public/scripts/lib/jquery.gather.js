(function() {

var getValue = function(el) {
	// if it's a checkbox, return 1 or 0
	var t = el.attr("type");
	return t == "checkbox" || t == "radio" ?
		(el.is(":checked") ? 1 : 0) : el.val();
};

/** Gathers all input values within the element called upon and returns an object mapping names to values. */
$.fn.gather = function() {

	var nameValuePairs = $("select[name], input[name], textarea[name]", this)
		.filter(function() { 
			return !$(this).attr('data-gather-ignore');
		})
		.map(function() {
			return RJS.keyValue($(this).attr("name"), getValue($(this)));
		})
		.toArray();

	/*******************************
	 * Get slider values
	 *******************************/
	//var sliderPairs = $(".slider", this).map(function() {
	//	var values = $(this).slider("values");
	//	return RJS.keyValue($(this).data("name"), [
	//		{ op: ">=", value: values[0] },
	//		{ op: "<=", value: values[1] }
	//	]);
	//}).toArray();
	
	// merge form data
	var formData = _.extend.apply(_, [].concat({}, nameValuePairs/*, sliderPairs*/));

	return formData;
};

/** Gathers all input values within the element called upon and returns an object mapping names to values. */
$.fn.gatherOpValues = function() {

	/*******************************
	 * Get input and textarea values
	 *******************************/
	var opValue = function(operator, value) {
		operator = operator || "=";
		return operator == "like" ?		{ op: "LIKE", value: "%{0}%".supplant([value]) } :
			operator == "startsWith" ?	{ op: "LIKE", value: "{0}%".supplant([value]) } :
			operator == "endsWith" ?	{ op: "LIKE", value: "%{0}".supplant([value]) } :
										{ op: operator, value: value };
	};

	var inputs = $("input[name], textarea[name]", this);
	var nameGroups = inputs
		.filter(function() { return RJS.hasValue(getValue($(this))); })
		.toArray()
		.group(function(input) {
			return $(input).attr("name");
		});
	var nameValuePairs = 
		RJS.toArray(nameGroups, function(name, elements) {
			var csv = elements.filter(function(el){ return $(el).attr("data-csv"); });
			var nonCsv = elements.filter(function(el){ return !$(el).attr("data-csv"); });
			
			var nonCsvopValuePairs = nonCsv.map(function(el) { 
				return opValue($(el).data("operator"), getValue($(el)));
			});
			var csvpValuePairs = _.flatten(csv.map(function(el){
				return getValue($(el)).split(/\s*,\s*/).map(function(val){
					return opValue($(el).data("operator"), val);
				});
			}),true);
			return RJS.keyValue(name, nonCsvopValuePairs.concat(csvpValuePairs));
		});
	
	/*******************************
	 * Get dropdown values
	 *******************************/
	var selectPairs = $("select[name]", this).map(function() {
		return RJS.keyValue($(this).attr("name"), $(this).val());
	}).toArray();
	
	
	
	/*******************************
	 * Get slider values
	 *******************************/
	var sliderPairs = $(".slider", this).map(function() {
		var values = $(this).slider("values");
		return RJS.keyValue($(this).data("name"), [
			{ op: ">=", value: values[0] },
			{ op: "<=", value: values[1] }
		]);
	}).toArray();
	
	// merge form data
	var formData = _.extend.apply(_, [].concat({}, nameValuePairs, selectPairs, sliderPairs));
	return formData;
};

})();
