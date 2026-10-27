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

class M4pPopup extends ObjectModel
{
    public const PAGES_HOME = 'home';
    public const PAGES_ALL = 'all';

    /** @var int */
    public $id_m4p_popup;

    /** @var string Campaign label (panel only) */
    public $name;

    /** @var bool */
    public $active = true;

    /** @var int Delay before showing the popup (seconds) */
    public $delay = 3;

    /** @var string Where it runs: PAGES_HOME or PAGES_ALL */
    public $pages = self::PAGES_HOME;

    /** @var int Days before the same visitor sees it again; 0 = once per browser session */
    public $repeat_days = 0;

    /** @var int */
    public $position = 0;

    /** @var string|null Start date (NULL = no limit) - managed outside ObjectModel */
    public $date_start;

    /** @var string|null End date (NULL = no limit) - managed outside ObjectModel */
    public $date_end;

    /** @var string */
    public $date_add;

    /** @var string */
    public $date_upd;

    /** @var string Title (lang) */
    public $title;

    /** @var string HTML content (lang) */
    public $content;

    /** @var string CTA button label (lang) */
    public $cta_label;

    /** @var string CTA button URL (lang) */
    public $cta_url;

    public static $definition = [
        'table' => 'm4p_popup',
        'primary' => 'id_m4p_popup',
        'multilang' => true,
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'delay' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'],
            'pages' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 16],
            'repeat_days' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'],
            'position' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            // Language fields
            'title' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255],
            'content' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'],
            'cta_label' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255],
            'cta_url' => ['type' => self::TYPE_STRING, 'lang' => true, 'size' => 255],
        ],
    ];

    /**
     * Enabled campaigns that have not ended, for a given language and page, sorted by position.
     * The start date and the end date are checked again in the browser (`start`/`end` as Unix time):
     * full-page caches keep the HTML for hours, so a campaign must be in it before it starts.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getForPage(int $idLang, bool $isHome): array
    {
        // Dates are entered in the shop's time zone, which is PHP's; MySQL's NOW() may run in another one.
        $sql = 'SELECT p.`id_m4p_popup` AS id, p.`delay`, p.`repeat_days`,
                p.`date_start`, p.`date_end`,
                pl.`title`, pl.`content`, pl.`cta_label`, pl.`cta_url`
            FROM `' . _DB_PREFIX_ . 'm4p_popup` p
            INNER JOIN `' . _DB_PREFIX_ . 'm4p_popup_lang` pl
                ON (pl.`id_m4p_popup` = p.`id_m4p_popup` AND pl.`id_lang` = ' . $idLang . ')
            WHERE p.`active` = 1
                AND (p.`date_end` IS NULL OR p.`date_end` >= \'' . pSQL(date('Y-m-d H:i:s')) . '\')
                ' . ($isHome ? '' : 'AND p.`pages` = \'' . self::PAGES_ALL . '\'') . '
            ORDER BY p.`position` ASC, p.`id_m4p_popup` ASC';

        $rows = Db::getInstance()->executeS($sql);
        if (!is_array($rows)) {
            return [];
        }

        foreach ($rows as &$row) {
            $row['start'] = $row['date_start'] ? (int) strtotime($row['date_start']) : 0;
            $row['end'] = $row['date_end'] ? (int) strtotime($row['date_end']) : 0;
        }

        return $rows;
    }
}
