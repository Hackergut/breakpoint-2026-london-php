# Breakpoint 2026 — London (PHP)

PHP 8.1+ conversion of the Solana London Week / Breakpoint 2026 landing page.

## Layout

```
index.php                 Landing page
register.php              POST handler — validates, stores lead, Telegram, issues ticket
includes/                 Config, data, helpers, Telegram, templates
api/webhooks/forminit.php Forminit webhook
api/webhooks/leads.php    Generic JSON lead webhook
assets/                   CSS + JS
media/ brand/ partners/   Static art (copy from public/)
data/leads.json           Written at runtime (not web-accessible)
```

## Host

Upload this `php/` folder **and** the site `public/` media (`media/`, `brand/`, `partners/`, `favicon.svg`) into the document root of any Apache/nginx PHP host.

Set these environment variables (or Apache `SetEnv`):

```
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHAT_ID=
FORMINIT_WEBHOOK_SECRET=
WEBHOOK_SECRET=
```

Tickets are stored in `data/leads.json` and forwarded to Telegram when a bot token is set.

Local:

```
php -S 0.0.0.0:8080 -t .
```
