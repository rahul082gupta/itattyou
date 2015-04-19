<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo 'Account Activation'; ?></title>
	</head>

	<body>
		<table style="width:80%;">
			<tbody>
				<tr>
					<td style="background:#152b43;height:30px;width:100%">
						<span style="color:#fff;">&nbsp;<?php echo "Welcome to ittatyou, $name"; ?></span>
					</td>
				</tr>
				<tr>
					<td style="height:100px;background:#ffffff;width:100%;font-size:12px;font-family:Arial,Verdana,sans-serif">
						<table cellspacing="0" cellpadding="5" border="0" style="width:100%">
							<tbody>
								<tr>
									<td colspan="8"  style="padding:10px; padding-left:0;">
										Dear <?php echo $name ;?>,
										<br><br>
										<?php echo "Click the link below to activate your account with us!" ?> 
										<br><br>
										<strong>
											<?php echo $this->Html->link('Activate Account', $link); ?>
										</strong>
										<br><br>
										
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="font-family:Arial,Verdana,sans-serif;font-size:12px;width:100%;background:#ffffff">
						Contact Us <br>
						Person :: <?php echo ADMIN_NAME;?><br>
						Phone :: <?php echo ADMIN_PHONE;?><br>
						Email :: <?php echo ADMIN_EMAIL;?><br>
						<b style="vertical-align: super;color: #222121;">Powered by &nbsp; </b>
						<?php 
							 echo $this->Html->link(
							    $this->Html->image('http://www.snaplion.com/landingpages/logoTheme.png', array('alt' => 'ittatyou', 'width' => '105', 'height' => '27', 'style' => 'margin-top:10px;')),
							    '/',
							    array('escapeTitle' => false, 'target' => '_blank"')
							);
						?>
						<br><br>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>