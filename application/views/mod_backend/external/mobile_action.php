<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
?>
<table class="table table-sm">
    <tr>
        <td><?php echo lang('p_request');?>:</td>
        <td style="font-weight:bold;">
            <?php echo $function;?>
        </td>
    </tr>
    <tr>
        <td><?php echo lang('p_client');?>:</td>
        <td style="font-weight:bold;">
            <?php echo $es_cliente;?>
        </td>
    </tr>
    <tr>
        <td><?php echo lang('p_viable');?>:</td>
        <td style="font-weight:bold;">
            <?php echo $viable;?>
        </td>
    </tr>
    <tr>
        <td><?php echo lang('p_name');?>:</td>
        <td style="font-weight:bold;">
            <?php echo $documentName;?>
        </td>
    </tr>
    <tr>
        <td><?php echo lang('p_sex');?>:</td>
        <td style="font-weight:bold;">
            <?php echo $documentSex;?>
        </td>
    </tr>
    <tr>
        <td><?php echo lang('p_number_doc');?>:</td>
        <td style="font-weight:bold;">
            <?php echo $documentNumber;?>
        </td>
    </tr>
    <tr>
        <td><?php echo lang('p_phone');?>:</td>
        <td style="font-weight:bold;">
            <?php echo "<a href='#' class='btn btn-info btn-raised phone phone-cell btn-md' style='margin:0px;padding:2px;'>".$documentArea." ".$documentPhone."</a>";?>
        </td>
    </tr>
</table>
