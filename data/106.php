<?php

namespace HeroesOfLegend;

$grandparents = [
	"Maternal grandmother",
	"Maternal grandfather",
	"Paternal grandmother",
	"Paternal grandfather",
];

return new NamedTable("106", "Family", DiceRoller::from("d20+CuMod"), [
	"-8" => [ "Mother and Father only", function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->getModifier('LegitMod') > 0) {
			$s->invoke("106");
			return '';
		}
		
		$ac->setMother(Character::NPC('Mother'));
		$ac->setFather(Character::NPC('Father'));
	}],
	"9-12" => [ "Extended family", function(State $s) use($grandparents) {
			$ac = $s->getActiveCharacter();
			if($ac->getModifier('LegitMod') > 0) {
				$s->invoke("106");
				return '';
			}
		
			$gp = Roll("d4");
			$auc = Roll("d4");
			LineAdder(sprintf("Mother, Father, %d grandparent(s), %d aunts/uncles/cousins", $gp, $auc))($s);
			$ac->setMother(Character::NPC('Mother'));
			$ac->setFather(Character::NPC('Father'));

			$gpk = array_keys($grandparents);
			shuffle($gpk);
			$pick = array_slice($gpk, 0, $gp, true);
			foreach($pick as $p) $ac->setGrandparent($p, Character::NPC($grandparents[$p]));
		
			$ac->setNumCousins($auc);
		}],
	"13" => function(State $s) {
		$ac = $s->getActiveCharacter();
		if(Roll("d2") === 1) {
			/* XXX kinda arguable */
			$ac->setMother($gm = Character::NPC('Maternal grandmother'));
			$ac->setFather($gp = Character::NPC('Maternal grandfather'));
			$ac->setGrandparent(0, $gm);
			$ac->setGrandparent(1, $gp);
			return "Maternal grandparents only";
		} else {
			if($ac->getModifier('LegitMod') > 0) {
				$s->invoke("106");
				return '';
			}
		
			$ac->setMother($gm = Character::NPC('Paternal grandmother'));
			$ac->setFather($gp = Character::NPC('Paternal grandfather'));
			$ac->setGrandparent(2, $gm);
			$ac->setGrandparent(3, $gp);	
			return "Paternal grandparents only";
		}
	},
	"14" => function(State $s) use($grandparents) {
		$ac = $s->getActiveCharacter();
		$legit = $ac->getModifier('LegitMod') > 0;
		$gp = Roll($legit ? "d4" : "d2") - 1;
		$ac->setGuardian(Character::NPC($grandparents[$gp]));
		return $grandparents[$gp]." only";
	},
	"15" => function(State $s) {
		$ac = $s->getActiveCharacter();
		if(Roll("d2") === 1) {
			/* XXX kinda arguable */
			$ac->setMother(Character::NPC('Maternal aunt'));
			$ac->setFather(Character::NPC('Maternal uncle'));
			return "Maternal aunt and uncle";
		} else {
			if($ac->getModifier('LegitMod') > 0) {
				$s->invoke("106");
				return '';
			}
			$ac->setMother(Character::NPC('Paternal aunt'));
			$ac->setFather(Character::NPC('Paternal unle'));			
			return "Paternal aunt and uncle";
		}
	},
	"16" => function(State $s) {
		$ac = $s->getActiveCharacter();
		$legit = $ac->getModifier('LegitMod') > 0;
		switch(Roll($legit ? "d4" : "d2")) {
		case 1:
			$ac->setGuardian(Character::NPC("Maternal aunt"));
			return "Maternal aunt only";
		case 2:
			$ac->setGuardian(Character::NPC("Maternal uncle"));
			return "Maternal uncle only";
		case 3: 
			$ac->setGuardian(Character::NPC("Maternal aunt"));
			return "Paternal aunt only";
		case 4: 
			$ac->setGuardian(Character::NPC("Maternal aunt"));
			return "Paternal uncle only";
		}
	},
	"17-18" => [ "Mother only", function(State $s) {
		$s->getActiveCharacter()->setMother(Character::NPC('Mother'));
	}],
	"19" => [ "Father only", function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->getModifier('LegitMod') > 0) {
			$s->invoke("106");
			return '';
		}
		$ac->setFather(Character::NPC('Father'));
	}],
	"20" => [ "Guardian", function(State $s) {
		if(Roll("d20") <= 8) {
			$s->invoke("754");
		} else {
			$s->invokeTable("106", new RerollFilter(DiceRoller::from("d20+CuMod"), function($r) {
				return $r < 20;
			}));
			return "Orphaned at birth and adopted in another family";
		}
	}],
	"21-24" => [ "None known, left to fend for self", function(State $s) {
		$ac = $s->getActiveCharacter();
		$ac->setModifier('SolMod', -3);

		if($ac->getRootEntry()->findAndReplaceLines("103", [ "Destitute" ]) === null) {
			LineAdder("Change social status to Destitute")($s);
		}
	}],
	"25-27" => [ "None known, raised in Orphanage (GM rolls siblings)", function(State $s) {
		$ac = $s->getActiveCharacter();
		$ac->setModifier('SolMod', -1);

		if($ac->getRootEntry()->findAndReplaceLines("103", [ "Poor" ]) === null) {
			LineAdder("Change social status to Poor")($s);
		}
	}],
]);
