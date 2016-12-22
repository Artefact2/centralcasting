<?php

namespace HeroesOfLegend;

$illegit = function(State $s) {
	$ac = $s->getActiveCharacter();
	$ac->setModifier('LegitMod', Roll("d4"));
	$ac->setModifier('TiMod', 0); /* XXX unless he is the sole heir */
	
	if($ac->getModifier('SolMod') >= 0) {
		$ac->increaseModifier('SolMod', -$ac->getModifier('LegitMod'));
	}

	$s->invoke("105");
};

return new NamedTable("104", "Birth Legitimacy", DiceRoller::from("d20"), [
	"1-19" => SubtableInvoker(DiceRoller::from("d19+CuMod"), [
		"-18" => "Legitimate",
		"19-" => [ "Illegitimate", $illegit ],
	]),
	"20" => [ "Illegitimate", $illegit ],
]);
