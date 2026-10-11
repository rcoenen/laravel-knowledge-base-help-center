# Design notes

The standard help center for `laravel-knowledge-base`: a public, multi-language help site that works out of the box and is meant to be restyled.

## Brief

- **Who reads it:** customers of the host app, often on a phone, sometimes in their second language, usually with one concrete question.
- **Primary job:** get from a question to an answer they can trust, in their language, in as few steps as possible.
- **Second job:** make it obvious when an answer is not in their language or may be out of date, because a stale answer can be worse than none.

## Research that shaped it

Patterns that recur in well-regarded help centers (Help Scout, Stripe, Notion, Slack, Dropbox, Shopify, Zendesk's Copenhagen theme):

- Search first: one dominant search field on the home page, results that show where an answer lives.
- Quick answers before long reads (Shopify): the FAQ sits on the home page, expandable in place.
- Browsable topics as a clear index, not a wall of tiles.
- Article pages: breadcrumb, an "on this page" table of contents for longer articles (Notion, Help Scout), related articles (Atlassian), a "was this helpful?" prompt.
- Titles written as tasks ("How to apply for…"), which the demo content follows.

## Tokens

| Token | Value | Use |
|---|---|---|
| `--kb-ink` | `#1c2230` | Text, headings, input borders |
| `--kb-paper` | `#ffffff` | Page background |
| `--kb-mist` | `#eef1f4` | Search band, table-of-contents panel |
| `--kb-rule` | `#d9dde3` | Dividers, list separators |
| `--kb-slate` | `#566072` | Secondary text |
| `--kb-accent` | `#8c1d2c` | Links, button, focus ring (a deep red; override per app) |
| `--kb-notice` | `#fdf3d7` / `#6b4b00` | Fallback and outdated notices |

Type: headings in a book serif from the system (Charter, Iowan Old Style, Sitka, Georgia), body in the system sans. No web fonts: nothing to download, nothing sent to a font CDN (GDPR), nothing to build. Scale steps of 1.25 from a 17px base; article text at 17px / 1.65, max 68 characters wide.

## Layout

```
Home                                     Article
┌──────────────────────────────────┐     ┌──────────────────────────────────┐
│ Brand Help              EN  DE   │     │ Brand Help              EN  DE   │
├──────────────────────────────────┤     ├──────────────────────────────────┤
│ What do you need help with?      │     │ Topic › Subtopic                 │
│ [ search ...............][Search]│     │ [notice: shown in English]       │
├──────────────────────────────────┤     │ Title as a task                  │
│ Quick answers      Browse topics │     │ Updated 3 Mar 2026  Also in: DE  │
│ ▸ question         Topic (4)     │     │ ┌──────────────┐ ┌─────────────┐ │
│ ▸ question           Subtopic    │     │ │ article body │ │ On this page│ │
│ ▸ question         Topic (2)     │     │ │              │ │ Related     │ │
└──────────────────────────────────┘     │ └──────────────┘ └─────────────┘ │
                                         │ Was this helpful?  Yes  No       │
                                         └──────────────────────────────────┘
```

Everything is left aligned on one column grid (max 1080px). On phones the aside drops below the article and the home's two columns stack, quick answers first.

## Principles

- The one bold element is the home question set large in the serif with the search field directly under it. Everything else stays quiet.
- Structure is information: no cards around topics, no numbered markers, no all-caps labels, no decorative gradients.
- Trust signals over decoration: the served language, the update date and the outdated notice are always visible when they apply.
- Zero JavaScript. FAQ answers use `<details>`; feedback is a plain form post.
- Every colour is a CSS custom property, so an app restyles by overriding a handful of variables, or publishes the views and rewrites them.
