# phpgdo-country

Country module for GDOv7.
Add basic country table data.
Allow changing country of origin and living.
Country flags.

On installation the module generates `img/country-sprite.png` from the
versioned flags. The generated 26×26 ISO-alpha-2 sprite is intentionally
ignored by Git. Rebuild it manually with `php bin/build_country_sprite.php`.

## phpgdo-country: Metrics

There is currently only phone code, flag, iso2, iso3.
