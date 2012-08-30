#!/usr/bin/php
<?php

$f = file_get_contents('http://en.wikipedia.org/wiki/Universe_Championships');
preg_match_all('#wiki/([^": ]+)#', $f, $matches);

sort($matches[1]);
$names = array_unique($matches[1]);

$names = array_diff($names, array(
	'Competition',
	'Talk',
	'Wikipedia'
));

foreach ($names as $slug) {

	$url = "http://en.wikipedia.org/wiki/$slug";

	$name = str_replace('_', ' ', $slug);

	$f = @file_get_contents($url);

	preg_match_all('#<span class="toctext">(.*)</span>#', $f, $headings);

	$career = FALSE;
	foreach ($headings[1] as $heading) {
		if (stripos($heading, 'polit') !== FALSE) {
			$career = TRUE;
		}
	}

	if ($career) {
		echo "$name (http://en.wikipedia.org/wiki/$slug)\n";
	}
}
