<?php

namespace HeroesOfLegend;

/* XXX reroll nonsensical rolls (which implies keeping a LOT more state) */

return new NamedTable("528", "Tragedy", DiceRoller::from("d20+SolMod"), [
	"m2" => [ "Wild carnivorous beasts attack", function(State $s) {
		LineAdder("And character gets severely injured")($s);
		$s->invoke("870");
		$frags = Roll("d4");
		LineAdder("And devour ".$frags." family member(s)/guardian/friend(s)")($s);
		Repeater($frags, Invoker("753"))($s);
	}],
	"m1" => TableInvoker("528", DiceRoller::from("d20")),
	"0" => [ "Imprisoned for a crime character did not commit", Invoker("875", "540") ],
	"1" => [ "One of character's children dies", SubtableInvoker(DiceRoller::from("d6"), [
		"1-2" => "Accident",
		"3" => "Fire",
		"4-5" => "Disease",
		"6" => [ "Someone's actions", Invoker("750", "545") ], /* Typo in the book (443->545) */
	])],
	"2" => [ "Parents/guardian unable to pay taxes and get imprisoned", Invoker("546") ],
	"3" => [ "Favorite pet dies painfully", function(State $s) {
		if(Roll("d6") <= 4) return;
		LineAdder("And the death was caused by someone else")($s);
		$s->invoke("750");
	}],
	"4" => [ "Character gets orphaned!", Invoker("546") ],
	"5" => [ "Village/small town/part of city is wiped out", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("(Optional) And entire city is destroyed")($s);
		}
		/* XXX family can die here */
		$s->invoke("528A");
	}],
	"6" => [ "Character responsible for someone's death", Invoker("750", "545") ],
	"7" => [ "Character gets orphaned!", Invoker("546") ],
	"8" => [ "Family/guardian(s) is wiped out", function(State $s) {
		/* XXX close family can die here */
		$s->invoke("528A");
	}],
	"9" => [ "Favorite (possibly valuable) possession vanishes", SubtableInvoker(DiceRoller::from("d6"), [
		"1-3" => "It was lost",
		"4-5" => "It was stolen",
		"6" => "It was stolen and fake left in its place",
	])],
	"10" => [ "Character's parent(s) outlawed and goes into hiding", Combiner(SubtableInvoker(DiceRoller::from("d6"), [
		"1-3" => [ "Father", LineAdder(Roll("d6") <= 2 ? "And rest of family follows him" : null) ],
		"4" => [ "Mother", LineAdder(Roll("d6") <= 4 ? "And rest of family follows her" : null) ],
		"5-6" => [ "Both parents", LineAdder(Roll("d6") <= 5 ? "And rest of family follows them" : null) ],
	]), function(State $s) {
		if(Roll("d6") <= 4) return;
		LineAdder("And parents hide in a different culture level");
		/* XXX only change CuMod if character actually follows */
		$s->getActiveCharacter()->setModifier('CuMod', 0);
		$s->invoke("103");
	})],
	"11" => [ "Character sold into slavery", Invoker("539") ],
	"12" => [ "Character receives severe injury", Combiner(Invoker("870"), SubtableInvoker(DiceRoller::from("d8"), [
		"1-4" => "Accident",
		"5" => "Terrible fire",
		"6" => "Animal attack",
		"7-8" => [ "Attacked by someone else", Invoker("750") ],
	]))],
	"13" => [ (Roll("d2") === 1 ? "Mother/female guardian" : "Father/male guardian")." dies",
	          SubtableInvoker(DiceRoller::from("d6"), [
		          /* XXX reroll if no/one parent */
		          "1-4" => "Accident",
		          "5-6" => [ "Someone's actions", Invoker("750", "545") ],
	          ])],
	"14" => [ "Banned from performing primary occupation", LineAdder("And cast out of any guild associated with occupation") ],
	"15" => [ "Something terrible happens to lover", SubtableInvoker(DiceRoller::from("d10"), [
		/* XXX reroll if no lover */
		"1" => "Lover is unfaithful, leaves character heartbroken",
		"2" => [ "Lover attempts to kill character and disappears", function(State $s) {
			if(Roll("d6") === 6) {
				LineAdder("And character gets severely injured")($s);
				$s->invoke("870");
			}
		}],
		"3" => "Lover tries to kill character, dies in attempt",
		"4" => "Lover dies of disease",
		"5" => "Lover dies in a fire",
		"6" => "Lover dies in an accident",
		"7" => "Lover killed by own jealous former lover",
		"8" => "Lover disappears and is never seen again",
		"9" => "Lover comes out as homosexual",
		"10" => [ "Lover is imprisoned for a crime", Invoker("875") ],
	])],
	"16" => [ "Disease almost kills character and leaves horrible scars",
	          LineAdder("-".Roll("d4")." Charisma and -".Roll("d4")." Appearance") ],
	"17" => [ "War ravages homeland, more tragedies occur", SubtableInvoker(DiceRoller::from("d6"), [
		"1-2" => Invoker("528"),
		"3-4" => Repeater(2, Invoker("528")),
		"5" => Repeater(Roll("d3"), Invoker("528")),
		"6" => [ "If 14 or older, character conscripted into military duty", Combiner(
			Repeater(Roll("d3"), Invoker("528")),
			Invoker("535")
		)],
	])],
	"18" => [ "Fire destroys character's home, all belongings are destroyed", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("And social status drops by one level")($s);
			$ac = $s->getActiveCharacter();
			if($ac->getModifier('SolMod') >= -1) $ac->increaseModifier('SolMod', -2);
		}
	}],
	"19" => [ "Character is cursed", Invoker("868") ],
	"20" => [ "Best friend dies", Invoker("545") ],
	"21" => [ "Family estate destroyed", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => "A revolt",
		"2-3" => "A terrible fire",
		"4" => "An unexplainable incident",
		"5" => "War",
		"6" => [ "Someone's actions", function(State $s) {
			$s->invoke("750");
			LineAdder("And all belongings are destroyed")($s);
			if(Roll("d6") === 6) {
				LineAdder("And social status drops by one level")($s);
				$s->getActiveCharacter()->increaseModifer('SolMod', -2);
			}
		}],
	])],
	"22" => [ "Imprisoned for crime character did not commit", Invoker("875", "540") ],
	"23" => TableInvoker("528", DiceRoller::from("d20")),
	"24" => [ "Family loses all its wealth", function(State $s) {
		$ac = $s->getActiveCharacter();
		$ac->setModifier('SolMod', 0);
		$ac->setModifier('TiMod', 0);
		$s->invokeTable("103", new TrivialRoller(-30), true);
	}],
	"25" => [ "Character is disinherited by parents", function(State $s) {
		$ac = $s->getActiveCharacter();
		$ac->setModifier('SolMod', 0);
		$ac->setModifier('TiMod', 0);
		$s->invokeTable("103", new TrivialRoller(-10), true); /* XXX -45 if no primary occupation (rank >= 3) */
	}],
	"26-27" => [ "Character forced in political marriage", function(State $s) {
		/* XXX figure out when to show this */
		LineAdder("And previous spouse (if applicable) \"disappears\"")($s);
		LineAdder("And new spouse dislikes character")($s);
	}],
	"28-29" => "Severe inflation, money loses 9/10th of its value", /* XXX it's complicated */
	"30-31" => TableInvoker("528", DiceRoller::from("d20")),
	"32" => [ "Main source of income is utterly destroyed", function(State $s) {
		LineAdder("And social status drops by one level")($s);
		$s->getActiveCharacter()->increaseModifier('SolMod', -2);
	}],
	"33" => [ "Family stripped of all titles and land by ruler", function(State $s) {
		$ac = $s->getActiveCharacter();
		$ac->setModifier('SolMod', 0);
		$ac->setModifier('TiMod', 0);
		$s->invokeTable("103", new TrivialRoller(-10), true);
		
		if(Roll("d6") === 6) {
			/* XXX "see 10" */
			LineAdder("And family is outlawed")($s);
		}
	}],
]);
