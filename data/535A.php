<?php

namespace HeroesOfLegend;

$cumod = $s->getActiveCharacter()->getModifier('CuMod');
$timod = $s->getActiveCharacter()->getModifier('TiMod');
$solmod = $s->getActiveCharacter()->getModifier('SolMod');

$td = [
	"LI" => "*Light Infantry (lightly armed and armored foot soldiers)",
	"MI" => "*Medium Infantry (medium armor and weapons foot soldiers)",
	"HI" => "*Heavy Infantry (heavily armored foot soldiers and knights)",
	"A" => "*Archer (longbowmen, crossbowmen)",
	"C" => "*Chariots (small, lightly armored carts drawn by two horses)",
	"LC" => "*Light Cavalry (not heavily armored, lancers and horse archers)",
	"HC" => "Heavy Cavalry (armored knights)",
	"M" => [ "*Mercenaries (warriors for hire)", Invoker("535A") ],
	"N" => "*Navy (sailors, marines)",
	"SF" => [ "*Special Forces", Invoker("537") ],
	"ND" => [ "*Noncombat duty", Invoker("536") ], /* XXX add 5 to all rolls on 535B */
];

if($solmod >= 8 || $timod > 0) {
	$ftd = [
		"1" =>    $td["LI"],
		"2" =>    $td["MI"],
		"3-4" =>  $td["HI"],
		"5" =>    $td["A"],
		"6-7" =>  $td["C"],
		"8" =>    $td["LC"],
		"9-16" => $td["HC"],
		"17" =>   $td["M"],
		"18" =>   $td["N"],
		"19" =>   $td["SF"],
		"20" =>   $td["ND"],
	];
} else if($cumod <= -2) {
	$ftd = [
		"1-12" =>  $td["LI"],
		"13-14" => $td["MI"],
		"15-16" => $td["A"],
		"17-18" => $td["LC"],
		"19-20" => $td["M"],
	];
} else if($cumod <= 2) {
	$ftd = [
		"1-3" =>   $td["LI"],
		"4-7" =>   $td["MI"],
		"8" =>     $td["A"],
		"9-10" =>  $td["C"],
		"11-15" => $td["LC"],
		"16-17" => $td["M"],
		"18-19" => $td["N"],
		"20" =>    $td["ND"],
	];
} else {
	$ftd = [
		"1" =>     $td["LI"],
		"2-6" =>   $td["MI"],
		"7-8" =>   $td["HI"],
		"9-10" =>  $td["A"],
		"11" =>    $td["C"],
		"12-13" => $td["LC"],
		"14" =>    $td["HC"],
		"15-16" => $td["M"],
		"17-18" => $td["N"],
		"19" =>    $td["SF"],
		"20" =>    $td["ND"],
	];
}

assert(is_array($ftd));
return new NamedTable("535A", "Type of Service", new DiceRoller("d20"), $ftd);
