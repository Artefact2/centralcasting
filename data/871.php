<?php

Table($s, "871A", "", Roll(1, 20), [
	"1" => "Commander of the",
	"2" => "Custodian of the",
	"3" => "Grim Sentinel of the",
	"4" => "High Champion of the",
	"5" => "Honored Defender of the",
	"6" => "Iron Tower of the",
	"7" => "Lord Protector of the",
	"8" => "Liberator of the",
	"9" => "Lord Governor of the",
	"10" => "Lord Guardian of the",
	"11" => "Keeper of the",
	"12" => "Preserver of the",
	"13" => "Marshall of the",
	"14" => "Ranger of the",
	"15" => "Reagent of the",
	"16" => "Retaliator of the",
	"17" => "Swordmaster of the",
	"18" => "Vindicator of the",
	"19" => "Warden of the",
	"20" => "Watchwarder of the",
]);

Table($s, "871B", "", Roll(1, 20), [
	"1-10" => "",
	"11" => "Highland",
	"12" => "Lowland",
	"13" => "Upper",
	"14" => "Lower",
	"15" => "Seaward",
	"16" => "Northern",
	"17" => "Eastern",
	"18" => "Southern",
	"19" => "Western",
	"20" => "Frozen",
]);

Table($s, "871C", "", Roll(1, 20), [
	"1" => "Coasts",
	"2" => "Creation",
	"3" => "Domain",
	"4" => "Downs",
	"5" => "Fens",
	"6" => "Forests",
	"7" => "Garth",
	"8" => "Hearth",
	"9" => "Hills",
	"10" => "Isles",
	"11" => "Marches",
	"12" => "Moors",
	"13" => "Mountains",
	"14" => "Pale",
	"15" => "Reaches",
	"16" => "Shire",
	"17" => "Steppe",
	"18" => "Uplands",
	"19" => "Wastes",
	"20" => "Waves",
]);

$loc = array_pop($s->char->entries);
$mod = array_pop($s->char->entries);
$pos = array_pop($s->char->entries);

$s->char->entries[] = [
	"871",
	"Special Nobility Title",
	$pos[2].' '.ltrim($mod[2].' '.$loc[2]),
];
