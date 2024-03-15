<?php
namespace GDO\Country;

use GDO\Core\GDO_DBException;

/**
 * Install country data.
 * https://raw.githubusercontent.com/lukes/ISO-3166-Countries-with-Regional-Codes/master/all/all.csv
 * name,alpha-2,alpha-3,country-code,iso_3166-2,region,sub-region,intermediate-region,region-code,sub-region-code,intermediate-region-code
 *
 * @author gizmore
 */
final class InstallCountries
{

    public static array $PATCHES = [
        'XK' => ['XK', 'Kos'],
    ];

    /**
     * @throws GDO_DBException
     */
    public static function install()
	{
		$module = Module_Country::instance();
		$path = $module->filePath('data/all.csv');

        foreach (self::$PATCHES as $patch)
        {
            list ($cca2, $cca3) = $patch;
            if (!GDO_Country::getById($cca2))
            {
                GDO_Country::blank([
                    'c_iso' => $cca2,
                    'c_iso3' => $cca3,
                    'c_phonecode' => null,
                    'c_population' => '0',
                ])->insert();
            }
        }

		if ($fh = fopen($path, 'r'))
		{
			# Build csv index names from header row
			$headers = fgetcsv($fh, null, ',');
			$cca2 = array_search('alpha-2', $headers);
			$cca3 = array_search('alpha-3', $headers);
//			$phone = array_search('callingCode', $headers);

			$data = [];

			# Loop
			while ($row = fgetcsv($fh, null, ','))
			{
				if (count($row) > 3)
				{
					if (!GDO_Country::getById($row[$cca2]))
					{
						$data[] = [
							'c_iso' => $row[$cca2],
							'c_iso3' => $row[$cca3],
							'c_phonecode' => null,
							'c_population' => '0',
						];
					}
				}
			}

			fclose($fh);

			$fields = GDO_Country::table()->gdoColumnsOnly('c_iso', 'c_iso3', 'c_phonecode', 'c_population');
			GDO_Country::bulkInsert($fields, $data);
		}
	}

}
