<?php

namespace HeroesOfLegend;

$makenoble = function(State $s) {
	$ac = $s->getActiveCharacter();
	if($ac->getModifier('TiMod') > 0) return;
	$ac->setModifier('TiMod', 1);
	LineAdder("And character is made petty noble (lowest rank)")($s);
};

return new NamedTable("538", "Military Rank", DiceRoller::from("d6+SolMod"), [
	"-10" => "Soldier/Sailor",
	"11-12" => "Corporal/Petty Officer",
	"13-15" => "Sergeant/Chief Petty Officer",
	"16" => "Lieutenant II/Ensign",
	"17-18" => "Lieutenant I/Lieutenant",
	"19-20" => "Captain/Commander",
	"21-24" => "Major/Captain",
	"25" => "Colonel/Commodore",
	"26-100" => function() { assert(false); },
	"101" => [ "General/Admiral", $makenoble ],
	"102" => "Field Marshal/Admiral of the Fleet",
	"103" => "Commander in Chief",
	"104" => "King",
	"105" => "Emperor",
]);
