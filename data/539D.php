<?php

namespace HeroesOfLegend;

return new NamedTable("539D", "Enslaved Event", DiceRoller::from("d20"), [
	"1" => [ "Character escaped", Invoker("539A") ],
	"2" => [ "Willingly freed by owner", Invoker("539B") ],
	"3" => [ "Ruler of the land declared slavery illegal, got free with ".Roll("d100")." gp", function(State $s) {
		$s->getActiveCharacter()->setEnslaved(false);
	}],
	"4" => [ "Bought my freedom, remain as employee for ".Roll("d4")." year(s)", function(State $s) {
		$s->getActiveCharacter()->setEnslaved(false);
	}],
	"5" => [ "Owner dies", Invoker("539C") ],
	"6-7" => "Improves occupational skill by 1 rank", /* XXX */
	"8" => "Improve occupational skill by ".Roll("d3+1")." rank(s)", /* XXX */
	"9" => "Often beaten by owner",
	"10" => "Learn an additional occupation at rank 1 from owner's culture", /* XXX */
	"11" => "Become sexual plaything of the owner", /* XXX */
	"12" => [ "Participate in a slave revolt", function(State $s) {
		if($leader = (Roll("d6") === 6)) {
			LineAdder("And led the revolt")($s);
		}
		if($success = (Roll("d6") >= 5)) {
			LineAdder("And revolt succeeded")($s);
			$s->getActiveCharacter()->setEnslaved(false);
		} else {
			LineAdder("But revolt failed")($s);
		}
		if($killed = (Roll("d6") === 6)) {
			LineAdder("And owner is killed")($s);
			if(!$success) {
				$s->invoke("539C");
				return;
			}
		}
		if($success) {
			$s->invokeTable("539D", new TrivialRoller(1));
			if($leader) {
				LineAdder("Now have ".($f = Roll("d6"))." low-ability NPC follower(s)")($s);
				Repeater($f, Invoker("761C"))($s);
			}
		} else {
			LineAdder("Tortured and received a permanent injury")($s);
			$s->invoke("870");
		}
	}],
	"13" => "Promoted to a position of authority",
	"14" => [ "Become owner's favorite, senior slave in the household, another slaves becomes rival", Invoker("762") ],
	"15" => "Used as breeding stock", /* XXX */
	"16" => "Resold ".Roll("d3")." time(s)", /* XXX */
	"17" => function(State $s) {
		$s->invoke("867");
		if(Roll("d6") >= 5) {
			return "Branded (very recognisable slave brand)";
		} else {
			return "Branded (not recognisable unless inspected closely)";
		}
	},
	"18" => [ "Escape attempt fails, gets branded and beaten", function(State $s) {
		$s->invokeTable("539D", new TrivialRoller(17));
		if(Roll("d6") === 6) {
			$s->invoke("870");
		}
	}],
	"19-20" => [ "Enslaved for ".Roll("d4")." more year(s)",
	             Repeater(Roll("d3"), TableInvoker("539D", DiceRoller::from("d20+1"))) ],
	"21" => [ "Exotic event frees character", function(State $s) {
		$s->invoke("544");
		$s->getActiveCharacter()->setEnslaved(false);
	}],
]);
