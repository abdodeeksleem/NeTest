<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" name="forgotpassword-form" id="forgotpassword-form" autocomplete="off">
            <div class="form-title"><?php echo __("Forgot Password","form")?></div>
            <div class="error-wrap"></div>
            <div class="form-group">
                <div class="columns twelve control-label form-desc"><?php echo __("Please Enter your Portal Username - Email in order to Request Change of your Password","form")?> :</div>
            </div>
            <div class="form-group">
                <label for="inputEmailLogin" class="columns five control-label"><?php echo __("Email","form")?></label>
                <div class="columns seven">
                    <input type="email" class="form-control" id="inputEmailForgot" name="username" value="" />
                </div>
            </div>
            <div class="form-group">
                <div class="columns twelve">
                    <button type="submit" id="forgotpassword-btn" name="submit" class="btn btn-default" value="forgot-password"><?php echo __("Send Request","form")?></button>
                </div>
            </div>
            <div class="form-group">
                <div class="ajax_loader"></div>
            </div>
        </form>
    </div>
</div>