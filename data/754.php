<?php

namespace HeroesOfLegend;

/* XXX: develop parents/guardians further, table 114? */

return new NamedTable("754", "Guardian", DiceRoller::from("d20"), [
	"1-5" => [ "Relative", Invoker("753") ], /* XXX: generates a lot of nonsense */
	"6-8" => "Raised in an orphanage",
	"9-10" => [ "Adopted in another family", Invoker("106") ],
	"11" => [ "Raised by priests/monks in a temple", Invoker("864") ],
	"12" => [ "Raised by nonhumans", Invoker("751") ],
	"13" => [ "Sold into indentured servitude to pay parent's depts", Invoker("539") ],
	"14" => "Raised on the street by outcasts (beggars and prostitutes)",
	"15" => [ "Raised by a thieves' guild", Invoker("534") ],
	"16" => "Passed from relative to relative until reaching the age of majority",
	"17" => [ "Raised by an adventurer", Invoker("757") ],
	"18" => "Mysteriously disappears for ".Roll("d10")." year(s) without memories (GM special 978#754)",
	"19" => "Raised by beasts in the wild (wolves, tigers, bears, etc.)",
	"20" => [ "Raised by monsters", Invoker("756") ],
]);
