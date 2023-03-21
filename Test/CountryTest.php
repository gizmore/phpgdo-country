<?php
namespace GDO\Country\Test;

use GDO\Country\GDO_Country;
use GDO\DB\Database;
use GDO\Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

/**
 * This test also tests @{GDO->allCached()}.
 *
 * @version 7.0.0
 * @author gizmore
 */
final class CountryTest extends TestCase
{

	public function testCountriesAllCached()
	{
		$countries = GDO_Country::table()->allCached();
		assertTrue(count($countries) > 200);
		$before = Database::$QUERIES;
		$countries = GDO_Country::table()->allCached();
		$after = Database::$QUERIES;
		assertEquals($before, $after, 'Make sure countries use allCached() properly.');
	}

}
