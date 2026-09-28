# M4P Popup Campaigns for PrestaShop 8 & 9

**Say the one thing a visitor needs to hear — a free-shipping threshold, a trade fair, a price list going up — without editing a single template.**

> **Meta description (149 chars):** Run popup campaigns in PrestaShop: your own HTML, a call to action, a delay and a date range. Managed from the back office. Free MIT module.

---

## Why a popup, and why one you control

Most shops end up pasting an announcement into the theme, then forgetting to remove it. A campaign
with a start and an end date removes itself:

- **Schedules itself** — set the dates once, the campaign appears and disappears on its own
- **Shown once per session** — a returning visitor is not nagged on every page
- **Your own HTML** — a sentence, a list, an image, whatever the message needs
- **One button that matters** — a call to action pointing wherever you send people

## What the module does

You create campaigns in **Catalogue → Popup campaigns**: a heading, the content, an optional button
with its link, how many seconds after the page loads it appears and, if you want, the days it runs.
The campaign shows up on the front office in the visitor's language and stays closed for the rest of
the session once dismissed.

### Key features

- **Several campaigns at once** — ordered by position, the first eligible one is shown
- **Per language** — heading, content and button label are translated like any PrestaShop text
- **Date range** — leave both dates empty to run until you switch the campaign off
- **Delay in seconds** — enough time for the page to settle before anything covers it
- **Closes with Escape, the overlay or the button** — no visitor is trapped

### What it does not do

The module does not target by page, country, cart value or customer group, does not collect
e-mail addresses and does not A/B test. It shows a message you wrote, when you said, to everyone.

## Compatibility

| | |
|---|---|
| PrestaShop | 1.7.6 – 9.x |
| PHP | 7.4+ |
| Requirements | none |
| Multistore | Campaigns are shared across shops |
| Themes | Needs a theme that renders `displayBeforeBodyClosingTag` (all standard themes do) |

The module performs no core overrides. It creates two tables, `m4p_popup` and `m4p_popup_lang`, and
drops them on uninstall.

## Installation

1. Upload and install the module from **Modules → Module Manager**.
2. Open **Catalogue → Popup campaigns** and add one.
3. Fill in the heading, the content and, if you want a button, its label and link.
4. Open the shop in a private window — the popup appears after the delay you set.

## Configuration options

The module has no configuration screen; everything is a property of the campaign:

| Field | Description |
|---|---|
| **Campaign name** | A label for the back office only. |
| **Enabled** | Turns the campaign on without deleting it. |
| **Heading**, **Content (HTML)** | What the visitor reads, per language. |
| **Button label**, **Button link** | Leave the label empty to show no button. |
| **Delay before it appears** | Seconds after the page loads. |
| **Runs from**, **Runs until** | Leave empty for no limit. |
| **Position** | Which campaign wins when several are eligible; a lower number first. |

## Frequently asked questions

**What happens when two campaigns are eligible at the same time?**
The one with the lower position is shown. Only one popup appears at a time.

**How often does a visitor see it?**
Once per session. Closing it is remembered until the browser session ends.

**Can I put an image in it?**
Yes, the content is HTML — point an `<img>` at a file you host, or use any markup your theme styles.

**Does it work on mobile?**
Yes; the dialog is centred and scales to the screen width.

**What happens to campaigns when I uninstall the module?**
Both tables are dropped, so the campaigns are gone. Export them first if you plan to reinstall.

---

**Keywords:** PrestaShop popup, popup campaign, announcement, call to action, marketing popup,
scheduled banner.

## License

MIT — see [LICENSE](LICENSE). Free to use commercially, fork and modify; keep the copyright notice.

## Contributing

Bug reports and pull requests are welcome — see [CONTRIBUTING.md](CONTRIBUTING.md). For security
issues, follow [SECURITY.md](SECURITY.md) instead of opening a public issue.

---

Built by [Nice Code](https://nice-code.com/pl/oferta/moduly-prestashop) — we build and maintain PrestaShop stores.

© Nice Code sp. z o.o. (Modules4Presta) — released under the MIT license.
