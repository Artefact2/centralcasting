<?php

namespace HeroesOfLegend;

return new NamedTable("546A", "Inheritance", new DiceRoller("d8"), [
	"1-3" => "Character recives ".Roll("d10")."x starting money in cash",
	"4" => [ "Parent's estate is liquidated to pay off debts", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("But the debts remain unpaid, character is liable for ".Roll("d100")."x starting money")($s);
		}
	}],
	"5" => "Character receives nothing, parent's last will condemns character's lifestyle",
	"6" => [ "Character receives map, key and strange gift, somehow related (GM decides)", Invoker("863") ],
	"7" => "Character becomes heir to parent's estate, may assume control of lands, money, properties and possessions",
	"8" => [ "Character becomes heir to parent's estate, may assume control of lands, money, properties and possessions",
	         SubtableInvoker(new DiceRoller("d4"), [
		         "1" => "But character must first marry and produce an heir",
		         "2" => "But character must first change lifestyle (give up adventuring, become priest, etc.)",
		         "3" => "But character must perform task, mission or quest described in will (GM decides)",
		         "4" => "But character must devote life to championing the poor, week and downtrodden",
	         ])],
]);
