<?php 
	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	if(strpos($url, 'xpto.php'))
		$url = 'xpto';
	else if (strpos($url, 'page1.php'))
		$url = 'page1';
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
	<div class="navbar-header">
	  <a class="navbar-brand" href="#">WebSiteName</a>
	</div>
	<ul class="nav navbar-nav">
	  <li class="<?php echo ($url == 'xpto' ? 'active' : ''); ?>"><a href="xpto.php">Home</a></li>
	  <li class="<?php echo ($url == 'page1' ? 'active' : ''); ?>"><a href="page1.php">Page 1</a></li>
	  <li><a href="#">Page 2</a></li>
	  <li><a href="#">Page 3</a></li>
	</ul>
  </div>
</nav>