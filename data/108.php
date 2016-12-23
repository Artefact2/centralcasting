<?php

namespace HeroesOfLegend;

return new NamedTable("108", "Birth Order", DiceRoller::from("d20"), [
	"1-2" => "First born (+20% starting money)",
	"3-10" => function(State $s) {
		if($s->getActiveCharacter()->getNumSiblings() > 1) {
			return "Second born (+10% starting money)";
		} else {
			return "First born (+10% starting money)";
		}
	},
	"11-16" => function(State $s) {
		if($s->getActiveCharacter()->getNumSiblings() > 3) {
			return "Middle child";
		} else {
			$s->invoke("108");
		}
	},
	"17-18" => function(State $s) {
		if($s->getActiveCharacter()->getNumSiblings() > 1) {
			return "Second-to-last born (-10% starting money)";
		} else {
			return "Last born (-10% starting money)";
		}
	},
	"19-20" => "Last born (-20% starting money)",
]);
