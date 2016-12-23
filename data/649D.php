<?php

namespace HeroesOfLegend;

$nt = new NamedTable("649D", "Allergies", DiceRoller::from("d10"), [
	"1" => "Fur (constant sneezing)",
	"2" => "Dust (constant sneezing)",
	"3" => "Insect bites/stings",
	"4" => "Common food type (eg cheese, eggs, red meat, flour)",
	"5" => "Unusual food type (eg caviar, horse milk cheese, jalapeno peppers)",
	"6" => "Exotic food type (eg candied prawns, cumquat surprise)",
	"7" => "Common medicine type (home remedies)",
	"8" => "Unusual medicine type (magical potions, antidotes)",
	"9" => "Mold (constant sneezing)",
	"10" => "Magic (cast magic)",
]);

$nt->addPostExecuteHook(function(State $s) {
	$ac = $s->getActiveCharacter();
	$ae = $ac->getActiveEntry();
	$c = $ae->getChildren();
	$lc = end($c);
	
	$ac->setActiveEntry($lc);
	SubtableInvoker(DiceRoller::from("d10"), [
		"1-4" => "Mild reaction (factor in character Constitution)",
		"5-7" => "Serious reaction (factor in character Constitution)",
		"8-9" => "Severe reaction (factor in character Constitution)",
		"10" => "Deadly reaction (factor in character Constitution)",
	])($s);
	$ac->setActiveEntry($ae);
});

return $nt;
