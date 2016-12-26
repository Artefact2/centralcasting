<?php

namespace HeroesOfLegend;

return new NamedTable("543C", "What?", DiceRoller::from("2d8"), [
	"2" => "Travel widely with patron, learn the land",
	"3" => [ "Patron is in love with character (may be one sided)", Invoker("542") ], /* XXX set spouse? */
	"4" => "Patron provides for character's formal education",
	"5" => [ "Patron dies while character is in service", function(State $s) {
		$p = $s->getActiveCharacter()->getPatron();
		if($p !== null) $p->kill();
	}],
	"6" => [ "Patron has rival who has threatened character's life", Invoker("762") ],
	"7" => [ "Character leaves patron after ".Roll("d6")." year(s)", function(State $s) {
		$s->getActiveCharacter()->setPatron(null);
	}],
	"8" => [ "Patron is noted for exotic personality", Invoker("649") ],
	"9" => [ "Patron introduces character to his ward (of opposite sex)", Combiner(
		LineAdder("And character instantly falls in love"),
		Invoker("542") /* XXX set spouse? */
	)],
	"10" => "Patron trains character in sword use (+".Roll("d4")." rank(s))",
	"11" => [ "Patron requires character to perform criminal acts", Invoker("875A") ], /* XXX or 875? */
	"12" => "Patron is outlawed, character is watched closely by (secret) police",
	"13" => [ "Patron is noted for a physical affliction", Invoker("874") ],
	"14" => "Learn an occupation (at rank ".Roll("d3").")",
	"15" => [ "Patron sets character up in business (owned by patron, run by character)", Invoker("423") ],
	"16" => [ "Patron introduces character to several very influential people",
	          LineAdder("The kind that often hires mercenaries and adventurers") ],
]);
