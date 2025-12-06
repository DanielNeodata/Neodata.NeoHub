var _openClearing = null;
var _vTransfers = {};
var _vFinal = {};
var _vRecibe = {};
var _vEnvia = {};

setTimeout(function () {
	var d = new Date();
	var year = d.getFullYear();
	var month = (d.getMonth() + 1);
	$(".browser_year").val(year);
	$(".browser_month").val(month);
	$(".browser_id_type_currency").val(1);
},50);


function resetForm() {
	$(".btn-close-clearing").addClass("d-none");
	$(".alert-clearing").addClass("d-none")
	$(".resultados").html("");
	$(".firmas").html("");
}
$("body").off("change", ".browser_month").on("change", ".browser_month", function () {
	resetForm();
});
$("body").off("change", ".browser_year").on("change", ".browser_year", function () {
	resetForm();
});
$("body").off("click", ".btn-close-clearing").on("click", ".btn-close-clearing", function () {
	if (!confirm("¿Realmente quiere cerrar la liquidación?")) { return false;}
	var _month = $("#browser_month").val();
	var _year = $("#browser_year").val();
	var _id_currency = $("#browser_id_type_currency").val();
	if (_month == "") { alert("Seleccione mes"); return false; }
	if (_year == "") { alert("Seleccione año"); return false; }
	if (_id_currency == "") { alert("Seleccione moneda"); return false; }
	var _json = { "clearing_year": _year, "clearing_month": _month, "id_type_currency": _id_currency, "static": _openClearing };
	_FUNCTIONS.onSignature(".btn-close-clearing", _json, "LIQUIDACION", (_year + _month), "");
	_AJAX.UiCloseClearing(_json).then(function (data) {
		if (data.status == "OK") {$(".btn-get-clearing").click();}
	});
});
$("body").off("click", ".btn-sign-clearing").on("click", ".btn-sign-clearing", function () {
	var _month = $("#browser_month").val();
	var _year = $("#browser_year").val();
	var _id_currency = $("#browser_id_type_currency").val();
	if (_month == "") { alert("Seleccione mes"); return false; }
	if (_year == "") { alert("Seleccione año"); return false; }
	if (_id_currency == "") { alert("Seleccione moneda"); return false; }
	var _json = { "clearing_year": _year, "clearing_month": _month, "id_type_currency": _id_currency };
	_AJAX.UiSignClearing(_json).then(function (data) {
		if (data.status == "OK") { $(".btn-get-clearing").click(); }
	});
});
$("body").off("click", ".btn-get-clearing").on("click", ".btn-get-clearing", function () {
	$(".firmas").html("");
	var _month = $("#browser_month").val();
	var _year = $("#browser_year").val();
	var _id_currency = $("#browser_id_type_currency").val();
	if (_month == "") { alert("Seleccione mes"); return false; }
	if (_year == "") { alert("Seleccione año"); return false; }
	if (_id_currency == "") { alert("Seleccione moneda"); return false; }
	var _json = { "year": _year, "month": _month, "id_type_currency": _id_currency };
	_AJAX.UiGetClearing(_json).then(function (data) {
		if (data.status == "OK") {
			var _images = data.images["data"];
			var _grand_amount = parseFloat(data.grandAmount);
			_vTransfers = {};
			_vFinal = {};
			_vRecibe = {};
			_vEnvia = {};

			if (data.clearing.totalrecords == 0) {
				$(".btn-close-clearing").removeClass("d-none");
				$(".alert-clearing").addClass("d-none")
			} else {
				$(".alert-clearing").removeClass("d-none")
				$(".btn-close-clearing").addClass("d-none");
			}

			var _status = "<span class='material-icons' style='color:darkred;font-size:13px;'>lock</span>";
			var _html = "";
			if (data.open == 1) {
				_html += "<div class='row'>";
				_html += "      <table style='width:100%;font-size:12px;' align='center'>";
				_html += "			<tr style='background-color:grey;font-weight:bold;color:white;'>";
				_html += "				<td align='right'></td>";
				_html += "				<td align='center'>Fecha</td>";
				_html += "				<td>Emitida por</td>";
				_html += "				<td>Descontar a</td>";
				_html += "				<td>Cliente</td>";
				_html += "				<td>Tipo</td>";
				_html += "				<td>Contrato</td>";
				_html += "				<td align='right'>Importe</td>";
				//_html += "				<td align='right'>IVA</td>";
				//_html += "				<td align='right'>Total</td>";
				_html += "          </tr>";
				$.each(data.data["data"], function (i, item) {
					$color = "white";
					if ((i % 2) != 0) { $color = "silver";}
					_html += "<tr style='background-color:" + $color + ";'>";
					_html += "   <td align='center'>" + _status + "</td>";
					_html += "   <td align='center'>" + item.fecha + "</td>";
					_html += "   <td>" + item.user_invoice_description + "</td>";
					if (item.user_discount_description == null) { item.user_discount_description = "--"; }
					_html += "   <td>" + item.user_discount_description + "</td>";
					_html += "   <td>" + item.application_description + "</td>";
					if (item.details == null) { item.details = "--"; }
					if (item.invoice_description == null) { item.invoice_description = item.details; }
					_html += "   <td>" + item.invoice_description + "</td>";
					_html += "   <td>" + item.month_to_end + "</td>";
					_html += "   <td align='right'>" + _TOOLS.toMoney(item.amount, undefined, 'currency', 'ARS') + "</td>";
					_html += "</tr>";
				});
				_html += "      </table>";
				_html += "</div>";
			} else {
				_AJAX.UiGetClearingSigns(_json).then(function (dataSign) {
					var _sign = ("<span class='alert alter-warning'>No firmaste esta liquidación <button class='btn btn-sm btn-raised btn-dark btn-sign-clearing'>Firmar</button></span>");;
					if (dataSign.status == "OK") {
						$.each(dataSign.data, function (i, item) {
							if (parseInt(item.id_user) == parseInt(_AJAX._id_user_active)) {
								_sign = ("<span class='alert alter-success'>Ya firmaste esta liquidación: " + item.created + "</span>");
								setTimeout(function () {
									$(".td-signed-" + item.id_user).removeClass("d-none");
									$(".card-" + item.id_user).css({ "border": "solid 2px green" });
								}, 2000);
							} else {
								setTimeout(function () {
									$(".td-signed-" + item.id_user).removeClass("d-none").css({ "color": "lightgreen" });
									$(".card-" + item.id_user).css({ "border": "solid 2px lightgreen" });
								}, 2000);
							}
						});
						$(".firmas").html(_sign);
					}
				});
			}

			_html += "<div class='row'>";

			//rebuild static data for closed clearing!
			if (data.open == 0) { data = JSON.parse(data.clearing.data[0].static); }

			$.each(data.amounts, function (i, item) {
				var _corresponde = (_grand_amount * (item.sharing / 100));
				var _diff = (item.amount - _corresponde);
				var _excedente = 0;
				var _faltante = 0;
				if (_diff > 0) { _excedente = _diff; }
				if (_diff < 0) { _faltante = _diff; }
				_vTransfers[item.id] = [];
				_vRecibe[item.id] = [];
				_vEnvia[item.id] = [];
				var _cardStyle = "style='border:solid 1px pink;'";
				if (item.id == _AJAX._id_user_active) {_cardStyle = "style='border:solid 1px red;'";}

				_html += "   <div class='col-xs-12 col-sm-12 col-md-3 card shadow m-1 card-" + item.id + "' " + _cardStyle + ">";
				_html += "      <div class='card-body'>";
				$.each(_images, function (x, img) {
					if (img.id == item.id) {
						_html += "<table cellpadding='2'>";
						_html += "   <tr>";
						_html += "      <td><img style='width:64px;' class='rounded-circle' src='" + img.image + "'/></td>";
						_html += "      <td><b>" + item.person + "</b></td>";
						_html += "      <td class='d-none td-signed-" + item.id + "'><span class='material-icons td-signed-" + item.id + "' style='color:green;'>done</span></td>";
						_html += "   </tr>";
						_html += "</table>";
						//_html += "<img class='card-img-top' src='" + img.image + "'/>";
					}
				});
				//_html += "         <h5 class='card-title'><img class='card-img-top' src='" + img.image + "'/> " + item.person + "</h5>";
				_html += "         <table style='width:90%;' align='center'>";
				_html += "            <tr><td>Share</td><td><span class='float-right badge badge-dark' style='font-size:0.8rem;'>" + item.sharing + "%</span></td></tr>";
				_html += "            <tr><td>Facturado</td><td><span class='float-right badge badge-secondary' style='font-size:0.8rem;'>" + _TOOLS.toMoney(item.amount, undefined, 'currency', 'ARS') + "</span></td></tr>";
				_html += "            <tr><td>IVA</td><td><span class='float-right badge badge-light' style='font-size:0.8rem;'>" + _TOOLS.toMoney(item.iva, undefined, 'currency', 'ARS') + "</span></td></tr>";
				_html += "            <tr><td>Total</td><td><span class='float-right badge badge-light' style='font-size:0.8rem;'>" + _TOOLS.toMoney(item.total, undefined, 'currency', 'ARS') + "</span></td></tr>";
				_html += "            <tr><td colspan='2'><hr style='border-bottom:solid 1px silver;'/></td></tr>";
				_html += "            <tr><td>Corresponde</td><td><span class='float-right badge badge-primary' style='font-size:0.8rem;'>" + _TOOLS.toMoney(_corresponde, undefined, 'currency', 'ARS') + "</span></td></tr>";
				_html += "            <tr><td>Excedente</td><td><span class='float-right badge badge-info' style='font-size:0.8rem;'>" + _TOOLS.toMoney(_excedente, undefined, 'currency', 'ARS') + "</span></td></tr>";
				_html += "            <tr><td>Faltante</td><td><span class='float-right badge badge-warning' style='font-size:0.8rem;'>" + _TOOLS.toMoney(_faltante, undefined, 'currency', 'ARS') + "</span></td></tr>";
				_html += "            <tr><td colspan='2'><hr style='border-bottom:solid 1px silver;'/></td></tr>";
				$.each(data.amounts, function (ia, rec) {
					if (rec.id != item.id) {
						var _recibe = (_diff * (rec.sharing / 100));
						var _text = "Recibe de ";
						var _color = "badge badge-success";
						if (_recibe > 0) {
							_text = "Envía a ";
							_color = "badge badge-danger";
							_vEnvia[item.id].push({ "origen": item.id, "envia": item.person, "destino": rec.id, "recibe": rec.person, "amount": Math.abs(_recibe) });
						} else {
							_vRecibe[item.id].push({ "origen": rec.id, "envia": rec.person, "destino": item.id, "recibe": item.person, "amount": Math.abs(_recibe) });
						}
						_html += "<tr class='d-none'><td>" + _text + rec.person + "</td><td><span class='float-right " + _color + "' style='font-size:0.8rem;'>" + _TOOLS.toMoney(Math.abs(_recibe), undefined, 'currency', 'ARS') + "</span></td></tr>";

					}
				});

				_html += "		   </table>";

				_html += "         <div class='dyn-" + item.id + "'></div>";
				_html += "      </div>";
				_html += "   </div>";
			});

			_html += "</div>";

			$.each(data.amounts, function (i, item) {
				data.amounts[i]["recibe"] = [];
				$.each(_vRecibe[item.id], function (ia, rec) {
					data.amounts[i]["recibe"].push(rec);
				});
				$.each(_vEnvia, function (ia, rec) {
					$.each(rec, function (ix, obj) {
						if (obj.destino == item.id) { data.amounts[i]["recibe"].push(obj); }
					});
				});
			});

			$.each(data.amounts, function (i, item) {
				$.each(item.recibe, function (ix, obj) {
					_vTransfers[item.id][obj.origen]={ "amount": 0, "envia": obj.envia, "id_origen": obj.origen };
				});
			});
			$.each(data.amounts, function (i, item) {
				$.each(item.recibe, function (ix, obj) {
					_vTransfers[item.id][obj.origen].amount += obj.amount;
				});
			});

			$.each(data.discounts, function (i, item) {
				if (parseFloat(item.amount) > 0) {
					if (_vTransfers[item.id_discount][item.id] == undefined) {
						_vTransfers[item.id_discount][item.id] = { "amount": 0, "envia": item.person, "id_origen": item.id_discount };
					}
					_vTransfers[item.id_discount][item.id].amount += parseFloat(Math.abs(item.amount));
				} else {
					if (_vTransfers[item.id][item.id_discount] == undefined) {
						_vTransfers[item.id][item.id_discount] = { "amount": 0, "envia": item.person, "id_origen": item.id_discount };
					}
					_vTransfers[item.id][item.id_discount].amount += parseFloat(Math.abs(item.amount));
				}
			});

			_vFinal = [];
			var _final = 0;
			$.each(data.amounts, function (i, item) {
				$.each(data.amounts, function (ia, itema) {
					_final = 0;
					if (item.id != itema.id) {
						if (_vTransfers[item.id][itema.id] == undefined) {
							_vTransfers[item.id][itema.id] = { "amount": 0 };
						}
						_final += parseFloat(_vTransfers[item.id][itema.id].amount);
						if (_vTransfers[itema.id][item.id] == undefined) {
							_vTransfers[itema.id][item.id] = { "amount": 0 };

						}
						_final -= parseFloat(_vTransfers[itema.id][item.id].amount);
						if (_final > 0) {
							_vFinal.push({ "amount": _final, "id": item.id, "id_contra": itema.id, "envia": itema.person });
						}

					}
				});
			});

			$(".resultados").html(_html);
			$.each(data.amounts, function (i, item) {
				_html = "<h5>Movimientos detallados</h5>";
				_html += "<table style='width:90%;' align='center'>";
				$.each(data.amounts, function (a, rec) {
					if (_vTransfers[item.id][rec.id] != undefined && parseFloat(_vTransfers[item.id][rec.id].amount)!=0) {
						_html += "<tr><td>Recibe de " + _vTransfers[item.id][rec.id].envia + "</td><td><span class='float-right badge badge-light' style='font-size:0.8rem;'>" + _TOOLS.toMoney(_vTransfers[item.id][rec.id].amount, undefined, 'currency', 'ARS') + "</span></td></tr>";
					}
				});
				_html += "</table>";
				_html += "<hr/>";
				var _dirty = false;
				$.each(_vFinal, function (a, rec) {
					if (item.id == rec.id) {
						if (!_dirty) { _html += "<h4>Transferencias consolidadas</h4>"; _dirty = true;}
						_html += "<table style='width:90%;' align='center'>";
						_html += "<tr><td>Recibe de " + rec.envia + "</td><td><span class='float-right badge badge-success' style='font-size:0.8rem;'>" + _TOOLS.toMoney(rec.amount, undefined, 'currency', 'ARS') + "</span></td></tr>";
						_html += "</table>";
					}
				});
				$(".dyn-" + item.id).html(_html);
			});
			_openClearing = data;

			console.log(_vTransfers);
			console.log(_vFinal);
		} else {
			throw data;
		}
	});
});

