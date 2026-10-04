# Layout Reference

> Auto-extracted from live DOM. Use this to understand how the site is structured spatially.

## Spacing System

**Base grid:** 4px

**Scale:** `2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30` px

| Spacing | Semantic Use |
|---------|-------------|
| 4px | Tight — within a component |
| 8px | Medium — between sibling items |
| 16px | Wide — between sections |
| 32px | Vast — major section breaks |

## Flex Layouts

| Element | Direction | Justify | Align | Gap | Children |
|---------|-----------|---------|-------|-----|----------|
| `div.header__bottom.header-container` | row | space-between | center | — | 3 |
| `div.container--large.gutter-top--regular` | row | space-between | — | — | 2 |
| `div.section-heading.section-heading--left` | row | space-between | end | normal 30px | 1 |
| `div.section-heading.section-heading--left` | row | space-between | end | — | 1 |
| `div.reviewer-cards__row` | row | center | — | 20px | 3 |
| `div.section-heading.section-heading--left` | row | space-between | end | — | 1 |
| `div.section-heading.section-heading--left` | row | space-between | end | normal 30px | 2 |
| `div.section-heading.section-heading--left` | row | space-between | end | — | 1 |
| `div.animated-card-banner__cards` | row | — | stretch | 15px | 3 |
| `div#element-template--27397372182914__rich_text_YhyPNq.card.` | row | — | — | — | 1 |

## Grid Layouts

| Element | Template Columns | Gap | Children |
|---------|-----------------|-----|----------|
| `div.grid.grid--layout` | `383.984px 383.984px 383.984px` | 64px | 3 |
| `div#header-top.header__top.container--large` | `164.531px 891.469px 200px` | 12px | 5 |
| `div.grid.grid--layout` | `296px 296px 296px 296px` | 32px | 4 |
| `div.grid.grid--layout` | `405.328px 405.328px 405.328px` | 32px | 12 |

## Structural Containers

### `<main>` (`main#main.main-content`)

```
display:          block
children:         15
```

### `<section>` (`section#shopify-section-template--27397372182914__animated_c`)

```
display:          block
children:         1
```

### `<section>` (`section#shopify-section-template--27397372182914__industrial`)

```
display:          block
children:         1
```

### `<section>` (`section#industrial-design-essentials-template--2739737218291`)

```
display:          block
padding:          28px 0px
children:         2
```

## Layout Rules

- **Container max-width:** `1360px` — always center with `margin: auto`
- Primary layout system: **Flexbox**
- Secondary layout system: **CSS Grid** (used for card grids and multi-column layouts)
- Every spacing value must be a multiple of **4px**
- Never use arbitrary margin/padding values outside the spacing scale

