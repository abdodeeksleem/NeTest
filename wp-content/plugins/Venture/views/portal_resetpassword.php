<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" name="resetpassword-form" id="resetpassword-form" autocomplete="off">
            <div class="form-title"><?php echo __("Reset Password","form")?></div>
            <div class="error-wrap"></div>
            <div class="form-group">
                <label for="inputEmailLogin" class="columns five control-label"><?php echo __("Enter new Password","form")?></label>
                <div class="columns seven">
                    <input type="password" class="form-control" id="inputPassword" name="password" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputPasswordConfirm" class="columns five control-label"><?php echo __("Confirm your Password","form")?></label>
                <div class="columns seven">
                    <input type="password" class="form-control" id="inputPasswordConfirm" name="passwordconfirm" value="" />
                </div>
            </div>
            <div class="form-group">
                <div class="columns twelve">
                    <button type="submit" id="resetpassword-btn" name="submit" class="btn btn-default" value="reset-password"><?php echo __("Reset Password","form")?></button>
                </div>
            </div>
            <div class="form-group">
                <div class="ajax_loader"></div>
            </div>
            <input type="hidden" id="account_token" name="account_token" value="<?php echo $token?>" />
            <input type="hidden" id="InputEmailReset" name="email" value="<?php echo $email?>" />
        </form>
    </div>
</div>