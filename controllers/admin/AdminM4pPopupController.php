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

class AdminM4pPopupController extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'm4p_popup';
        $this->className = 'M4pPopup';
        $this->identifier = 'id_m4p_popup';
        $this->lang = true;
        $this->allow_export = false;
        $this->context = Context::getContext();

        parent::__construct();

        $this->fields_list = [
            'id_m4p_popup' => [
                'title' => $this->trans('ID', [], 'Modules.M4padvancedpopup.Admin'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'name' => [
                'title' => $this->trans('Campaign name', [], 'Modules.M4padvancedpopup.Admin'),
            ],
            'position' => [
                'title' => $this->trans('Position', [], 'Modules.M4padvancedpopup.Admin'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'date_start' => [
                'title' => $this->trans('From', [], 'Modules.M4padvancedpopup.Admin'),
                'type' => 'datetime',
                'align' => 'center',
            ],
            'date_end' => [
                'title' => $this->trans('To', [], 'Modules.M4padvancedpopup.Admin'),
                'type' => 'datetime',
                'align' => 'center',
            ],
            'active' => [
                'title' => $this->trans('Enabled', [], 'Modules.M4padvancedpopup.Admin'),
                'active' => 'status',
                'type' => 'bool',
                'align' => 'center',
                'class' => 'fixed-width-sm',
            ],
        ];

        $this->bulk_actions = [
            'delete' => [
                'text' => $this->trans('Delete selected', [], 'Modules.M4padvancedpopup.Admin'),
                'confirm' => $this->trans('Delete the selected campaigns?', [], 'Modules.M4padvancedpopup.Admin'),
                'icon' => 'icon-trash',
            ],
        ];
    }

    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        return parent::renderList();
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->trans('Popup campaign', [], 'Modules.M4padvancedpopup.Admin'),
                'icon' => 'icon-comment',
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->trans('Campaign name', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'name',
                    'required' => true,
                    'desc' => $this->trans('A label for the back office only; the customer never sees it.', [], 'Modules.M4padvancedpopup.Admin'),
                ],
                [
                    'type' => 'switch',
                    'label' => $this->trans('Enabled', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'active',
                    'is_bool' => true,
                    'values' => [
                        ['id' => 'active_on', 'value' => 1, 'label' => $this->trans('Yes', [], 'Modules.M4padvancedpopup.Admin')],
                        ['id' => 'active_off', 'value' => 0, 'label' => $this->trans('No', [], 'Modules.M4padvancedpopup.Admin')],
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Heading', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'title',
                    'lang' => true,
                ],
                [
                    'type' => 'textarea',
                    'label' => $this->trans('Content (HTML)', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'content',
                    'lang' => true,
                    'autoload_rte' => true,
                    'cols' => 60,
                    'rows' => 10,
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Button label', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'cta_label',
                    'lang' => true,
                    'desc' => $this->trans('Leave empty to show no button.', [], 'Modules.M4padvancedpopup.Admin'),
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Button link', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'cta_url',
                    'lang' => true,
                    'desc' => $this->trans('For example https://your-shop.com/offers', [], 'Modules.M4padvancedpopup.Admin'),
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Delay before it appears', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'delay',
                    'class' => 'fixed-width-sm',
                    'suffix' => $this->trans('seconds', [], 'Modules.M4padvancedpopup.Admin'),
                    'desc' => $this->trans('How long after the page loads the popup is shown.', [], 'Modules.M4padvancedpopup.Admin'),
                ],
                [
                    'type' => 'datetime',
                    'label' => $this->trans('Runs from', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'date_start',
                    'desc' => $this->trans('Leave empty for no limit.', [], 'Modules.M4padvancedpopup.Admin'),
                ],
                [
                    'type' => 'datetime',
                    'label' => $this->trans('Runs until', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'date_end',
                    'desc' => $this->trans('Leave empty for no limit.', [], 'Modules.M4padvancedpopup.Admin'),
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Position', [], 'Modules.M4padvancedpopup.Admin'),
                    'name' => 'position',
                    'class' => 'fixed-width-sm',
                    'desc' => $this->trans('Order of campaigns; a lower number wins.', [], 'Modules.M4padvancedpopup.Admin'),
                ],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Modules.M4padvancedpopup.Admin'),
            ],
        ];

        // Inject date values (managed outside ObjectModel).
        if (($obj = $this->loadObject(true)) && Validate::isLoadedObject($obj)) {
            $row = Db::getInstance()->getRow(
                'SELECT `date_start`, `date_end` FROM `' . _DB_PREFIX_ . 'm4p_popup` WHERE `id_m4p_popup` = ' . (int) $obj->id
            );
            $this->fields_value['date_start'] = $row['date_start'] ?? '';
            $this->fields_value['date_end'] = $row['date_end'] ?? '';
        }

        return parent::renderForm();
    }

    public function processAdd()
    {
        $object = parent::processAdd();
        if (Validate::isLoadedObject($object)) {
            $this->saveDates((int) $object->id);
        }

        return $object;
    }

    public function processUpdate()
    {
        $object = parent::processUpdate();
        if (Validate::isLoadedObject($object)) {
            $this->saveDates((int) $object->id);
        }

        return $object;
    }

    /**
     * Daty od/do trzymamy poza ObjectModel, aby czysto obslugiwac NULL (bez ograniczenia).
     */
    private function saveDates(int $id): void
    {
        if (!$id) {
            return;
        }

        $start = trim((string) Tools::getValue('date_start'));
        $end = trim((string) Tools::getValue('date_end'));

        $startSql = Validate::isDate($start) ? "'" . pSQL($start) . "'" : 'NULL';
        $endSql = Validate::isDate($end) ? "'" . pSQL($end) . "'" : 'NULL';

        Db::getInstance()->execute(
            'UPDATE `' . _DB_PREFIX_ . 'm4p_popup` SET `date_start` = ' . $startSql . ', `date_end` = ' . $endSql
            . ' WHERE `id_m4p_popup` = ' . $id
        );
    }
}
