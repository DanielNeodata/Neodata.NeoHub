var _AJAX = {
	/**
	 * /
	 * GENERAL
	 */
	_pre: "",
    _waiter: false,
	server: (window.location.protocol + "//" + window.location.host + "/"),
	_here: (window.location.protocol + "//" + window.location.host + "/"),
	_remote_mode: (typeof window.parent.ripple === "undefined"),
	_ready: false,
	_user_firebase: null,
	_uid: null,
	_id_app: null,
	_id_channel: null,
	_id_user_active: null,
	_id_type_user_active: null,
	_username_active: null,
	_master_account: null,
	_image_active: null,
	_master_image_active: null,
	_doc_editor: 0,
	_doc_reviser: 0,
	_doc_publisher: 0,
	_language: "es-ar",
	_token_authentication: "",
	_token_authentication_created: "",
	_token_authentication_expire: "",
	_token_transaction: "",
	_token_transaction_created: "",
	_token_transaction_expire: "",
	_token_push: null,
	_model: null, 
	_function: null,
	_module: null,
	_start_time: 0,
	forcePost: function (_path, _target, _parameters) {
		$("#forcedPost").remove();
		var form = $("<form id='forcedPost' method='post' action='" + _path + "' target='" + _target + "'></form>");
		$.each(_parameters, function (key, value) { form.append($("<input type='hidden' id='" + key + "' name='" + key + "' value='" + value + "'></input>")); });
		$(document.body).append(form);
		setTimeout(function () { form.submit();},1000);
	},
	formatFixedParameters: function (_json) {
		try {
			_AJAX._user_firebase.getIdToken().then(function (data) {
				_AJAX._token_push = data;
			}).catch(function (data) {
				_AJAX._token_push = "";
			});
		} catch (rex) {
			_AJAX._token_push = null;
		} finally {
			if (_AJAX._id_user_active == "" || _AJAX._id_user_active == null) { _AJAX._id_user_active = 0; }
			_json["token_push"] = _AJAX._token_push;
			_json["language"] = _AJAX._language;
			_json["token_authentication"] = _AJAX._token_authentication;
			_json["username_active"] = _AJAX._username_active;
			if (_json["server"] == undefined) { _json["server"] = _AJAX.server; }
			if (_json["id_app"] == undefined) { _json["id_app"] = _AJAX._id_app; }
			if (_json["id_user_active"] == undefined) { _json["id_user_active"] = _AJAX._id_user_active; }
			if (_json["id_type_user_active"] == undefined) { _json["id_type_user_active"] = _AJAX._id_type_user_active; }
			if (_json["id_channel"] == undefined) { _json["id_channel"] = _AJAX._id_channel; }
			if (_json["model"] == undefined) { _json["module"] = _AJAX.model; }
			if (_json["module"] == undefined) { _json["module"] = _AJAX._module; }
			if (_json["function"] == undefined) { _json["function"] = _AJAX._function; }
			if (_json["table"] == undefined) { _json["table"] = ""; }
			if (_json["method"] == undefined) { _json["method"] = "api.backend/neocommand"; }
			return _json;
		}
	},
	initialize: function (_user_firebase) {
		if (_AJAX._user_firebase == null) { _AJAX._user_firebase = _user_firebase; }
		_AJAX._ready = true;
	},
	ExecuteDirect: function (_json, _method) {
		return new Promise(
			function (resolve, reject) {
				try {
					_AJAX.Execute(_AJAX.formatFixedParameters(_json)).then(function (datajson) {
						if (datajson.status != undefined) {
							if (datajson.status == "AK" || datajson.status == "OK") {
								$(".raw-username_active").html(_AJAX._username_active);
								$(".raw-master_account").html(_AJAX._master_account);
								resolve(datajson);
							} else {
								reject(datajson);
							}
						} else {
							resolve(datajson);
						}
					});
				} catch (rex) {
					reject(rex);
				}
			});
	},
	Execute: function (_json) {
		_AJAX._start_time = new Date().getTime();
		return new Promise(
			function (resolve, reject) {
				try {
					if (!_AJAX._ready) { _AJAX.initialize(null); }
					$(".raw-raw-request").html(_TOOLS.prettyPrint(_json));
					var ajaxRq = $.ajax({
						type: "POST",
						dataType: "json",
						url: (_json.server + _json.method),
						data: _json,
						beforeSend: function () {_AJAX.onBeforeSendExecute(); },
						complete: function () { _AJAX.onCompleteExecute(); },
						error: function (xhr, ajaxOptions, thrownError) {reject(thrownError);},
						success: function (datajson) {
							_AJAX.onSuccessExecute(datajson, _json)
								.then(function (datajson) { resolve(datajson); })
								.catch(function (err) { reject(err); });
						}
					});
				} catch (rex) {
					reject(rex);
				}
			}
		)
	},
	Load: function (_file) {
		return new Promise(
			function (resolve, reject) {
				var ajaxRq = $.ajax({
					type: "GET",
					timeout: 10000,
					dataType: "html",
					async: false,
					cache: false,
					url: _file,
					success: function (data) { resolve(data); },
					error: function (xhr, msg) { reject(msg); }
				});
			});
	},
	onBeforeSendExecute: function () {
		$(".waiter").removeClass("d-none");
		$(".wait-menu-ajax").html("<img src='" + _AJAX._pre + "./assets/img/menu.gif' style='height:24px'/>");
		$(".wait-search-ajax").html("<img src='" + _AJAX._pre + "./assets/img/search.gif' style='height:25px;width:50px;'/>");
		$(".wait-accept-ajax").html("<img src='" + _AJAX._pre + "./assets/img/accept.gif' style='height:25px;width:65px;'/>");
		if (_AJAX._waiter) {
			$(".wait-ajax").html("<img src='" + _AJAX._pre + "./assets/img/wait.gif' style='height:36px;'/>");
			$.blockUI({ message: '<img src="' + _AJAX._pre + './assets/img/wait.gif" />', css: { border: 'none', backgroundColor: 'transparent', opacity: 1, color: 'transparent' } });
		}
	},
	onCompleteExecute: function () {
		var request_time = ((new Date().getTime() - _AJAX._start_time) / 1000);
		$(".img-master").attr("src", _AJAX._master_image_active);
		$(".img-user").attr("src", _AJAX._image_active);
		$(".elapsed-time").html("Respuesta en " + request_time + " s");
		$(".waiter").html("");
		$(".status-ajax-calls").removeClass("d-none");
		if (_AJAX._waiter) { $.unblockUI(); }
		_AJAX._waiter = false;
	},
	onSuccessExecute: function (datajson, _json_original) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (datajson["message"] == "Records") { datajson["message"] = "";}
					$(".raw-raw-response").html(_TOOLS.prettyPrint(datajson));
					$(".raw-message").html(datajson["code"] + ": " + datajson["message"]);
					if (datajson["status"] == "OK") {
						$(".status-last-call").removeClass("badge-danger").addClass("badge-success");
						$(".status-message").removeClass("d-sm-inline");
						if (parseInt(_AJAX._doc_editor) == 1) { $(".editor-mode").removeClass("d-none"); } else { $(".editor-mode").addClass("d-none"); }
						if (parseInt(_AJAX._doc_reviser) == 1) { $(".reviser-mode").removeClass("d-none"); } else { $(".reviser-mode").addClass("d-none"); }
						if (_AJAX._doc_publisher == 1) { $(".publisher-mode").removeClass("d-none"); } else { $(".publisher-mode").addClass("d-none"); }
					} else {
						$(".status-last-call").removeClass("badge-success").addClass("badge-danger");
						$(".status-message").html(datajson["code"] + ": " + datajson["message"]).addClass("d-sm-inline");
					}
					$(".status-last-call").html(datajson["status"]);
					if (datajson == null) {
						datajson = { "results": null };
						resolve(datajson);
					} else {
						if (datajson.compressed == null) { datajson.compressed = false; }
						if (datajson.compressed == undefined) { datajson.compressed = false; }
						if (datajson != null && datajson.compressed) {
							var zip = new JSZip();
							JSZip.loadAsync(atob(datajson.message)).then(function (zip) {
								zip.file("compressed.tmp").async("string").then(
									function success(content) {
										datajson.message = content;
										resolve(datajson);
									},
									function error(err) { reject(err); });
							});
						} else {
							if (datajson.message != "") { _FUNCTIONS.onAlert({ "message": datajson.message, "class": "alert-danger" }); }
							switch (parseInt(datajson.code)) {
								case 5400:
									_AJAX.UiReAuthenticate({}).then(function (data) {
										_AJAX.Execute(_json_original);
									})
									break;
								case 5200:
								case 5401:
									var _title = (datajson.code + ": " + datajson.message);
									var _body = "<p class='text-monospace'>Ha cambiado su token de autenticación.</p>";
									_body += "<p class='text-monospace'>Esto puede haberse debido a: ";
									_body += "<li>Sus credenciales fueron usadas en otro dispositivo estando la actual sesión activa</li>";
									_body += "<li>Desde administración, se ha modificado su perfil de seguridad</li>";
									_body += "</p > ";
									_body += "<p class='text-monospace'>Por favor autentíquese nuevamente, para seguir en este dispositivo.</p>";
									_FUNCTIONS.onInfoModal({ "title": _title, "body": _body });
									_FUNCTIONS.onReloadInit();
									break;
								default:
									resolve(datajson);
									break;
							}
						}
					}
				} catch (rex) {
					reject(rex);
				}
			}
		)
	},

	/**
	 * /
	 * 
	 * MOD_BACKEND
	 */
	UiGet: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "get";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiSave: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "save"; //function
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiOffline: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "offline"; //function
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiOnline: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "online"; //function
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiDelete: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "delete"; //function
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiProcess: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "process"; //function
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiForm: function (_json) {
		return new Promise(
			function (resolve, reject) {
				//_json["function"] = "form";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiBrow: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "brow";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiEdit: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "edit";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiAuthenticate: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["try"] = "LOCAL";
				//_json["try"] = "LDAP";
				_json["method"] = "api.pre/authenticate"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) {
					resolve(data);
				}).catch(function (err) {
					reject(err);
				});
			});
	},
	UiAuthenticateFirebase: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.pre/authenticateFirebase"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiReAuthenticate: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.pre/reAuthenticate"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGenerateTokenPush: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.pre/generateTokenPush"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) {
					resolve(data);
				}).catch(function (err) {
					reject(err);
				});
			});
	},
	UiGenerateTokenTransaction: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.pre/generateTokenTransaction"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiLogged: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/logged"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiLogout: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/logout"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiMessageRead: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "messageRead";
				_json["module"] = "mod_backend";
				_json["table"] = "messages_attached";
				_json["model"] = "messages_attached";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiMessagesNotification: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "notifications";
				_json["module"] = "mod_backend";
				_json["table"] = "messages_attached";
				_json["model"] = "messages_attached";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiSendExternal: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["module"] = "mod_backend";
				_json["table"] = "external";
				_json["model"] = "external";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiProfile: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/profile"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiStateLinkAPI: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/stateLinkAPI"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	/**
	 * /
	 * MOD_SUPPORT
	 */
	UiKnowHelp: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "knowHelp";
				_json["module"] = "mod_support";
				_json["table"] = "tickets";
				_json["model"] = "tickets";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	/**
	 * /
	 * MOD_FINANCES
	 */
	UiFacturar: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/Facturar"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetClearing: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "getClearing";
				_json["module"] = "mod_finances";
				_json["table"] = "clearings";
				_json["model"] = "clearings";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiCloseClearing: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "closeClearing";
				_json["module"] = "mod_finances";
				_json["table"] = "clearings";
				_json["model"] = "clearings";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetClearingSigns: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "getClearingSigns";
				_json["module"] = "mod_finances";
				_json["table"] = "clearings";
				_json["model"] = "clearings";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiSignClearing: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "signClearing";
				_json["module"] = "mod_finances";
				_json["table"] = "clearings";
				_json["model"] = "clearings";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetStatics: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "getStatics";
				_json["module"] = "mod_finances";
				_json["table"] = "clearings";
				_json["model"] = "clearings";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
};

