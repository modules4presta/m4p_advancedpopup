{**
 * m4p_advancedpopup
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 *}

{foreach from=$m4p_popups item=popup}
    <dialog class="m4p-popup" tabindex="-1" data-m4p-popup data-popup-id="{$popup.id|intval}" data-delay="{$popup.delay|intval}" data-repeat="{$popup.repeat_days|intval}" data-start="{$popup.start|intval}" data-end="{$popup.end|intval}" {if $popup.title}aria-labelledby="m4p-popup-title-{$popup.id|intval}"{else}aria-label="{l s='Notice' d='Modules.M4padvancedpopup.Shop'}"{/if}>
        <button type="button" class="m4p-popup__close" data-m4p-popup-close title="{l s='Close' d='Modules.M4padvancedpopup.Shop'}" aria-label="{l s='Close' d='Modules.M4padvancedpopup.Shop'}">&times;</button>
        {if $popup.title}
            <h2 class="m4p-popup__title" id="m4p-popup-title-{$popup.id|intval}">{$popup.title|escape:'html':'UTF-8'}</h2>
        {/if}
        {* Closed dialogs are not rendered, but their images would still load and compete with the LCP image. *}
        <div class="m4p-popup__content">{$popup.content|replace:'<img ':'<img loading="lazy" decoding="async" ' nofilter}</div>
        {if $popup.cta_label && $popup.cta_url}
            <a class="btn btn-primary m4p-popup__cta" href="{$popup.cta_url|escape:'html':'UTF-8'}">{$popup.cta_label|escape:'html':'UTF-8'}</a>
        {/if}
    </dialog>
{/foreach}
