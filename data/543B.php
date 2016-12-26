<?php

namespace HeroesOfLegend;

return new NamedTable("543B", "Why?", DiceRoller::from("d8"), [
	"1" => function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->hasMother() || $ac->hasFather()) {
			return 'Parent was allied to the patron';
		} else {
			$s->invoke("543B");
			return '';
		}
	},
	"2" => "Patron admires character's skills",
	"3" => "Patron has sexual interest in character",
	"4" => "Patron needs all the friends he can get",
	"5" => "Patron needs character's skills",
	"6" => "Character was chosen at random",
	"7" => "Character is part of complicated wager",
	"8" => "Character is being prepared for special task (GM decides)",
]);
