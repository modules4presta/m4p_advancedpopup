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
    // Set for the browser session once any campaign has been shown, so other popups can step aside.
    var SESSION_KEY = 'm4p_popup_session';
    var DAY = 86400;
    var BUSY_RETRY = 1500;

    function read(storage, key) {
        try {
            return window[storage].getItem(key);
        } catch (e) {
            return null;
        }
    }

    function write(storage, key, value) {
        try {
            window[storage].setItem(key, value);
        } catch (e) {}
    }

    function now() {
        return Math.floor(Date.now() / 1000);
    }

    // Start and end are checked here too: a full-page cache can serve the HTML long after it was rendered.
    function isDue(dialog) {
        var id = dialog.getAttribute('data-popup-id');
        var start = parseInt(dialog.getAttribute('data-start'), 10) || 0;
        var end = parseInt(dialog.getAttribute('data-end'), 10) || 0;
        var days = parseInt(dialog.getAttribute('data-repeat'), 10) || 0;

        if ((start && now() < start) || (end && now() > end)) {
            return false;
        }

        if (!days) {
            return read('sessionStorage', SEEN_PREFIX + id) !== '1';
        }

        return now() - (parseInt(read('localStorage', SEEN_PREFIX + id), 10) || 0) >= days * DAY;
    }

    // showModal() makes the page inert and takes focus, so it waits while another dialog is open or the visitor is typing.
    function isBusy() {
        var active = document.activeElement;

        return !!document.querySelector('dialog[open]')
            || (!!active && /^(?:INPUT|TEXTAREA|SELECT)$/.test(active.tagName));
    }

    function open(dialog) {
        if (isBusy()) {
            window.setTimeout(function () {
                open(dialog);
            }, BUSY_RETRY);

            return;
        }

        var id = dialog.getAttribute('data-popup-id');
        write('sessionStorage', SEEN_PREFIX + id, '1');
        write('localStorage', SEEN_PREFIX + id, String(now()));
        write('sessionStorage', SESSION_KEY, '1');

        dialog.showModal();
        // Otherwise the close button takes focus and shows its ring before anyone uses a keyboard.
        dialog.focus();
        document.documentElement.classList.add('m4p-popup-open');
    }

    function arm(dialog) {
        var delay = Math.max(0, parseInt(dialog.getAttribute('data-delay'), 10) || 0);
        var events = ['mousemove', 'touchstart', 'keydown', 'wheel', 'scroll'];
        var armed = false;
        // The countdown starts on the first interaction, so the popup never opens during a Lighthouse run.
        var start = function () {
            if (armed) {
                return;
            }
            armed = true;
            events.forEach(function (name) {
                window.removeEventListener(name, start);
            });
            window.setTimeout(function () {
                open(dialog);
            }, delay * 1000);
        };

        if (window.m4pInteracted) {
            start();
        } else {
            events.forEach(function (name) {
                window.addEventListener(name, start, { passive: true });
            });
        }
    }

    function init() {
        var dialogs = document.querySelectorAll('dialog[data-m4p-popup]');
        var target = null;

        for (var i = 0; i < dialogs.length && !target; i++) {
            if ('function' === typeof dialogs[i].showModal && isDue(dialogs[i])) {
                target = dialogs[i];
            }
        }

        // Read by other popups (e.g. a newsletter popup of the theme) before they open.
        window.m4pAdvancedPopup = {
            pending: !!target,
            shownThisSession: function () {
                return read('sessionStorage', SESSION_KEY) === '1';
            }
        };

        if (!target) {
            return;
        }

        target.addEventListener('click', function (e) {
            if (e.target === target || e.target.closest('[data-m4p-popup-close]')) {
                target.close();
            }
        });
        target.addEventListener('close', function () {
            document.documentElement.classList.remove('m4p-popup-open');
        });

        arm(target);
    }

    // The script may be injected after DOMContentLoaded (deferred bundles).
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
