<?php

namespace HeroesOfLegend;

return new NamedTable("863", "Gift or Legacy", DiceRoller::from("d20"), [
	"1" => [ "Weapon", Invoker("863A") ],
	"2" => [ "Guardianship of a young NPC ward", Invoker("761") ],
	"3" => [ "Unusual pet", Invoker("759") ],
	"4" => [ "Piece of jewelry", Invoker("863B") ],
	"5" => "Tapestry",
	"6" => "Anachronistic device (flashlight, sewing machine, Tardis, etc.)",
	"7" => "Key",
	"8" => "Locked or sealed book",
	"9" => "Shield",
	"10" => "Sealed bottle",
	"11" => "Tarnished old helmet",
	"12" => "Bound wooden staff",
	"13" => "Riding animal (horse, etc.)",
	"14" => [ "Deed to a property", Invoker("863C") ],
	"15" => "Musical instrument",
	"16" => [ "Piece of clothing", Invoker("863D") ],
	"17" => [ "Pouch of papers containing...", Invoker("863E") ],
	"18" => [ "Sealed trunk", function(State $s) {
		if(Roll("d100") > 60) return "Sealed trunk (empty)";

		Repeater(Roll("d3+1"), TableInvoker("863", new RerollFilter(DiceRoller::from("d20"), function($r) {
				return $r !== 18;
		})));
		return "Sealed trunk containing...";
	}],
	"19" => "Chain mail hauberk",
	"20" => [ "Magic and great plot significance version of...", TableInvoker("863", DiceRoller::from("d19")) ],
]);
