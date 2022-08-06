<?php
namespace GDO\Country;

use GDO\Core\GDO_Module;

/**
 * Country related functionality.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 3.0.0
 */
class Module_Country extends GDO_Module
{
	public int $priority = 10;
	
	##############
	### Module ###
	##############
	public function thirdPartyFolders() : array { return ['/img/']; }
	public function getClasses() : array { return [GDO_Country::class]; }
	public function onInstall() : void { InstallCountries::install(); }
	public function onLoadLanguage() : void { $this->loadLanguage('lang/country'); }

	##############
	### Config ###
	##############
	public function getUserSettings() : array
	{
		return [
			GDT_Country::make('country'),
		];
	}
	
}
