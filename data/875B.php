<?php

namespace HeroesOfLegend;

/*<<< Name: Victim & Punishment >>>*/

$ac = $s->getActiveCharacter();
$ae = $ac->getActiveEntry();

if($ae->getSourceID() !== "875") {
	/* No crime? */
	return;
}

$punishments = [];

$traverse = function(Entry $e) use(&$punishments, &$traverse) {
	if($e->getSourceID() !== "875A") return;
		
	foreach($e->getLines() as $l) {
		if(preg_match('%\s\(([1-9][0-9]*|DD?)\)((,|\sor)\s\(([1-9][0-9]*|DD?)\))*$%', $l, $match)) {
			$punishments[] = substr($match[0], 1);
			$e->replaceLine($l, substr($l, 0, -strlen($match[0])) ?: null);
		}
	}

	foreach($e->getChildren() as $c) {
		$traverse($c);
	}
};

$ptable = [
	"1" => Roll("d3")." year(s) imprisonment",
	"2" => Roll("d4")." year(s) imprisonment",
	"3" => Roll("d6")." year(s) imprisonment",
	"4" => Roll("d8")." year(s) imprisonment",
	"5" => Roll("2d4")." years imprisonment",
	"6" => Roll("2d8")." years imprisonment",
	"7" => Roll("d10")." year(s) imprisonment",
	"8" => Roll("2d10")." years imprisonment",
	"9" => "Heretic is imprisoned until heresy is renounced (or burned, or ".Roll("2d10")." years imprisonment)",
	"10" => "NPCs put to death, life sentence (".Roll("d20+20")." years imprisonment) for PCs",
	"11" => Roll("d6")." year(s) imprisonment",
	"12" => "5 years imprisonment",
	"13" => "Pilloried (placed on public display in stocks for a week, -".Roll("d4")." Charisma)",
	"14" => "Publicly flogged (-".Roll("d4")." Charisma)",
	"15" => "Dominant hand cut off (-1 Dexterity, -1 Appearance)",
	"16" => "Tortured",
	"17" => "Branded (brand indicates the crime)",
	"D" => null,
	"DD" => null,
];

$pactions = [
	"16" => function(State $s) { if(Roll("d6") === 6) $s->invoke("870"); },
];

$c = $ae->getChildren();
$lc = end($c);
assert($lc->getSourceID() === "875A");
$traverse($lc);
assert($punishments !== []);

$ve = new Entry("875V", "Crime Victim", null);
$lc->addChild($ve);
$pe = new Entry("875B", "Punishment", null);
$lc->addChild($pe);

$ac->setActiveEntry($ve);
$s->invoke("750");

/* XXX ideally figure out a way to add TiMod if noble was generated by 750 */
CharacterSandboxer(true, $vchar, Invoker("103"))($s);

/* XXX not always perfect (750 can nest in itself, noble isn't always going to be at the top */
if($vchar->getModifier('TiMod') > 0 || $ve->findDescendantByID("750")->getLines()[0] === "Noble person") {
	$ptable["D"] =& $ptable["12"];
	$ptable["DD"] =& $ptable["10"];
} else {		
	if($vchar->getModifier('SolMod') > $ac->getModifier('SolMod')) {
		$ptable["D"] =& $ptable["11"];
	}
}
if($ac->getModifier('TiMod') > 0) {
	/* PC is noble, pays a fine instead of going to jail */
	$ptable["1"] = Roll("d3*1000")." gp fine";
	$ptable["2"] = Roll("d4*1000")." gp fine";
	$ptable["3"] = Roll("d6*1000")." gp fine";
	$ptable["4"] = Roll("d8*1000")." gp fine";
	$ptable["5"] = Roll("2d4*1000")." gp fine";
	$ptable["6"] = Roll("2d8*1000")." gp fine";
	$ptable["7"] = Roll("d10*1000")." gp fine";
	$ptable["8"] = Roll("2d10*1000")." gp fine";
}
$ac->setActiveEntry($lc);
	
foreach($punishments as $p) {
	$p = explode(', ', $p);
	foreach($p as $x) {
		$x = explode(' or ', $x);

		if(count($x) === 1) {
			$addto = $pe; 
		} else {
			$addto = new Entry("875", "Choose one of", null);
			$pe->addChild($addto);
		}
			
		foreach($x as $y) {
			$pref = substr($y, 1, -1);
			assert(array_key_exists($pref, $ptable)); /* Fuck you, isset. */
			if(isset($pactions[$pref])) $pactions[$pref]($s);
			$addto->addLine($ptable[$pref]);
		}
	}
}

$ac->setActiveEntry($ae);

/* XXX if imprisoned, invoke 540 */
/* XXX reduce prison time for wealthy chars */