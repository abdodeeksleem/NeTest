<div>



    <div class="panel panel-default">
        <div class="panel-body">
            <div id="message" class="lead_message error-wrap"></div>
            <form class="form-horizontal" role="form" method="POST" name="sampleForm" id="LeadForm" autocomplete="off">

                <div class="form-group columns two">
                    <!--                    <label for="inputFirstName" class="col-sm-3 control-label">--><?php //echo __("First name","form")?><!--</label>-->
                    <div>
                        <input type="text" class="form-control" id="inputFirstName" name="firstName" placeholder="<?php echo __("First name","form")?>" />
                    </div>
                </div>
                <div class="form-group columns two">
                    <!--                    <label for="inputLastName" class="col-sm-3 control-label">--><?php //echo __("Last name","form")?><!--</label>-->
                    <div>
                        <input type="text" class="form-control" id="inputLastName" name="lastName" placeholder="<?php echo __("Last name","form")?>" />
                    </div>
                </div>
                <div class="form-group columns two">
                    <!--                    <label for="inputEmail" class="col-sm-3 control-label">--><?php //echo __("Email","form")?><!--</label>-->
                    <div>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="<?php echo __("Email","form")?>" value="" />
                    </div>
                </div>
                <div class="form-group columns two">
                    <!--                    <label for="countryId" class="col-sm-3 control-label">--><?php //echo __("Country","form")?><!--</label>-->
                    <div>
                        <select name="countryId" id="countryId" class="form-control">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['guid'];?>"<?php if ($data['country']==$country['name']) echo "selected" ?>><?php echo $country['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group columns two">
                    <!--                    <label class="col-sm-3 control-label">--><?php //echo __("Phone number","form")?><!--</label>-->
                    <div>
                        <div class="row">
                            <div class="columns four">
                                <input type="text" class="form-control" id="inputPhoneCountryCode" name="phoneCountryCode" placeholder="" />
                            </div>
                            <!--                            <div class="col-sm-2">-->
                            <!--                                <input type="text" class="form-control" id="inputPhoneAreaCode" name="phoneAreaCode" placeholder="" />-->
                            <!--                            </div>-->
                            <div class="columns eight">
                                <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber" placeholder="<?php echo __("Phone number","form")?>" />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="reg_ip"  id="reg_ip"  value="<?php echo $data['ip'];?>">
                    <input type="hidden" name="reg_lang"  id="reg_lang"  value="<?php echo $data['lang'];?>">
                </div>

                <div class="form-group columns two">
                    <div>
                        <button type="submit" name="submit"  id="leadsubmit" value="create_lead" class="btn btn-default">Submit</button>
                        <div class="form-group"><div class="ajax_loader"></div></div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
