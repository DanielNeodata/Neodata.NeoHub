    <?php
       $html="<div class='container-fluid area-legales' style='margin-top:15px;'>";
       $html.="<div class='row'>";
       $html.="   <div class='col-6 text-right'>";
       $html.="      <a class='btn btn-info btn-raised' href='https://www.neodata.ar/wp-content/uploads/2025/04/Neodata-Legales.pdf' target='_blank'>Términos y condiciones de uso</a>";
       $html.="   </div>";
       $html.="   <div class='col-6 text-left style='font-size:0.8em;'>";
       $html.="      <a href='http://www.gruponeodata.com' target='_blank'>".TITLE_GENERAL." - www.gruponeodata.com</a>";
       $html.="   </div>";
       $html.="</div>";
       $html.="</div>";

       $html.="<div class='container-fluid area-legales' style='margin-top:15px;'>";
       if  (ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') {
           $html.="<div class='row'>";
           $html.=" <div class='col'>";
		   if($_SERVER['SERVER_NAME']=="trace.gruponeodata.com"){
              $html.=TITLE_GENERAL_TRACE;
		   } else {
              $html.="  <a href='http://www.gruponeodata.com' target='_blank'>".TITLE_GENERAL."</a>";
		   }
           $html.=" </div>";
           $html.="</div>";
           $html.="<div class='row'>";
           $html.=" <div class='col'>";
           $html.="  Ejecutando: <strong>".strtoupper(ENVIRONMENT)."</strong>";
           $html.=" </div>";
           $html.="</div>";
           $html.="<div class='row'>";
           $html.=" <div class='col'>";
           $html.="  <strong class='elapsed-time'>{elapsed_time}</strong> segundos. CI <strong>".CI_VERSION."</strong>";
           $html.=" </div>";
           $html.="</div>";
       }
       $html.="</div>";

       if  (ENVIRONMENT === 'development') {
           $html.=" <div id='codeigniter_profiler' style='clear:both;background-color:#fff;padding:10px;'>";
           $html.="  <fieldset style='border:1px solid navy;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;'>";
           $html.="   <legend style='color:navy;'>&nbsp;&nbsp;NEODATA CONTROLLER RESPONSE&nbsp;&nbsp;</legend>";
           $html.="   <table style='width:100%;' class='long-text'>";
           $html.="    <tbody>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>REQUEST RAW:</td>";
           $html.="        <td class='label-darkred reseteable raw-raw-request'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>RESPONSE RAW:</td>";
           $html.="        <td class='label-darkred reseteable raw-raw-response'>".json_encode($status, JSON_PRETTY_PRINT)."</td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>MESSAGE:</td>";
           $html.="        <td class='label-darkred reseteable raw-message'>".$status["code"].": ".lang("error_".$status["code"])."</td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>ID USER:</td>";
           $html.="        <td class='label-darkred raw-id_user_active'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>ID TYPE USER:</td>";
           $html.="        <td class='label-darkred raw-id_type_user_active'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>USERNAME:</td>";
           $html.="        <td class='label-darkred raw-username_active'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>A-TOKEN FROM:</td>";
           $html.="        <td class='label-darkred raw-a-token_created_datetime'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>A-TOKEN TO:</td>";
           $html.="        <td class='label-darkred raw-a-token_ttl_datetime'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>A-TOKEN KEY:</td>";
           $html.="        <td class='label-darkred raw-a-token_key'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>A-TOKEN STATUS:</td>";
           $html.="        <td class='label-darkred raw-a-token_status'></td>";
           $html.="     </tr>";
           $html.="        <td class='label-black' style='width:150px;'>T-TOKEN FROM:</td>";
           $html.="        <td class='label-darkred raw-t-token_created_datetime'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>T-TOKEN TO:</td>";
           $html.="        <td class='label-darkred raw-t-token_ttl_datetime'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>T-TOKEN KEY:</td>";
           $html.="        <td class='label-darkred raw-t-token_key'></td>";
           $html.="     </tr>";
           $html.="     <tr>";
           $html.="        <td class='label-black' style='width:150px;'>T-TOKEN STATUS:</td>";
           $html.="        <td class='label-darkred raw-t-token_status'></td>";
           $html.="     </tr>";
           $html.="    </tbody>";
           $html.="   </table>";
           $html.="  </fieldset>";
           $html.=" </div>";
       }
       echo $html;
?>

<script language="javascript">
    $.getScript("./assets/js/_INIT_EVENTS.js").done(function (script, textStatus) {});
</script>
