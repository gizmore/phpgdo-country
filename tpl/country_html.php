<?php
namespace GDO\Country\tpl;

use GDO\Country\GDO_Country;
use GDO\Country\GDT_Country;
use GDO\Country\CountrySprite;

/** @var $field GDT_Country * */
$country = $field->gdo ?? null;
if (!($country instanceof GDO_Country))
{
	if ($id = $field->getVar())
	{
		$country = GDO_Country::getById($field->getVar());
	}
}
?>
<span class="gdo-country">
<?php
if ($country instanceof GDO_Country) :
	$id = $country->getID();
	$name = $country->renderName();
	if ($option)
	{
		echo $country->renderCLI() . '&nbsp;' . $name;
		return;
	}
	?>
    <span class="country-flag"
          role="img"
          aria-label="<?=$id?>"
          title="<?=$name?>"
          style="background-image:url('<?=GDO_WEB_ROOT?>GDO/Country/img/country-sprite.png'); background-position: <?=CountrySprite::backgroundPosition($id)?>"></span>
<?php
	if ($field->withName) : ?>
        <span><?=$name?></span>
	<?php
	endif; ?>
<?php
else : ?>
	<?php
	if ($option)
	{
		echo $country->renderCLI() . '&nbsp;' . t('unknown_country');
		return;
	}
	?>
    <span class="country-flag"
          role="img"
          aria-label="??"
          title="<?=t('unknown_country')?>"
          style="background-image:url('<?=GDO_WEB_ROOT?>GDO/Country/img/country-sprite.png'); background-position: <?=CountrySprite::backgroundPosition('ZZ')?>"></span>
<?php
	if ($field->withName) : ?>
        <span><?=t('unknown_country')?></span>
	<?php
	endif; ?>
<?php
endif; ?>
</span>
