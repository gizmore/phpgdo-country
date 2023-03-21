<?php
namespace GDO\Country\Method;

use GDO\Core\GDO;
use GDO\Core\MethodCompletion;
use GDO\Country\GDO_Country;

/**
 * Autocomplete adapter for countries.
 *
 * @version 7.0.1
 * @since 6.0.0
 * @author gizmore
 */
final class Completion extends MethodCompletion
{

	public function getMethodTitle(): string
	{
		return t('countries');
	}

	protected function gdoTable(): GDO
	{
		return GDO_Country::table();
	}

}
