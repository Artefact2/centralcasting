<?php

namespace HeroesOfLegend;

/* NB: book says to roll d10 but has no value for 8 */
return new NamedTable("863A", "Weapon", DiceRoller::from("d9"), [
	"1" => "Ornate dagger",
	"2" => "Ornate sword",
	"3" => "Plain sword",
	"4" => "Mace",
	"5" => "Ornate spear",
	"6" => "Well-made bow",
	"7" => "Ornate battle axe",
	"8" => "Exotic weapon (GM choice)",
	"9" => "Anachronistic weapon (gun, laser rifle, flint handaxe, etc.)",
]);
