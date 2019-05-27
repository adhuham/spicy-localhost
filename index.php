<?php
/**
 * 27-05-2019
 *
 * Copyright 2019 Mohamed Adhuham 
 * Released under GPLv3
 *
 */


// add extra tools 
// '[label]' => '[link of the tool]' 
// eg: 'phpMyAdmin' => 'http://localhost/phpMyAdmin'
$extras = [
	'phpinfo()' => '?phpinfo=1'
];


// display phpinfo 
if(!empty($_GET['phpinfo'])) {
	phpinfo();
	exit;
}

$apache_version = explode(' ', explode('/', apache_get_version())[1])[0];
$php_version = explode('-', phpversion())[0];
$mysql_version = explode('-', explode(' ', mysqli_get_client_info())[1])[0];

$info = [
	'Apache' => $apache_version,
	'PHP' => $php_version,
	'MySQL' => $mysql_version
];


// read all items in the ./ dir
$directory_list = [];
if($handle  = opendir('./')) {
	$item_list = [];
	while(false !== ($item = readdir($handle))) {
		if($item == '..' || $item == '.') {
			continue;
		}
		$item_type = is_dir($item) ? 'dir' : 'file';
		$order = ($item_type == 'dir') ? 1 : 0;
		$item_list[] = ['name' => $item, 
							 'type' => $item_type,
							 'order' => $order];
	}
	$order_column = array_column($item_list, 'order');
	array_multisort($order_column, SORT_DESC, $item_list);
	$directory_list = $item_list;
	closedir($handle);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		body {
			font-family: monospace;
			background: linear-gradient(#001c33,#002707);
			margin: 0;
			padding: 0;
			min-height: 100vh;
			display: flex;
			align-items: center;	
			justify-content: center;
		}
		h2 {
			font-size: 24px;
			font-weight: bold;
			margin-bottom: 20px;
		}
		main {
			margin: 40px 0;
			display: flex;
			justify-content: center;
			color: #FFF;
		}
		.info {}
		.info .table {}
		.info .table > div {
			margin: 7px 0;
		}
		.info .table > div > span {}
		.info .table > div > span:first-child {
			width: 50px;
			display: inline-block;
		}
		.info .table > div > span:last-child {
			font-weight: bold;
			padding: 0 3px;
			border-radius: 3px;
		}

		.info .table > div.Apache {
			color: #ff8600;
		}
		.info .table > div.Apache > span:last-child {
			background-color: #ff8600;
			color: #000;
		}
	
		.info .table > div.PHP {
			color: #ccbfff;
		}
		.info .table > div.PHP > span:last-child {
			background-color: #ccbfff;
			color: #000;
		}

		.info .table > div.MySQL {
			color: #3dcfff;
		}
		.info .table > div.MySQL > span:last-child {
			background-color: #3dcfff;
			color: #000;
		}

		.projects {
			margin-left: 50px;
		}
		.projects ul {
			list-style-type: none;
			padding: 0;
			margin-left: 27px;
		}
		.projects ul li {
			margin: 6px 0;
		}
		.projects ul li a {
			text-decoration: none;
			border-radius: 3px;
			font-size: 14px;
			padding: 2px 4px;
		}
		.projects ul li.dir a {
			color: #00ffc8;
			font-weight: bold;
		}
		.projects ul li.dir a:hover {
			background-color: #00ffc8;
			color: #000;
		}
		.projects ul li.file a {
			color: #e8e8e8;
		}
		.projects ul li.file a:hover {
			background-color: #e8e8e8;
			color: #000;
		}

		.tools {
			margin-left: 40px;
		}
		.tools ul {
			list-style-type: none;
			padding: 0;
			margin-left: 27px;
		}
		.tools ul li::before {
			content: '↪ ';
		}
		.tools ul li {
			margin: 6px 0;
		}
		.tools ul li a {
			color: #ffd800;
			text-decoration: none;
			border-radius: 3px;
			font-size: 14px;
			padding: 2px 4px;
		}
		.tools ul li a:hover {
			background-color: #FFd800;
			color: #000;
		}
	</style>
</head>

<body>
	<main>
		<div class="info">
			<h2>= info</h2>
			<div class="table">
				<?php foreach($info as $label => $value): ?>
				<div class="<?=$label?>">
					<span><?=$label?></span>
					<span><?=$value?></span>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="projects">
			<h2>= projects</h2>
			<ul>
				<?php foreach($directory_list as $item): ?>
				<li class="<?=$item['type']?>">
					<a href="<?=$item['name']?>">
						<?php $slash = $item['type'] == 'dir' ? '/' : null; ?>
						<?=$item['name'].$slash;?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="tools">
			<h2>= extras</h2>
			<ul>
				<?php foreach($extras as $label => $link): ?>
				<li><a href="<?=$link?>"><?=$label?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</main>
</body>
</html>
