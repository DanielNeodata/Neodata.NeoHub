var _FUNCTIONS = {
	_show_map: 0,
	_type_transactions: null,
	_gMapReady: false,
	_videoMeetingOpen: false,
	_cache: {},
	_stream: 0,
	_graphs: 0,
	_croppie: null,
	_ATTACH_LIMIT: 1.5,
	_timerPushAlert: 0,
	_defaultAttachDir: "./attached/threads/",
	_defaultBrowserSearch: "browser_search",
	_defaultBrowserSearchOperator: "like",
	_defaultBrowserSearchFields: ["code", "description"],
	_defaultProviderFooter: "<img src='./assets/img/small.png' style='width:32px;' /><a href='http://www.gruponeodata.com' target='_blank'>www.gruponeodata.com</a>",
	_max_filesize_upload: 50,
	_last_insert: 0,
	_TIMEOUT_ALERT: 3000,
	_TIMER_MODAL: 0,
	GLOOGLE_API_KEY: "AIzaSyBJ_YJJWQ2hgpbxfVeVhWki2_hdpGvedkE",
	onReloadInit: function () {
		$(".sidebar-wrapper").fadeOut("slow");
		$(".dyn-area").fadeOut("slow", function () { setTimeout(function () { window.location = "/"; }, 10000); });
	},
	onAddLinkExternal: function (_this) {
		var _target = _this.attr("data-target");
		var _html = "";
		_html += "<label>Descripción</label>";
		_html += "<input value='' class='validate-link form-control' type='text' name='title-link' id='title-link' data-clear-btn='false' placeholder='Descripción' />";
		_html += "<label>HTML para insertar link</label>";
		_html += "<textarea rows='20' id='body-link' name='body-link' class='validate-link shadow' style='width:100%;'></textarea>";
		_html += "<div class='panel-footer'>";
		_html += " <div class='row'>";
		_html += "  <div class='col-6'>";
		_html += "   <a class='btn-cancel-link btn btn-danger btn-raised btn-md'>Cancelar</a>";
		_html += "  </div>";
		_html += "  <div class='col-6'>";
		_html += "   <a class='btn-success-link btn btn-success btn-raised btn-md'>Aceptar</a>";
		_html += "  </div>";
		_html += " </div>";
		_html += "</div>";
		_FUNCTIONS.onShowHtmlModal("Ingresar link externo ", _html, function () {
			$("body").off("click", ".btn-success-link").on("click", ".btn-success-link", function () {
				if (!_TOOLS.validate(".validate-link", false)) {
					alert("Complete los datos requeridos");
					return false;
				}
				var _name = $("#title-link").val();
				var _body = $("#body-link").val();
				var _id = _TOOLS.UUID();
				var _html = "<li class='list-group-item li-" + _id + "'>";
				_html += "<span data-priority='0' data-id='" + _id + "' data-result='data:link;" + _body + "' class='new-file img-" + _id + "' data-filename='" + _name + "'><i class='material-icons'>link</i></span> ";
				_html += "<div class='badge badge-primary text-truncate' style='display:inline-block;max-width:100%;' title='" + _name + "'>" + _name + "</div> ";
				_html += "<a href='#' data-id='" + _id + "' class='btn btn-sm btn-danger float-right btn-link-delete'><i class='material-icons'>delete</i></a>";
				_html += "</li>";
				$(_target).append(_html);
				$("#modal-html").modal("hide").data("bs.modal", null);
				_FUNCTIONS.onDestroyModal("#modal-html");
			});
			$("body").off("click", ".btn-cancel-link").on("click", ".btn-cancel-link", function () {
				$("#modal-html").modal("hide").data("bs.modal", null);
				_FUNCTIONS.onDestroyModal("#modal-html");
			});
		});
	},
	onAlert: function (_json) {
		try {
			clearTimeout(_FUNCTIONS._timerPushAlert);
			$(".push-alert").remove();
			if (_json["message"] == "") { return false; }
			var _html = "<div class='push-alert alert " + _json["class"] + " alert-dismissible fade show' role='alert'>";
			_html += "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
			_html += _json["message"];
			_html += "</div>";
			$(".alert-frame").append(_html);
			_FUNCTIONS._timerPushAlert = setTimeout(function () { $(".push-alert").alert('close') }, 3500);
			return true;
		} catch (rex) {
			alert(rex.message);
			return false;
		}
	},
	onShowAlert: function (_message, _title) {
		_FUNCTIONS.onDestroyModal("#modal-alert");
		if (_title == undefined) { _title = ""; }
		var _html = "";
		_html += "<div id='modal-alert' class='modal fade' style='z-index:9999;'>";
		_html += "   <div class='modal-dialog'>";
		_html += "      <div class='modal-content'>";
		_html += "         <div class='modal-header'>";
		if (_title != "") {
			_html += "<h4>" + _title + "<button type='button' class='close pull-right' data-dismiss='modal' aria-hidden='true' style='position:absolute;right:10px;top:5px;font-size:2em;'>&times;</button></h4>";
		} else {
			_html += "<button type='button' class='close' data-dismiss='modal' aria-hidden='true' style='position:absolute;right:10px;top:5px;font-size:2em;'>&times;</button>";
		}
		_html += "         </div>";
		_html += "         <div class='modal-body danger alert-danger'>";
		_html += "            <p style='color:darkred;'>" + _message + "</p>";
		_html += "         </div>";
		_html += "      </div>";
		_html += "   </div>";
		_html += "</div>";
		$("body").append(_html);
		$("#modal-alert").on('hide.bs.modal', function () { clearInterval(_FUNCTIONS._TIMER_MODAL); });
		$("#modal-alert").modal({ backdrop: true, keyboard: true });
		_FUNCTIONS._TIMER_MODAL = setTimeout(function () { _FUNCTIONS.onDestroyModal("#modal-alert"); }, _FUNCTIONS._TIMEOUT_ALERT);
	},
	onShowInfo: function (_message, _title) {
		_FUNCTIONS.onDestroyModal("#modal-info");
		if (_title == undefined) { _title = ""; }
		var _html = "";
		_html += "<div id='modal-info' class='modal fade' style='z-index:9999;'>";
		_html += "   <div class='modal-dialog'>";
		_html += "      <div class='modal-content'>";
		_html += "         <div class='modal-header'>";
		if (_title != "") {
			_html += "<h4>" + _title + "<button type='button' class='close pull-right' data-dismiss='modal' aria-hidden='true' style='font-size:2em;position:absolute;right:10px;top:5px;'>&times;</button></h4>";
		} else {
			_html += "<button type='button' class='close' data-dismiss='modal' aria-hidden='true' style='font-size:2em;position:absolute;right:10px;top:5px;'>&times;</button>";
		}
		_html += "         </div>";
		_html += "         <div class='modal-body danger alert-default'>";
		_html += "            <p style='color:darkred;'>" + _message + "</p>";
		_html += "         </div>";
		_html += "      </div>";
		_html += "   </div>";
		_html += "</div>";
		$("body").append(_html);
		$("#modal-info").on('hide.bs.modal', function () { });
		$("#modal-info").modal({ backdrop: true, keyboard: true });
	},
	onShowHtmlModal: function (_title, _message, _callback) {
		_FUNCTIONS.onDestroyModal("#modal-html");
		if (_title == undefined) { _title = ""; }
		var _html = "";
		_html += "<div id='modal-html' class='modal fade' style='z-index:9999;'>";
		_html += "   <div class='modal-dialog modal-lg'>";
		_html += "      <div class='modal-content'>";
		_html += "         <div class='modal-header'>";
		if (_title != "") {
			_html += "            <h4>" + _title + "<button type='button' class='close pull-right' data-dismiss='modal' aria-hidden='true'style='position:absolute;right:10px;top:5px;font-size:2em;'>&times;</button></h4>";
		} else {
			_html += "            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'style='position:absolute;right:10px;top:5px;font-size:2em;'>&times;</button>";
		}
		_html += "         </div>";
		_html += "         <div class='modal-body danger alert-default'>" + _message + "</div>";
		_html += "      </div>";
		_html += "   </div>";
		_html += "</div>";
		$("body").append(_html);
		$("#modal-html").on('hide.bs.modal', function () { });
		$("#modal-html").modal({ backdrop: true, keyboard: true });
		if ($.isFunction(_callback)) { _callback(); }
	},

	onDestroyModal: function (_target) {
		$(_target).remove();
		$(".modal-backdrop").remove();
		$("body").removeClass("modal-open");
	},
	onInfoModal: function (_json, _callBack) {
		try {
			_FUNCTIONS.onDestroyModal("#infoModal");
			if (_json["close"] == undefined) { _json["close"] = false; }
			if (_json["size"] == undefined) { _json["size"] = "modal-md"; }
			if (_json["center"] == undefined) { _json["center"] = ""; }
			if (_json["center"] === true) { _json["center"] = "modal-dialog-centered"; } else { _json["center"] = ""; }
			var _html = "<div class='modal fade' id='infoModal' role='dialog'>";
			_html += " <div class='modal-dialog modal-dialog-scrollable " + _json["center"] + " " + _json["size"] + "' role='document'>";
			_html += "  <div class='modal-content'>";
			_html += "    <div class='modal-header'>";
			_html += "      <h4 class='modal-title'>" + _json["title"] + "</h4>";
			if (_json["close"]) { _html += "<button type='button' class='close btn-close-modal' data-dismiss='modal'>&times;</button>"; }
			_html += "    </div>";
			_html += "    <div class='modal-body'>";
			_html += _json["body"];
			if (!_json["close"]) {
				_html += "       <div class='progress' style='height:5px;'>";
				_html += "          <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:100%;'></div>";
				_html += "       </div>";
			}
			_html += "    </div>";
			_html += "    <div class='modal-footer font-weight-light'>";
			_html += _FUNCTIONS._defaultProviderFooter;
			_html += "</div>";
			_html += "  </div>";
			_html += " </div>";
			_html += "</div>";
			$("body").append(_html);
			$('.trumbo').trumbowyg({ lang: 'es_ar' });
			if ($.isFunction(_callBack)) { _callBack(); }

			$("#infoModal").modal({ backdrop: false, keyboard: true, show: true });
			return true;
		} catch (rex) {
			alert(rex.message);
			return false;
		}
	},
	onBriefModal: function (_this) {
		var _title = _this.attr("data-title");
		var _body = _this.attr("data-body");
		if (_body == "" || _body == null || _body == undefined) { _body = ""; } else { _body = atob(_body); }
		_FUNCTIONS.onInfoModal({ "title": _title, "body": _body, "close": true, "size": "modal-xl", "center": false });
	},
	onImageModal: function (_json) {
		try {
			_FUNCTIONS._croppie = null;
			$('.modal-body').croppie("destroy");
			var _html = "<div class='modal fade' id='imageModal'>";
			_html += " <div class='modal-dialog modal-dialog-centered' role='document'>";
			_html += "  <div class='modal-content'>";
			_html += "    <div class='modal-header'>";
			_html += "      <h4 class='modal-title'>" + _json["title"] + "</h4>";
			_html += "      <button type='button' class='close' data-dismiss='modal'>&times;</button>";
			_html += "    </div>";
			_html += "    <div class='modal-body'></div>";
			_html += "    <div class='modal-footer font-weight-light'>";
			_html += "       <button type='button' class='btn btn-primary btn-crop'>Recortar</button>";
			_html += "    </div>";
			_html += "  </div>";
			_html += " </div>";
			_html += "</div>";
			$("body").append(_html);
			_FUNCTIONS._croppie = $('.modal-body').croppie(
				{
					viewport: { height: 250, width: 250, type: "square" },
					boundary: { height: 400, width: 400, }
				}
			);
			_FUNCTIONS._croppie.croppie('bind', { url: _json["image"], points: [77, 469, 280, 739] });
			$("body").off("click", ".btn-crop").on("click", ".btn-crop", function () {
				var _args = { type: _json["type"], format: _json["format"], quality: _json["quality"] };
				_FUNCTIONS._croppie.croppie('result', _args).then(function (_image) {
					if (!_json["multi"]) {
						$(_json["input"]).val(_image);
						$(_json["target"]).attr("src", _image);
					} else {
						var _id = _TOOLS.UUID();
						var _line = "<li class='list-group-item li-" + _id + "'>";
						_line += "<img data-id='" + _id + "' src='" + _image + "' style='width:40px;' class='new-file img-" + _id + "' data-filename='" + _json["filename"] + "' /> ";
						_line += "<div class='badge badge-primary text-truncate' style='display:inline-block;max-width:100%;' title='" + _json["filename"] + "'>" + _FUNCTIONS._defaultAttachDir + _json["filename"] + "</div> ";
						_line += "<a href='#' data-id='" + _id + "' class='btn btn-sm btn-danger float-right btn-upload-delete'><i class='material-icons'>delete</i></a>";
						_line += "</li>";
						$(_json["target"]).append(_line);
					}
					_FUNCTIONS.onDestroyModal("#imageModal");
				});
			});
			$("#imageModal").modal({ backdrop: false, keyboard: false, show: true });
			return true;
		} catch (rex) {
			alert(rex.message);
			return false;
		}
	},

	onProcessSelectedFiles: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					var x = document.querySelector(_this.attr("data-click"));
					for (var i = 0; i < x.files.length; i++) {
						var f = x.files[i];
						var _file_type = f.type;
						var _filename = f.name;
						if (f.size > (_FUNCTIONS._max_filesize_upload * 1024000)) { throw ("Se aceptan archivos de hasta " + _FUNCTIONS._max_filesize_upload + "mb"); }
						var fr = new FileReader();
						fr.onload = function (e) {
							var _id = _TOOLS.UUID();
							var _result = this.result;
							var _image = _TOOLS.iconByMime(_file_type, fr.result);
							var _target = _this.attr("data-target");
							var _line = "<li class='list-group-item li-" + _id + "'>";
							_line += "<img data-priority='0' data-id='" + _id + "' data-result='" + _result + "' src='" + _image + "' style='width:40px;' class='new-file img-" + _id + "' data-filename='" + _filename + "'/> ";
							_line += "<a href='#' data-id='" + _id + "' class='btn btn-sm btn-danger float-right btn-tickets-delete'><i class='material-icons'>delete_forever</i></a>";
							_line += "</li>";
							$(".img-image").attr("src", _result).attr("data-result", _result);
							$(_target).append(_line);
							resolve(_image);
						}
						fr.readAsDataURL(f);
					}
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},

	onResetSelectedFile: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (confirm("¿Confirma el borrado del archivo?")) {
						$(_this.attr("data-target")).attr("src", _this.attr("data-default"));
						$(_this.attr("data-input")).val("");
					}
					resolve(true);
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onDeleteSelectedFile: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (confirm("¿Confirma el borrado del archivo?")) {
						var _id = _this.attr("data-id");
						if ($(".img-" + _id).hasClass("new-file")) {
							$(".li-" + _id).fadeOut("fast").remove();
						} else {
							$(".li-" + _id).addClass("d-none")
							$(".img-" + _id).addClass("del-file");
						}
					}
					resolve(true);
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},

	onLogin: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					var _scoope = $(this).attr("data-scoope");
					if (_scoope == undefined || _scoope == "") { _scoope = "backend"; }
					if (_TOOLS.validate(".validate", true)) {
						var _json = _TOOLS.getFormValues(".dbase", _this);
						_json["scoope"] = _scoope;
						_AJAX.UiAuthenticate(_json)
							.then(function (data) {
								if (data.status == "OK") {
									_FUNCTIONS.onStatusAuthentication(data).then(function (datajson) {
										_AJAX.UiLogged({}).then(function (data) {
											if (data.status == "OK") {
												switch (_scoope) {
													case "backend":
														$(".main").fadeOut("fast", function () {
															$(".main").removeClass("container").addClass("container-flex").html(data.message).fadeIn("slow");
															resolve(data);
														});
														break;
													default:
														window.location = "/site/logged";
														resolve(data);
														break;
												}
											} else {
												throw data;
											}
										}).catch(function (error) { throw error; });
									}).catch(function (error) { throw error; });
								} else {
									throw data;
								}
							}).catch(function (error) {
								alert(error.message);
								throw error;
							});
					}
				} catch (rex) {
					alert(rex.message);
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onLogout: function (_this, _mode) {
		if (_mode == undefined) { _mode = "/"; }
		_AJAX.UiLogout({}).then(function (data) {
			window.location = _mode;
		});
	},

	onStatusAuthentication: function (datajson) {
		return new Promise(
			function (resolve, reject) {
				try {
					_AJAX._token_authentication = datajson.data.token_authentication;
					_AJAX._token_authentication_created = datajson.data.token_authentication_created;
					_AJAX._token_authentication_expire = datajson.data.token_authentication_expire;
					_AJAX._id_app = datajson.data.applications[0].id;
					_AJAX._id_user_active = datajson.data.id;
					_AJAX._id_type_user_active = datajson.data.id_type_user;
					_AJAX._username_active = datajson.data.username;
					_AJAX._master_account = datajson.data.master_account;
					_AJAX._image_active = datajson.data.image;
					_AJAX._master_image_active = datajson.data.master_image;
					$(".raw-id_user_active").html(_AJAX._id_user_active);
					$(".raw-id_type_user_active").html(_AJAX._id_type_user_active);
					$(".raw-master_account").html(_AJAX._master_account);
					$(".raw-username_active").html(_AJAX._username_active);
					$(".raw-a-token_created_datetime").html(_AJAX._token_authentication_created);
					$(".raw-a-token_ttl_datetime").html(_AJAX._token_authentication_expire);
					$(".raw-a-token_key").html(_AJAX._token_authentication);
					resolve(true);
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onStatusClick: function (_this) {
		if (_this.hasClass("btn-menu-click")) { _this.find(".label-menu").append("<span class='mx-0 px-1 waiter wait-menu-ajax'></span>"); }
		if (_this.hasClass("btn-browser-search")) { _this.html("<span class='mx-0 px-1 waiter wait-search-ajax'></span>"); }
		if (_this.hasClass("btn-abm-accept")) { _this.html("<span class='mx-0 px-1 waiter wait-accept-ajax'></span>"); }
	},

	onMenuOpen: function (_this, e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
		$(".info-heading").addClass("d-none").fadeOut("fast");
	},
	onMenuClose: function (_this, e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
		$(".info-heading").removeClass("d-none").fadeIn("fast");
	},
	onMenuClick: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					clearInterval(_FUNCTIONS._stream);
					clearInterval(_FUNCTIONS._graphs);
					$("." + _FUNCTIONS._defaultBrowserSearch).val("");
					switch (_this.attr("data-action")) {
						case "brow":
							_FUNCTIONS.onBrowserSearch(_this);
							break;
						case "form":
							_FUNCTIONS.onFormSearch(_this);
							break;
						default:
							_FUNCTIONS.onFormSearch(_this);
							break;
					}
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},

	onRecordEdit: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					var _json = _TOOLS.getFormValues(null, _this);
					_FUNCTIONS.onTransactionLog("onRecordEdit", _json);
					_AJAX.UiEdit(_json).then(function (data) {
						if (data.status == "OK") {
							$(".dyn-area").addClass("d-none").hide();
							$(".abm").html(data.message).removeClass("d-none").fadeIn("slow");
							resolve(data);
						} else {
							throw data;
						}
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onRecordRemove: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (!confirm("¿Confirma el borrado del registro?")) {
						resolve(null);
						return false;
					}
					var _json = _TOOLS.getFormValues(null, _this);
					_FUNCTIONS.onTransactionLog("onRecordRemove", _json);
					_AJAX.UiDelete(_json).then(function (data) {
						if (data.status == "OK") {
							_FUNCTIONS.onRefreshBrowser();
							_FUNCTIONS.onAlert({ "message": data.message, "class": "alert-info" });
							resolve(data);
						} else {
							throw data;
						}
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onRecordOffline: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (!confirm("¿Confirma sacar de línea el registro?")) {
						resolve(null);
						return false;
					}
					var _json = _TOOLS.getFormValues(null, _this);
					_FUNCTIONS.onTransactionLog("onRecordOffline", _json);
					_AJAX.UiOffline(_json).then(function (data) {
						if (data.status == "OK") {
							_FUNCTIONS.onRefreshBrowser();
							_FUNCTIONS.onAlert({ "message": data.message, "class": "alert-info" });
							resolve(data);
						} else {
							throw data;
						}
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onRecordOnline: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (!confirm("¿Confirma poner en línea el registro?")) {
						resolve(null);
						return false;
					}
					var _json = _TOOLS.getFormValues(null, _this);
					_FUNCTIONS.onTransactionLog("onRecordOnline", _json);
					_AJAX.UiOnline(_json).then(function (data) {
						if (data.status == "OK") {
							_FUNCTIONS.onRefreshBrowser();
							_FUNCTIONS.onAlert({ "message": data.message, "class": "alert-info" });
							resolve(data);
						} else {
							throw data;
						}
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onRecordProcess: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (!confirm("¿Confirma la ejecución del proceso?")) {
						resolve(null);
						return false;
					}
					var _json = _TOOLS.getFormValues(null, _this);
					_FUNCTIONS.onTransactionLog("onRecordProcess", _json);
					_AJAX.UiProcess(_json).then(function (data) {
						if (data.status == "OK") {
							_FUNCTIONS.onRefreshBrowser();
							_FUNCTIONS.onAlert({ "message": data.message, "class": "alert-info" });
							resolve(data);
						} else {
							throw data;
						}
					}).error(function (err) {
						throw err;
					});
				} catch (rex) {
					_FUNCTIONS.onRefreshBrowser();
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},

	onAbmAccept: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (_TOOLS.validate(".validate", true)) {
						_AJAX._waiter = true;
						_AJAX.onBeforeSendExecute();
						setTimeout(function () {
							var _json = _TOOLS.getFormValues(".dbase", _this);
							_FUNCTIONS.onTransactionLog("onAbmAccept", _json);
							_AJAX.UiSave(_json).then(function (data) {
								if (data.status == "OK") {
									_FUNCTIONS._last_insert = data.id;
									if (data.proposal != undefined) {
										if (parseInt(data.proposal.dirty) != 0) {
											eval(data.proposal.function);
										} else {
											_FUNCTIONS.onClosePostTickets(_this);
											resolve(data);
										}
									} else {
										_FUNCTIONS.onClosePostTickets(_this);
										resolve(data);
									}
								} else {
									throw data;
								}
							});
						}, 250);
					}
				} catch (rex) {
					setTimeout(function () { _AJAX.onCompleteExecute(); }, 50);
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onAbmCancel: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					_FUNCTIONS.onTransactionLog("onAbmCancel", null);
					$(".abm").addClass("d-none").hide();
					$(".browser").removeClass("d-none").fadeIn("slow");
					_FUNCTIONS.onAlert({ "message": "No se han efectuado cambios al registro", "class": "alert-info" });
					resolve(true);
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},

	onSignature: function (_function, _data, _type_key, _val_key, _name_key) {
		var _obj = {
			"function": _function,
			"id_user": _AJAX._id_user_active,
			"username": _AJAX._username_active,
			"data": _data
		};
		var _raw_data = ("data:application/json;base64," + _TOOLS.utf8_to_b64(JSON.stringify(_obj)));
		var _raw_data_additional = ("data:application/json;base64," + _TOOLS.utf8_to_b64(JSON.stringify(_obj)));
		_NEOSIGNATURE.onSendTransfer(_raw_data, _raw_data_additional, _type_key, _val_key, _name_key);
	},

	onTransactionLog: function (_function, _data) {
		var _obj = {
			"function": _function,
			"id_user": _AJAX._id_user_active,
			"username": _AJAX._username_active,
			"data": _data
		};
		var _raw_data = ("data:application/json;base64," + _TOOLS.utf8_to_b64(JSON.stringify(_obj)));
		_NEOTRANSACTIONS.onSendTransaction(_raw_data);
	},

	onBrowserSearch: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					$(".abm").html("").addClass("d-none").hide();
					var _html = _this.html();
					_FUNCTIONS.onStatusClick(_this);
					var _json = _TOOLS.getFormValues(null, _this);
					_FUNCTIONS.onTransactionLog("onBrowserSearch", _json);
					var _data_filters = _this.attr("data-filters");
					if (_data_filters == undefined || _data_filters == "[]") {
						_data_filters = [{ "name": _FUNCTIONS._defaultBrowserSearch, "operator": _FUNCTIONS._defaultBrowserSearchOperator, "fields": _FUNCTIONS._defaultBrowserSearchFields }];
					} else {
						_data_filters = JSON.parse(_data_filters);
					};
					var _where = "";
					var _arrS = [];
					var _arrW = [];
					$.each(_data_filters, function (i, item) {
						if ($("#" + item.name).val() != undefined && $("#" + item.name).val() != "") {
							var _value = $("#" + item.name).val();
							var _temp = "";
							_arrS.push({ "name": item.name, "value": _value });
							$.each(item.fields, function (ix, field) {
								if (_temp != "") { _temp += " OR "; }
								switch (item.operator.toLowerCase()) {
									case "like":
										_temp += (field + " " + item.operator + " '%" + _value + "%'");
										break;
									default:
										_temp += (field + " " + item.operator + " '" + _value + "'");
										break;
								}
							});
							if (_temp != "") { _arrW.push("(" + _temp + ")"); }
						}
					});
					for (var i = 0; i < _arrW.length; i++) { if (_where != "") { _where += " AND "; } _where += ("(" + _arrW[i] + ")"); }
					_json["where"] = _where;
					_AJAX.UiBrow(_json).then(function (data) {
						if (data.status == "OK") {
							var _dynLoadIdApp = false;

							$(".browser").html(data.message).removeClass("d-none").fadeIn("slow");
							var _browser_id_net = "";
							var _browser_id_system = "";
							for (var i = 0; i < _arrS.length; i++) {
								var _val = _arrS[i]["value"];
								var _name = _arrS[i]["name"];
								$("#" + _name).val(_val);

								if (!_dynLoadIdApp) { _dynLoadIdApp = (_name == "browser_id_app"); };
								switch (_name) {
									case "browser_id_system":
										_browser_id_system = _val;
										break;
									case "browser_id_net":
										_browser_id_net = _val;
										break;
								}
							}

							if (_dynLoadIdApp) { /* Reload dinamico basado en seleccion de id_application*/
								var _id = $(".browser_id_app").val();
								if (_id == "" || _id == "-1") { _id == "0"; }
								var _params = { "empty": true, "module": "mod_infrastructure", "table": "nets", "where": ("id_application=" + _id), "model": "nets", "order": "description ASC", "page": -1, "pagesize": -1 };
								_FUNCTIONS.onChangeDynCombos(_params, ".browser_id_net", _browser_id_net);
								var _params = { "empty": true, "module": "mod_infrastructure", "table": "systems", "where": ("id_application=" + _id), "model": "systems", "order": "description ASC", "page": -1, "pagesize": -1 };
								_FUNCTIONS.onChangeDynCombos(_params, ".browser_id_system", _browser_id_system);
							}
							resolve(data);
						} else {
							throw data;
						}
					}).catch(function (error) {
						throw error;
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				} finally {
					setTimeout(function () { _this.html(_html) }, 250);
				}
			});
	},
	onFormSearch: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					var _html = _this.html();
					var _target = _this.attr("data-forced");
					if (_target == undefined) {
						$(".abm").html("").addClass("d-none").hide();
						_target = ".browser";
					} else {
						$(".hideable").removeClass("active").removeClass("in");
						$(".nav-link").removeClass("active").removeClass("show");
					}
					_FUNCTIONS.onStatusClick(_this);
					var _json = _TOOLS.getFormValues(null, _this);
					_FUNCTIONS.onTransactionLog("onFormSearch", _json);
					_json["function"] = _this.attr("data-action");
					_AJAX.UiForm(_json).then(function (data) {
						if (data.status == "OK") {
							$(_target).html(data.message).removeClass("d-none").fadeIn("slow");
							resolve(data);
						} else {
							throw data;
						}
					}).catch(function (error) {
						throw error;
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				} finally {
					setTimeout(function () { _this.html(_html) }, 250);
				}
			});
	},
	onRefreshBrowser: function () {
		if ($(".pagination").html().trim() != "") {
			$(".page-item.active a").click();
		} else {
			$(".btn-browser-search").click();
		}
	},

	onClosePostTickets: function (_this) {
		_FUNCTIONS.onDestroyModal("#modal-postticket");
		$(".abm").addClass("d-none").hide();
		$(".browser").removeClass("d-none").fadeIn();
		_FUNCTIONS.onRefreshBrowser();
		_FUNCTIONS.onAlert({ "message": "Se ha grabado el registro", "class": "alert-success" });
	},
	onPostTickets: function (_this, data) {
		var _local = _this;
		var _message = "";
		var _dirty = false;
		_message += "<table class='table table-condensed' style='width:100%;'>";
		$.each(data.knows, function (i, item) {
			_message += "<tr><td><p>" + item.description + "</p></td><td><button data-id='" + item.id + "' type='button' class='btn btn-success btn-yeshelp'>Esto me ayudó</button></td></tr>";
			_dirty = true;
		});
		_message += "</table>";

		_FUNCTIONS.onDestroyModal("#modal-postticket");
		var _html = "";
		_html += "<div id='modal-postticket' class='modal fade' style='z-index:9999;'>";
		_html += "   <div class='modal-dialog'>";
		_html += "      <div class='modal-content'>";
		_html += "         <div class='modal-header'>";
		_html += "            <h4>Probables soluciones al requerimiento</h4>";
		_html += "         </div>";
		_html += "         <div class='modal-body danger alert-default'>" + _message + "</div>";
		_html += "         <div class='modal-body danger alert-default'><button type='button' class='btn btn-danger btn-raised btn-nohelp'>Nada de esto me sirve</button></div>";
		_html += "      </div>";
		_html += "   </div>";
		_html += "</div>";
		$("body").append(_html);
		$("body").off("click", ".btn-nohelp").on("click", ".btn-nohelp", function () {
			_FUNCTIONS.onClosePostTickets(_local);
		});
		$("body").off("click", ".btn-yeshelp").on("click", ".btn-yeshelp", function () {
			var _json = { "id_know": $(this).attr("data-id"), "id_ticket": _FUNCTIONS._last_insert };
			_AJAX.UiKnowHelp(_json).then(function (data) {
				if (data.status == "OK") {
					_FUNCTIONS.onClosePostTickets(_local);
				} else {
					throw data;
				}
			});
			_FUNCTIONS.onDestroyModal("#modal-postticket");
			$(".abm").addClass("d-none").hide();
			_FUNCTIONS.onRefreshBrowser();
			_FUNCTIONS.onAlert({ "message": "Se ha grabado el registro", "class": "alert-success" });
		});

		$("#modal-postticket").on('hide.bs.modal', function () { });
		$("#modal-postticket").modal({ backdrop: true, keyboard: true });

	},

	onViewFile: function (_this) {
		var _json = {
			"id": _this.attr("data-id"),
			"mode": "view",
			"exit": "download",
			"function": "fileLoader",
			"module": "mod_tickets",
			"table": "ticket_items",
			"model": "ticket_items"
		};
		_AJAX.UiFileLoader(_json);
	},
	onMessageRead: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					_AJAX.UiMessageRead({ "id": _this.attr("data-id") }).then(function (data) {
						_this.fadeOut("fast", function () { _this.remove(); })
						resolve(data);
					}).catch(function (error) {
						resolve(error);
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onMessagesNotification: function (_this) {
		return new Promise(
			function (resolve, reject) {
				try {
					var _json = _TOOLS.getFormValues(null, _this);
					_AJAX.UiMessagesNotification(_json).then(function (data) {
						if (data.data.length != 0) {
							$(".raw-messages_alert").removeClass("d-none").addClass("d-sm-inline").html("<i class='material-icons'>email</i> " + data.data.length);
						} else {
							$(".raw-messages_alert").removeClass("d-sm-inline").addClass("d-none").html("");
						}
						resolve(data);
					}).catch(function (error) {
						resolve(error);
					});
				} catch (rex) {
					_FUNCTIONS.onAlert({ "message": rex.message, "class": "alert-danger" });
					reject(rex);
				}
			});
	},
	onCheckRecord: function (_this) {
		if (_this.val() == 0) { $(".btn-record-check").prop("checked", _this.prop("checked")); }
	},

	onChangeDynCombos: function (_params, _target, _default) {
		_FUNCTIONS._cache = {};
		$(_target).empty();
		_AJAX.UiGet(_params).then(function (datajson) { _TOOLS.loadCombo(datajson, { "empty": _params.empty, "target": _target, "selected": _default, "id": "id", "description": "description" }); });
	},
	onActivateVideoMeeting: function (_this) {
		_NEOVIDEO.onDisconnect = function () {
			$(".dyn-video").addClass("d-none");
			$(".active-video").addClass("d-none").hide();
			_FUNCTIONS._videoMeetingOpen = false;
		};
		if (_FUNCTIONS._videoMeetingOpen) {
			_NEOVIDEO.onTurnOffVideo().then(function (data) { });
		} else {
			_FUNCTIONS._videoMeetingOpen = true;
			$(".dyn-video").removeClass("d-none");
			_NEOVIDEO.onAuthenticate().then(function (_auth) {
				_NEOVIDEO.UiListAvailableVideoRooms({}).then(function (data) {
					if (data.records.length != 0) {
						_NEOVIDEO.onJoinOpenSession(data.records[0].id).then(function (data) { _FUNCTIONS.onVideoAreaShow(data); });
					} else {
						_NEOVIDEO.onCreateNewVideoRoom($(this)).then(function (data) { _FUNCTIONS.onVideoAreaShow(data); });
					}
				}).catch(function (err) {
					_FUNCTIONS.onAlert({ "message": err.message, "class": "alert-danger" });
				});
			});
		}
	},
	onVideoAreaShow: function (data) {
		$(".title-connected").html(data.title);
		$(".title-rol").html(data.rol);
		$(".active-video").addClass("d-none").hide();
		$.blockUI({ message: "<img src='./assets/img/wait.gif' />", css: { border: 'none', backgroundColor: 'transparent', opacity: 1, color: 'transparent' } });
		setTimeout(function () {
			$(".active-video").removeClass("d-none").fadeIn();
			$.unblockUI();
		}, 1000);
	},

	onDrawStateAPI: function (data) {
		if (data.status == "OK") {
			$(".api-message").html(_TOOLS.onFormatData(data.message, "text"));
			$(".api-trace").html(_TOOLS.onFormatData(data.trace, "text"));
			$(".api-scope").html(_TOOLS.onFormatData(data.scope, "text"));
			$(".api-status").html(_TOOLS.onFormatData(data.status, "text"));
			$(".api-udT0").html(_TOOLS.onFormatData(data.now, "date"));
			try {
				$(".api-code").html(_TOOLS.onFormatData(data.records[0].code, "text"));
			} catch (err) {
				$(".api-code").html("N/D");
			}
		} else {
			_FUNCTIONS.onAlert({ "message": data.message, "class": "alert-danger" });
		}
	},
	onDrawSearchAPI: function (data, _showPacket) {
		var _html = "";
		if (data.records == null) {
			_html = "<div class='card shadow'>";
			_html += "  <span class='text-left badge badge-warning p-2' style='font-size:1.2em;'>Sin resultados para esta consulta</span>";
			_html += "</div>";
		} else {
			_html = "<div class='row no-gutters'>";
			_html += "	<div class='col-12 div-map d-none'>";
			_html += "	   <div id='map' class='map shadow-sm' style='width:100%;height:100vh;'>";
			_html += "	   </div>";
			_html += "	</div>";

			_html += "	<div class='col-12 div-grid'>";
			_html += "		<table class='table table-condensed' style='width:100%;'>";
			_html += "			<thead class='thead-light'>";
			_html += "				<tr>";
			_html += "					<th></th>";
			if (_showPacket) { _html += "<th></th>"; }
			_html += "					<th>Id</th>";
			_html += "					<th>Tipo</th>";
			_html += "					<th>Estado</th>";
			_html += "					<th>Timestamp</th>";
			_html += "					<th>Descripción</th>";
			_html += "					<th>Id externo</th>";
			_html += "				</tr>";
			_html += "			</thead>";
			_html += "			<tbody>";
			$.each(data.records, function (i, item) {
				var _record = _TOOLS.utf8_to_b64(JSON.stringify(item));
				var _packet = _TOOLS.utf8_to_b64(item.raw_data);
				_html += "			<tr>";
				_html += "				<td><a href='#' class='btn-viewRecord btn btn-raised btn-success btn-sm' data-record='" + _record + "' data-latitude='" + item.latitude + "' data-longitude='" + item.longitude + "'><i class='material-icons'>fullscreen</i></a></td>";
				if (_showPacket) { _html += "<td><a href='#' class='btn-viewPacket btn btn-raised btn-dark btn-sm' data-packet='" + _packet + "'><i class='material-icons'>token</i></a></td>"; }
				_html += "				<td>" + _TOOLS.onFormatData(item.id, "number") + "</td>";
				_html += "				<td>" + _TOOLS.onFormatData(item.type_transaction, "badge-dark") + "</td>";
				_html += "				<td>" + _TOOLS.onFormatData(item.type_status, "badge-warning") + "</td>";
				_html += "				<td>" + _TOOLS.onFormatData(item.created, "date") + "</td>";
				_html += "				<td>" + _TOOLS.onFormatData(item.description, "text") + "</td>";
				_html += "				<td>" + _TOOLS.onFormatData(item.externalid, "number") + "</td>";
				_html += "			</tr>";
			});
			_html += "			</tbody>";
			_html += "		</table>";

			_html += "		<hr/>";
			_html += "		<table>";
			_html += "		   <tr>";

			var _paginator = "";
			var _totalPages = parseInt(data.totalPages);
			Math.ceil(data.recordsTotal / data.pageSize);
			var _page = data.page;
			var _limit = (_page + 10);
			if (_limit > _totalPages) { _limit = _totalPages; }
			if (_totalPages > 1) {
				if (_page > 1) { _paginator += "<td><button type='button' class='btn btn-warning btn-api_search' data-page='" + (_page - 1) + "'>Anteriores</button></td>"; }
				for (var i = _page; i <= _limit; i++) {
					var _active = "btn-primary";
					if (i == _page) { _active = "btnActualPage btn-dark btn-raised"; }
					_paginator += "<td><button type='button' class='btn " + _active + " btn-api_search' data-page='" + i + "'>" + i + "</button></td>";
				}
				if ((_limit + 1) <= _totalPages) { _paginator += "<td><button type='button' class='btn btn-warning btn-api_search' data-page='" + (_limit + 1) + "'>Más</button></td>"; }
			}
			if (data.recordsTotal == 0) { _paginator += "<td><span class='text-left badge badge-primary p-1' style='font-size:1em;'>Sin resultados para esta consulta</span></td>"; }
			if (_paginator != "") { _html += _paginator; }

			_html += "	      </tr>";
			_html += "     </table>";
			_html += "	</div>";
			_html += "</div>";
		}
		$(".resultados").html(_html);
		if (_FUNCTIONS._show_map == 1) {
			const map = new google.maps.Map(document.getElementById("map"), { zoom: 12 });
			var position = { lat: 0, lng: 0 };
			$.each(data.records, function (i, item) {
				var contentString = _FUNCTIONS.onBuildPacketView(JSON.parse(item.raw_data));
				position = { lat: parseFloat(item.latitude), lng: parseFloat(item.longitude) };
				var marker = new google.maps.Marker({ position: position, map, title: "A" });
				var infowindow = new google.maps.InfoWindow({ content: contentString, ariaLabel: "Uluru" });
				marker.addListener("click", () => { infowindow.open({ anchor: marker, map }); });
			});
			map.setCenter(position);
		}

		$(".btn-Toggle").addClass("d-none");
		$(".btn-verMapa").removeClass("d-none");
		$(".div-map").addClass("d-none");
		$(".div-grid").removeClass("d-none");
	},
	onEvalSearchAPI: function (_params) {
		//if (_search == "") {
		//	_FUNCTIONS.onShowAlert("Debe efectuar la búsqueda poniendo algún dato a evaluar", "Alerta");
		//	return false;
		//}
		return true;
	},
	onViewRecord: function (_this) {
		var _html = "";
		var _data = JSON.parse(_TOOLS.b64_to_utf8(_this.attr("data-record")));
		_html += "<div class='container'>";
		_html += "<ul class='nav nav-tabs' role='tablist'>";
		_html += "   <li class='nav-item active'><a class='nav-link active' data-toggle='tab' href='#detalles'>Detalles</a></li>";
		_html += "   <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#adicionales'>Adicionales</a></li>";
		_html += "   <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#codigos'>Códigos</a></li>";
		_html += "   <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#firmas'>Firmas</a></li>";
		_html += "   <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#trace'>Trace</a></li>";
		_html += "   <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#raw'>Raw</a></li>";
		_html += "</ul>";
		_html += "<div class='tab-content'>";
		_html += "	<div id='detalles' class='tab-pane fade show active'>";
		_html += "		<table>";
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id, "number"), "Id", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.code, "text"), "Código", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.description, "text"), "Descripción", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.created, "date"), "Timestamp", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.verified, "date"), "Timestamp verificado", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.offline, "date"), "Offline", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.fum, "date"), "FUM", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.action, "action"), "Acción", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.code_application, "text"), "Aplicación", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_application, "number"), "Id aplicación", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_user, "number"), "Id usuario", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_profile, "number"), "Id perfil", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_last_thread, "number"), "Id último thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_type_document, "number"), "Id tipo documento", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.type_document, "type"), "Tipo de documento", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_type_log, "number"), "Id tipo log", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_type_status, "number"), "Id tipo estado", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.type_status, "badge-warning"), "Estado", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.id_type_transaction, "number"), "Id tipo transacción", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.type_transaction, "badge-warning"), "Tipo de transacción", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.type_key, "type"), "Clave de registro", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.type_step, "type"), "Tipo de paso", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.altitude, "number"), "Altitud", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.lat, "number"), "Latitud", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.lng, "number"), "Longitud", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.speed, "number"), "Velocidad", "");
		_html += "		</table>";
		_html += "	</div>";
		_html += "	<div id='adicionales' class='tab-pane fade'>";
		_html += "		<table>";
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.live, "bool"), "Transmitiendo en vivo", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.update_video_guest, "date"), "Fecha update cliente", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.update_video_host, "date"), "Fecha update anfitrión", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.require_input, "bool"), "Requiere entrada de datos", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.wait_input, "bool"), "Aguardando entrada de datos", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.waiting, "text"), "Esperando", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.privatized, "date"), "Registro privatizado", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.referer, "text"), "Referido por", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.field_rel, "text"), "Campo relacionado", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.name_key, "text"), "Clave relacionada", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.custom_message, "textlong"), "Mensaje personalizado", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.modifier, "text"), "Modificador", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.priority, "number"), "Prioridad", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.seconds, "number"), "Segundos", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.step, "text"), "Paso", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.fum_step, "date"), "FUM paso", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.destroyed, "date"), "Destruído", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.tech, "text"), "Tech", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread, "number"), "Thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread_init, "date"), "Inicio del thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread_id_profile, "number"), "Id perfil del thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread_screenshot, "number"), "Id thread de captura de pantalla", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread_fum_error, "date"), "FUM de error en thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread_fum_screeshot, "date"), "FUM captura de pantalla en thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread_end, "date"), "Fin del thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.thread_error, "text"), "Error en thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.end_last_thread, "date"), "Fin del último thread", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.last_error, "text"), "Último error", "");
		_html += "		</table>";
		_html += "	</div>";
		_html += "	<div id='codigos' class='tab-pane fade'>";
		_html += "		<table>";
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.head, "html"), "Encabezado del formulario", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.body, "html"), "Cuerpo del formulario", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.script, "command"), "Script del formulario", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.privateKey, "key"), "Clave privada", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.privateKey_additional, "key"), "Clave privada adicional", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.privateParty, "key"), "Info privada", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.publicKey, "key"), "Clave pública", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.publicKey_additional, "key"), "Clave pública adicional", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.publicParty, "key"), "Info pública", "");
		_html += "		</table>";
		_html += "	</div>";
		_html += "	<div id='firmas' class='tab-pane fade'>";
		_html += "		<table>";
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.integrity_check, "material-icon"), "Estado de integridad", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.integrity, "bool"), "Integridad", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.verified_integrity, "date"), "Fecha de verificación de integridad", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.integrity_additional, "bool"), "Integridad adicional", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.verified_integrity_additional, "date"), "Fecha de verificación de integridad adicional", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.signature, "key"), "Firma digital", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.signature_additional, "key"), "Firma digital adicional", "");
		_html += "		</table>";
		_html += "	</div>";
		_html += "	<div id='trace' class='tab-pane fade'>";
		_html += "		<table>";
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.externalid, "number"), "Id externo", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.external_response, "raw"), "Respuesta externa", "");

		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.trace, "json"), "Datos de rastreo", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.command_rel, "command"), "Comando ejecutado", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.val_rel, "text"), "Valor de relación", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.val_key, "text"), "Valor de clave", "");
		_html += "		</table>";
		_html += "	</div>";
		_html += "	<div id='raw' class='tab-pane fade'>";
		_html += "		<table>";
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.mime_type, "text"), "Tipo mime", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.mime_type_additional, "text"), "Tipo mime adicional", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.raw_data, "raw"), "Datos crudos", "");
		_html += _FUNCTIONS.onDrawFieldRecord(_TOOLS.onFormatData(_data.raw_data_additional, "raw"), "Datos crudos adicionales", "");
		_html += "		</table>";
		_html += "	</div>";
		_html += "</div>";
		_html += "</div>";

		_FUNCTIONS.onShowInfo(_html, "Detalles del registro");
		$(".comment").shorten({ showChars: 25, });
	},

	onViewPacket: function (_this) {
		_FUNCTIONS.onShowInfo(_FUNCTIONS.onBuildPacketView(JSON.parse(_TOOLS.b64_to_utf8(_this.attr("data-packet")))), "Detalles del paquete de datos");
		$(".comment").shorten({ showChars: 25, });
	},

	onBuildPacketView: function (_raw) {
		var _html = "";
		_html += "<div class='container'>";
		_html += "   <ul class='nav nav-tabs' role='tablist'>";
		_html += "      <li class='nav-item active'><a class='nav-link active' data-toggle='tab' href='#detalles'>Detalles</a></li>";
		_html += "      <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#archivos'>Archivos</a></li>";
		_html += "      <li class='nav-item'><a class='nav-link' data-toggle='tab' href='#geolocalizacion'>Geolocalización</a></li>";
		_html += "   </ul>";
		_html += "   <div class='tab-content'>";
		_html += "	    <div id='detalles' class='tab-pane fade show active'>";
		_html += "         <table class='table table-sm table-borderless'>";
		_html += "            <tbody>";
		Object.keys(_raw).forEach(key => {
			if (!key.match(/^(password|userName|username|contraseña|usuario)$/)) {
				if (key.slice(0, 5) != "file-") { _html += "<tr><td>" + key + "</td><td><span class='p-1 shadow-sm'>" + _raw[key] + "</span></td></tr>"; }
			}
		});
		_html += "            </tbody>";
		_html += "         </table>";
		_html += "	    </div>";

		_html += "	    <div id='archivos' class='tab-pane fade'>";
		_html += "         <div class='row px-1 py-4 m-0'>";
		Object.keys(_raw).forEach(key => {
			if (key.slice(0, 5) == "file-") {
				_html += "<div class='col-3'>";
				var mime = _raw[key].split(";")[0].split(":")[1];
				if (mime.split("/")[0] == "image") {
					_html += "<img src='" + _raw[key] + "' style='width:100%;'/>";
				} else {
					_html += "<span class='p-1'><i class='material-icons'>sell</i>archivo." + mime.split("/")[1] + "</span>";
				}
				_html += "</div>";
			}
		});
		_html += "         </div>";
		_html += "      </div>";

		var _lat = "";
		var _lng = "";
		Object.keys(_raw).forEach(key => {
			if (key.match(/^(longitude|long|lng|longitud)$/)) { _lng = _raw[key]; }
			if (key.match(/^(latitude|lat|latitud)$/)) { _lat = _raw[key]; }
		});
		var _url = ("https://maps.googleapis.com/maps/api/staticmap?center=" + _lat + "," + _lng + "&maptype=hybrid&zoom=16&size=400x400&key=" + _FUNCTIONS.GLOOGLE_API_KEY + "&markers=" + _lat + "," + _lng + "&format=png&style=feature:poi|element:labels|visibility:off");

		_html += "	    <div id='geolocalizacion' class='tab-pane fade'>";
		_html += "         <div class='row px-1 py-4 m-0'>";
		_html += "            <img src='" + _url + "' style='width:100%;'/>";
		_html += "         </div>";
		_html += "	    </div>";
		_html += "   </div>";
		_html += "</div>";
		return _html;
	},

	onDrawFieldRecord: function (val, label, target) {
		var _ret;
		if (target != "") {
			_ret = { "draw": false, "html": "", "target": "" };
			if (val != "N/D") { _ret = { "draw": true, "html": val, "target": target }; }
			if (_ret.draw) { $(target).html(_ret.html); }
		} else {
			_ret = "";
			if (val != "N/D" && val != "") {
				if (label != "") { _ret += ("<tr><td><b>" + label + "</b></td></tr>"); }
				_ret += ("<tr><td>" + val + "</td></tr>");
			} else { _ret = ""; }
		}
		return _ret;
	},
	onPopulateUserAPI: function (_active_api) {
		_AJAX.UiProfile({ "active_api": _active_api }).then(function (data) {

			$.each(data.api_users, function (i, item) {
				$.each(item.api_applications, function (x, app) {
					var _types = "";
					if (app.api_profiles != null) { _types = _TOOLS.utf8_to_b64(JSON.stringify(app.api_profiles[0].api_types_transactions)); }
					var _option = "<option value='" + item.id + "' data-types_transactions='" + _types + "' data-show_map='" + item.show_map + "' data-id_application='" + app.id + "' data-username='" + item.username + "' data-password='" + item.password + "'>" + item.description + "</option>";
					$(".cboApiUsername").append(_option);
				});
			});
			$(".cboApiUsername").change();
			$(".btn-api_search").click();
		});
	},
	onFacturar: function (_this) {
		var _id = _this.attr("data-id");
		if (!confirm("Se marcará como facturado ¿Acepta?")) { return false; }
		_AJAX.UiFacturar({ "id": _id }).then(function (data) {
			$(".btn-browser-search").click();
		});
	},
	onSetActiveCredentials: function (_this) {
		_active = {
			"types_transactions": _this.find(':selected').attr("data-types_transactions"),
			"show_map": _this.find(':selected').attr("data-show_map"),
			"username": _this.find(':selected').attr("data-username"),
			"password": _this.find(':selected').attr("data-password"),
			"id_application": _this.find(':selected').attr("data-id_application")
		};
		_FUNCTIONS._show_map = parseInt(_active.show_map);
		if (_FUNCTIONS._show_map == 1) { $(".btn-Toggle").show(); } else { $(".btn-Toggle").hide(); }

		_FUNCTIONS._type_transactions = JSON.parse(_TOOLS.b64_to_utf8(_active.types_transactions));
		$(".tdTypeSelector").addClass("d-none");
		$(".browser_id_type_transaction").html("");
		var _option = "";
		$.each(_FUNCTIONS._type_transactions, function (x, tt) { _option += "<option value='" + tt.id + "'>" + tt.description + "</option>"; });
		if (_option != "") {
			_option = ("<option value='0' selected>[Todos]</option>" + _option);
			$(".browser_id_type_transaction").append(_option);
			$(".tdTypeSelector").removeClass("d-none");
		}

		InitStateAPI();
		$(".btn-api_search").click();
	},
	onSetUsageCredentials: function (_this) {
		var _val = parseInt(_this.val());
		$(".tr-user").addClass("d-none");
		if (_val == -1) {
			$(".tr-user").removeClass("d-none");
		} else {
			$(".tr-user-" + _val).removeClass("d-none");
		}
	},
	onStateLinkAPI: function (_this) {
		var _state = _this.attr("data-state");
		if (!confirm("¿Confirma la acción '" + _state + "'?")) { return false; }
		var _json = {
			"application": _this.attr("data-application"),
			"user": _this.attr("data-user"),
			"state": _state
		};
		_AJAX.UiStateLinkAPI(_json).then(function (data) {
			$(".btn-m_api_user_profiles").click();
		});
	},
	onTestAuthentication: function (_this) {
		var _auth = {
			"username": _this.attr("data-username"),
			"password": _this.attr("data-password"),
			"id": _this.attr("data-application")
		};
		_NEOAUTHENTICATION.UiAuthenticate(_auth)
			.then(function (data) {
				if (data.status == "OK") {
					var _html = "<table class='table table-condensed table-stripped'>";
					_html += "      <tr class='table-secondary'><td colspan='2'><b>Datos de verificación</b></td></tr>";
					_html += "      <tr class='table-success'><td>Aplicación:</td><td>" + data.records[0].application + "</td></tr>";
					_html += "      <tr class='table-success'><td>Estado:</td><td>" + data.status + "</td></tr>";
					_html += "      <tr class='table-success'><td>Timestamp:</td><td>" + data.udT0 + "</td></tr>";
					_html += "      <tr class='table-success'><td>Email:</td><td>" + data.records[0].email + "</td></tr>";
					_html += "      <tr class='table-success'><td>Nombre:</td><td>" + data.records[0].name + " " + data.records[0].surname + "</td></tr>";
					_html += "      <tr class='table-success'><td>Tipo:</td><td>" + data.records[0].type_user + "</td></tr>";
					_html += "   </table>";

					_html += "   <table class='table table-condensed table-stripped'>";
					_html += "      <tr class='table-secondary'><td colspan='2'><b>Credenciales</b></td></tr>";
					_html += "      <tr class='table-warning'>";
					_html += "         <td>Username:</td><td>" + data.records[0].username + "</td>";
					_html += "      </tr>";
					_html += "      <tr class='table-warning'>";
					_html += "         <td>Password:</td><td>" + _auth.password + "</td>";
					_html += "      </tr>";
					_html += "      <tr class='table-warning'>";
					_html += "         <td>Id:</td><td>" + data.records[0].id_application + "</td>";
					_html += "      </tr>";
					_html += "   </table>";
					_FUNCTIONS.onShowInfo(_html, "Detalles de la autenticación");
				} else {
					throw data.message;
				}
			})
			.catch(function (rex) {
				_NEOAUTHENTICATION.onErrHandler(rex);
				reject(rex);
			});

	},
	onTestProfile: function (_this) {
		var id_user_auth = _this.attr("data-user");
		var id_application_auth = _this.attr("data-application");
		var _data = JSON.parse(_TOOLS.b64_to_utf8(_this.attr("data-record")));
		var _html = "";
		if (_data != null) {
			if (_data.length != 0) {
				_html = "<table class='table table-condensed table-stripped'>";
				_html += "   <tr class='table-primary'><td colspan='4'><b>Datos del registro </b></td></tr>";
				_html += "   <tr class='table-info'>";
				_html += "      <td><b>Código:</b></td><td>" + _TOOLS.onFormatData(_data[0].code, "text") + "</td>";
				_html += "      <td><b>Descripción:</b></td><td>" + _TOOLS.onFormatData(_data[0].description, "text") + "</td>";
				_html += "   </tr>";
				_html += "   <tr class='table-info'><td><b>Timestamp:</b></td><td colspan='3'>" + _TOOLS.onFormatData(_data[0].created, "date") + "</td></tr>";
				_html += "   <tr class='table-info'><td><b>Certificado p12:</b></td><td colspan='3'>" + _TOOLS.onFormatData(_data[0].p12, "text") + "</td></tr>";
				_html += "   <tr class='table-info'>";
				_html += "      <td><b>User:</b></td><td>" + _TOOLS.onFormatData(_data[0].id_user_auth, "number") + "</td>";
				_html += "      <td><b>App:</b></td><td>" + _TOOLS.onFormatData(_data[0].id_application_auth, "number") + "</td>";
				_html += "   </tr>";
				_html += "   <tr class='table-info'>";
				_html += "      <td><b>Operaciones libres:</b></td><td>" + _TOOLS.onFormatData(_data[0].free_by_plan, "number") + "</td>";
				_html += "      <td><b>Monto por excedente:</b></td><td>u$s " + _TOOLS.onFormatData(_data[0].amount_excedent, "number") + " por operación</td>";
				_html += "   </tr>";
				_html += "</table>";
				switch (parseInt(_data[0].id_application_auth)) {
					case 1: // Transactions
						_html += "<h5>Tipos de transacciones </h5>";
						_html += "<table class='table table-condensed table-stripped'>";
						$.each(_data[0].api_types_transactions, function (i, type) {
							if (i == 0) {
								_html += "   <tr class='table-primary'>";
								_html += "      <td><b>Id</b></td>";
								_html += "      <td><b>Código</b></td>";
								_html += "      <td><b>Descripción</b></td>";
								_html += "   </tr>";
							}
							_html += "   <tr class='table-info'>";
							_html += "      <td>" + _TOOLS.onFormatData(type.id, "number") + "</td>";
							_html += "      <td>" + _TOOLS.onFormatData(type.code, "number") + "</td>";
							_html += "      <td>" + _TOOLS.onFormatData(type.description, "text") + "</td>";
							_html += "   </tr>";
						});
						_html += "</table>";
						break;
				}
				_FUNCTIONS.onShowInfo(_html, "Detalles del perfil");
			} else {
				_html = "<span class='badge badge-danger'>Debe generarse un nuevo perfil para acceder a este segmento del Neodata Ecosystem</span>";
				_html += "<table class='table table-condensed table-stripped'>";
				_html += "   <tr class='table-light'><td>Código:</td><td><input id='newcode' name='newcode' class='form-control newcode' type='text'/></td></tr>";
				_html += "   <tr class='table-light'><td>Descripción:</td><td><input id='newdescription' name='newdescription' class='form-control newdescription' type='text'/></td></tr>";
				_html += "   <tr class='table-light'><td>Timestamp:</td><td>" + _TOOLS.getNow() + "</td></tr>";
				_html += "   <tr class='table-light'><td>Certificado p12:</td><td><input disabled id='newp12' name='newp12' class='form-control newp12' type='text' value='./application/config/certificates/NeodataBase64.p12'/></td></tr>";
				_html += "   <tr class='table-light'><td>Cert. password:</td><td><input disabled id='newcertificate_password' name='newcertificate_password' class='form-control newcertificate_password' type='text' value='55AraucariA'/></td></tr>";
				_html += "   <tr class='table-light'><td>User:</td><td><input disabled id='newid_user_path' name='newid_user_path' class='form-control newid_user_path' type='text' value='" + id_user_auth + "'/></td></tr>";
				_html += "   <tr class='table-light'><td>App:</td><td><input disabled id='newid_user_path' name='newid_user_path' class='form-control newid_user_path' type='text' value='" + id_application_auth + "'/></td></tr>";
				_html += "   <tr class='table-light'><td>Transacciones:</td><td><input disabled id='newtransactions' name='newtransactions' class='form-control newtransactions' type='text' value='0'/></td></tr>";
				_html += "   <tr class='table-light'><td>Libres por plan:</td><td><input disabled id='newfree_by_plan' name='newfree_by_plan' class='form-control newfree_by_plan' type='text' value='0'/></td></tr>";
				_html += "   <tr class='table-light'><td>Monto por cada excedente:</td><td><input disabled id='newamount_excedent' name='newamount_excedent' class='form-control newamount_excedent' type='text' value='0'/></td></tr>";
				_html += "   <tr class='table-light'><td>Webhooks:</td><td><input disabled id='newwebhooks' name='newwebhooks' class='form-control newwebhooks' type='text' value='1'/></td></tr>";
				_html += "</table>";
				_html += "<table class='table table-condensed'>";
				_html += "   <tr>";
				_html += "       <td align='left'><button type='button' class='btn btn-dark btn-raised btn-cancel-add-profile'>Cancelar</button></td>";
				_html += "       <td align='right'><button type='button' class='btn btn-success btn-raised btnAddProfile'>Aceptar</button></td>";
				_html += "   <tr>";
				_html += "</table>";
				_FUNCTIONS.onShowInfo(_html, "Alta de nuevo perfil");
				$("body").off("click", ".btn-cancel-add-profile").on("click", ".btn-cancel-add-profile", function () {
					$("#modal-info").modal("hide").data("bs.modal", null);
					_FUNCTIONS.onDestroyModal("#modal-info");
				});
			}
		} else {
			_html = "<p>No se requiere perfil para acceder a este segmento del Neodata Ecosystem</p>";
			_FUNCTIONS.onShowInfo(_html, "Información");
		}
	},
	onAddProfile: function (_this) {
		alert("alta de perfil!");
	},
	onViewBigImage: function (_this) {
		var _html = "<span class='badge badge-primary my-1 p-1' style='font-size:1em'>" + _this.attr("data-label") + "</span>";
		_html += "<img src='" + _this.attr("src") + "' style='width:100%;'/>";
		_FUNCTIONS.onShowHtmlModal("Detalles de la imagen", _html, function () {
			$("body").off("click", ".btn-cancel-link").on("click", ".btn-cancel-link", function () {
				$("#modal-html").modal("hide").data("bs.modal", null);
				_FUNCTIONS.onDestroyModal("#modal-html");
			});
		});
	},
	onViewExcedent: function (_this) {
		var _excedents = _this.attr("data-excedent");
		var _amount = _this.attr("data-amount");
		var _total = (_excedents * _amount);
		var _html = "<table class='table table-condensed table-stripped'>";
		_html += "   <tr class='table-primary'><td colspan='2'>Para facturar a <b>" + _this.attr("data-client") + "</b> el mes <b>" + _this.attr("data-month") + "</b> del año <b>" + _this.attr("data-year") + "</b></td></tr>";
		_html += "   <tr class='table-secondary'><td>Operaciones excedentes:</td><td align='right'>" + _TOOLS.onFormatData(_excedents, "number") + "</td></tr>";
		_html += "   <tr class='table-secondary'><td>Monto por operación:</td><td align='right'>u$d " + _TOOLS.onFormatData(_amount, "number") + "</td></tr>";
		_html += "   <tr><td colspan='2'><hr/></td></tr>";
		_html += "   <tr class='table-success'><td>Total</td><td align='right'>u$d " + _TOOLS.onFormatData(_total, "number") + "</td></tr>";
		_html += "</table>";
		_FUNCTIONS.onShowHtmlModal("Detalles de facturación", _html, function () {
			$("body").off("click", ".btn-cancel-link").on("click", ".btn-cancel-link", function () {
				$("#modal-html").modal("hide").data("bs.modal", null);
				_FUNCTIONS.onDestroyModal("#modal-html");
			});
		});
	},
	onViewMap: function (_this) {
		$(".div-grid").addClass("d-none");
		$(".div-map").removeClass("d-none");
		$(".btn-Toggle").removeClass("d-none");
		_this.addClass("d-none");
	},
	onViewGrid: function (_this) {
		$(".div-map").addClass("d-none");
		$(".div-grid").removeClass("d-none");
		$(".btn-Toggle").removeClass("d-none");
		_this.addClass("d-none");
	},
}
