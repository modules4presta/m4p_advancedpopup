# M4P Popup Campaigns for PrestaShop 8 & 9

**Say the one thing a visitor needs to hear – a free-shipping threshold, a trade fair, a price list going up – without editing a single template.**

> **Meta description (149 chars):** Run popup campaigns in PrestaShop: your own HTML, a call to action, a delay and a date range. Managed from the back office. Free MIT module.

---

## Why a popup, and why one you control

Most shops end up pasting an announcement into the theme, then forgetting to remove it. A campaign
with a start and an end date removes itself:

- **Schedules itself** – set the dates once, the campaign appears and disappears on its own
- **Shown as often as you decide** – once per browser session, or again after a number of days
- **Your own HTML** – a sentence, a list, an image, whatever the message needs
- **One button that matters** – a call to action pointing wherever you send people

## What the module does

You create campaigns in **Catalogue → Popup campaigns**: a heading, the content, an optional button
with its link, where it runs, how long it waits, how often the same visitor sees it again and, if you
want, the days it runs. The campaign is shown in the visitor's language as a native `<dialog>`, so
the browser handles the backdrop, the focus and the Escape key.

### Key features

- **Home page or the whole shop** – per campaign; the whole shop leaves out the cart, the checkout
  and the customer account
- **Several campaigns at once** – ordered by position, the first one due is shown
- **Per language** – heading, content and button label are translated like any PrestaShop text
- **Date range** – leave both dates empty to run until you switch the campaign off
- **Delay counted from the first interaction** – a scroll, a tap, a key or a mouse move, so the popup
  never covers a page a visitor has not started reading, and never opens during a performance audit
- **Waits its turn** – a campaign holds back while another dialog is open or while a form field has
  focus
- **Closes with Escape, the backdrop or the button** – no visitor is trapped

### What it does not do

The module does not target by country, cart value or customer group, does not collect e-mail
addresses and does not A/B test. It shows a message you wrote, when you said, to everyone.

## Compatibility

| | |
|---|---|
| PrestaShop | 1.7.6 – 9.x |
| PHP | 7.4+ |
| Requirements | none |
| Multistore | Campaigns are shared across shops |
| Themes | Needs a theme that renders `displayBeforeBodyClosingTag` (all standard themes do) |
| Browsers | `<dialog>`: Chrome, Edge, Firefox and Safari 15.4+. An older browser shows no popup |

The module performs no core overrides. It creates two tables, `m4p_popup` and `m4p_popup_lang`, and
drops them on uninstall.

## Installation

1. Upload and install the module from **Modules → Module Manager**.
2. Open **Catalogue → Popup campaigns** and add one.
3. Fill in the heading, the content and, if you want a button, its label and link.
4. Open the shop in a private window and scroll – the popup appears after the delay you set.

## Configuration options

Almost everything is a property of the campaign:

| Field | Description |
|---|---|
| **Campaign name** | A label for the back office only. |
| **Enabled** | Turns the campaign on without deleting it. |
| **Heading**, **Content (HTML)** | What the visitor reads, per language. |
| **Button label**, **Button link** | Leave the label empty to show no button. |
| **Delay before it appears** | Seconds counted from the visitor's first scroll, tap, key or mouse move. |
| **Where** | The home page, or the whole shop except the cart, the checkout and the customer account. |
| **Show again after** | Days before the same visitor sees it again. 0 shows it once per browser session. |
| **Runs from**, **Runs until** | Leave empty for no limit. |
| **Position** | Which campaign wins when several are due; a lower number first. |

One setting sits above the campaign list:

| Setting | Description |
|---|---|
| **Load the module stylesheet** | Switch it off when the theme styles the popup itself. |

## Frequently asked questions

**What happens when two campaigns are eligible at the same time?**
The one with the lower position is shown. Only one popup appears at a time.

**How often does a visitor see it?**
As often as **Show again after** says. With 0 the campaign is shown once and stays closed until the
browser session ends; with 7 the same visitor sees it again a week later. Both are remembered in the
browser, so clearing site data starts over.

**Can I put an image in it?**
Yes, the content is HTML – point an `<img>` at a file you host, or use any markup your theme styles.
A campaign whose content is nothing but an image is rendered edge to edge, without the dialog's
padding around it.

**Does it work on mobile?**
Yes; the dialog is centred and scales to the screen width.

**I changed a campaign and the shop still shows the old one.**
Saving a campaign clears the template cache. A full-page cache in front of the shop (a hosting
cache, a CDN) is not ours to clear, so purge it there – the dates are checked in the browser as
well, so a cached page will not show a campaign before it starts or after it ends.

**What happens to campaigns when I uninstall the module?**
Both tables are dropped, so the campaigns are gone. Export them first if you plan to reinstall.

---

**Keywords:** PrestaShop popup, popup campaign, announcement, call to action, marketing popup,
scheduled banner.

## License

MIT – see [LICENSE](LICENSE). Free to use commercially, fork and modify; keep the copyright notice.

## Contributing

Bug reports and pull requests are welcome – see [CONTRIBUTING.md](CONTRIBUTING.md). For security
issues, follow [SECURITY.md](SECURITY.md) instead of opening a public issue.

---

Built by [Nice Code](https://nice-code.com/pl/oferta/moduly-prestashop) – we build and maintain PrestaShop stores.

© Nice Code sp. z o.o. (Modules4Presta) – released under the MIT license.
