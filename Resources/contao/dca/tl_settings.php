<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

// 1️⃣ Felddefinition
$GLOBALS['TL_DCA']['tl_settings']['fields']['filessyncgo_token'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['filessyncgo_token'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['mandatory'=>true, 'maxlength'=>255],
    'sql'       => "varchar(255) NOT NULL default ''",
];

// 2️⃣ Legende und Feld in die Standard‑Palette einfügen
$paletteManipulator = new PaletteManipulator();
$paletteManipulator->addLegend('filessyncgo_legend', 'system')
    ->addField('filessyncgo_token', 'filessyncgo_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings');
