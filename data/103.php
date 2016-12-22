<?php

namespace HeroesOfLegend;

return new NamedTable(
	"103", "Social Status",
	DiceRoller::from(Roll("d100") <= 95 ? "d100+CuMod+TiMod" : "d100+CuMod"), [
		"-12" => [ "Destitute", ModifierIncreaser("SolMod", -3) ],
		"13-40" => [ "Poor", ModifierIncreaser("SolMod", -1) ],
		"41-84" => "Comfortable",
		"85" => TableInvoker("103", DiceRoller::from(Roll("d100") <= 95 ? "d100+TiMod" : "d100")),
		"86-94" => [ "Well-to-Do", ModifierIncreaser("SolMod", 2) ],
		"95-98" => [ "Wealthy", Combiner(ModifierIncreaser("SolMod", 4), function(State $s) {				
			if(Roll("d100") <= $s->getActiveCharacter()->getModifier('TiMod') + 1) {
				$s->getActiveCharacter()->increaseModifier('SolMod', 4);
				return "Extremely Wealthy";
			}
		})],
		"99-" => [ "Nobility", function(State $s) {
			if($s->getActiveCharacter()->getModifier('TiMod') > 0) {
				/* Character is already a noble! */
				$s->invoke("103");
				return '';
			}

			$s->getActiveCharacter()->increaseModifier('SolMod', 5);
			$s->invoke("758", "103");
		}],
	]);
