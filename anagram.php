<?php
$start = microtime(1);

$filename = $argv[1];
$word = $argv[2];

$dict = file($filename);

$anagrams = array();
$wordlength = mb_strlen($word);
$wordstats = letters($word);
// var_dump($wordstats);

foreach($dict as $line) {
	if (rtrim($line) == $word) {
		continue;
	}
	$linestats = letters($line);
	$intersect = array_intersect($wordstats, $linestats);
	if (sizeof($intersect) != sizeof($linestats)) {
		continue;
	}
	sort($intersect);
	sort($linestats);
	if ($intersect == $linestats) {
		$anagrams[] = trim($line);
	}
}
// var_dump($anagrams);

function letters($word) {
	$aStats = array();
	$word = trim(mb_strtolower($word));
	for($i=0;$i<mb_strlen($word);$i++) {
		$aStats[] = mb_substr($word, $i, 1);
	}
	return $aStats;
}

$end = microtime(1);
echo round(($end-$start)*1000000, 3);
echo ",".implode(",", $anagrams);
echo "\n";