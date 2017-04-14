<html><body>
<table style="background-color: #fff; color: #555555; font-family: Arial; font-weight: normal; font-size: 12px; width: 600px; margin: 0 auto; border: 1px solid #7d95af; border-collapse: collapse;" cellpadding="0" cellspacing="0"><tbody>
    <tr><td style="background: #181818;"><img alt="Xchange Option" src="{$customer->portalsite}/wp-content/themes/ronneby/assets/images/logo.png" width="299" height="123" /></td></tr>
<tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>Hello Admin,</p></td></tr>
<tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>There was a registration failure due to an error mentioned below.</p></td></tr>
<tr><td><br/><p style='font-size: 15px; width: 580px; margin-left: 15px;'>Mentioned below are the details of the client.</p></td></tr>
<tr><td><br/><p style='margin:0 0 0 15px !important;'>First Name<strong style='font-weight: bold;font-size: 15px;'> :  {$customer->FirstName}  </strong> </p></td></tr>
<tr><td><br/><p style='margin:0 0 0 15px !important;'>Last Name<strong style='font-weight: bold;font-size: 15px;'> :   {$customer->LastName}  </strong> </p></td></tr>
<tr><td><br/><p style='margin:0 0 0 15px !important;'>Email ID<strong style='font-weight: bold;font-size: 15px;'> : {$customer->email}</strong> </p></td></tr>
<tr><td><br/><p style='margin:0 0 0 15px !important;'>Phone<strong style='font-size: 15px;'> : {$customer->phone_code} {$customer->phone}  </strong> </p></td></tr>
<tr><td><br/><p style='margin:0 0 0 15px !important;'>Country<strong style='font-size: 15px;'> : {$customer->country}</strong> </p></td></tr>
<tr><td><br/><p style='margin:0 0 0 15px !important;'>Error Message<strong style='font-size: 15px;'> : {$customer->error} </strong> </p></td></tr>

<tr><td style='width: 600px; height: 30px;'></td></tr>

<tr><td style='width: 600px; height: 11px; background-color: #1b4472;'></td></tr>

</tbody></table>
</body></html>