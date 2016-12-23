<?php

namespace HeroesOfLegend;

return new NamedTable("649E", "Behavior Tag", DiceRoller::from("d20"), [
	"1" => "Absentminded (misplaces things easily)",
	"2" => [ "Addict (eg tobacco, alcohol, narcotics)", DarksideTrait() ],
	"3" => [ "Anarchist (believes every man should rule himself)", NeutralTrait() ],
	"4" => [ "Distinctive possession", Invoker("863") /* XXX "roll until you get something you are comfortable with */ ],
	"5" => [ "Ego signature (cannot do anything anonymously)", NeutralTrait() ],
	"6" => "Hiccupping (brought on by stress or eating)",
	"7" => "Insomniac",
	"8" => [ "Know-it-all", NeutralTrait() ],
	"9" => [ "Neatnik (obsessively neat person)", Combiner(NeutralTrait(), function(State $s) {
		if(Roll("d100") <= 10) LineAdder("And has a dirt phobia")($s);
	})],
	"10" => "Stuttering (-d4 Charisma when talking, +25% Spellcasting difficulty)",
	"11" => [ "Pet lover (has many pets)", LightsideTrait() ],
	"12" => [ "Political activist", LightsideTrait() ],
	"13" => "Practical joker",
	"14" => "Secret identity (maintains two separate identities)",
	"15" => "Slob (disorganized and unconcerned about appearance)",
	"16" => [ "Packrat (picks up everything, never throws anything away)", NeutralTrait() ],
	"17" => "Unique physical habit (unconscious action eg rapid blinking, twisting hair, rubbing part of face/body etc.)",
	"18" => [ "Vandal (defaces or destroys property)", DarksideTrait() ],
	"19" => [ "Yes-Man (no personal opinions or convictions)", NeutralTrait() ],
	"20" => Repeater(Roll("d3+1"), Invoker("649E")),
]);
