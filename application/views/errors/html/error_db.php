<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo html_escape($heading); ?></title>
</head>
<body>
	<div id="container">
		<h1><?php echo html_escape($heading); ?></h1>
		<?php echo sprintf("%s",$message); ?>
	</div>
</body>
</html>