{**
 * m4p_advancedpopup
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 *}

{if isset($m4p_popups) && $m4p_popups}
    {foreach from=$m4p_popups item=popup}
        <div class="m4p-popup" data-popup-id="{$popup.id|intval}" data-delay="{$popup.delay|intval}">
            <div class="m4p-popup__overlay" data-popup-close="1"></div>
            <div class="m4p-popup__dialog" role="dialog" aria-modal="true" aria-label="{if $popup.title}{$popup.title|escape:'html':'UTF-8'}{else}{l s='Notice' d='Modules.M4padvancedpopup.Shop'}{/if}">
                <button type="button" class="m4p-popup__close" data-popup-close="1" aria-label="{l s='Close' d='Modules.M4padvancedpopup.Shop'}">&times;</button>
                {if $popup.title}
                    <h2 class="m4p-popup__title">{$popup.title|escape:'html':'UTF-8'}</h2>
                {/if}
                {* popup is hidden until its delay fires — lazy-load its images so
                   they don't compete with the LCP hero for bandwidth *}
                <div class="m4p-popup__content">{$popup.content|replace:'<img ':'<img loading="lazy" decoding="async" ' nofilter}</div>
                {if $popup.cta_label && $popup.cta_url}
                    <a class="btn btn-primary m4p-popup__cta" href="{$popup.cta_url|escape:'html':'UTF-8'}">{$popup.cta_label|escape:'html':'UTF-8'}</a>
                {/if}
            </div>
        </div>
    {/foreach}
{/if}
