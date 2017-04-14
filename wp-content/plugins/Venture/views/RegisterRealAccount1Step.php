<div class="panel panel-default">
    <div class="panel-body">

        <form class="form-horizontal" role="form" method="POST" name="Real-Form-Short" id="Real-Form-Short" autocomplete="off">

            <div class="form-title"><?php echo __("Registration","form")?></div>
            <div id="message" class="error-wrap"></div>
            <div class="form-subtitle"><?php echo __("Direct Login Details","form")?></div>

            <div class="form-group">
                <label for="inputEmail" class="columns five control-label"><?php echo __("Email","form")?></label>
                <div class="columns seven">
                    <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo(isset($data['email'])?$data['email']:'' );?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword" class="columns five control-label"><?php echo __("Password","form")?></label>
                <div class="columns seven">
                    <input type="password" class="form-control" id="inputPassword" name="Password" value="" />
                </div>
            </div>

            <div class="form-subtitle"><?php echo __("Personal Details","form")?></div>

            <div class="form-group">
                <label for="inputFirstName" class="columns five control-label"><?php echo __("First name","form")?></label>
                <div class="columns seven">
                    <input type="text" class="form-control" id="inputFirstName" name="firstName" value="<?php echo(isset($data['first_name'])?$data['first_name']:'' );?>"/>
                </div>
            </div>
            <div class="form-group">
                <label for="inputLastName" class="columns five control-label"><?php echo __("Last name","form")?></label>
                <div class="columns seven">
                    <input type="text" class="form-control" id="inputLastName" name="lastName" value="<?php echo(isset($data['last_name'])?$data['last_name']:'' );?>"/>
                </div>
            </div>
            <div class="form-group">
                <label for="countryId" class="columns five control-label"><?php echo __("Country","form")?></label>
                <div class="columns seven">
                    <select name="countryId" id="countryId" class="form-control">
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo $country['guid'];?>"<?php if ($data['country']==$country['name']) echo "selected" ?>><?php echo $country['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="columns five control-label"><?php echo __("Phone number","form")?></label>
                <div class="columns seven">
                    <div class="row">
                        <div class="columns four">
                            <input type="text" class="form-control" id="inputPhoneCountryCode" name="phoneCountryCode" value="<?php echo(isset($data['phone_ccode'])?$data['phone_ccode']:'' );?>"/>
                        </div>
                        <!--                        <div class="columns three">-->
                        <!--                            <input type="text" class="form-control" id="inputPhoneAreaCode" name="phoneAreaCode"/>-->
                        <!--                        </div>-->
                        <div class="columns eight">
                            <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber" value="<?php echo(isset($data['phone'])?$data['phone']:'' );?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="form-group">-->
            <!--                <label class="columns five control-label">--><?php //echo __("Mobile","form")?><!-- </label>-->
            <!--                <div class="columns seven">-->
            <!--                    <div class="row">-->
            <!--                        <div class="columns four">-->
            <!--                            <input type="text" class="form-control" id="inputMobileCountryCode" name="MobileNumberCCode"/>-->
            <!--                        </div>-->
            <!--                        <div class="columns eight">-->
            <!--                            <input type="text" class="form-control" id="inputMobileNumber" name="MobileNumber"/>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->

            <div class="form-group">
                <label for="currencyId" class="columns five control-label"><?php echo __("Choose Base Currency","form")?></label>
                <div class="columns seven">
                    <select name="currencyId" class="form-control">
                        <?php foreach ($currencies as $currency): ?>
                            <option value="<?php echo $currency['currency_id'];?>"><?php echo $currency['currency_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <input type="hidden" name="reg_ip"  id="reg_ip"  value="<?php echo $data['ip'];?>">
            <input type="hidden" name="reg_lang"  id="reg_lang"  value="<?php echo $data['lang'];?>">
            <input type="hidden" name="account_id"  id="account_id"  value="<?php echo $data['account_id'];?>">
            <div class="form-group">
                <label for="platform" class="columns five control-label"><?php echo __("Choose Trading Platform","form")?></label>
                <div class="columns seven">
                    <select name="platform" class="form-control">
                        <?php foreach ($platforms as $platform): ?>
                            <option value="<?php echo $platform;?>"><?php echo $platform; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" id="accept-terms" name="terms" value="1"><span class="terms"><?php echo __('I declare that I have carefully read the entire content of the <a href="/terms-and-conditions/" target="_blank">Terms and Conditions</a> with which I fully understand and agree.',"form")?> </span>
            </div>

            <div class="form-group">
                <div class="columns twelve">
                    <button type="submit" name="submit"  id="real-step" value="real-short-step1" class="btn btn-default"><?php echo __("Confirm and Start Trade","form")?></button>
                </div>
            </div>
            <div class="form-group">
                <div class=" ajax_loader"></div>
            </div>
        </form>

    </div>
</div>
