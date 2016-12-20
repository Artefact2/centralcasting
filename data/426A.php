<?php

$adj = [
	"Hard worker", "Lazy",
	"Ambitious", "Laid back/Casual",
	"Overbearing", "Submissive",
	"Well-liked", "Hated",
	"Patient", "Impatient",
	"Talented", "Incompetent",
	"Generous", "Stingy",
	"Fair", "Underhanded",
	"Opinionated", "A Yesman",
	"Inspired Loyalty", "Inspired Mistrust",
	"Humble", "Arrogant",
	"Trusting", "Jealous",
	"Creative", "Uncreative",
	"Adept", "Clumsy",
	"Efficient", "Inefficient",
	"Workaholic", "Slacker",
	"Productive", "Unproductive",
	"Office Politician", "Avoids politics",
	"Happy", "Unhappy",
];

$tdata = [];
$i = 1;
while($adj !== []) {
	$good = array_shift($adj);
	$bad = array_shift($adj);

	$tdata[(string)$i] = [ "Adjective", function() use($good, $bad) {
			return Roll(6) <= 4 ? $good : $bad;
		}];

	++$i;
}

$tdata["20"] = [
	null, function() use(&$s) {
		Invoke($s, Roll(6) <= 4 ? "647" : "648");
	},
];
	
Table($s, "426A", "Work Attitude", Roll(20), $tdata);
