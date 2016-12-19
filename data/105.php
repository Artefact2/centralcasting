<?php

Table($s, "105", "Reason of Illegitimate Birth", Roll(20) + $s->char->CuMod, [
	"-12" => "Mother was a common prostitute and unmarried",
	"13-14" => [ "Mother was raped, remained unmarried", function() use(&$s) {
			$s->char->entries[] = [
				"", "Father's identity", Roll(100) <= 15 ? "Known" : "Unknown"
			];
		}],
	"15-23" => [ "Mother was unmarried", function() use(&$s) {
			$s->char->entries[] = [
				"", "Father's identity", Roll(100) <= 15 ? "Known" : "Unknown"
			];
		}],
	"24-27" => [ "Mother was a courtesan (prostitute to Nobility)", function() use(&$s) {
			$s->char->entries[] = [
				"", "Father's identity", Roll(2) === 1 ? "Known" : "Unknown"
			];
		}],
]);
