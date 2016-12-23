<?php

namespace HeroesOfLegend;

return new NamedTable("762A", "Who?", DiceRoller::from("d10"), [
	"1" => [ "Former lover", function(State $s) {
		if($s->getActiveCharacter()->getAgeRange() === Character::CHILD) {
			$s->invoke("762A");
			return '';
		}
	}],
	"2" => [ "Family member", Invoker("753") ],
	"3" => [ "Nonhuman", Invoker("751") ],
	"4" => [ "Stranger", Invoker("750") ],
	"5" => "Former friend",
	"6" => "Enemy of the family",
	"7" => function(State $s) {
		$sibling = $s->getActiveCharacter()->pickRandomSibling();
		if($sibling === null) return '';
		return $sibling;
	},
	"8" => "Professional rival (with same occupation)",
	"9" => "Friend (rivalry other than friendly is kept secret)",
	"10" => function(State $s) {
		if(($r = Roll("d10")) === 10) {
			$s->invoke("864");
			return "Deity";
		}
		$s->invokeTable("762A", new TrivialRoller($r));
	}
]);
