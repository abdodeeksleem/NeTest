<div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" name="login-form" id="login-form" autocomplete="off">
                <div class="form-title"><?php echo __("Login","form")?></div>
                <div class="error-wrap"></div>
                <div class="form-group">
                    <label for="inputEmail" class="columns five control-label"><?php echo __("Email/Account number","form")?></label>
                    <div class="columns seven">
                        <input type="text" class="form-control" id="inputEmailLogin" name="username" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="columns five control-label"><?php echo __("Password","form")?></label>
                    <div class="columns seven">
                        <input type="password" class="form-control" id="inputPasswordLogin" name="password" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="columns twelve">
                        <button type="submit" id="login-submit" name="submit" class="btn btn-default" value="login">Login</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="ajax_loader"></div>
                </div>
                <div class="form-group">
                    <div class="columns twelve forgot">
                        <a href="/forgot-password/"><?php echo __("Forgot Password?","form")?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>