$("body").off("click", ".btn-get-statics").on("click", ".btn-get-statics", function () {
	var _open = $(this).attr("data-open");
	var _report = $(this).attr("data-report");
	var _client = "";
	var _id_currency = $(this).attr("data-id_currency");
	var _currency = $(this).attr("data-currency");
	var _year_from = $("#browser_year_from").val();
	var _year_to = $("#browser_year_to").val();
	var _id_application = $("#browser_id_app").val();
	if (_year_from == "") { alert("Seleccione año desde"); return false; }
	if (_year_to == "") { alert("Seleccione año hasta"); return false; }
	if (_id_application != "") { _client = $("#browser_id_app option:selected").text(); }
	google.charts.load('current', { 'packages': ['corechart'] });
	google.charts.setOnLoadCallback(function () {
		var _json = {
			"open": _open,
			"year_from": _year_from,
			"year_to": _year_to,
			"report": _report,
			"id_type_currency": _id_currency,
			"id_application": _id_application
		};
		var _todo = "CERRADO";
		if (_open == "S") { _todo = "TODO";}
		_AJAX.UiGetStatics(_json).then(function (data) {
			drawChartFacturacion(data, _currency, _client, _todo);
			drawTotalesFacturacion(data, _currency, _client, _todo);
		});
	});
});

function drawChartFacturacion(data, _currency, _client, _todo) {
	var _dataTable = new google.visualization.DataTable();
	_dataTable.addColumn('date', 'Fecha');
	_dataTable.addColumn('number','Consolidado');
	_dataTable.addColumn('number', 'Facturado');
	if (_currency == "ARS") {
		_dataTable.addColumn('number', 'Estimado');
		_dataTable.addColumn('number', 'IVA');
		_dataTable.addColumn('number', 'Gastos');
		_dataTable.addColumn('number', 'Inflación Ba');
		_dataTable.addColumn('number', 'Inflación Pr');
	}
	_dataTable.addColumn({ role: 'annotation', type: 'string' });

	var _dataTable2 = new google.visualization.DataTable();
	_dataTable2.addColumn('date', { role: 'annotation', type: 'string' },  'Fecha');
	_dataTable2.addColumn('number', 'Pesos en dólares');
	_dataTable2.addColumn('number', 'Dólares');
	_dataTable2.addColumn('number', 'Consolidado en dólares');
	_dataTable2.addColumn({ role: 'annotation', type: 'string' });

	var _dataTable3 = new google.visualization.DataTable();
	_dataTable3.addColumn('date', 'Fecha');
	_dataTable3.addColumn('number', 'Dólares / hora');
	_dataTable3.addColumn({ role: 'annotation', type: 'string' });

	var _vert = null;
	var _dataRows = [];
	var _dataRows2 = [];
	var _dataRows3 = [];
	var d = new Date();
	var _actualYYYMM = (String(d.getFullYear()) + '-' + String(d.getMonth()));
	var _last_amount_pesos = 0;
	var _last_porc_adjust = 0;
	var _preserved_last_porc_adjust = 0;
	var _bEstimado = false;
	$.each(data.data, function (i, item) {
		var _year_month = (String(item.move_year) + "-" + String(item.move_month));
		var _gastos = 0;
		var _adjust = 0;
		var _adjust2 = 0;
		var _estimado = 0;
		$.each(data.data2, function (b, rec) {
			var _year_month2 = (String(rec.move_year) + "-" + String(rec.move_month));
			if (_year_month == _year_month2) { _gastos = rec.amount; }
		});

		$.each(data.adjusts, function (b, rec) {
			var _year_month2 = (String(rec.adjust_year + 1) + "-" + String(rec.adjust_month));
			var _ndx = (i - 1);
			var _ndx2 = (i - 12);
			if (_year_month == _year_month2 && (_ndx >= 0)) {
				_last_porc_adjust = (parseFloat(rec.amount) / 100);
				_adjust = (data.data[_ndx].amount + (data.data[_ndx].amount * (rec.amount / 100)));
			}
			if (_year_month == _year_month2 && (_ndx2 >= 0)) {
				_adjust2 = (data.data[_ndx2].amount + (data.data[_ndx2].amount * (rec.amount / 100)));
			}
		});

		if (_todo == 'TODO' && _actualYYYMM == _year_month) {
			_vert = 'Desde aquí, estimado';
			_bEstimado = true;
			_preserved_last_porc_adjust = _last_porc_adjust;
		} else {
			_vert = null;
		}
		if (_bEstimado) {
			_estimado = _last_amount_pesos + (_last_amount_pesos * _preserved_last_porc_adjust);
			_last_amount_pesos = (_estimado * (1 - (_preserved_last_porc_adjust/1.25)));
		} else {
			_estimado = 0;
			_last_amount_pesos = item.amount_pesos;
		}
		if (_currency == "ARS") {
			_dataRows.push([new Date(item.move_year, item.move_month, 1), item.amount_pesos, item.amount_solo_pesos, _estimado, item.iva, _gastos, _adjust, _adjust2, _vert]);
		} else {
			_dataRows.push([new Date(item.move_year, item.move_month, 1), item.amount_dolar, item.amount_solo_dolar, _vert]);
		}
	});
	_dataTable.addRows(_dataRows);

	$.each(data.consolidado, function (i, item) {
		var _year_month = (String(item.move_year) + "-" + String(item.move_month));
		if (_todo =='TODO' && _actualYYYMM == _year_month) { _vert = 'Desde aquí, estimado'; } else { _vert = null; }
		_dataRows2.push([new Date(item.move_year, item.move_month, 1), item.amount_pesos_dolar, item.amount_solo_dolar, item.amount_dolar, _vert]);
	});
	_dataTable2.addRows(_dataRows2);

	$.each(data.consolidado, function (i, item) {
		var _year_month = (String(item.move_year) + "-" + String(item.move_month));
		if (_todo == 'TODO' && _actualYYYMM == _year_month) { _vert = 'Desde aquí, estimado'; } else { _vert = null; }
		_dataRows3.push([new Date(item.move_year, item.move_month, 1), (item.amount_dolar / item.hours), _vert]);
	});
	_dataTable3.addRows(_dataRows3);

	var chartOptions = {
		annotations: {
			alwaysOutside: true,
			textStyle: { color: 'grey', auraColor: 'yellow' },
			stem: { color: 'grey', length: -10 },
			style: 'line'
		},
		title: 'Facturación Neodata ' + _currency + " " + _client + ' - ' + _todo,
		curveType: 'function',
		pointSize: 10,
		pointShape: { type: 'square' },
		legend: { position: 'bottom' },
		crosshair: { trigger: 'both' },
		series: {
			0: { color: 'black', lineWidth: 2, pointSize: 5, pointShape: 'square', dataOpacity: 0.75 },
			1: { color: 'blue', lineWidth: 2, pointSize: 5, pointShape: 'square', dataOpacity: 0.75 },
			2: { color: 'green', lineWidth: 0.5, pointSize: 2, pointShape: 'circle', dataOpacity: 0.75, lineDashStyle: [2, 2] },
			3: { color: 'red', lineWidth: 1, pointSize: 4, pointShape: 'square', dataOpacity: 0.75 },
			4: { color: 'gold', lineWidth: 1, pointSize: 4, pointShape: 'square', dataOpacity: 0.75 },
			5: { color: 'magenta', lineWidth: 0.5, pointSize: 4, pointShape: 'circle', dataOpacity: 0.5, lineDashStyle: [2, 2] },
			6: { color: 'cyan', lineWidth: 0.5, pointSize: 6, pointShape: 'triangle', dataOpacity: 0.5, lineDashStyle: [2, 2] },
		},
		trendlines: {
			0: {
				opacity: 0.2,
				type: 'polynomial',
				lineWidth: 1,
				pointSize: 1,
				color: 'grey'
			},
			1: {
				opacity: 0.2,
				type: 'polynomial',
				lineWidth: 1,
				pointSize: 1,
				color: 'blue'
			},
			2: {
				opacity: 0.2,
				type: 'polynomial',
				lineWidth: 1,
				pointSize: 1,
				color: 'pink'
			},
			3: {
				opacity: 0.2,
				type: 'polynomial',
				lineWidth: 1,
				pointSize: 1,
				color: 'yellow'
			},
		}
	};

	var chartOptions2 = {
		annotations: {
			alwaysOutside: true,
			textStyle: { color:'grey', auraColor:'yellow'},
			stem: { color: 'grey', length: -10 },
			style: 'line'
		},
		title: 'Neodata Consolidado en dólares, por moneda facturada ' + _client + ' - ' + _todo,
		curveType: 'function',
		pointSize: 10,
		pointShape: { type: 'square' },
		legend: { position: 'bottom' },
		crosshair: { trigger: 'both' },
		series: {
			0: { color: 'navy', lineWidth: 1, pointSize: 4, pointShape: 'square', dataOpacity: 0.5},
			1: { color: 'darkgreen', lineWidth: 1, pointSize: 4, pointShape: 'square', dataOpacity: 0.5 },
			2: { color: 'black', lineWidth: 2, pointSize: 5, pointShape: 'square', dataOpacity: 0.75 },
		},
		trendlines: {
			0: {
				opacity: 0.1,
				type: 'polynomial',
				lineWidth: 1,
				pointSize: 1,
				color: 'blue'
			},
			1: {
				opacity: 0.1,
				type: 'polynomial',
				lineWidth: 1,
				pointSize: 1,
				color: 'green'
			},
			2: {
				opacity: 0.4,
				type: 'polynomial',
				lineWidth: 1,
				pointSize: 1,
				color: 'grey'
			},
		}
	};
	var chartOptions3 = {
		annotations: {
			alwaysOutside: true,
			textStyle: { color: 'grey', auraColor: 'yellow' },
			stem: { color: 'grey', length: -10 },
			style: 'line'
		},
		title: 'Neodata renta por hora estimada en dólares ' + _client + ' - ' + _todo,
		curveType: 'function',
		pointSize: 10,
		pointShape: { type: 'square' },
		legend: { position: 'bottom' },
		crosshair: { trigger: 'both' },
		series: {
			0: { color: 'darkred', opacity: 0.25,lineWidth: 1, pointSize: 1, pointShape: 'square', dataOpacity: 0.5 },
		},
		trendlines: {
			0: {
				opacity: 1,
				type: 'polynomial',
				lineWidth: 2,
				pointSize: 4,
				color: 'red'
			},
		}
	};
	var chart = new google.visualization.LineChart(document.getElementById('chart'));
	var chart2 = new google.visualization.LineChart(document.getElementById('chart2'));
	var chart3 = new google.visualization.LineChart(document.getElementById('chart3'));

	chart.draw(_dataTable, chartOptions);
	chart2.draw(_dataTable2, chartOptions2);
	chart3.draw(_dataTable3, chartOptions3);
}

function drawTotalesFacturacion(data, _currency, _client, _todo) {
	var _last_year = 0;
	var _html = "";
	var _iva = 0;
	var _gastos = 0;
	var _solo_pesos = 0;
	var _solo_dolar = 0;
	var _consolidado_pesos = 0;
	var _consolidado_dolares = 0;
	var _parcial_gastos = 0;

	$.each(data.data, function (i, item) {
		var _year_month = (String(item.move_year) + "-" + String(item.move_month));
		if (_last_year != item.move_year) {
			if (_last_year != 0) {
				_html += drawTotalYear(_last_year, _iva, _gastos, _solo_pesos, _solo_dolar, _consolidado_pesos, _consolidado_dolares, _todo);
				_iva = 0;
				_gastos = 0;
				_solo_pesos = 0;
				_solo_dolar = 0;
				_consolidado_pesos = 0;
				_consolidado_dolares = 0;
			}
			_last_year = item.move_year;
		}
		_parcial_gastos = 0;
		$.each(data.data2, function (b, rec) {
			var _year_month2 = (String(rec.move_year) + "-" + String(rec.move_month));
			if (_year_month == _year_month2) { _parcial_gastos += rec.amount; }
		});
		if (!isNaN(item.iva)) { _iva += item.iva; }
		if (!isNaN(_parcial_gastos)) { _gastos += _parcial_gastos; }
		if (!isNaN(item.amount_solo_pesos)) { _solo_pesos += item.amount_solo_pesos; }
		if (!isNaN(item.amount_solo_dolar)) { _solo_dolar += item.amount_solo_dolar; }
		if (!isNaN(item.amount_pesos)) { _consolidado_pesos += item.amount_pesos; }
		if (!isNaN(item.amount_dolar)) { _consolidado_dolares += item.amount_dolar; }
	});
	if (_last_year != 0) { _html += drawTotalYear(_last_year, _iva, _gastos, _solo_pesos, _solo_dolar, _consolidado_pesos, _consolidado_dolares, _todo); }
	$("#totales").html(_html);
}

function drawTotalYear(_last_year, _iva, _gastos, _solo_pesos, _solo_dolar, _consolidado_pesos, _consolidado_dolares, _todo) {
	var _estimado = " - Cerrado";
	var d = new Date();
	var _actualYYY = String(d.getFullYear());
	if (_actualYYY == _last_year) {
		_estimado = " - Parcial según cierres a fecha  ";
		if (_todo == "TODO") { _estimado = " - Parcialmente estimado ";}
	}
	var _html = "<div class='col-12 card shadow m-2 p-2'>";
	_html += "   <h2>" + _last_year + _estimado + "</h2>";
	_html += "      <table cellpadding='4' style='width:100%;'>";
	_html += "         <tr>";
	_html += "            <td align='right' width='15%'><b>IVA</b></td>";
	_html += "            <td align='right' width='15%'><b>Gastos</b></td>";
	_html += "            <td align='center' width='35%'><b>Facturado</b></td>";
	_html += "            <td align='center' width='35%'><b>Consolidado</b></td>";
	_html += "         </tr>";
	_html += "         <tr>";
	_html += "            <td align='right' width='15%'>" + _TOOLS.toMoney(_iva, undefined, 'currency', 'ARS') + "</td>";
	_html += "            <td align='right' width='15%'>" + _TOOLS.toMoney(_gastos, undefined, 'currency', 'ARS') + "</td>";
	_html += "            <td align='center' width='35%' style='border:solid 1px grey;'>";
	_html += "			     <table cellpadding='2' style='width:100%;'>";
	_html += "                  <tr>";
	_html += "                     <td align='right' style='color:blue;' width='50%'>" + _TOOLS.toMoney(_solo_pesos, undefined, 'currency', 'ARS') + "</td>";
	_html += "                     <td align='right' style='color:darkgreen;' width='50%'>" + _TOOLS.toMoney(_solo_dolar, undefined, 'currency', 'USD')  + " USD</td>";
	_html += "                  </tr>";
	_html += "               </table>";
	_html += "            </td>";
	_html += "            <td align='center' width='35%' style='border:solid 1px grey;'>";
	_html += "			     <table cellpadding='2' style='width:100%;'>";
	_html += "                  <tr>";
	_html += "                     <td align='right' style='color:blue;' width='50%'>" + _TOOLS.toMoney(_consolidado_pesos, undefined, 'currency', 'ARS') + "</td>";
	_html += "                     <td align='right' style='color:darkgreen;' width='50%'>" + _TOOLS.toMoney(_consolidado_dolares, undefined, 'currency', 'USD') + " USD</td>";
	_html += "                  </tr>";
	_html += "               </table>";
	_html += "            </td>";
	_html += "         </tr>";
	_html += "      </table>";
	_html += "</div>";
	return _html;
}
