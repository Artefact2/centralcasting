<?php

namespace HeroesOfLegend;

return new NamedTable("217A", "Travel", DiceRoller::from("d8"), [
	"1" => "Visit most major cities/towns in the land",
	"2" => "Sign on as seaman on a ship (gain rank 2 ranks of sailoring skills)",
	"3" => "Journey to the mountains",
	"4" => "Investigate nearby dark woods",
	"5" => "Travel to a distant land, learn foreign language (rank 3)",
	"6" => [ "Live with nonhumans", Invoker("751") ],
	"7-8" => [ "Combine (and discard conflicts):", Repeater(2, Invoker("217A")) ],
]);
