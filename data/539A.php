<?php

namespace HeroesOfLegend;

$nt = new NamedTable("539A", "Escape consequence", DiceRoller::from("d8"), [
	"1" => "Offered ".Roll("d10*100")." gp reward",
	"2" => "Accompanied by ".Roll("d6")." slaves",
	"3" => "Government pays a bounty of ".Roll("d10*10")." gp for escaped slaves",
	"4" => [ "Aided by relative", Invoker("753") ],
	"5" => [ "Forced to kill the owner during escape", LineAdder("And own life will be forfeit if caught") ],
	"6" => [ "Stole an item of value during escape",
	         Combiner(LineAdder("And owner wants it back desperately"), Invoker("863")) ],
	"7" => [ "Owner (or spouse) secretely in love with character",
	         LineAdder("And helps him/her escape without his/her knowledge") ],
	"8" => Repeater(Roll("d2+1"), TableInvoker("539A", DiceRoller::from("d7"))),
]);

$nt->addPostExecuteHook(function(State $s) {
	$s->getActiveCharacter()->free();
});

return $nt;
