<div>

    <div id="message"></div>

    <div class="panel panel-default">
        <div class="panel1-body">
            <form class="form-horizontal" role="form" method="POST" name="sampleForm" id="LeadForm" autocomplete="off">
                <div class="six form-group">
                    <div class="col-sm-12 form-element">
                        <div class='form-icon contact-icon'></div>
                        <div class="form-part ten"><input type="text" class="form-control" id="inputFirstName" name="firstName" placeholder="<?php echo __("First name","form")?>" /></div>
                    </div>
                </div>
                <div class="six form-group">
                    <div class="col-sm-12 form-element">
                        <div class='form-icon contact-icon'></div>
                        <div class="form-part ten"> <input type="text" class="form-control" id="inputLastName" name="lastName" placeholder="<?php echo __("Last name","form")?>" /></div>
                    </div>
                </div>
                <div class="six form-group">
                    <div class="col-sm-12 form-element">
                        <div class="form-icon email-icon"><!-- form-icon --></div>
                        <div class="form-part ten"><input type="email" class="form-control" id="inputEmail" name="email" placeholder="<?php echo __("Email","form")?>" value="" /></div>
                    </div>
                </div>
                <div class="six form-group">
                    <div class="col-sm-12 form-element">
                        <div class="form-icon phone-icon"><!-- form-icon --></div>
                        <div class="form-part twelve">
                            <div class="form-part-extra three">
                                <input type="text" class="form-control" id="inputPhoneCountryCode" name="phoneCountryCode" placeholder="<?php echo __("Code","form")?>" />
                            </div>
                            <div class="form-part-extra seven">
                                <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber" placeholder="<?php echo __("Phone","form")?>" />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="reg_ip"  id="reg_ip"  value="<?php echo $data['ip'];?>">
                    <input type="hidden" name="reg_lang"  id="reg_lang"  value="<?php echo $data['lang'];?>">
                    <input type="hidden" name="affid" id="affid" value="<?php echo (isset($_GET['affid']) ?  $_GET['affid']: '') ?>">
                    <input type="hidden" name="cxd" id="cxd" value="<?php echo (isset($_GET['cxd']) ?  $_GET['cxd']: '') ?>">
                </div>

                <div class="six form-group">
                    <div class="col-sm-12">
                        <div class="form-icon country-icon"><!-- form-icon --></div>
                        <div class="form-part ten"><select name="countryId" class="form-control" id="country">
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo $country['guid'];?>"<?php if ($data['country']==$country['name']) echo "selected" ?>><?php echo $country['name'];?></option>
                                <?php endforeach; ?>
                            </select></div>
                    </div>
                </div>
                <input type="hidden" name="reg_ip"  id="reg_ip"  value="<?php echo $data['ip'];?>">
                <input type="hidden" name="reg_lang"  id="reg_lang"  value="<?php echo $data['lang'];?>">

                <div class="form-group submit-button six">
                    <div class="col-sm-12">
                        <button type="submit" name="submit"  id="leadsubmit" value="create_lead" class="btn btn-default twelve"><?php echo __("GET YOUR BONUS","form")?></button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="ajax_loader"></div>
                </div>
            </form>
        </div>
    </div>
</div>
