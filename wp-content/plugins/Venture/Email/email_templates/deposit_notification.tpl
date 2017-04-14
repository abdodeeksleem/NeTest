<html><body>
<table style=" background-color:#ffffff; color: #000; font-family: Arial;  font-size: 12px; width: 600px; margin: 0 auto; border: 1px solid #002161; border-collapse: collapse;" cellpadding="0" cellspacing="0"><tbody>
    <tr><td style="background:#fff; border-bottom: 2px solid #002161; "><img alt="{$customer->portalsite_name}" src="{$customer->portalsite}/wp-content/themes/ronneby/assets/images/logo.png" width="299" height="123" /></td></tr>

    <tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>Hello Admin,</p></td></tr>
    <tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>There was a Deposit on your Site .</p></td></tr>
    <tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>UserName : {$customer->firstname} {$customer->lastname}</p></td></tr>
    <tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>Email : {$customer->email}</p></td></tr>
    <tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>Mentioned below are the details of the Deposit .</p></td></tr>
    </tbody></table>
</body>


    <div>
    {$customer->deposit_details}
    </div>


</html>