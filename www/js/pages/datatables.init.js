/**
* Theme: Ubold Admin Template
* Author: Coderthemes
* Component: Datatable
*
* MODIFIED: added custom datatable-buttons selector
* 
*/

var handleDataTableButtons = function(selector) {
	"use strict";
	if (!$(selector).length) {
		return false;
	}
	return $(selector).DataTable({
		dom: "Bfrtip",
		buttons: [{
			extend: "copy",
			className: ""
		}, {
			extend: "csv",
			className: ""
		}, {
			extend: "excel",
			className: ""
		}, {
			extend: "pdf",
			className: ""
		}, {
			extend: "print",
			className: ""
		}],
		responsive: !0
	})
},
TableManageButtons = function() {
	"use strict";
	return {
		init: function(selector) {
			return handleDataTableButtons(selector)
		}
	}
}();