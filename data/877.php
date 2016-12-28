<?php

namespace HeroesOfLegend;

$td = [
	"Light Infantry" => [
		"d3", 0, 1, 0,
		"bow & sword, javelin & sling, javelin & short sword, sling & sword or javelin & spear",
		"small shield, leather or studded leather",
		null
	],
	"Medium Infantry" => [
		"d4", 0, 1, 0,
		"two handed spear, two handed axe & sword, axe & javelin or spear & sword",
		"medium shield, ringmail, studded leather or cuir bouilli",
		null
	],
	"Heavy Infantry" => [
		"d3+1", 0, 1, 0,
		"two handed spear, two handed axe & sword, axe & javelin or spear & sword",
		"medium or large shield, scale mail, chain mail or partial plate mail",
		null
	],
	"Archer" => [
		"d3", 0, 2, 0,
		"longbow or crosspow and short sword or axe",
		"cloth, leather or studded leather",
		null
	],
	"Chariots" => [
		"d4", "d2", 0, 0,
		"bow & sword, sword & lance, javelin & sword, lance & sword, lance & axe or crossbow & sword",
		"small or medium shield, leather, studded leather or cuir bouilli",
		null
	],
	"Light Cavalry" => [
		"d4", "d4", 1, 0,
		"bow, sword & lance, javelin & sword, lance & sword, lance & axe or crossbow & sword",
		"small or medium shield, leather, studded leather or cuir bouilli",
		null
	],
	"Heavy Cavalry" => [
		"d4", "d3+1", 1, 0,
		"bow, sword & lance; javelin, spear & sword or lance & axe",
		"medium shield, heavy or light scale mail, chainmail, or partial plate mail (Knights always wear plate mail if culture allows it)",
		null
	],
	"Mercenaries" => [
		0, 0, 0, 0, null, null,
		"Learn 1 skill of choice (at rank 2) even if it is outside unit's skills",
	],
	"Navy" => [
		"d3", 0, 0, "d4",
		"sword (cutlass); javelin & short sword or bow & sword",
		"small shield, cloth, leather or studded leather",
		null
	],
];

$doit = function(State $s, Entry $stype) use($td, &$doit) {
	$sts = $stype->getLines()[0] ?? '';
	
	foreach($td as $k => [ $combat, $horse, $forestry, $naval, $weapons, $armor, $more ]) {
		$pos = strpos($sts, $k);
		if($pos !== 0 && $pos !== 1) continue;

		Repeater(is_int($combat) ? $combat : Roll($combat),       Invoker("877A"))($s);
		Repeater(is_int($horse) ? $horse : Roll($horse),          Invoker("877B"))($s);
		Repeater(is_int($forestry) ? $forestry : Roll($forestry), Invoker("877C"))($s);
		Repeater(is_int($naval) ? $naval : Roll($naval),          Invoker("877D"))($s);
		if($weapons !== null) LineAdder("Weapon(s): ".$weapons)($s);
		if($armor !== null) LineAdder("Armor: ".$armor)($s);
		if($more !== null) LineAdder($more)($s);

		break;
	}
	
	foreach($stype->getChildren() as $sc) {
		$doit($s, $sc);
	}
};

SubentryCreator("877", "Military Skills", null, function(State $s) use($doit) {
	$aec = $s->getActiveCharacter()->getActiveEntry()->getNeighbors();

	while($aec !== []) {
		$c = array_pop($aec);
		if($c->getSourceID() !== "535A" && $c->getSourceID() !== "536") continue;
		$doit($s, $c);
		return;
	}

	LineAdder("<<No service found (535A/536), don't know what to do!>>>")($s);
})($s);
