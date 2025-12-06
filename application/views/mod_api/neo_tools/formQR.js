$("body").off("click", ".btn-api_qr").on("click", ".btn-api_qr", function () {
	if (_TOOLS.validate(".validate", true)) {
		var _data = _TOOLS.getFormValues(".qrdata", null)
		var _url = _data.url;
		if (_data.parametro != "") {
			_url += "?" + _data.parametro;
			if (_data.codigo != "") {
				_url += "=" + _data.codigo;
			}
		}
		var _params = {"url": _url};
		_NEOTOOLS.onCreateQR(_params).then(function (data) {
			var _urlImagen = (_NEOTOOLS._SERVER + data.url);
			var _html = "<div class='row no-gutters align-items-top'>";
			_html += "      <div class='col-12'>";
			_html += "         <table class='table table-condensed table-stripped'>";
			_html += "            <tr class='table-secondary'><td colspan='4'><b>Datos del código QR generado</b></td></tr>";
			_html += "            <tr class='table-success'>";
			_html += "               <td>QR:</td>";
			_html += "               <td><a href='" + _urlImagen + "' target='_blank'>" + _urlImagen + "</a></td>";
			_html += "               <td><img src='" + _urlImagen + "'/></td>";
			_html += "               <td><a ref='#' class='btn-clipboard' data-id='url_imagen' style='cursor:pointer;'><i class='material-icons'>file_copy</i></a></td>";
			_html += "            </tr>";
			_html += "            <tr class='table-info'>";
			_html += "               <td>Enlace codificado:</td>";
			_html += "               <td colspan='2'>" + _params.url + "</td>";
			_html += "               <td><a ref='#' class='btn-clipboard' data-id='url_enlace' style='cursor:pointer;'><i class='material-icons'>file_copy</i></a></td>";
			_html += "            </tr>";
			_html += "         </table>";
			_html += "         <input type='text' style='display:none;' id='url_imagen' name='url_imagen' value='" + _urlImagen + "'/>";
			_html += "         <input type='text' style='display:none;' id='url_enlace' name='url_enlace' value='" + _params.url + "'/>";
			_html += "      </div>";
			_html += "   </div>";
			$(".resultados").html(_html);
		}).finally(function () { });
	}
});
