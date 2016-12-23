<?php

namespace HeroesOfLegend;

/* NB: book says to roll d10 but has no value for 8 */
return new NamedTable("863B", "Jewelry", DiceRoller::from("d9"), [
	"1" => "Amulet",
	"2" => "Necklace",
	"3" => "Earrings",
	"4" => "Tiara",
	"5" => "Torc (one piece neck ring)",
	"6" => "Arm band",
	"7" => "Ring",
	"8" => "Pin or brooch",
	"9" => [ "Extremely valuable piece", TableInvoker("863B", DiceRoller::from("d8")) ],
]);
