<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
?>
<!DOCTYPE html>
<html lang="<?php echo $language;?>">
<?php echo $header;?>
<body>
    <div class="container main">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h3 class="card-title text-center" style="vertical-align:middle;"><?php echo $title;?></h3>
                        <form class="form-signin">
                            <div class="form-label-group" style="padding-bottom:15px;">
                                <label for="username"><?php echo lang('p_username');?></label>
                                <input type="text" id="username" name="username" class="form-control dbase validate" placeholder="<?php echo lang('p_username');?>" autofocus />
                            </div>

                            <div class="form-label-group" style="padding-bottom:15px;">
                                <label for="password"><?php echo lang('p_password');?></label>
                                <input type="password" id="password" name="password" class="form-control dbase validate" placeholder="<?php echo lang('p_password');?>" />
                            </div>

                            <hr class="my-4" />
                            <div data-scoope="backend" class="btn-login btn btn-lg btn-primary btn-raised btn-block text-uppercase"><?php echo lang('b_login');?></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <?php echo $footer;?>
</body>
</html>
