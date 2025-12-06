var _active = { "username": "", "password": "", "id_application": 0, "show_map": 0, "types_transactions": null };
var _preserve = {"username": _NEOTRANSACTIONS._username,"password": _NEOTRANSACTIONS._password,"id_application": _NEOTRANSACTIONS._id_application};

$("body").off("click", ".btn-api_search").on("click", ".btn-api_search", function () {
	var _page = $(this).attr("data-page");
	if (_page == undefined) { _page = 1; }
	var _id_type_transaction = $(".browser_id_type_transaction").val();
	if (_id_type_transaction == null) { _id_type_transaction = 0; }
	var _params = {
		"date_from": $(".browser_date_from").val(),
		"date_to": $(".browser_date_to").val(),
		"id_type_status": $(".browser_id_type_status").val(),
		"id_type_transaction": _id_type_transaction,
		"search": $(".api_search").val(),
		"page": _page
	};
	if (_FUNCTIONS.onEvalSearchAPI(_params)) {
		setActive();
		_NEOTRANSACTIONS.onMonitoring(_params).then(function (data) {
			_FUNCTIONS.onDrawSearchAPI(data,true);
		}).finally(function () { getPreserve(); });
	};
});

function InitStateAPI() {
	setActive();
	_NEOTRANSACTIONS.onState().then(function (data) {
		_FUNCTIONS.onDrawStateAPI(data);
	}).catch(function (err) {
		$(".operativo").addClass("d-none");
		$(".no-operativo").removeClass("d-none");
	}).finally(function () { getPreserve(); });
}

function setActive() {
	_NEOTRANSACTIONS._username = _active.username;
	_NEOTRANSACTIONS._password = _active.password;
	_NEOTRANSACTIONS._id_application = _active.id_application;
}

function getPreserve() {
	_NEOTRANSACTIONS._username = _preserve.username;
	_NEOTRANSACTIONS._password = _preserve.password;
	_NEOTRANSACTIONS._id_application = _preserve.id_application;
}
