# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2026-10-27

### Added

- Placement per campaign: the home page or the whole shop. The cart, the checkout and the customer
  account are left out of the whole shop.
- "Show again after" in days, remembered in the browser. 0 keeps a campaign to one appearance per
  browser session.
- A switch for the module stylesheet, for themes that style the popup themselves.
- `upgrade/upgrade-1.1.0.php` adding the two columns and the setting.

### Changed

- The popup is a native `<dialog>` opened with `showModal()`, so the browser handles the backdrop,
  focus and the Escape key. A campaign waits while another dialog is open or while a form field has
  focus.
- The delay is counted from the first scroll, tap, key or mouse move instead of from page load.
- The date range is evaluated in the browser as well, so a campaign served from a cached page does
  not appear before it starts.
- Saving, editing or deleting a campaign clears the template cache.
- `window.m4pAdvancedPopup` tells other scripts whether a campaign is waiting and whether one has
  already been shown in this browser session.

## [1.0.0] - 2026-09-28

### Added

- Popup campaigns with a heading, HTML content, an optional call to action, a delay and a date
  range, managed from a back-office screen and translated per language.
- English and Polish translations, MIT license and the standard documentation set.

### Removed

- A demo banner image nothing referenced.

### Changed

- The admin controller no longer restores the `l()` method PrestaShop 9 removed; every string goes
  through the translation system.
