/**
 * m4p_advancedpopup
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 */

(function () {
    'use strict';

    var SEEN_PREFIX = 'm4p_popup_seen_';

    function seenKey(id) {
        return SEEN_PREFIX + id;
    }

    function wasSeen(id) {
        try {
            return window.sessionStorage.getItem(seenKey(id)) === '1';
        } catch (e) {
            return false;
        }
    }

    function markSeen(id) {
        try {
            window.sessionStorage.setItem(seenKey(id), '1');
        } catch (e) {
            /* prywatny tryb / brak storage - trudno */
        }
    }

    function openPopup(el) {
        el.classList.add('m4p-popup--open');
        document.body.classList.add('m4p-popup-open');
        markSeen(el.getAttribute('data-popup-id'));
    }

    function closePopup(el) {
        el.classList.remove('m4p-popup--open');
        document.body.classList.remove('m4p-popup-open');
    }

    function init() {
        var popups = document.querySelectorAll('.m4p-popup');
        if (!popups.length) {
            return;
        }

        // The first campaign not yet shown in this session.
        var target = null;
        for (var i = 0; i < popups.length; i++) {
            if (!wasSeen(popups[i].getAttribute('data-popup-id'))) {
                target = popups[i];
                break;
            }
        }

        if (target) {
            var delay = parseInt(target.getAttribute('data-delay'), 10);
            if (isNaN(delay) || delay < 0) {
                delay = 0;
            }
            // Countdown starts on the user's first interaction, not on page
            // load - a popup opened during a Lighthouse run injected a large
            // image and inflated LCP.
            var events = ['mousemove', 'touchstart', 'keydown', 'wheel', 'scroll'];
            var armed = false;
            var arm = function () {
                if (armed) {
                    return;
                }
                armed = true;
                events.forEach(function (name) {
                    window.removeEventListener(name, arm);
                });
                window.setTimeout(function () {
                    openPopup(target);
                }, delay * 1000);
            };
            // The whole bundle may be deferred until first interaction
            // (theme's delay-load.js) - in that case it already happened.
            if (window.m4pInteracted) {
                arm();
            } else {
                events.forEach(function (name) {
                    window.addEventListener(name, arm, { passive: true });
                });
            }
        }

        // Close: the X button, the overlay, or the Esc key.
        document.addEventListener('click', function (e) {
            var closer = e.target.closest('[data-popup-close]');
            if (!closer) {
                return;
            }
            var popup = closer.closest('.m4p-popup');
            if (popup) {
                closePopup(popup);
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                var open = document.querySelector('.m4p-popup.m4p-popup--open');
                if (open) {
                    closePopup(open);
                }
            }
        });
    }

    // readyState guard: the script may be injected after DOMContentLoaded
    // (deferred bundle - theme's delay-load.js).
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
