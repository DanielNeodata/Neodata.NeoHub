<?php
defined("BASEPATH") OR exit("No direct script access allowed");
?>
<div class="container-full">
    <h3><?php echo $title;?></h3>
    <div class="container-full">
		<div class="row no-gutters shadow align-items-end">
			<div class="col-12 p-2">
				<label class="p-0 m-0">URL</label>
				<input id="url" name="url" type="text" class="form-control url qrdata validate" value="<?php echo $profile["data"][0]["default_url"];?>"/>
			</div>
			<div class="col-4 p-2">
				<label class="p-0 m-0">Parámetro</label>
				<input id="parametro" name="parametro" type="text" class="form-control parametro qrdata" value="<?php echo $profile["data"][0]["default_parameter"];?>"/>
			</div>
			<div class="col-4 p-2">
				<label class="p-0 m-0">Código</label>
				<input id="codigo" name="codigo" type="text" class="form-control codigo qrdata" value="<?php echo $profile["data"][0]["default_code"];?>"/>
			</div>

			<div class="col-4 p-2">
				<a href="#" class="btn btn-raised btn-primary btn-sm btn-api_qr" type="button"><i class="material-icons">bolt</i> Generar QR</a>
			</div>
		</div>
	</div>
    <div class="resultados mt-4"></div>
</div>
<script>
    $.getScript("./application/views/mod_api/neo_tools/formQR.js", function() { });
</script>
