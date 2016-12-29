<?php

namespace HeroesOfLegend;

return new NamedTable("871", "Special Nobility Title", DiceRoller::from("d1"), [
	"1" => function(State $s) {
		$s->invoke("871A", "871B", "871C");
		$e = $s->getActiveCharacter()->getActiveEntry();
		
		$ch = $e->getChildren();
		assert(count($ch) === 3);

		$line = null;
		foreach($ch as $c) {
			$l = $c->getLines();
			assert(count($l) === 1);
			$c->replaceLine($l[0], null);
			
			if($l[0] === '') continue;
			if($line === null) $line = $l[0];
			else $line .= ' '.$l[0];
		}

		$e->addLine($line);
	},
]);
