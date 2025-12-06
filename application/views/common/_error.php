<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="<?php echo $language;?>">
<?php echo $header;?>
<body>
    <?php
       $html="<h1>".lang("error_1000")."</h1>";
       $html.="<div class='alert alert-danger' role='alert'>";
       $html.="  <strong>".$code."</strong> ";
       $html.="  <i>".$message."</i> ";
       $html.="</div>";
       $html.=$footer;
       echo $html;
    ?>
</body>

</html>
