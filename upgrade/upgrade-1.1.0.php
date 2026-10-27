<?php

declare(strict_types=1);

/**
 * m4p_advancedpopup
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Adds the page and repeat settings, the stylesheet switch and the cache purge hooks.
 */
function upgrade_module_1_1_0(M4p_AdvancedPopup $module): bool
{
    $table = _DB_PREFIX_ . 'm4p_popup';
    $columns = array_column(Db::getInstance()->executeS('SHOW COLUMNS FROM `' . $table . '`') ?: [], 'Field');

    if (!in_array('pages', $columns, true)
        && !Db::getInstance()->execute('ALTER TABLE `' . $table . '` ADD `pages` VARCHAR(16) NOT NULL DEFAULT \'' . M4pPopup::PAGES_HOME . '\' AFTER `delay`')) {
        return false;
    }
    if (!in_array('repeat_days', $columns, true)
        && !Db::getInstance()->execute('ALTER TABLE `' . $table . '` ADD `repeat_days` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `pages`')) {
        return false;
    }

    Configuration::updateValue(M4p_AdvancedPopup::CFG_MODULE_CSS, 1);

    return $module->registerHook('actionObjectM4pPopupAddAfter')
        && $module->registerHook('actionObjectM4pPopupUpdateAfter')
        && $module->registerHook('actionObjectM4pPopupDeleteAfter');
}
