# visune DESIGN.md

> Auto-generated design system — reverse-engineered via static analysis by skillui.
> Frameworks: None detected
> Colors: 20 · Fonts: 2 · Components: 9
> Icon library: not detected · State: not detected
> Primary theme: light · Dark mode toggle: no · Motion: expressive

## Visual Reference

**Match this design exactly** — study colors, fonts, spacing, and component shapes before writing any UI code.

![visune Homepage](../screenshots/homepage.png)

---

## 1. Visual Theme & Atmosphere

This is a **light-themed** interface with a warm, approachable feel. The light background emphasizes content clarity. Typography pairs **Saans-Bold** for display/headings with **Saans-Heavy** for body text, creating clear visual hierarchy through type contrast. Spacing follows a **4px base grid** (compact density), with scale: 2, 4, 6, 8, 10, 12, 14, 16px. The accent color **#ccff00** anchors interactive elements (buttons, links, focus rings). Motion is expressive — spring physics, layout animations, and staggered reveals are part of the visual language.

---

## 2. Color Palette & Roles

| Token | Hex | Role | Use |
|---|---|---|---|
| color-background-header | `#ffffff` | background | Page background, darkest surface |
| color-background-main-alternate | `#f5f5f5` | surface | Card and panel backgrounds |
| color-text-header | `#000000` | text-primary | Headings and body text |
| text-muted | `#5e5e5e` | text-muted | Captions, placeholders, secondary info |
| color-text-cards | `#282830` | border | Dividers, card borders, outlines |
| accent | `#ccff00` | accent | CTAs, links, focus rings, active states |
| danger | `#e56d6d` | danger | Error states, destructive actions |
| success | `#51ce0f` | success | Success states, positive indicators |
| info | `#020024` | info | Informational highlights |
| color-background-footer | `#151515` | unknown | Palette color |
| color-background-cards | `#e7e5e2` | unknown | Palette color |
| unknown | `#d3d3d3` | unknown | Palette color |
| unknown | `#acacac` | unknown | Palette color |
| unknown | `#1d2020` | unknown | Palette color |
| unknown | `#9e9a8f` | unknown | Palette color |
| unknown | `#919191` | unknown | Palette color |
| unknown | `#767676` | unknown | Palette color |
| unknown | `#3b393d` | unknown | Palette color |
| unknown | `#52c057` | unknown | Palette color |
| unknown | `#de1e1e` | unknown | Palette color |

### CSS Variable Tokens

```css
--color-background-cards: var(--color-background-main);
--color-text-cards: var(--color-text-main);
--color-foreground-cards: var(--color-foreground-main);
--color-secondary-text-cards: var(--color-secondary-text-main);
--color-accent-cards: var(--color-text-main);
--color-foreground-accent-cards: var(--color-foreground-main);
--color-borders-cards: var(--color-borders-main);
--font-weight-headings-primary: 400;
--font-style-headings-primary: normal;
--font-weight-body-primary: 400;
--font-weight-body-primary-bold: 700;
--font-weight-body-primary-medium: 400;
--font-style-body-primary: normal;
--font-weight-body-secondary: 400;
--font-weight-body-secondary-bold: 700;
--font-style-body-secondary: normal;
--base-headings-primary-size: 60;
--base-headings-secondary-size: ;
--base-body-primary-size: 16;
--base-body-secondary-size: 18;
```


---

## 3. Typography Rules

**Font Stack:**
- **Saans-Heavy** — Heading 1, Heading 2, Heading 3
- **Saans-Bold** — Body, Caption

**Font Sources:**

```css
@font-face {
  font-family: "Saans-Bold";
  src: url("https://visune.io/cdn/shop/t/93/assets/Saans-Bold.woff2") format("woff2");
  font-weight: 400;
}
@font-face {
  font-family: "Saans-Heavy";
  src: url("https://visune.io/cdn/shop/t/93/assets/Saans-Heavy.woff2") format("woff2");
  font-weight: 400;
}
@font-face {
  font-family: "Saans-Light";
  src: url("https://visune.io/cdn/shop/t/93/assets/Saans-Light.woff2") format("woff2");
  font-weight: 400;
}
@font-face {
  font-family: "Saans-Medium";
  src: url("https://visune.io/cdn/shop/t/93/assets/Saans-Medium.woff2") format("woff2");
  font-weight: 400;
}
@font-face {
  font-family: "Saans-Regular";
  src: url("https://visune.io/cdn/shop/t/93/assets/Saans-Regular.woff2") format("woff2");
  font-weight: 400;
}
@font-face {
  font-family: "Saans-SemiBold";
  src: url("https://visune.io/cdn/shop/t/93/assets/Saans-SemiBold.woff2") format("woff2");
  font-weight: 400;
}
```

| Role | Font | Size | Weight |
|---|---|---|---|
| Heading 1 | Saans-Heavy | calc(120px/60*var(--base-headings-primary-size) + 0px) | 700 |
| Heading 2 | Saans-Heavy | 90px | 700 |
| Heading 3 | Saans-Heavy | calc(80px/60*var(--base-headings-primary-size) + 0px) | 700 |
| Body | Saans-Bold | calc(16px/16*var(--base-body-primary-size) + 0px) | 400 |
| Caption | Saans-Bold | 14px | 400 |

**Typographic Rules:**
- Limit to 2 font families max per screen
- Use **Saans-Heavy** for body/UI text, **Saans-Bold** for display/headings
- Maintain consistent hierarchy: no more than 3-4 font sizes per screen
- Headings use bold (600-700), body uses regular (400)
- Line height: 1.5 for body text, 1.2 for headings
- Use color and opacity for secondary hierarchy, not additional font sizes


---

## 4. Component Stylings

### Navigation (1)

**Navigation** — `html`

### Data Display (3)

**Card** — `html`
- Variants: `banner`, `s`, `banner__curtain`, `content`, `banner__body`

**Badge** — `html`

**List** — `html`

### Data Input (2)

**Button** — `html`
- Variants: `-prev`, `-next`
- Animation: 

**Input** — `html`
- State: :focus, :placeholder

### Overlay (1)

**Modal** — `html`

### Media (2)

**Image** — `html`

**Icon** — `html`



---

## 5. Layout Principles

- **Base spacing unit:** 4px
- **Spacing scale:** 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24
- **Border radius:** .3125rem, .375rem, .5rem, .625rem, 1.25rem, 2em, 2rem, 3px, 4px, 5px, 6px, 8px, 10px, 12px, 15px, 16px, 17px, 20px, 24px, 28px, 30px, 32px, 34px, 40px, 45px, 60px, 100%, 999px, inherit, 100px
- **Max content width:** 1023px

**Spacing as Meaning:**
| Spacing | Use |
|---|---|
| 4-8px | Tight: related items within a group |
| 12-16px | Medium: between groups |
| 24-32px | Wide: between sections |
| 48px+ | Vast: major section breaks |


---

## 6. Depth & Elevation

### Flat — subtle depth hints

- `0 0 0 1px var(--color-text-main)`
- `inset 0 0 0 1px #0003`

### Raised — cards, buttons, interactive elements

- `0 0#0000`
- `0 0 1.875rem .375rem #00000026`
- `0 0 0 3px var(--color-secondary-background-main)`

### Floating — dropdowns, popovers, modals

- `0 2px 10px 2px #0000000f`
- `inset -20px 19px 16px #0009,inset 20px -19px 16px #0009`
- `inset -20px 19px 16px rgba(0,0,0,0.6),inset 20px -19px 16px rgba(0,0,0,0.6)`

### Overlay — full-screen overlays, top-level dialogs

- `0 0 60px #0000001a`
- `0 9.5px 61.98px 2.37px #00000040`
- `0 8px 32px #1f268712`

### Z-Index Scale

`0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 20, 99, 100, 200, 999, 1000, 1001, 1002, 9999, 10000, 10001, 10002, 10003, 99999, 1000000`



---

## 7. Animation & Motion

This project uses **expressive motion**. Animations are an integral part of the experience.

### CSS Animations

- `@keyframes shopify-rotator`
- `@keyframes shopify-dash`
- `@keyframes acceleratedCheckoutLoadingSkeleton`
- `@keyframes dash`
- `@keyframes dash-check`
- `@keyframes fill-progress`
- `@keyframes reveal-image`
- `@keyframes reveal-opacity`

### Animated Components

- **Button**: 

### Motion Guidelines

- Duration: 150-300ms for micro-interactions, 300-500ms for page transitions
- Easing: `ease-out` for enters, `ease-in` for exits
- Always respect `prefers-reduced-motion`


---

## 8. Do's and Don'ts

### Do's

- Use `#ccff00` for interactive elements (buttons, links, focus rings)
- Use `#ffffff` as the primary page background
- Pair **Saans-Heavy** (body) with **Saans-Bold** (display) — these are the only allowed fonts
- Follow the **4px** spacing grid for all margins, padding, and gaps
- Use the defined shadow tokens for elevation — see Section 6
- Use border-radius from the scale: .3125rem, .375rem, .5rem, .625rem, 1.25rem
- Reuse existing components from Section 4 before creating new ones

### Don'ts

- Don't introduce colors outside this palette — extend the design tokens first
- Don't introduce additional font families beyond Saans-Heavy and Saans-Bold
- Don't use arbitrary spacing values — stick to multiples of 4px
- Don't create custom box-shadow values outside the system tokens
- Don't use arbitrary border-radius values — pick from the defined scale
- Don't duplicate component patterns — check Section 4 first
- Don't use backdrop-blur or blur effects

### Anti-Patterns (detected from codebase)

- No blur or backdrop-blur effects
- No zebra striping on tables/lists


---

## 9. Responsive Behavior

| Name | Value | Source |
|---|---|---|
| xs | 350px | css |
| xs | 374px | css |
| xs | 400px | css |
| xs | 460px | css |
| xs | 470px | css |
| xs | 474px | css |
| xs | 475px | css |
| sm | 510px | css |
| sm | 511px | css |
| sm | 550px | css |
| sm | 600px | css |
| sm | 620px | css |
| sm | 640px | css |
| md | 680px | css |
| md | 700px | css |
| md | 749px | css |
| md | 767px | css |
| md | 768px | css |
| lg | 840px | css |
| lg | 880px | css |
| lg | 900px | css |
| lg | 989px | css |
| lg | 990px | css |
| lg | 1000px | css |
| lg | 1023px | css |
| lg | 1024px | css |
| xl | 1200px | css |
| xl | 1280px | css |
| 2xl | 1281px | css |
| 2xl | 1300px | css |
| 2xl | 1310px | css |
| 2xl | 1360px | css |
| 2xl | 1361px | css |
| 2xl | 1366px | css |
| 2xl | 1400px | css |
| 2xl | 1920px | css |

**Approach:** Use `@media (min-width: ...)` queries matching the breakpoints above.


---

## 10. Agent Prompt Guide

Use these as starting points when building new UI:

### Build a Card

```
Background: #f5f5f5
Border: 1px solid #282830
Radius: 16px
Padding: 16px
Font: Saans-Heavy
Use shadow tokens from Section 6.
```

### Build a Button

```
Primary: bg #ccff00, text white
Ghost: bg transparent, border #282830
Padding: 8px 16px
Radius: 16px
Hover: opacity 0.9 or lighter shade
Focus: ring with #ccff00
```

### Build a Page Layout

```
Background: #ffffff
Max-width: 1023px, centered
Grid: 4px base
Responsive: mobile-first, breakpoints from Section 9
```

### Build a Stats Card

```
Surface: #f5f5f5
Label: #5e5e5e (muted, 12px, uppercase)
Value: #000000 (primary, 24-32px, bold)
Status: use success/warning/danger from Section 2
```

### Build a Form

```
Input bg: #ffffff
Input border: 1px solid #282830
Focus: border-color #ccff00
Label: #5e5e5e 12px
Spacing: 16px between fields
Radius: 16px
```

### General Component

```
1. Read DESIGN.md Sections 2-6 for tokens
2. Colors: only from palette
3. Font: Saans-Heavy, type scale from Section 3
4. Spacing: 4px grid
5. Components: match patterns from Section 4
6. Elevation: shadow tokens
```
