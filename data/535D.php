<?php

namespace HeroesOfLegend;

$spec = "d20-d20";
$ac = $s->getActiveCharacter();
if($ac->getMilitaryRank() >= 8 && $ac->getModifier('ViMod') > 0) {
	$spec .= "+".min(3, $ac->getModifier('ViMod'));
}

$fs = function(State $s, int $r) {
		$s->invokeTable("535D", new TrivialRoller(-$r));
};

return new NamedTable("535D", "Battle Event", new DiceRoller($spec), [
	"-m21" => $fs,
	"m20" => [ "Act of character reverses battle's outcome", function(State $s) {
		$s->getActiveCharacter()->increaseModifier('ViMod', 1);
		if(Roll("d6") === 6) {
			LineAdder("And character is recognised for it")($s);
			$s->getActiveCharacter()->promote($s);
		}
	}],
	"m19-m1" => $fs,
	"0-1" => [ "Carnage was awesome, ".Roll("d100")."% of character's side died", function(State $s) {
		LineAdder("Character fought poorly and almost died from serious injury")($s);
		$s->invoke("870");
		if(Roll("d6") === 6) {
			LineAdder("And character's military career ends")($s);
			$s->getActiveCharacter()->setEnlistedInMilitary(false);
		}
	}],
	"2" => "Serious casualties, character was injured and has an impressive scar",
	"3" => [ "Horror of battle causes character to develop an exotic personality feature", Invoker("649") ],
	"4-5" => function(State $s) {
		Repeater(Roll("d3+1"), Invoker("535D"))($s); /* XXX reroll conflicting results */
	},
	"6-7" => "Character sees action, but nothing noteworthy",
	"8" => [ "Character fought well and killed many", function(State $s) {
		if(Roll("d6") >= 5) {
			LineAdder("Improve one weapon skill by one rank (of choice)")($s);
		}
	}],
	"9" => [ "Character fought well with notable heroism, saved many comrades", function(State $s) {
		$s->getActiveCharacter()->promote($s);
		if(Roll("d6") >= 4) {
			LineAdder("Improve one weapon skill by one rank (of choice)")($s);
		}
	}],
	"10" => [ "Character is captured and enslaved, military service ends", function(State $s) {
		$s->getActiveCharacter()->setEnlistedInMilitary(false);
		$s->invoke("539");
	}],
	"11" => [ "Character is decorated for heroism", function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->getModifier('TiMod') === 0 && $ac->getMilitaryRank() >= 3) {
			/* XXX check if army serves a noble ugh */
			LineAdder("If army serves a noble, character is made a Knight")($s);
			$ac->increaseModifier('TiMod', Roll("d4"));
		}
	}],
	"12" => [ "Character was coward in battle", function(State $s) {
		if(Roll("d6") >= 5) {
			LineAdder("And no one else noticed")($s);
		} else {
			LineAdder("And others noticed")($s);
		}
	}],
	"13" => "Character's best friend dies at his/her side",
	"14" => "Character is only survivor of his/her unit",
	"15" => "Character deserts during battle, revealing to all his/her cravenly cowardice",
	"16" => function(State $s) {
		$mr = max(1, $s->getActiveCharacter()->getMilitaryRank());
		$deaths = Character::MILITARY_RANKS[$mr][0] * Roll("d10");
		return "Character is personally responsible for deaths of ".$deaths." comrade(s)/follower(s)";
	},
	"17" => "Character slays leader of enemy army",
	"18" => [ "Character's immediate superior officer is slain and assumes command", function(State $s) {
		$s->getActiveCharacter()->promote($s);
	}],
	"19" => [ "Character is accused of dereliction of duty and is court-martialed", function(State $s) {
		$s->getActiveCharacter()->demote($s);
	}],
	"20" => [ "Act of character reverses battle's outcome", function(State $s) {
		$s->getActiveCharacter()->increaseModifier('ViMod', -1);
		if(Roll("d6") === 6) {
			LineAdder("And character is recognised for it")($s);
			Repeater(Roll("d3"), function(State $s) { $s->getActiveCharacter()->demote($s); })($s);
		}
	}],
	"21" => [ "Victor's side suffers light casualties", TableInvoker("535D", new DiceRoller("2d10")) ], /* XXX reroll conflicts */
	"22" => [ "Loser's side is utterly destroyed", function(State $s) {
		if($s->getActiveCharacter()->getMilitaryRank() >= 3) {
			$s->getActiveCharacter()->increaseModifier('ViMod', 1);
		}
	}],
	"23-" => function(State $s) {
		/* This can happen when 535B:13 rolls high. The book doesn't
		 * really say what to do in this uncharted territory. */
		$s->invokeTable("535D", new DiceRoller("d4"), true);
		return '';
	},
]);
