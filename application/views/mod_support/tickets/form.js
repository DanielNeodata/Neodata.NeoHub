$(function () {
	$("body").off("click", ".btn-report").on("click", ".btn-report", function () {
		createLinks();
	});
	$("body").off("change", ".id_application").on("change", ".id_application", function () {
		createLinks();
	});
	$("body").off("change", ".cboYear").on("change", ".cboYear", function () {
		createLinks();
	});
	$("body").off("change", ".cboMonth").on("change", ".cboMonth", function () {
		createLinks();
	});

	function createLinks() {
		if (!_TOOLS.validate(".validate-report", false)) {
			//alert("Complete los datos requeridos");
			$(".link-informe-tareas").html("");
			$(".link-informe-asignaciones").html("");
			$(".rpt-tareas").addClass("d-none");
			$(".rpt-asignaciones").addClass("d-none");
			$(".btn-report-tareas").attr("href", "");
			$(".btn-report-asignaciones").attr("href", "");
			return false;
		}
		var _id_application = $(".id_application").val();
		var _id_system = $(".id_system").val();
		var _id_type_ticket = $(".id_type_ticket").val();
		var _id_type_status = $(".id_type_status").val();
		var _year = $(".cboYear").val();
		var _month = $(".cboMonth").val();
		if (_id_application == undefined || _id_application == "") { _id_application = "0"; }
		if (_id_system == undefined || _id_system == "") { _id_system = "0"; }
		if (_id_type_ticket == undefined || _id_type_ticket == "") { _id_type_ticket = "0"; }
		if (_id_type_status == undefined || _id_type_status == "") { _id_type_status = "0"; }

		var _link_tareas = (_AJAX.server + "informeTareas/" + _id_application + "/" + _id_system + "/" + _id_type_ticket + "/" + _id_type_status + "/" + _year + "/" + _month);
		$(".link-informe-tareas").html("<a target='_blank' href='" + _link_tareas + "'>" + _link_tareas + "</a>");
		$(".btn-report-tareas").attr("href", _link_tareas);
		$(".rpt-tareas").removeClass("d-none");

		var _link_asignaciones = (_AJAX.server + "informeAsignaciones/" + _id_application + "/" + _id_system + "/" + _id_type_ticket + "/" + _id_type_status + "/" + _year + "/" + _month);
		$(".link-informe-asignaciones").html("<a target='_blank' href='" + _link_asignaciones + "'>" + _link_asignaciones + "</a>");
		$(".btn-report-asignaciones").attr("href", _link_asignaciones);
		$(".rpt-asignaciones").removeClass("d-none");
	}
});

