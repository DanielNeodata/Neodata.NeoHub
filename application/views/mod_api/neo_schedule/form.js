var _active = { "username": "", "password": "", "id_application": 0, "show_map": 0, "types_transactions": null };
var _preserve = { "username": _NEOSCHEDULE._username, "password": _NEOSCHEDULE._password, "id_application": _NEOSCHEDULE._id_application};

$("body").off("click", ".btn-api_search").on("click", ".btn-api_search", function () {
	var _page = $(this).attr("data-page");
	if (_page == undefined) { _page = 1; }
	var _params = {
		"date_from": $(".browser_date_from").val(),
		"date_to": $(".browser_date_to").val(),
		"id_type_transaction": _id_type_transaction,
		"search": $(".api_search").val(),
		"page": _page
	};
	if (_FUNCTIONS.onEvalSearchAPI(_params)) {
		setActive();
		_NEOSCHEDULE.onMonitoring(_params).then(function (data) {
			_FUNCTIONS.onDrawSearchAPI(data,true);
		}).finally(function () { getPreserve(); });
	};
});

function InitStateAPI() {
	setActive();
	_NEOSCHEDULE.onState().then(function (data) {
		_FUNCTIONS.onDrawStateAPI(data);
	}).catch(function (err) {
		$(".operativo").addClass("d-none");
		$(".no-operativo").removeClass("d-none");
	}).finally(function () { getPreserve(); });
}

function setActive() {
	_NEOSCHEDULE._username = _active.username;
	_NEOSCHEDULE._password = _active.password;
	_NEOSCHEDULE._id_application = _active.id_application;
}

function getPreserve() {
	_NEOSCHEDULE._username = _preserve.username;
	_NEOSCHEDULE._password = _preserve.password;
	_NEOTRANSACTIONS._id_application = _preserve.id_application;
	_NEOSCHEDULE
