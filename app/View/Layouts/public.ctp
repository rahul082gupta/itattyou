<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'itattyou : ');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="itattyou">
    <meta name="author" content="itattyou">
    <link rel="shortcut icon" href="<?php echo ROOT;?>/favicon.ico" type="image/x-icon" /> 
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	 <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<?php

		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script'); 

		/* Load core css files */
		echo $this->Html->css(array('bootstrap.min', 'bootstrap', 'font-awesome.min', 'animate.min' ,'prettyPhoto', 'responsive' ,'style', 'front/developer'));

		// custome theme of validation

		echo $this->Html->css(array('validationEngine.jquery', 'main'));

		/* Load core js files */
		echo $this->Html->script(array('jquery', 'jquery.easing.min', 'front/front', 'bootstrap.min'));

		// custom validations

		echo $this->Html->script(array('jquery.validationEngine', 'jquery.validationEngine-en', 'jquery.prettyPhoto', 'plugins'));
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			
		</div>
		<div id="content">

			<?php
				echo $this->Session->flash('auth', array('element' => 'bad_flash_message')); 
				echo $this->Session->flash('flash', array('element' => 'flash_message')); 
				echo $this->Session->flash('bad', array('element' => 'bad_flash_message')); 
				echo $this->Session->flash('good', array('element' => 'good_flash_message')); 
			?>
			

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			
			<p>
				
			</p>
		</div>
	</div>
</body>
</html>
<script type="text/javascript"> 
    $(document).ready(function(){
        $(".validationengine").validationEngine()   
    }); 
</script>
