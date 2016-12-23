<?php

namespace HeroesOfLegend;

return new NamedTable("539C", "Death Consequence", DiceRoller::from("d6"), [
	"1" => "Sold to a new owner", /* XXX */
	"2" => [ "Freed", Invoker("539B") ],
	"3" => [ "ALL owner possesions must be buried with him", Combiner(LineAdder("But character escapes!"), Invoker("539A")) ],
	"4" => [ "All slaves now owned by owner's relative", Invoker("753") ],
	"5" => [ "Accused of killing the owner", function(State $s) {
		LineAdder("Character escapes but death hangs over his/her head")($s);
		$s->invoke("545");
		$s->getActiveCharacter()->free();
	}],
	"6" => [ "Freed by owners will and became heir", function(State $s) {
		LineAdder("Assume control of all property and slaves")($s);
			
		if(Roll("d10") < 5) {
			$s->getActiveCharacter()->free();
			return;
		}

		LineAdder("But family has will voided, back to enslavement")($s);
	}],
]);
