(function () {
	var _ecosystemServer = "https://localhost:44315/";
	var _authenticationServer = "https://localhost:44315/neoauthentication.v1/";
	var _transactionsServer = "https://localhost:44315/neotransactions.v1/";
	var _scheduleServer = "https://localhost:44315/neoschedule.v1/";
	var _interfacesServer = "https://localhost:44315/neointerfaces.v1/";
	var _rpaServer = "https://localhost:44315/neorpa.v1/";
	var _signatureServer = "https://localhost:44315/neosignature.v1/";
	var _logsServer = "https://localhost:44315/neologs.v1/";
	var _videoServer = "https://localhost:44315/neovideo.v1/";
	var _videoTools = "https://localhost:44315/neotools.v1/";

	if (window.location.hostname != "localhost") {
		_ecosystemServer = "https://api.gruponeodata.com/";
		_authenticationServer = "https://api.gruponeodata.com/neoauthentication.v1/";
		_transactionsServer = "https://api.gruponeodata.com/neotransactions.v1/";
		_scheduleServer = "https://api.gruponeodata.com/neoschedule.v1/";
		_interfacesServer = "https://api.gruponeodata.com/neointerfaces.v1/";
		_rpaServer = "https://api.gruponeodata.com/neorpa.v1/";
		_signatureServer = "https://api.gruponeodata.com/neosignature.v1/";
		_logsServer = "https://api.gruponeodata.com/neologs.v1/";
		_videoServer = "https://api.gruponeodata.com/neovideo.v1/";
		_videoTools = "https://api.gruponeodata.com/neotools.v1/";
	}

	$.getScript("https://jvideo1.gruponeodata.com/external_api.js").done(function (script, textStatus) {
		$.getScript("./assets/js/AJAX.js").done(function (script, textStatus) {
			$.getScript("https://cdn.gruponeodata.com/tools/TOOLS.js").done(function (script, textStatus) {
				$.getScript("./assets/js/FUNCTIONS.js").done(function (script, textStatus) {
					$.getScript("https://cdn.gruponeodata.com/authentication/NEOAUTHENTICATION.js").done(function (script, textStatus) {
						$.getScript("https://cdn.gruponeodata.com/video/NEOVIDEO-jvideo1.js").done(function (script, textStatus) {
							$.getScript("https://cdn.gruponeodata.com/neointerfaces/NEOINTERFACES.js").done(function (script, textStatus) {
								$.getScript("https://cdn.gruponeodata.com/neologs/NEOLOGS.js").done(function (script, textStatus) {
									$.getScript("https://cdn.gruponeodata.com/neorpa/NEORPA.js").done(function (script, textStatus) {
										$.getScript("https://cdn.gruponeodata.com/neosignature/NEOSIGNATURE.js").done(function (script, textStatus) {
											$.getScript("https://cdn.gruponeodata.com/neotransactions/NEOTRANSACTIONS.js").done(function (script, textStatus) {
												$.getScript("https://cdn.gruponeodata.com/neoschedule/NEOSCHEDULE.js").done(function (script, textStatus) {
													$.getScript("https://cdn.gruponeodata.com/neotools/NEOTOOLS.js").done(function (script, textStatus) {
														window.initMap = function () { _FUNCTIONS._gMapReady = true; };
														$.getScript("https://maps.googleapis.com/maps/api/js?key=" + _FUNCTIONS.GLOOGLE_API_KEY + "&callback=initMap").done(function (script, textStatus) { });
														moment().tz("America/Montevideo").format();
														_NEOTOOLS._SERVER = _videoTools;
														_NEOAUTHENTICATION._SERVER = _authenticationServer;

														_NEOTRANSACTIONS._SERVER = _transactionsServer;
														_NEOTRANSACTIONS._id_application = 1;
														_NEOTRANSACTIONS._username = "neohub";
														_NEOTRANSACTIONS._password = "1";

														_NEOSCHEDULE._SERVER = _scheduleServer;
														_NEOSCHEDULE._id_application = 9;
														_NEOSCHEDULE._username = "neohub";
														_NEOSCHEDULE._password = "1";

														_NEOINTERFACES._SERVER = _interfacesServer;
														_NEOINTERFACES._id_application = 3;
														_NEOINTERFACES._username = "neohub";
														_NEOINTERFACES._password = "1";

														_NEORPA._SERVER = _rpaServer;
														_NEORPA._id_application = 4;
														_NEORPA._username = "neohub";
														_NEORPA._password = "1";

														_NEOSIGNATURE._SERVER = _signatureServer;
														_NEOSIGNATURE._id_application = 5;
														_NEOSIGNATURE._username = "neohub";
														_NEOSIGNATURE._password = "1";

														_NEOVIDEO._SERVER = _videoServer;
														_NEOVIDEO._id_application = 6;
														_NEOVIDEO._username = "neohub";
														_NEOVIDEO._password = "1";

														_NEOLOGS._SERVER = _logsServer;
														_NEOLOGS._id_application = 8;
														_NEOLOGS._username = "neohub";
														_NEOLOGS._password = "1";

														window.addEventListener("dragover", function (e) { e = e || event; e.preventDefault(); }, false);
														window.addEventListener("drop", function (e) { e = e || event; e.preventDefault(); }, false);

														//$("body").off("change", ".browser_id_app").on("change", ".browser_id_app", function (e) {
														//	_FUNCTIONS.onChangeApp($(this));
														//});

														$("body").off("keyup", ".textarea").on("keyup", ".textarea", function (e) {
															var textarea = $(this), top = textarea.scrollTop(), height = textarea.height();
															textarea.attr('rows', 2).css("heigth", "40");
															if (top > 0) { textarea.css("height", top + height); }
														});
														$("body").off("click", ".btn-external-link").on("click", ".btn-external-link", function () {
															_FUNCTIONS.onAddLinkExternal($(this));
														});
														$("body").off("keyup", ".search-trigger").on("keyup", ".search-trigger", function (e) {
															var keyCode = (e.keyCode || e.which);
															if (keyCode === 13) { _FUNCTIONS.onBrowserSearch($(".btn-browser-search")); }
														});
														$("body").off("change", ".search-trigger").on("change", ".search-trigger", function () {
															if ($(this).is("select") === true) { _FUNCTIONS.onBrowserSearch($(".btn-browser-search")); }
														});
														$("body").off("change", ".btn-tickets-files-tickets").on("change", ".btn-tickets-files-tickets", function (e) {
															_FUNCTIONS.onProcessSelectedFiles($(this));
														});
														$("body").off("change", ".btn-knows-files-knows").on("change", ".btn-knows-files-knows", function (e) {
															_FUNCTIONS.onProcessSelectedFiles($(this));
														});
														$("body").off("click", ".btn-tickets-delete").on("click", ".btn-tickets-delete", function (e) {
															_FUNCTIONS.onDeleteSelectedFile($(this));
														});
														$("body").off("click", ".btn-login").on("click", ".btn-login", function () {
															_FUNCTIONS.onLogin($(this)).then(function (data) { _AJAX.UiLogged({}); });
														});
														$("body").off("click", ".btn-logout").on("click", ".btn-logout", function () {
															_FUNCTIONS.onLogout($(this));
														});
														$("body").off("click", ".btn-menu-open").on("click", ".btn-menu-open", function (e) {
															_FUNCTIONS.onMenuOpen($(this), e);
														});
														$("body").off("click", ".btn-menu-close").on("click", ".btn-menu-close", function (e) {
															_FUNCTIONS.onMenuClose($(this), e);
														});
														$("body").off("click", ".btn-menu-click").on("click", ".btn-menu-click", function (e) {
															_FUNCTIONS.onMenuClick($(this));
														});
														$("body").off("click", ".btn-record-edit").on("click", ".btn-record-edit", function (e) {
															_FUNCTIONS.onRecordEdit($(this));
														});
														$("body").off("click", ".btn-record-remove").on("click", ".btn-record-remove", function (e) {
															_FUNCTIONS.onRecordRemove($(this));
														});
														$("body").off("click", ".btn-record-offline").on("click", ".btn-record-offline", function (e) {
															_FUNCTIONS.onRecordOffline($(this));
														});
														$("body").off("click", ".btn-record-online").on("click", ".btn-record-online", function (e) {
															_FUNCTIONS.onRecordOnline($(this));
														});
														$("body").off("click", ".btn-record-process").on("click", ".btn-record-process", function (e) {
															_FUNCTIONS.onRecordProcess($(this));
														});
														$("body").off("click", ".btn-abm-accept").on("click", ".btn-abm-accept", function (e) {
															_FUNCTIONS.onAbmAccept($(this));
														});
														$("body").off("click", ".btn-abm-cancel").on("click", ".btn-abm-cancel", function (e) {
															_FUNCTIONS.onAbmCancel($(this));
														});
														$("body").off("click", ".btn-browser-search").on("click", ".btn-browser-search", function (e) {
															_FUNCTIONS.onBrowserSearch($(this));
														});
														$("body").off("click", ".btn-brief").on("click", ".btn-brief", function (e) {
															_FUNCTIONS.onBriefModal($(this));
														});
														$("body").off("click", ".btn-close-modal").on("click", ".btn-close-modal", function (e) {
															$($(this).attr("data-click")).click();
															_FUNCTIONS.onDestroyModal(".modal");
														});
														$("body").off("click", ".btn-upload").on("click", ".btn-upload", function (e) {
															$($(this).attr("data-click")).click();
														});
														$("body").off("click", ".btn-upload-reset").on("click", ".btn-upload-reset", function (e) {
															_FUNCTIONS.onResetSelectedFile($(this));
														});
														$("body").off("click", ".btn-upload-delete").on("click", ".btn-upload-delete", function (e) {
															_FUNCTIONS.onDeleteSelectedFile($(this));
														});
														$("body").off("change", ".btn-pick-files-image").on("change", ".btn-pick-files-image", function (e) {
															_FUNCTIONS.onProcessSelectedFiles($(this));
														});
														$("body").off("click", ".btn-view-file").on("click", ".btn-view-file", function (e) {
															_FUNCTIONS.onViewFile($(this));
														});
														$("body").off("click", ".btn-message-external").on("click", ".btn-message-external", function (e) {
															_FUNCTIONS.onFolderMessagesModal($(this));
														});
														$("body").off("click", ".btn-message-read").on("click", ".btn-message-read", function (e) {
															_FUNCTIONS.onMessageRead($(this));
														});
														$("body").off("click", ".btn-record-check").on("click", ".btn-record-check", function (e) {
															_FUNCTIONS.onCheckRecord($(this));
														});
														$("body").off("click", ".btn-api-info").on("click", ".btn-api-info", function (e) {
															_FUNCTIONS.onApiDocument($(this));
														});
														$("body").off("click", ".btn-activate-video-meeting").on("click", ".btn-activate-video-meeting", function (e) {
															_FUNCTIONS.onActivateVideoMeeting($(this));
														});
														$("body").off("click", ".btn-viewRecord").on("click", ".btn-viewRecord", function (e) {
															_FUNCTIONS.onViewRecord($(this));
														});
														$("body").off("click", ".btn-viewPacket").on("click", ".btn-viewPacket", function (e) {
															_FUNCTIONS.onViewPacket($(this));
														});
														$("body").off("change", ".cboApiUsername").on("change", ".cboApiUsername", function () {
															_FUNCTIONS.onSetActiveCredentials($(this));
														});
														$("body").off("click", ".btnStateLinkAPI").on("click", ".btnStateLinkAPI", function (e) {
															_FUNCTIONS.onStateLinkAPI($(this));
														});
														$("body").off("click", ".btnTestAuthentication").on("click", ".btnTestAuthentication", function (e) {
															_FUNCTIONS.onTestAuthentication($(this));
														});
														$("body").off("click", ".btnTestProfile").on("click", ".btnTestProfile", function (e) {
															_FUNCTIONS.onTestProfile($(this));
														});
														$("body").off("click", ".btnAddProfile").on("click", ".btnAddProfile", function (e) {
															_FUNCTIONS.onAddProfile($(this));
														});
														$("body").off("change", ".cboUsageUsername").on("change", ".cboUsageUsername", function () {
															_FUNCTIONS.onSetUsageCredentials($(this));
														});
														$("body").off("click", ".btnBigImage").on("click", ".btnBigImage", function (e) {
															_FUNCTIONS.onViewBigImage($(this));
														});
														$("body").off("click", ".btn-clipboard").on("click", ".btn-clipboard", function (e) {
															_TOOLS.onCopyToClipboard($(this).attr("data-id"));
														});
														$("body").off("click", ".btnExcedent").on("click", ".btnExcedent", function (e) {
															_FUNCTIONS.onViewExcedent($(this));
														});
														$("body").off("change", ".browser_id_type_status").on("change", ".browser_id_type_status", function (e) {
															$(".btn-api_search").click();
														});
														$("body").off("change", ".browser_id_type_transaction").on("change", ".browser_id_type_transaction", function (e) {
															$(".btn-api_search").click();
														});
														$("body").off("click", ".btn-verMapa").on("click", ".btn-verMapa", function (e) {
															_FUNCTIONS.onViewMap($(this));
														});
														$("body").off("click", ".btn-verGrilla").on("click", ".btn-verGrilla", function (e) {
															_FUNCTIONS.onViewGrid($(this));
														});
														$("body").off("click", ".btn-Facturar").on("click", ".btn-Facturar", function (e) {
															_FUNCTIONS.onFacturar($(this));
														});
														setInterval(function () { _FUNCTIONS.onMessagesNotification($(this)); }, 60000);
													});
												});
											});
										});
									});
								});
							});
						});
					});
				});
			});
		});
	});
})();


