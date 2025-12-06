var _active = { "username": "", "password": "", "id_application": 0, "show_map": 0, "types_transactions": null };
var _preserve = { "username": _NEOSIGNATURE._username, "password": _NEOSIGNATURE._password, "id_application": _NEOSIGNATURE._id_application };

$("body").off("click", ".btn-api_search").on("click", ".btn-api_search", function () {
	var _page = $(this).attr("data-page");
	if (_page == undefined) { _page = 1; }
	var _params = {
		"date_from": $(".browser_date_from").val(),
		"date_to": $(".browser_date_to").val(),
		"search": $(".api_search").val(),
		"page": _page
	};
	if (_FUNCTIONS.onEvalSearchAPI(_params)) {
		setActive();
		_NEOSIGNATURE.onMonitoring(_params).then(function (data) {
			_FUNCTIONS.onDrawSearchAPI(data,false);
		}).finally(function () { getPreserve(); });
	};
});

function InitStateAPI() {
	setActive();
	_NEOSIGNATURE.onState().then(function (data) {
		_FUNCTIONS.onDrawStateAPI(data);
	}).catch(function (err) {
		$(".operativo").addClass("d-none");
		$(".no-operativo").removeClass("d-none");
	}).finally(function () { getPreserve(); });
}

function setActive() {
	_NEOSIGNATURE._username = _active.username;
	_NEOSIGNATURE._password = _active.password;
	_NEOSIGNATURE._id_application = _active.id_application;
}

function getPreserve() {
	_NEOSIGNATURE._username = _preserve.username;
	_NEOSIGNATURE._password = _preserve.password;
	_NEOSIGNATURE._id_application = _preserve.id_application;
}
