# Animation Reference

> Cinematic motion design extracted from live DOM. Follow these specs exactly to recreate the experience.

## Motion Technology Stack

| Library | Type | Notes |
|---------|------|-------|
| **Web Animations API (2 active)** | animation |  |

## Scroll Journey

The page is **13.339px** tall. Each frame below shows what the user sees at that scroll depth.

> **Use these screenshots to understand WHAT animates, WHEN it animates, and HOW it moves.**

### 0% — Top / Hero
Scroll position: 0px

![Scroll 0%](../screens/scroll/scroll-000.png)

### 17% — Opening Section
Scroll position: 2115px

![Scroll 17%](../screens/scroll/scroll-017.png)

### 33% — First Feature Section
Scroll position: 4105px

![Scroll 33%](../screens/scroll/scroll-033.png)

### 50% — Mid-Page
Scroll position: 6220px

![Scroll 50%](../screens/scroll/scroll-050.png)

### 67% — Lower Content
Scroll position: 8334px

![Scroll 67%](../screens/scroll/scroll-067.png)

### 83% — Near Footer
Scroll position: 10.324px

![Scroll 83%](../screens/scroll/scroll-083.png)

### 100% — Bottom / Footer
Scroll position: 12.439px

![Scroll 100%](../screens/scroll/scroll-100.png)

## Video Elements

| # | Role | Autoplay | Loop | Muted | Size | First Frame |
|---|------|----------|------|-------|------|-------------|
| 1 | background | ✓ | ✓ | ✓ | 1280×519 | — |
| 2 | content | ✓ | ✓ | ✓ | 405×304 | — |

- **Source:** `https://cdn.shopify.com/videos/c/o/v/7619dc33a6de4def9d40667fadb334a7.mp4`
- **Source:** `https://cdn.shopify.com/videos/c/o/v/7bbfbb01e391467d8f7b0bc33c46c34d.mp4`

## Scroll Animation Patterns

| Pattern | Library | Element Count | Duration | Delay | Easing |
|---------|---------|---------------|----------|-------|--------|
| parallax / sticky scroll | CSS | 4 | — | — | — |

### CSS Implementation

## CSS Keyframes (13 extracted)

### `@keyframes reveal-opacity`

Duration: `245ms` · Easing: `ease-out` · Delay: `35ms` · Iteration: `1` · Fill: `forwards`

Used by: `.product-item__image-figure--on-top`, `.info-tabs__panel.active .info-tabs__image`

```css
@keyframes reveal-opacity {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
```

> Opacity fade

### `@keyframes circle-bounce`

Duration: `0.4s` · Easing: `linear` · Delay: `0s` · Iteration: `infinite` · Fill: `none`

Used by: `.alert--circle.alert--circle-loading::before`

```css
@keyframes circle-bounce {
  0% {
    border-top-width: 2px;
    border-right-width: 2px;
    border-bottom-width: 2px;
    border-left-width: 2px;
    opacity: 0.5;
  }
  100% {
    border-top-width: 4px;
    border-right-width: 4px;
    border-bottom-width: 4px;
    border-left-width: 4px;
    opacity: 0.25;
  }
}
```

> Opacity fade · Dimension expand/collapse

### `@keyframes rotate`

Duration: `3s` · Easing: `linear` · Delay: `0s` · Iteration: `infinite` · Fill: `none`

Used by: `.button--loader .button__preloader-element`

```css
@keyframes rotate {
  100% {
    transform: rotate(360deg);
  }
}
```

> Transform/motion animation

### `@keyframes dash`

Duration: `6s` · Easing: `linear` · Delay: `0s` · Iteration: `infinite` · Fill: `none`

Used by: `.button--loader .button__preloader-element circle`

```css
@keyframes dash {
  0% {
    stroke-dasharray: 1, 200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 89, 200;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 89, 200;
    stroke-dashoffset: -124;
  }
}
```

> SVG stroke animation

### `@keyframes move`

Duration: `0.35s` · Easing: `ease-in-out` · Delay: `0s` · Iteration: `1` · Fill: `forwards`

Used by: `.no-touchevents .button--move:hover .button__text`

```css
@keyframes move {
  0% {
    transform: translateY(0px);
  }
  49% {
    transform: translateY(-200%);
  }
  50% {
    transform: translateY(-200%);
    visibility: hidden;
  }
  51% {
    transform: translateY(200%);
  }
  52% {
    transform: translateY(200%);
    visibility: visible;
  }
  100% {
    transform: translateY(0px);
  }
}
```

> Transform/motion animation

### `@keyframes lazy-loading`

Duration: `4s` · Easing: `linear` · Delay: `0s` · Iteration: `infinite` · Fill: `none`

Used by: `.lazy-image:not(.lazy-image--no-transition)::after`

```css
@keyframes lazy-loading {
  0% {
    height: 0px;
    top: 0px;
  }
  33% {
    height: 100%;
    top: 0px;
  }
  66% {
    top: 100%;
    height: 0px;
  }
  100% {
    top: 0px;
    height: 0px;
  }
}
```

> Dimension expand/collapse

### `@keyframes shopify-rotator`

Duration: `1.4s` · Easing: `linear` · Delay: `0s` · Iteration: `infinite` · Fill: `none`

Used by: `.shopify-payment-button__button .spinner`

```css
@keyframes shopify-rotator {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(270deg);
  }
}
```

> Transform/motion animation

### `@keyframes shopify-dash`

Duration: `1.4s` · Easing: `ease-in-out` · Delay: `0s` · Iteration: `infinite` · Fill: `none`

Used by: `.shopify-payment-button__button .path`

```css
@keyframes shopify-dash {
  0% {
    stroke-dashoffset: 280px;
  }
  50% {
    stroke-dashoffset: 75px;
    transform: rotate(135deg);
  }
  100% {
    stroke-dashoffset: 280px;
    transform: rotate(450deg);
  }
}
```

> Transform/motion animation · SVG stroke animation

### `@keyframes ai-logo-scroll-aazbmwnfluhhwdtvomaigenblock87f61e14nbptc`

Duration: `30s` · Easing: `linear` · Delay: `0s` · Iteration: `infinite` · Fill: `none`

Used by: `.ai-logo-carousel-track-aazbmwnfluhhwdtvomaigenblock87f61e14nbptc`

```css
@keyframes ai-logo-scroll-aazbmwnfluhhwdtvomaigenblock87f61e14nbptc {
  0% {
    transform: translateX(0px);
  }
  100% {
    transform: translateX(-50%);
  }
}
```

> Transform/motion animation

### `@keyframes reveal-image`

```css
@keyframes reveal-image {
  0% {
    clip-path: polygon(0px 0px, 100% 0px, 100% 0px, 0px 0px);
    transform: translateY(-0.625rem);
  }
  100% {
    clip-path: polygon(0px 0px, 100% 0px, 100% 100%, 0px 100%);
    transform: translateY(0px);
  }
}
```

> Transform/motion animation · Clip-path reveal

### `@keyframes lazyanimation`

```css
@keyframes lazyanimation {
  0% {
    opacity: 0;
    transform: translateY(10px) scale(1.05);
  }
  50% {
    opacity: 1;
    transform: translateY(5px) scale(1.025);
  }
  100% {
    opacity: 1;
    transform: translateY(0px) scale(1);
  }
}
```

> Fade + motion enter animation

### `@keyframes acceleratedCheckoutLoadingSkeleton`

```css
@keyframes acceleratedCheckoutLoadingSkeleton {
  50% {
    opacity: var(--shopify-accelerated-checkout-skeleton-animation-opacity-start,1);
  }
  75% {
    opacity: var(--shopify-accelerated-checkout-skeleton-animation-opacity-end,.5);
  }
  100% {
    opacity: var(--shopify-accelerated-checkout-skeleton-animation-opacity-start,1);
  }
}
```

> Opacity fade

### `@keyframes animateBorder`

```css
@keyframes animateBorder {
  0% {
    width: 0px;
  }
  100% {
    width: 100%;
  }
}
```

> Dimension expand/collapse

## Global Transition Declarations

These `transition` values were extracted from CSS rules across the site:

```css
transition: 175ms linear;
transition: opacity 0.12s linear;
transition: 0.1s linear;
transition: transform 175ms, 175ms linear;
transition: opacity 175ms linear, transform 175ms;
transition: background-color 175ms, border 175ms;
transition: transform 175ms linear;
transition: opacity 175ms linear;
transition: opacity 175ms;
transition: 175ms ease-out 50ms;
transition: width 0.5s cubic-bezier(0.47, 1.64, 0.41, 0.8);
transition: transform 175ms;
```

## How to Recreate This Motion Design

### Step 1 — Install Dependencies

```bash
```

### Step 2 — Scroll-Reveal Pattern

Elements that animate into view follow this pattern:

```css
/* Initial hidden state */
.reveal {
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 175ms cubic-bezier(0.4, 0, 0.2, 1),
              transform 175ms cubic-bezier(0.4, 0, 0.2, 1);
}
.reveal.visible {
  opacity: 1;
  transform: translateY(0);
}
```

### Step 3 — Key Motion Principles

- **Video backgrounds** — use `<video autoplay loop muted playsinline>` for background videos. Always include a poster image fallback
- **Duration scale:** `175ms` · `0.12s` · `0.1s` — use these values, never invent new durations
- **Always add** `@media (prefers-reduced-motion: reduce) { * { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }`

### Step 4 — Scroll Journey Reference

Match what happens at each scroll position:

- **0%** (`0px`) → `screens/scroll/scroll-000.png`
- **17%** (`2115px`) → `screens/scroll/scroll-017.png`
- **33%** (`4105px`) → `screens/scroll/scroll-033.png`
- **50%** (`6220px`) → `screens/scroll/scroll-050.png`
- **67%** (`8334px`) → `screens/scroll/scroll-067.png`
- **83%** (`10324px`) → `screens/scroll/scroll-083.png`
- **100%** (`12439px`) → `screens/scroll/scroll-100.png`

