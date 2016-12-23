<?php

namespace HeroesOfLegend;

return new NamedTable("217B", "Wrongful Accusation Consequence", DiceRoller::from("d6"), [
	"1" => [ "Character is imprisoned", Combiner(DarksideTrait(), Invoker("540")) ],
	"2" => [ "Character is publicly stockaded and flogged as example, -33% Charisma", DarksideTrait() ],
	"3" => [ "Character is tortured to reveal names of accomplices", Combiner(
		DarksideTrait(), function(State $s) {
			if(Roll("d6") < 6) return;
			LineAdder("And receives a serious wound")($s);
			$s->invoke("870");
		})],
	"4" => [ "Character is found innocent but suffered serious humiliation, -".Roll("d3")." Charisma", DarksideTrait() ],
	"5" => [ "Character is sentenced to death, but rescued by notorious outlaws", function(State $s) {
		if($s->getActiveCharacter()->getAgeRange() === Character::ADULT) {
			NeutralTrait()($s);
		} else {
			DarksideTrait()($s);
		}
			
		if(Roll("d6") < 6) return;
		LineAdder("And joins the outlaws for ".Roll("d6")." year(s)")($s);
		$s->invoke("534C"); /* XXX check flow, book says to begin with 534C but 534 for adolescents */
	}],
	"6" => [ "Character sold into slavery", Combiner(DarksideTrait(), Invoker("539")) ],
]);
