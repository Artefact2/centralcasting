<?php

namespace HeroesOfLegend;

return new NamedTable("419B", "Apprenticeship Event", DiceRoller::from("d10"), [
	"1" => [ "Master noted for strong, often annoying personality", function(State $s) {
		LineAdder("Character cannot stand to be around anyone acting in the same manner")($s);
		
		$s->invokeTable("318A", new TrivialRoller($roll = Roll("d100")));
		if($roll <= 50) {
			/* Rolled 1-50 */
			$s->invoke("649");
		}
	}],
	"2" => [ "Character accidentally breaks master's valuable collection of sculptured ceramic chamber pots",
	         LineAdder("Apprenticeship ends after ".Roll("d4")." year(s)") ],
	"3" => [ "Character stumbled upon a lost secret of the craft",
	         LineAdder("master takes credit but only part of secret was revealed") ],
	"4" => "Character continues to study with master for additional ".Roll("d6")." year(s)",
	"5" => "Character discovers master's shop is a front office for vast criminal network",
	"6" => "Master is world-renowned with legendary skill",
	"7" => "Other apprentice becomes character's best friend",
	"8" => [ "Exotic event occurs in the master's shop", Combiner(
		LineAdder(Roll("d2") === 1 ? 'Affects the character' : 'Affects the master'),
		Invoker("544")
	)],
	/* XXX reroll "conflicts" */
	"9" => [ "Character accompanies master on long, eventful journeys", Repeater(Roll("d3"), Invoker("217")) ],
	"10" => Repeater(2, Invoker("419B")), /* XXX reroll "conflicts" */
], RandomTable::REROLL_DUPLICATES);
