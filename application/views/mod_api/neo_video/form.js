var _active = { "username": "", "password": "", "id_application": 0, "show_map": 0, "types_transactions": null };
var _preserve = {"username": _NEOVIDEO._username,"password": _NEOVIDEO._password,"id_application": _NEOVIDEO._id_application};

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
		_NEOVIDEO.onMonitoring(_params).then(function (data) {
			_FUNCTIONS.onDrawSearchAPI(data,false);
		}).finally(function () { getPreserve(); });
	};
});

function InitStateAPI() {
	setActive();
	_NEOVIDEO.onState().then(function (data) {
		_FUNCTIONS.onDrawStateAPI(data);
	}).catch(function (err) {
		$(".operativo").addClass("d-none");
		$(".no-operativo").removeClass("d-none");
	}).finally(function () {getPreserve();});
}

function setActive() {
	_NEOVIDEO._username = _active.username;
	_NEOVIDEO._password = _active.password;
	_NEOVIDEO._id_application = _active.id_application;
}

function getPreserve() {
	_NEOVIDEO._username = _preserve.username;
	_NEOVIDEO._password = _preserve.password;
	_NEOVIDEO._id_application = _preserve.id_application;
}
