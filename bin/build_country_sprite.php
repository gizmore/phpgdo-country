#!/usr/bin/env php
<?php
declare(strict_types=1);

use GDO\Country\CountrySprite;

/**
 * Build the deterministic ISO-3166 alpha-2 flag sprite used by LinkUUp.
 *
 * Usage: build_country_sprite.php [output-png]
 */

if ($argc > 2)
{
	throw new RuntimeException("Usage: {$argv[0]} [output-png]\n");
}

require_once dirname(__DIR__) . '/CountrySprite.php';

$output = $argv[1] ?? null;
$written = CountrySprite::build($output);
fwrite(STDOUT, "Wrote {$written} ISO flags to " . ($output ?? dirname(__DIR__) . '/img/country-sprite.png') . "\n");
