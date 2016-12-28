<?php

namespace HeroesOfLegend;

return new NamedTable("529", "Wonderful Event", DiceRoller::from("d20+SolMod"), [
	"m2" => [ "Wild carnivorous beasts invade character's camp", LineAdder("And character finds out he can command wild beasts") ],
	"m1" => [ "Get out of jail free (all prisoners are pardoned)", function(State $s) {
		$s->getActiveCharacter()->setImprisoned(false);
	}],
	"0-1" => function(State $s) {
		if(!$s->getActiveCharacter()->hasSpouse()) {
			$s->invoke("529");
			return '';
		}

		return [ /* XXX track children ? */
			"Character is blessed with birth of healthy & beautiful male child",
			"Character is blessed with birth of healthy & beautiful female child",
		][Roll("d2-1")];
	},
	"2" => [ "Character finds magical item while repairing family home", Invoker("863") ],
	"3" => [ "Character acquires unusual pet", Invoker("759") ],
	"4" => function(State $s) {
		$s->invoke("106", "114");
		$ac = $s->getActiveCharacter();
		return [
			"Character is adopted in wealthy family",
			"Character is treated like a son in a wealthy family",
		][(int)($ac->hasMother() || $ac->hasFather() || $ac->hasGuardian())];
	},
	"5" => [ "Character's village/city portion is destroyed", function(State $s) {
		LineAdder("But gets rebuilt and is more prosperous")($s);
		if($s->getActiveCharacter()->getModifier('SolMod') <= 2) {
			$s->getActiveCharacter()->increaseModifier('SolMod', 2);
			LineAdder("And character (and family) raises one social level")($s);
		}
	}],
	"6" => [ "Character responsible for saving a life", function(State $s) {
		$s->invoke("750", "545");
		CharacterSandboxer(false, $other, Invoker("103"))($s);
		if($other->getModifier('SolMod') >= 2) {
			LineAdder("And character receives reward from near-victim")($s);
		}
	}],
	"7-9" => TableInvoker("529", DiceRoller::from("d20")),
	"10" => [ "Evil local ruler outlaws character's parents", Combiner(
		Invoker("758"),
		LineAdder("But after ".Roll("d10")." years evil ruler is overthrown"),
		LineAdder("And parents are pardoned and get elevated to nobility (1 rank below overthrown evil ruler)")
	)],	
	"11" => [ "Slavery gets outlawed in land, all slaves are freed", function(State $s) {
		$s->getActiveCharacter()->setEnslaved(false);
	}],
	"12" => [ "Character receives severe injury that does not heal properly", Combiner(
		Invoker("870"),
		LineAdder("But benevolent wizard replaces damaged limb/organ with magical prosthesis"),
		LineAdder("And it grants character a magic power (GM decides)")
	)],
	"13-14" =>  [ "Character becomns renowned for his occupation", function(State $s) {
		$ac = $s->getActiveCharacter();
		$solmod = $ac->getModifier('SolMod');
		if($solmod <= 0) {
			$r = Roll("d2");
			$ac->increaseModifier('SolMod', 2 * $r);
			LineAdder("Infux of business makes character increase social status by ".$r." level(s)")($s);
		} else if($solmod <= 2) {
			$ac->increaseModifier('SolMod', 2);
			LineAdder("Infux of business makes character increase social status by one level")($s);
		}
	}],
	"15-16" => "Disease almost kills character, but becomes miraculously immune to it (or all disease)",
	"17-18" => [ "Character is blessed", Invoker("869") ],
	"19" => [ "Lasting peace takes hold in the land", function(State $s) {
		/* XXX discharge character if in military */
	}],
	"20" => [ "Character gains loyal friend and companion", Invoker("761") ],
	"21" => [ "Family home is declared a national treasure",
	          LineAdder("And government pays for its restoration and maintenance") ],
	"22-23" => TableInvoker("529", DiceRoller::from("d20")),
	"24-25" => function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->hasMother() || $ac->hasFather()) {
			return "Character becomes parents' sole heir";
		}
		$s->invoke("529");
	},
	"26-27" => [ "Character is forced in unwanted marriage", function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->hasSpouse()) {
			$s->invoke("529");
			return '';
		}
		
		LineAdder("But quickly loves (and even worship) spouse")($s);
		$ac->setSpouse(Character::NPC("PC's spouse"));
	}],
	"28-29" => [ "Shift in economy increases value of precious metals", function(State $s) {
		$ac = $s->getActiveCharacter();
		$solmod = $ac->getModifier('SolMod');
		if($solmod >= 0 && $solmod < 4) {
			$ac->increaseModifier('SolMod', 2);
			LineAdder("Character raises one social level")($s);
		} else if($solmod === 4 && Roll("d100") === 100) {
			$ac->increaseModifier('SolMod', 4);
			LineAdder("Character becomes extremely wealthy")($s);
		}
	}],
	"30-32" => [ "New market opens up for main source of character's income",
	             LineAdder("And several new estates are established in foreign countries") ],
	"33" => [ "Ruler of the land consolidates feifs and eliminates troublemakers",
	          LineAdder("Character's parents gain one nobility title level") ],
]);
