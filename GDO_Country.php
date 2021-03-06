<?php
namespace GDO\Country;

use GDO\Core\GDO;
use GDO\Core\GDT_Char;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Template;

/**
 * Country table/entity.
 * 
 * @author gizmore
 * @version 7.0.0
 * @since 3.00
 */
final class GDO_Country extends GDO
{
    ###########
    ### GDO ###
    ###########
	public function gdoColumns() : array
	{
		return array(
			GDT_Char::make('c_iso')->label('id')->length(2)->ascii()->caseS()->primary(),
			GDT_Char::make('c_iso3')->length(3)->ascii()->caseS()->notNull(),
			GDT_String::make('c_phonecode')->min(2)->max(32),
		);
	}

	##############
	### Getter ###
	##############
	public function getID() : ?string { return $this->getISO(); }
	public function getIDFile() : string { $iso = strtolower($this->getISO()); return $iso === 'ad' ? 'axx' : $iso; }
	public function getISO() : string { return $this->gdoVar('c_iso'); }
	public function getISO3() : string { return $this->gdoVar('c_iso3'); }
	public function renderName() : string { return t('country_'.strtolower($this->getISO())); }
	public function displayEnglishName() : string { return ten('country_'.strtolower($this->getISO())); }
	
	/**
	 * Get a country by ID or return a stub object with name "Unknown".
	 * @param int $id
	 * @return self
	 */
	public static function getByISOOrUnknown(string $iso=null) : self
	{
		if ( ($iso === null) || (!($country = self::getById($iso))) )
		{
			$country = self::unknownCountry();
		}
		return $country;
	}
	
	public static function unknownCountry() : self
	{
		return self::blank(['c_iso'=>'zz']);
	}
	
	###########
	### All ###
	###########
	/**
	 * @return self[]
	 */
	public function &allCached($order=null, $json=false) : array
	{
	    $all = parent::allCached($order, $json);
	    return $this->allSorted($all);
	}
	
	public function &all(string $order=null, bool $json=false) : array
	{
	    return $this->allSorted(parent::all($order, $json));
	}
	
	private function &allSorted(array &$all) : array
	{
	    uasort($all, function(GDO_Country $a, GDO_Country $b){
	        $ca = iconv('utf-8', 'ascii//TRANSLIT', $a->renderName());
	        $cb = iconv('utf-8', 'ascii//TRANSLIT', $b->renderName());
	        return strcasecmp($ca, $cb);
	    });
        return $all;
	}
	
	##############
	### Render ###
	##############
	public function renderFlag() : string
	{
		return GDT_Template::php('Country', 'country_html.php', ['field' => GDT_Country::make()->gdo($this), 'choice' => false]);
	}

	public function renderCell() : string
	{
		return GDT_Template::php('Country', 'country_html.php', ['field' => GDT_Country::make()->gdo($this), 'choice' => false]);
	}

	public function renderChoice() : string
	{
		return GDT_Template::php('Country', 'country_html.php', ['field' => GDT_Country::make()->gdo($this)->initial($this->getID()), 'choice' => true]);
	}
	
}
