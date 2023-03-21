<?php
namespace GDO\Country\Method;

use GDO\Core\GDT_JSON;
use GDO\Core\MethodAjax;
use GDO\Country\GDO_Country;

/**
 * AJAX List of all countries.
 *
 * @version 7.0.0
 * @since 6.10.1
 * @author gizmore
 */
final class AjaxList extends MethodAjax
{

	public function getMethodTitle(): string
	{
		return t('countries');
	}

	public function getMethodDescription(): string
	{
		return $this->getMethodTitle();
	}

	public function execute()
	{
		$json = array_map(function (GDO_Country $country)
		{
			return [
				'id' => $country->getID(),
				'text' => $country->renderName(),
				'display' => $country->renderOption(),
			];
		}, GDO_Country::table()->allCached());

		return GDT_JSON::make()->value($json);
	}

}
