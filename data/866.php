<?php

namespace HeroesOfLegend;

$nt = new NamedTable("866", "Birthmark", DiceRoller::from("d10"), [
	"1" => "Dragon",
	"2" => "Skull",
	"3" => "Bat",
	"4" => "Sword",
	"5" => "Hand",
	"6" => "Crescent moon",
	"7" => "Claw",
	"8" => "Eagle (or hawk)",
	"9" => "Fish",
	"10" => "Animal (of choice)",
]);

$nt->addPostExecuteHook(function(State $s) {
	$ac = $s->getActiveCharacter();
	$c = $ac->getActiveEntry()->getChildren();
	$lc = end($c);
	$ac->setActiveEntry($lc);
	
	$s->invoke("867");
	if(Roll("d20") === 20) {
		LineAdder("And birthmark has non-normal color")($s);
		$s->invoke("865");
	}

	$ac->setActiveEntry($lc->getParent());
});
return $nt;
