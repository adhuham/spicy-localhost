<?php
/**
 * 27-05-2019
 *
 * Spicy Localhost
 * ---------------
 * Spice up your localhost index page
 *
 * Copyright 2019 Mohamed Adhuham <hello@adhuham.com> 
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
	<link rel="icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAFcElEQVRYR62XWYwUZRDH/9U9Z389yyzH7nIJqOCCixwBAcUEHgyuD0aNxmCICkQQUZxZQkx8msQHI8fOoCgGrxAPEuUBfRCCRjREQJcgBrnWRRBBjl32mu6eu8v07DWz0wu9wPfU6a+O31dd9VU14TastiiCbohVzR16dEIEycGYpMEIcwQSRWDa6WgxsYMZ08hML1bXZv5watcxQDzqWwCmikBd4qsBAJYA9BkDGnLZxwJrk/ucQDgC0NaLKnjouAlzaVnI+NbOcMdGZbbskn6z9pgR98jpud416RM3gnAGEBP1AIWJzeUibHxiZ1TfpMxgWTrSt2f+KkLGPAL4ehDOAKLiPIjGgnmHGtaftf0EUfECiD4t2jMzi9S61N5bAuD3oOoZ0QmQdZgMgR8UIaOh0CivgFufIg4BNLPwPbG5TYSNlY4BOAKfPsRdrYYzR3uUOuoxVJbUa31GuFkic6W/LfGNVRHxDaiAS9lKJD3Z3xGBG0RIv98xgBYTUTYzHwXq0sd7lKzS04JqBwFq0amBdjBaiHgcQG57J3xBDeljHQFom8Q0yGjQMnp51TrohUrxqNhDRItulNGl+3xZDekjHQHEo8ouAtWKDt3f/7LR65WXWJK2DhaAGE0irE28IUBb1DfeTXITAMk09BFlb6DgmwPxzb6FxK4fBwsA5r1qWLeNHEfgoQjS+TLUYv61gLzRejbZfKIsbOwqdKbFxHMAbb8JgPVqWH/dtmzrfc+rdcnt3QBiD9D9jZmPCNbnUx0SlmK+0ZDYD1DNTQAsUcP6F/319LeVUTkvfVwW0mt7AK4AVFFQaicIvJOZrMx/BkSjS5y7XCCXG5zMc9ouiXPzlXDil/6bnfXKckmit9SQXkFXI1CVYM9FM4gzEsE/Zz7Mtlak/v4LyKRLlCUzN0epS+T7Q89igIyYaGBgpsjoAdJiohKgy4Nw3Svqq5kOOVgOM5VE8tjRkmiwaa4K1BkfFJe0sppI2tL1Tqsi6yYjt3rlZgA8E6vhruwq85yuIXn0cL4V9p2Wm0nCEtGq/9Dih/C6xWpJwpsAuSwZzmiVdDYC34ig0ACSBwvhmTQZ7oqqXrVk40nkrtoFk60pydXjuEuBc83tuppPQj0qzjHRuBIAWYYcHIrctWZbNt+M2ZBF3w2dbW1B6sQxR+cg5n9EWB+fB4hHla+JpKf6a3qra/IhTZ3ubQ29IlKgDL77ZoKsJtm9zFQKiYYDjgCYzZ2BsPF0VxluFkvBVDRoyMOGwzd5KjibhXH4IJDN9homrxdWAkp+pcgZM8M48HNRHlgCljynUsVgxMvU1/RP8wDWZeMhcYFBokfKN30WZDXQlWCdHUj/ew4wTUhlQXhGjQG57RugBcvJ4sHYM7kG6ZN/9h0ArKdZH1MeRntv/PSY8i5DeiVPrAj4Z8wuCq+juAJINZ1G9vJ/veLy8Ap475mCxO8NYKOryRLMLSJkvNr13L30qDKSSToFoMw1agy8d163iQ3Iw7kc0ufPwtQ0yMEg3KPvAEkSUmcakb100dLrJDarRdi4VATQnYyriKT3PXdNgntk6e3rNAp2cplLF5E+0whm8+VA2Oht7SVDaTwqvvRV37vYNaLyVvyV6GabryB56viOQL+htgSA34GXpz60iwLBR24nQS7evkc+tv9xWoOicrAdy/m7u70YNulDyJL1t+NodB8Ylhlsfo7mxhfp0aZ+tViQhHYG+FDtMsjyBhANvaloMLcil1tHc3fb/syUJKEtxL4Fw03Fv44keQURBZ2AMHM7m7ltkpHYQAt/armejuPw8oF5friG1IKkh5lpFhFNAFF53jhzGzOfJeLDYPN7ZDt20wMHB55UCoj+B6DZI2qvmfy2AAAAAElFTkSuQmCC">
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
