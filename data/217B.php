<?php

Table($s, "217B", "Wrongful Accusation Consequence", Roll(6), [
	"1" => [ "Character is imprisoned", Combiner(DarksideTrait($s), Invoker($s, "540")) ],
	"2" => [ "Character is publicly stockaded and flogged as example, -33% Charisma", DarksideTrait($s) ],
	"3" => [ "Character is tortured to reveal names of accomplices", Combiner(
		DarksideTrait($s), function() use(&$s) {
			if(Roll(6) < 6) return;
			$s->char->entries[] = [ "", "", "And receives a serious wound" ];
			Invoke($s, "870");
		})],
	"4" => [ "Character is found innocent but suffered serious humiliation, -".Roll(3)." Charisma", DarksideTrait($s) ],
	"5" => [ "Character is sentenced to death, but rescued by notorious outlaws", function() use(&$s) {
			if($s->char->ageRange === Character::ADULT) {
				NeutralTrait($s)();
			} else {
				DarksideTrait($s)();
			}
			
			if(Roll(6) < 6) return;
			$s->char->entries[] = [ "", "", "And joins the outlaws for ".Roll(6)." year(s)" ];
			Invoke($s, "534C"); /* XXX check flow, book says to begin with 534C but 534 for adolescents */
		}],
	"6" => [ "Character sold into slavery", Combiner(DarksideTrait($s), Invoker($s, "539")) ],
]);
