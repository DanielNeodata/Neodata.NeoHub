var _TOOLS = {
	_timerIcon: 0,
	latitude: null,
	longitude: null,
	altitude: null,
	accuracy: null,
	heading: null,
	speed: null,
	timestamp: null,
	observable: function (value) {
		var listeners = [];
		function notify(newValue) {
			listeners.forEach(function (listener) { listener(newValue); });
		}
		function accessor(newValue) {
			if (arguments.length && newValue !== value) {
				value = newValue;
				notify(newValue);
			}
			return value;
		}
		accessor.subscribe = function (listener) { listeners.push(listener); };
		return accessor;
	},
	todayYYYYMMDD: function (_separator) {
		var currentDate = new Date();
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		if (day < 10) { day = "0" + day; }
		if (month < 10) { month = "0" + month; }
		return (year + _separator + month + _separator + day);
	},
	toDeg: function (r) { return r * 180 / Math.PI; },
	getNow: function () {
		var currentDate = new Date();
		var second = currentDate.getSeconds();
		var minute = currentDate.getMinutes();
		var hour = currentDate.getHours();
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		if (day < 10) { day = "0" + day; }
		if (month < 10) { month = "0" + month; }
		if (hour < 10) { hour = "0" + hour; }
		if (minute < 10) { minute = "0" + minute; }
		if (second < 10) { second = "0" + second; }
		return day + "/" + month + "/" + year + " " + hour + ":" + minute + ":" + second;
	},
	getNowYYYYMMDD: function () {
		var currentDate = new Date();
		var second = currentDate.getSeconds();
		var minute = currentDate.getMinutes();
		var hour = currentDate.getHours();
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		if (day < 10) { day = "0" + day; }
		if (month < 10) { month = "0" + month; }
		if (hour < 10) { hour = "0" + hour; }
		if (minute < 10) { minute = "0" + minute; }
		if (second < 10) { second = "0" + second; }
		return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
	},
	isValidEmail: function (email) {
		var em = /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
		return em.test(email);
	},
	validate: function (_selector, _seeAlert) {
		if (_seeAlert == undefined) { _seeAlert = false; }
		var _ret = true;
		$(_selector).each(function () { _ret = _TOOLS.formatValidation($(this)) && _ret; });
		if (!_ret && _seeAlert) {
			_FUNCTIONS.onAlert({ "message": "Complete los datos requeridos", "class": "alert-danger" });
		}
		return _ret;
	},
	formatValidation: function (_obj) {
		var _ret = true;
		switch (_obj.prop("tagName")) {
			case "TEXTAREA":
			case "INPUT":
				switch (_obj.attr("type")) {
					case "email":
						if (!_TOOLS.isValidEmail(_obj.val())) {
							_ret = false;
						}
						break;
					case "checkbox":
						var _checked = _obj.is(":checked");
						if (!_checked) { _ret = false; }
						break;
					default:
						if (_obj.hasClass("data-list")) {
							if (_obj.attr("data-selected-id") == "" || _obj.attr("data-selected-id") == undefined) { _ret = false; }
						} else {
							if (_obj.val() == "") { _ret = false; }
						}
						break;
				}
				break;
			case "SELECT":
				if (_obj.val() == "-1" || _obj.val() == undefined || _obj.val() == null || _obj.val() == "") { _ret = false; }
				break;
		}
		if (_ret) {
			_obj.removeClass("is-invalid").addClass("is-valid");
			$(".invalid-" + _obj.prop("name")).html("").addClass("d-none");
		} else {
			_obj.removeClass("is-valid").addClass("is-invalid");
			var _msg = _obj.attr("placeholder");
			if (_msg == undefined) { _msg = "el valor de selección"; }
			$(".invalid-" + _obj.prop("name")).html("Debe completar " + _msg).removeClass("d-none");
		}
		return _ret;
	},
	getFormValues: function (_selector, _this) {
		try {
			var _jsonSave = {};
			$(_selector).each(function () {
				var property = $(this).attr('name');
				var value = "";
				switch ($(this).attr("data-type")) {
					case "select":
						if ($(this).length == 0) { value = ""; } else { value = $(this).val(); }
						if (value == null || value == "-1" || value == "0") { value = ""; }
						break;
					case "checkbox":
						if ($(this).prop("checked")) {
							value = $(this).val();
							if (parseInt(value) == 0 || value == '') { value = 1; }
						} else {
							value = 0;
						}
						break;
					default:
						value = $(this).val();
						break;
				}
				_jsonSave[property] = value;
			});
			//Process attached files
			/* GENERAL */
			var _newFiles = [];
			var _delFiles = [];
			var _newMessages = [];
			$(".new-file").each(function () { _newFiles.push({ "src": $(this).attr('src'), "filename": $(this).attr('data-filename') }); });
			$(".del-file").each(function () { _delFiles.push({ "id": $(this).attr('data-id') }); });
			$(".new-message").each(function () { _newMessages.push({ "message": $(this).html() }); });

			/* MOD_FOLDERS */
			var _newFolderItems = [];
			$(".new-folder-item").each(function () {
				_newFolderItems.push(
					{
						"src": $(this).attr('data-result'),
						"filename": $(this).attr('data-filename'),
						"description": $(this).attr('data-description'),
						"keywords": $(this).attr('data-keywords'),
						"id_type_folder_item": $(this).attr('data-type')
					});
			});

			_jsonSave["new-files"] = _newFiles;
			_jsonSave["del-files"] = _delFiles;
			_jsonSave["new-messages"] = _newMessages;
			_jsonSave["new-folder-items"] = _newFolderItems;

			_jsonSave["image"] = $(".img-image").attr("src");
			_jsonSave["id"] = _this.attr("data-id");
			_jsonSave["module"] = _this.attr("data-module");
			_jsonSave["model"] = _this.attr("data-model");
			_jsonSave["table"] = _this.attr("data-table");
			if (_this.attr("data-page") == undefined) { _this.attr("data-page", 1); };
			_jsonSave["page"] = _this.attr("data-page");
		} catch (rex) { };
		return _jsonSave;
	},
	UUID: function () {
		var s = [];
		var hexDigits = "0123456789abcdef";
		for (var i = 0; i < 36; i++) { s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1); }
		s[14] = "4";
		s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01
		s[8] = s[13] = s[18] = s[23] = "-";
		var uuid = s.join("");
		return uuid;
	},
	iconByMime: function (_file_type, _data) {
		var _icon = "";
		switch (true) {
			case (_file_type.indexOf("image") != -1):
				_icon = "./assets/img/image.png";
				break;
			case (_file_type.indexOf("wav") != -1):
			case (_file_type.indexOf("mp3") != -1):
			case (_file_type.indexOf("audio") != -1):
				_icon = "./assets/img/audio.png";
				break;
			case (_file_type.indexOf("video") != -1):
			case (_file_type.indexOf("youtube") != -1):
			case (_file_type.indexOf("video") != -1):
				_icon = "./assets/img/video.png";
				break;
			case (_file_type.indexOf("pdf") != -1):
				_icon = "./assets/img/pdf.png";
				break;
			default:
				_icon = "./assets/img/file.png";
				break;
		}
		return _icon;
	},
	diffSeconds: function (_from, _to) {
		_from = moment(_from);
		_to = moment(_to);
		var _duration = moment.duration(_from.diff(_to));
		return _duration.asSeconds();
	},
	prettyPrint: function (obj) {
		return JSON.stringify(obj, undefined, 4);
	},
	NASort: function (a, b) {
		if (a.innerHTML == 'NA') {
			return 1;
		}
		else if (b.innerHTML == 'NA') {
			return -1;
		}
		return (a.innerHTML > b.innerHTML) ? 1 : -1;
	},
	replaceAll: function (str, find, replace) {
		return str.replace(new RegExp(find, 'g'), replace);
	},
	loadCombo: function (datajson, params) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (params.empty == undefined) { params.empty = false; }
					$(params.target).empty();
					if (params.selected == -1 || params.empty) { $(params.target).append('<option selected value="-1">[Seleccione]</option>'); }
					$.each(datajson.data, function (i, item) {
						var _selected = "";
						if (params.selected == item[params.id]) { _selected = "selected"; }
						$(params.target).append('<option ' + _selected + ' value="' + item[params.id] + '">' + item[params.description] + '</option>');
					});
					resolve(true);
				} catch (rex) {
					reject(rex);
				}
			});
	},
	loadBrowser: function (datajson, params) {
		return new Promise(
			function (resolve, reject) {
				try {
					var _full = false;
					var _html = "";
					$.each(datajson.data, function (i, item) {
						if (i == 0) {
							_full = true;
							_html += "<table class='table table-condensed'>";
							_html += " <thead>";
							_html += "  <tr>";
							$.each(params.cols, function (i, col) {
								_html += "<th><b>" + col.title + "</b></th>";
							});
							_html += "  </tr>";
							_html += " </thead>";
							_html += " <tbody>";
						}
						_html += "<tr>";
						$.each(params.cols, function (i, col) {
							_html += "<td>" + item[col.field] + "</td>";
						});
						_html += "</tr>";
					});
					if (_full) {
						_html += " </tbody>";
						_html += "</table>";
					}
					$(params.target).html(_html);
					resolve(true);
				} catch (rex) {
					reject(rex);
				}
			});
	},
	successTelemetry: function (position) {
		_TOOLS.latitude = position.coords.latitude;
		_TOOLS.longitude = position.coords.longitude;
		_TOOLS.altitude = position.coords.altitude;
		_TOOLS.accuracy = position.coords.accuracy;
		_TOOLS.heading = position.coords.heading;
		_TOOLS.speed = position.coords.speed;
		_TOOLS.timestamp = position.coords.timestamp;
	},
	errorTelemetry: function (error) {
		_TOOLS.latitude = null;
		_TOOLS.longitude = null;
		_TOOLS.altitude = null;
		_TOOLS.accuracy = null;
		_TOOLS.heading = null;
		_TOOLS.speed = null;
		_TOOLS.timestamp = null;
	},
	createFileItem: function (_name, _result) {
		var _id = _TOOLS.UUID();
		return "<li class='list-group-item attach " + _id + "' data-name='" + _name + "' data-url='" + _result + "' style='padding:10px;'>Se ha adjuntado <span class='label label-success'>" + _name + "</span><a href='#' class='btn btn-xs btn-deattach btn-danger pull-right' data-id='" + _id + "' style='margin:0px;'><i class='material-icons'>delete_forever</i></a></li>"
	},
	counterAnimate: function (_this) {
		var _value = _this.attr("data-value");
		$({ countNum: _value }).animate({ countNum: 4000 }, {
			duration: 8000,
			easing: 'linear',
			step: function () {
				_this.html(Math.floor(this.countNum));
			},
			complete: function () {
				_this.html(this.countNum);
			}
		});
	},
	toMoney: function (_value, _intl, _style, _currency) {
		if (_intl == undefined) { _intl = "de-DE"; }
		var formatter = new Intl.NumberFormat(_intl, {
			style: _style,
			currency: _currency,
		});
		return formatter.format(_value);
	},
	utf8_to_str: function (a) {
		for (var i = 0, s = ''; i < a.length; i++) {
			var h = a[i].toString(16)
			if (h.length < 2) h = '0' + h
			s += '%' + h
		}
		return decodeURI(s);
	},
	utf8_to_b64: function (str) { return window.btoa(unescape(encodeURIComponent(str))); },
	b64_to_utf8: function (str) { str = str.replace(/\s/g, ''); return decodeURIComponent(escape(window.atob(str))); },
	b64_to_Blob: function (content, contentType) {
		contentType = contentType || '';
		const sliceSize = 512;
		const byteCharacters = window.atob(content);
		const byteArrays = [];
		for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
			const slice = byteCharacters.slice(offset, offset + sliceSize);
			const byteNumbers = new Array(slice.length);
			for (let i = 0; i < slice.length; i++) { byteNumbers[i] = slice.charCodeAt(i); }
			const byteArray = new Uint8Array(byteNumbers);
			byteArrays.push(byteArray);
		}
		const blob = new Blob(byteArrays, { type: contentType });
		return blob;
	},
	onFormatData: function (val, _format) {
		var _ret = "N/D";
		if (val == undefined || val == null) { val = _ret; };
		if (val != _ret) {
			switch (_format) {
				case "badge-primary":
				case "badge-secondary":
				case "badge-dark":
				case "badge-info":
				case "badge-success":
				case "badge-warning":
				case "badge-danger":
					if (val != "") { val = "<span class='badge " + _format + "'>" + val + "</span>"; }
				case "material-icon":
					if (val != "") { val = "<i class='material-icons'>" + val + "</i>"; }
					break;
				case "json":
					if (val != "") { val = "<pre>" + _TOOLS.prettyPrint(JSON.parse(val)) + "</pre>"; }
					break;
				case "img":
					if (val != "") { val = "<img src='" + val + "'/>"; }
					break;
				case "bool":
					if (parseInt(val) == 1) { val = "SI"; } else { val = "NO"; }
					break;
				case "key":
					val = "<pre class='comment more'>" + val + "</pre>";
					break;
				case "raw":
					var _obj;
					var _render = "";
					var _html = "";
					var _icols = 12;
					if (val != "") {
						try {
							val = window.atob(val);
							_obj = JSON.parse(val);
							_render = _TOOLS.onResolveJsonNodeDisplay(_obj);
							val = "<pre class='comment more'>" + _TOOLS.prettyPrint(_obj) + "</pre>";
							if (_render != "") { _icols = 9; }
						} catch (e) {
							try {
								_obj = JSON.parse(val);
								_render = _TOOLS.onResolveJsonNodeDisplay(_obj);
								val = "<pre class='comment more'>" + _TOOLS.prettyPrint(_obj) + "</pre>";
								if (_render != "") { _icols = 9; }
							} catch (e) {
								val = "<pre class='comment more'>Datos base64:<br/>" + val + "</pre>";
								_icols = 12;
							}
						}
					}
					_html = "<div class='row'>";
					if (_render != "") { _html += "<div class='col-3'>" + _render + "</div>"; }
					_html += "<div class='col-" + _icols + "'>" + val + "</div>";
					_html += "</div>";
					val = _html;

					break;
				case "html":
					if (val != "") { val = "<p style='font-size:0.7em;color:red;font-weight:bold;'>Vista de referencia y aproximada del código.  ¡No considerarla el render final!</p><div style='width:100%;height:200px;overflow:auto;'>" + val + "</div>"; }
					break;
				case "action":
					break;
				case "command":
					if (val != "") { val = "<code class='comment more'>" + val + "</code>"; }
					break;
				case "text":
					break;
				case "textlong":
					val = "<pre class='comment more p-0 m-0'>" + val + "</pre>";
					break;
				case "number":
					break;
				case "date":
					val = val.replace("T", " ");
					if (moment(val, "YYYY-MM-DD", false).isValid()) { val = moment(val).format("DD/MM/YYYY HH:mm:ss"); }
					break;
				default:
					break;
			}
			_ret = val;
		}
		return _ret;
	},
	onResolveJsonNodeDisplay: function (_obj) {
		var _html = "";
		var _ret = [];
		const entries = Object.entries(_obj);
		Object.entries(_obj).forEach(([key, value]) => {
			var _parts = value.split(":");
			if (_parts[0] == "data") {
				switch (true) {
					case (value.indexOf("image") != -1):
						var _item = {
							"type": "image",
							"label": ("<label style='font-size:0.5em;'>Imagen en nodo " + key + "</label>"),
							"html": ("<img class='btnBigImage' src='" + value + "' style='cursor:pointer;width:100%;' data-label='" + key + "' alt='" + key + "'/>")
						};
						_ret.push(_item);
						break;
				}
			}
		});
		for (var i = 0; i < _ret.length; i++) {
			switch (_ret[i].type) {
				case "image":
					_html += _ret[i].label + "<br/>";
					_html += _ret[i].html + "<br/>";
					break;
			}
		}
		return _html;
	},
	onCopyToClipboard: function (_id) {
		var copyText = document.getElementById(_id);
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		navigator.clipboard.writeText(copyText.value);
	},
};
