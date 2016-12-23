<?php

namespace HeroesOfLegend;

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

	$tdata[(string)$i] = function() use($good, $bad) {
		return Roll("d6") <= 4 ? $good : $bad;
	};

	++$i;
}

$tdata["20"] = Invoker(Roll("d6") <= 4 ? "647" : "648");
	
return new NamedTable("426A", "Work Attitude", DiceRoller::from("d20"), $tdata);
