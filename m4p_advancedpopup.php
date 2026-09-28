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

require_once __DIR__ . '/classes/M4pPopup.php';

class M4p_AdvancedPopup extends Module
{
    public function __construct()
    {
        $this->name = 'm4p_advancedpopup';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Modules4Presta';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = ['min' => '1.7.6.0', 'max' => _PS_VERSION_];

        parent::__construct();

        $this->displayName = $this->trans('Popup campaigns', [], 'Modules.M4padvancedpopup.Admin');
        $this->description = $this->trans('Runs popup campaigns on the shop: your own HTML with a call to action, shown after a delay, once per session.', [], 'Modules.M4padvancedpopup.Admin');
    }

    public function install(): bool
    {
        return parent::install()
            && $this->installDb()
            && $this->installTab()
            && $this->registerHook('actionFrontControllerSetMedia')
            && $this->registerHook('displayBeforeBodyClosingTag');
    }

    public function uninstall(): bool
    {
        return $this->uninstallTab()
            && $this->uninstallDb()
            && parent::uninstall();
    }

    protected function installDb(): bool
    {
        $queries = [
            'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'm4p_popup` (
                `id_m4p_popup` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
                `delay` INT UNSIGNED NOT NULL DEFAULT 3,
                `position` INT UNSIGNED NOT NULL DEFAULT 0,
                `date_start` DATETIME NULL DEFAULT NULL,
                `date_end` DATETIME NULL DEFAULT NULL,
                `date_add` DATETIME NOT NULL,
                `date_upd` DATETIME NOT NULL,
                PRIMARY KEY (`id_m4p_popup`),
                KEY `active` (`active`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4;',
            'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'm4p_popup_lang` (
                `id_m4p_popup` INT UNSIGNED NOT NULL,
                `id_lang` INT UNSIGNED NOT NULL,
                `title` VARCHAR(255) NOT NULL DEFAULT \'\',
                `content` TEXT,
                `cta_label` VARCHAR(255) NOT NULL DEFAULT \'\',
                `cta_url` VARCHAR(255) NOT NULL DEFAULT \'\',
                PRIMARY KEY (`id_m4p_popup`, `id_lang`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4;',
        ];

        foreach ($queries as $sql) {
            if (!Db::getInstance()->execute($sql)) {
                return false;
            }
        }

        return true;
    }

    protected function uninstallDb(): bool
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'm4p_popup_lang`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'm4p_popup`');

        return true;
    }

    protected function installTab(): bool
    {
        if (Tab::getIdFromClassName('AdminM4pPopup')) {
            return true;
        }

        $tab = new Tab();
        $tab->class_name = 'AdminM4pPopup';
        $tab->module = $this->name;
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminParentModulesSf');
        $tab->icon = 'web_asset';
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[(int) $lang['id_lang']] = 'Popupy (M4P)';
        }

        return (bool) $tab->add();
    }

    protected function uninstallTab(): bool
    {
        $idTab = (int) Tab::getIdFromClassName('AdminM4pPopup');
        if ($idTab) {
            $tab = new Tab($idTab);

            return (bool) $tab->delete();
        }

        return true;
    }

    /**
     * Module page in the admin panel => redirect to the campaign list.
     */
    public function getContent(): void
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminM4pPopup'));
    }

    public function hookActionFrontControllerSetMedia(): void
    {
        if (!$this->isHomePage()) {
            return;
        }

        $this->context->controller->registerStylesheet(
            'm4p-advancedpopup',
            'modules/' . $this->name . '/views/css/front.css'
        );
        $this->context->controller->registerJavascript(
            'm4p-advancedpopup',
            'modules/' . $this->name . '/views/js/front.js',
            ['position' => 'bottom', 'priority' => 200]
        );
    }

    public function hookDisplayBeforeBodyClosingTag(array $params): string
    {
        if (!$this->isHomePage()) {
            return '';
        }

        $popups = M4pPopup::getActive((int) $this->context->language->id);
        if (!$popups) {
            return '';
        }

        $this->context->smarty->assign(['m4p_popups' => $popups]);

        return $this->display(__FILE__, 'views/templates/hook/popup.tpl');
    }

    private function isHomePage(): bool
    {
        return ($this->context->controller->php_self ?? '') === 'index';
    }
}
