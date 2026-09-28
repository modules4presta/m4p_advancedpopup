# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
