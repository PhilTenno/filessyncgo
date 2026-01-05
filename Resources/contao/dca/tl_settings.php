<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\System;

// Felddefinition
$GLOBALS['TL_DCA']['tl_settings']['fields']['filessyncgo_token'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['filessyncgo_token'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => [
        'mandatory' => true,
        'maxlength' => 255,
    ],
    'sql'       => "varchar(255) NOT NULL default ''",
    'save_callback' => [
        static function (string $value): string {
            // Beispiel: Erlaubt A-Z, a-z, 0-9, _, -, @
            if (!preg_match('/^[A-Za-z0-9_@-]+$/', $value)) {
                // Fehlermeldung aus Sprachdatei
                $message = System::getContainer()->get('translator')->trans(
                    'tl_settings.filessyncgo_token_invalid',
                    [],
                    'contao_tl_settings'
                );

                throw new \RuntimeException($message);
            }

            return $value;
        },
    ],
];

// Legende und Feld einfügen
$paletteManipulator = new PaletteManipulator();
$paletteManipulator
    ->addLegend('FilesSyncGo', 'system')
    ->addField('filessyncgo_token', 'FilesSyncGo', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings');