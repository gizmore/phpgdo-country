<?php
use GDO\Country\GDO_Country;
/** @var $field \GDO\Country\GDT_Country **/
$country = isset($field->gdo) ? $field->gdo : null;
if (!($country instanceof GDO_Country ))
{
    $country = GDO_Country::getById($field->getVar());
}
?>
<?php
if ($country instanceof GDO_Country) :
$id = $country->getID();
$name = $country->renderName();
?>
<img
 class="gdo-country"
 alt="<?=$id?>"
 title="<?=$name?>"
 src="<?=GDO_WEB_ROOT?>GDO/Country/img/<?=$id?>.png" />
<?php if ($field->withName) : ?>
<span><?=$name?></span>
<?php endif; ?>
<?php else : ?>
<img
 class="gdo-country"
 alt="??"
 title="<?=t('unknown_country')?>"
 src="<?=GDO_WEB_ROOT?>GDO/Country/img/ZZ.png" />
<?php if ($field->withName) : ?>
<span><?=t('unknown_country')?></span>
<?php endif;?>
<?php endif;?>
