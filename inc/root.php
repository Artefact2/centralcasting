<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_CALLBACK, function() {
	ob_start();
	debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	fwrite(STDERR, ob_get_clean());
});
assert_options(ASSERT_BAIL, 1);

require __DIR__.'/state.php';
require __DIR__.'/character.php';
require __DIR__.'/entries.php';
require __DIR__.'/tables.php';
require __DIR__.'/lambdas.php';
require __DIR__.'/roller.php';
