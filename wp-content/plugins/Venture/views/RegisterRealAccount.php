<div id="registration-form">

<div id="steps-container">
    <div class="steps-container step-1">
        <div class="step-title"><?php echo __("CREATE","form")?> <br> <?php echo __("ACCOUNT","form")?></div>
        <div class="step-arrow"><div class="step-no-container"><div class="step-no">1</div></div></div>
    </div>
    <div class="steps-container step-2">
        <div class="step-title"><?php echo __("ACCOUNT","form")?> <br> <?php echo __("INFORMATION","form")?>  </div>
        <div class="step-arrow"><div class="step-no-container"><div class="step-no">2</div></div></div>
    </div>
    <div class="steps-container step-3">
        <div class="step-title"><?php echo __("CONFIRMATION","form")?></div>
        <div class="step-arrow"><div class="step-no-container"><div class="step-no">3</div></div></div>
    </div>
</div>

<div id="message"></div>

<div class="panel panel-default">
<div class="panel-body">
<form class="form-horizontal" role="form" method="POST" name="sampleForm" id="RealFormStep1" autocomplete="off">

    <div class="form-subtitle"><?php echo __("Direct Login Details","form")?></div>

    <div class="form-group">
        <label for="inputEmail" class="columns five control-label"><?php echo __("Email","form")?></label>
        <div class="columns seven">
            <input type="email" class="form-control" id="inputEmail" name="email" value="" />
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
            <input type="text" class="form-control" id="inputFirstName" name="firstName"/>
        </div>
    </div>
    <div class="form-group">
        <label for="inputLastName" class="columns five control-label"><?php echo __("Last name","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputLastName" name="lastName"/>
        </div>
    </div>
    <div class="form-group">
        <label for="countryId"  class="columns five control-label"><?php echo __("Country","form")?></label>
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
                    <input type="text" class="form-control" id="inputPhoneCountryCode" name="phoneCountryCode"/>
                </div>
                <div class="columns eight">
                    <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber"/>
                </div>
            </div>
        </div>
    </div>
    <!--    <div class="form-group">-->
    <!--        <label class="columns five control-label">--><?php //echo __("Mobile","form")?><!-- </label>-->
    <!--        <div class="columns seven">-->
    <!--            <div class="row">-->
    <!--                <div class="columns four">-->
    <!--                    <input type="text" class="form-control" id="inputMobileCountryCode" name="MobileNumberCCode"/>-->
    <!--                </div>-->
    <!--                <div class="columns eight">-->
    <!--                    <input type="text" class="form-control" id="inputMobileNumber" name="MobileNumber"/>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <div class="form-group">
        <div class="columns twelve">
            <button type="submit" name="submit"  id="real-step1" value="real-step1" class="btn btn-default"><?php echo __("Next Step","form")?></button>
        </div>
    </div>
    <div class="form-group">
        <div class=" ajax_loader"></div>
    </div>
</form>


<form class="form-horizontal" role="form" method="POST" name="sampleForm" id="RealFormStep2"   style="display: none;">

    <div class="form-subtitle"><?php echo __("Address Information","form")?></div>

    <div class="form-group">
        <label for="inputDateofBirth" class="columns five control-label"><?php echo __("Date of Birth","form")?></label>
        <div class="columns seven">
            <input type="date" class="form-control" id="inputDateofBirth" name="DateOfBirth" />
        </div>
    </div>

    <div class="form-group">
        <label for="inputAddress" class="columns five control-label"><?php echo __("Address","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputAddress" name="address1"/>
        </div>
    </div>

    <div class="form-group">
        <label for="inputAddress2" class="columns five control-label"><?php echo __("Alternative Address","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputAddress2" name="address2"/>
        </div>
    </div>

    <div class="form-group">
        <label for="inputTownCity" class="columns five control-label"><?php echo __("Town / City","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputTownCity" name="towncity"/>
        </div>
    </div>

    <div class="form-group">
        <label for="inputStateProvince" class="columns five control-label"><?php echo __("State/Province","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputStateProvince" name="State"/>
        </div>
    </div>

    <div class="form-group">
        <label for="inputPostCode" class="columns five control-label"><?php echo __("ZIP/Post Code","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputPostCode" name="ZipCode"/>
        </div>
    </div>

    <div class="form-subtitle"><?php echo __("Financial Information","form")?></div>

    <div class="form-group">
        <label for="inputAnualIncome" class="columns five control-label"><?php echo __("Estimated Annual Income","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputAnualIncome" name="EstimatedAnnualIncome"/>
        </div>
    </div>


    <div class="form-group">
        <label for="inputNetWorth" class="columns five control-label"><?php echo __("Estimated Net Worth","form")?></label>
        <div class="columns seven">
            <input type="text" class="form-control" id="inputNetWorth" name="EstimatedNetWorth"/>
        </div>
    </div>

    <div class="form-subtitle"><?php echo __("Trading Experience","form")?></div>

    <div class="form-group">
        <label for="DemoExperience" class="columns five control-label"><?php echo __("Demo Experience","form")?></label>
        <div class="columns seven">
            <select id="DemoExperience" name="HasDemoExperience" class="form-control">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>


    <div class="form-group">
        <label for="TradeSize" class="columns five control-label"><?php echo __("Average Trade Size","form")?></label>
        <div class="columns seven">
            <select id="TradeSize" name="AverageTradeSize" class="form-control">
                <option value="" selected="selected" title=""></option>
                <option value="1" title="less than $10000"><?php echo __("less than $10000","form")?></option>
                <option value="2" title="$10000-$25000">$10000-$25000</option>
                <option value="3" title="$25000-$50000">$25000-$50000</option>
                <option value="4" title="$50000-$100000">$50000-$100000</option>
                <option value="5" title="more than $100000"><?php echo __("more than $100000","form")?></option>
            </select>
        </div>
    </div>


    <div class="form-group">
        <label for="numberoftimestraded" class="columns five control-label"><?php echo __("Number of times traded in past 12 month","form")?></label>
        <div class="columns seven">
            <select id="numberoftimestraded" name="NumberOfTimesTradedInPastYear" class="form-control">
                <option value="" selected="selected" title=""></option>
                <option value="1" title="5 or less"><?php echo __("5 or less","form")?></option>
                <option value="2" title="6-20">6-20</option>
                <option value="3" title="20-40">20-40</option>
                <option value="4" title="40-60">40-60</option>
                <option value="5" title="more than 60"><?php echo __("more than 60","form")?></option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="cfdtradingexperience" class="columns five control-label"><?php echo __("CFD/Commodities","form")?></label>
        <div class="columns seven">
            <select id="cfdtradingexperience" name="CfdTradingExperience" class="form-control">
                <option value="" selected="selected" title=""></option>
                <option value="1" title="Less than 1 year"><?php echo __("Less than 1 year","form")?></option>
                <option value="2" title="1-2 years"><?php echo __("1-2 years","form")?></option>
                <option value="3" title="3-5 years"><?php echo __("3-5 years","form")?></option>
                <option value="4" title="more than 5 years"><?php echo __("more than 5 years","form")?></option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="currenciestradingexperience" class="columns five control-label"><?php echo __("Currencies","form")?></label>
        <div class="columns seven">
            <select id="currenciestradingexperience" name="CurrenciesTradingExperience" class="form-control">
                <option value="" selected="selected" title=""></option>
                <option value="1" title="Less than 1 year"><?php echo __("Less than 1 year","form")?></option>
                <option value="2" title="1-2 years"><?php echo __("1-2 years","form")?></option>
                <option value="3" title="3-5 years"><?php echo __("3-5 years","form")?></option>
                <option value="4" title="more than 5 years"><?php echo __("more than 5 years","form")?></option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="futurestradingexperience" class="columns five control-label"><?php echo __("Futures","form")?></label>
        <div class="columns seven">
            <select id="futurestradingexperience" name="FuturesTradingExperience" class="form-control">
                <option value="" selected="selected" title=""></option>
                <option value="1" title="Less than 1 year"><?php echo __("Less than 1 year","form")?></option>
                <option value="2" title="1-2 years"><?php echo __("1-2 years","form")?></option>
                <option value="3" title="3-5 years"><?php echo __("3-5 years","form")?></option>
                <option value="4" title="more than 5 years"><?php echo __("more than 5 years","form")?></option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="optionstradingexperience" class="columns five control-label"><?php echo __("Options","form")?></label>
        <div class="columns seven">
            <select id="optionstradingexperience" name="OptionsTradingExperience" class="form-control">
                <option value="" selected="selected" title=""></option>
                <option value="1" title="Less than 1 year"><?php echo __("Less than 1 year","form")?></option>
                <option value="2" title="1-2 years"><?php echo __("1-2 years","form")?></option>
                <option value="3" title="3-5 years"><?php echo __("3-5 years","form")?></option>
                <option value="4" title="more than 5 years"><?php echo __("more than 5 years","form")?></option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="securitiestradingexperience" class="columns five control-label"><?php echo __("Securities","form")?></label>
        <div class="columns seven">
            <select id="securitiestradingexperience" name="SecuritiesTradingExperience" class="form-control">
                <option value="" selected="selected" title=""></option>
                <option value="1" title="Less than 1 year"><?php echo __("Less than 1 year","form")?></option>
                <option value="2" title="1-2 years"><?php echo __("1-2 years","form")?></option>
                <option value="3" title="3-5 years"><?php echo __("3-5 years","form")?></option>
                <option value="4" title="more than 5 years"><?php echo __("more than 5 years","form")?></option>
            </select>
        </div>
    </div>

    <br>
    <input type="hidden" id="account_id" name="account_id" value="" />
    <div class="form-group">
        <div class="columns twelve">
            <button type="submit" name="real-step2"  id="real-step2" value="real-step2" class="btn btn-default"><?php echo __("Next Step","form")?></button>
        </div>
    </div>
    <input type="hidden" name="reg_ip"  id="reg_ip"  value="<?php echo $data['ip'];?>">
    <input type="hidden" name="reg_lang"  id="reg_lang"  value="<?php echo $data['lang'];?>">
    <div class="form-group">
        <div class=" ajax_loader"></div>
    </div>
</form>


<form class="form-horizontal" role="form" method="POST" name="sampleForm" id="RealFormStep3" style="display: none;" autocomplete="off">

    <div class="form-subtitle"><?php echo __("Upload your Documents and Agree to Term and Conditions","form")?></div>

    <div class="form-group">
        <label for="Inputproofofid" class="columns twelve control-label"><?php echo __("Select a file ","form")?><span class="browse btn btn-default"><?php echo __("Browse","form")?>...</span></label>
        <div class="columns seven">
            <input id="Inputproofofid" type="file" name="img">
        </div>
    </div>
    <div class="form-group">
        <input type="checkbox" name="terms" value="1"><span class="terms"><?php echo __("I declare that I have carefully read the entire content of the <a href='/terms-and-conditions/'>Terms and Conditions</a>with which I fully understand and agree.","form")?> </span>
    </div>
    <br>
    <input type="hidden" id="real-step3b" name="submit" value="real-step3" />
    <br>
    <div class="form-group">
        <div class="columns twelve">
            <button type="submit" name="submit"  id="real-step3" value="real-step3" class="btn btn-default"><?php echo __("Confirm and Start Trade","form")?> </button>
        </div>
    </div>
    <div class="form-group">
        <div class="ajax_loader"></div>
    </div>
</form>
</div>
</div>

</div>
