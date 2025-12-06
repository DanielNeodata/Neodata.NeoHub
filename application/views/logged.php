<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
?>
<div class="d-flex" id="wrapper" style="background-color:white;">
    <div class="bg-light shadow sidebar-wrapper" id="sidebar-wrapper">
        <div class="m-0" id="data-menu-close" style="width:100%;">
            <h5 class="p-1 sidebar-heading d-inline"><?php echo $title;?></h5> 
            <span class="btn-toggle-menu btn btn-menu-close btn-sm float-right pb-0 mb-0"><i class="material-icons">arrow_back_ios</i></span>
            <span class="mx-0 px-1 waiter wait-ajax"></span>
        </div>
        <div id="accordion" role="tablist" class="pt-0 mt-0 list-group side-menu">
            <?php   
            $html="";
            foreach ($menu as $item){
                $id=$item["id"];
                $ops=array("value"=>$item["running"],"dyncolor"=>true);
                $running=getProgressBar(null,$ops);
                $html.="<div class='p-0 m-0' role='tab' id='heading-".$id."' style='position:relative;'>";
                $html.="   <a class='list-group-item bg-secondary' data-toggle='collapse' href='#menu-".$id."' aria-expanded='true' aria-controls='menu-".$id."' style='color:whitesmoke;'>";
                $html.="      <table style='width:100%;'>";
                $html.="         <tr>";
                $html.="            <td valign='middle' style='width:30px;'><i class='material-icons'>".$item["icon"]."</i></td>";
                $html.="            <td valign='middle'>".ucfirst(lang($item["code"]))."</td>";
                $html.="         </tr>";
                $html.="         <tr>";
                $html.="            <td colspan='2' align='right' valign='middle'>".$running."</td>";
                $html.="         </tr>";
                $html.="      </table>";
                $html.="   </a>";
                if ($item["show_brief"]==1 && $item["brief"]!="") {$html.=getHelpButton($item,array("title"=>"code","body"=>"brief"));}
                $html.="</div>";
                $html.="<div id='menu-".$id."' class='collapse' role='tabpanel' aria-labelledby='heading-".$id."' data-parent='#accordion'>";
                foreach ($item["submenu"] as $subitem){
                    $ops=array("value"=>$subitem["running"],"dyncolor"=>true);
                    $running=getProgressBar(null,$ops);
                    $html.="  <div style='position:relative;'>";
                    $html.="    <a href='#' class='list-group-item bg-light btn-menu-click btn-".$subitem["code"]."' data-alert='".$subitem["alert_build"]."' data-module='".$subitem["data_module"]."' data-model='".$subitem["data_model"]."' data-table='".$subitem["data_table"]."' data-action='".$subitem["data_action"]."'>";
                    $html.="      <table style='width:100%;'>";
                    $html.="         <tr>";
                    $html.="            <td valign='middle' style='width:30px;'><i class='material-icons'>".$subitem["icon"]."</i></td>";
                    $html.="            <td valign='middle' class='label-menu'>".ucfirst(lang($subitem["code"]))."</td>";
                    $html.="         </tr>";
                    $html.="         <tr>";
                    if($subitem["alert_build"]==1) {
                        $html.="<td colspan='2'><span class='badge badge-danger'><i class='material-icons' style='font-size:14px;'>build</i> ".lang('msg_not_use')."</span></td>";
                    }else{
                        $html.="<td colspan='2' valign='middle'>".$running."</td>";
                    }
                    $html.="         </tr>";
                    $html.="      </table>";
                    $html.="    </a>";
                    if ($subitem["show_brief"]==1 && $subitem["brief"]!="") {$html.=getHelpButton($subitem,array("title"=>"code","body"=>"brief"));}
                    $html.="  </div>";
                }
                $html.="</div>";
            }
            echo $html;
            ?>
        </div>
    </div>

    <div id="page-content-wrapper">
        <div class="d-flex">
            <div class="col-4 m-0 p-0" style="min-height:40px;">
                <div class="info-heading d-none">
                    <span class="btn-toggle-menu btn btn-menu-open btn-sm pb-0 mb-0"><i class="material-icons">menu</i></span>
                    <h5 class="p-1 top-heading d-inline"><?php echo $title;?></h5> 
                    <span class="mx-0 px-1 waiter wait-ajax"></span>
                </div>
            </div>
            <div class="col-8 ml-auto m-auto p-auto">
                <div class="float-right status-ajax-calls d-none p-0 m-0">
                    <?php 
					    if((int)$_POST["id_type_user_active"]!=82){
						   echo "<a href='#' class='btn-activate-video-meeting btn btn-primary'><span class='material-icons'>video_call</span></a>";
						}
				    ?>
                    <a class="btn btn-xs btn-dark text-break mx-0 p-2 raw-messages_alert_NO d-none" title="<?php echo lang('msg_notreaded');?>"></a>
                    <img class="rounded-circle shadow img-master" src="./assets/img/user.jpg" style="height:40px;"/>
                    <span class="text-break font-weight-lighter badge badge-primary mx-0 px-2 raw-master_account d-none d-sm-inline"></span>
                    <img class="rounded-circle shadow img-user" src="./assets/img/user.jpg" style="height:40px;"/>
                    <span class="text-break font-weight-lighter badge badge-primary mx-0 px-2 raw-username_active d-none d-sm-inline"></span>
                    <a href="#" class="btn btn-raised btn-danger btn-sm btn-logout">Logout</a>
                    <?php 
                        if  (ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') {
                            echo "<br/>";
                            echo "<div class='float-right p-0 m-0'>";
                            echo "   <span class='text-monospace text-break font-weight-lighter badge badge-warning mx-0 px-1 editor-mode d-none' style='font-size:8px;' title='".lang("p_doc_editor")."'>E</span>";
                            echo "   <span class='text-monospace text-break font-weight-lighter badge badge-warning mx-0 px-1 reviser-mode d-none' style='font-size:8px;' title='".lang("p_doc_reviser")."'>R</span>";
                            echo "   <span class='text-monospace text-break font-weight-lighter badge badge-warning mx-0 px-1 publisher-mode d-node' style='font-size:8px;' title='".lang("p_doc_publisher")."'>P</span>";
                            echo "   <span class='text-monospace text-break font-weight-lighter badge badge-light mx-0 px-1 elapsed-time d-none d-sm-inline' style='font-size:8px;'></span>";
                            echo "   <span class='text-monospace text-break font-weight-lighter badge badge-info mx-0 px-1 execution-mode d-sm-inline' style='font-size:8px;'>".strtoupper(ENVIRONMENT)."</span>";
                            echo "   <span class='text-monospace text-break font-weight-lighter badge badge-success mx-0 px-1 status-last-call d-none d-sm-inline' style='font-size:8px;'></span>";
                            echo "   <span class='text-monospace text-break font-weight-lighter badge badge-danger mx-0 px-1 status-message d-none' style='font-size:8px;'></span>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="container-fluid dyn-area browser"></div>
        <div class="container-fluid dyn-area abm d-none"></div>
		<div class="dyn-video video d-none" style="position:absolute;right:15px;top:50px;z-index:9999999;width:602px;height:655px;background-color:white;border:solid 1px black;">
			<h4 class="p-0 m-0 title-connected pl-1 active-video d-none"></h4>
		    <div id="meet" class="p-0 d-none active-video" style="position:relative;width:600px;height:600px;left:0px;top:0px;"></div>
			<h5 class="title-rol p-0 m-0 pl-1 active-video d-none"></h5>
		</div>
        <div class="alert-frame" style="position:fixed;bottom:0;"></div>
    </div>
</div>
<script type="module">
import interact from 'https://cdn.interactjs.io/v1.10.11/interactjs/index.js'
interact('.dyn-video').draggable({
    inertia: true,
    modifiers: [interact.modifiers.restrictRect({restriction: 'parent',endOnly: true})],
    autoScroll: true,
    listeners: {
      move: dragMoveListener,
      end (event) {
        var textEl = event.target.querySelector('p')
        textEl && (textEl.textContent = 'moved a distance of ' + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) + Math.pow(event.pageY - event.y0, 2) | 0)).toFixed(2) + 'px')
      }
    }
  })

function dragMoveListener (event) {
  var target = event.target
  var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
  var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy
  target.style.transform = 'translate(' + x + 'px, ' + y + 'px)'
  target.setAttribute('data-x', x)
  target.setAttribute('data-y', y)
}
</script>
