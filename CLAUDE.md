# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Read first (project context)

@SPEC.md
@PROGRESS.md

- `SPEC.md` defines **what to build** (Manitas Vallés website). `PROGRESS.md` holds the current state, the decisions already taken, and what is pending. Both are written in Spanish.
- **Always read `PROGRESS.md` before starting any work.**
- **Update `PROGRESS.md` when you finish any important task** (new feature, design decision, environment or provisioning change, commit-worthy milestone): move the item to "Hecho" with its date, adjust "Estado actual", "En curso" and "Pendiente", and refresh the "Última actualización" date.
- If a decision contradicts `SPEC.md`, update `SPEC.md` too.
- If a blocking item in `SPEC.md` section 2 ("Decisiones pendientes") affects the task, **ask before writing code**.

## What this repository is

`ProyectoBaseWeb` is a **base workspace for web frontend work**. Its tooling is a set of Claude Code skills under `.claude/skills/` plus hooks wired up in `.claude/settings.local.json`. The tooling itself has no `package.json`, build system, linter, or tests.

It is now used to build the **Manitas Vallés** website: a local handyman / home repair service (plumbing, electricity, assembly) in the Vallès Occidental, Catalonia, whose goal is to generate quote requests from mobile users. Project deliverables live at the repository root (see "Expected project structure"); `.claude/` holds only tooling.

`SkillsIncluidas.txt` (Spanish) is the human-maintained inventory of every installed skill: origin, version, and purpose. Update it whenever a skill is added, removed, or upgraded.

## Project workflow (Manitas Vallés)

- Follow the order in `SPEC.md` section 3: **do not write final code until the user has chosen a color palette** (propose 3 combinations first and wait).
- Use the installed skills (see below) for design and UI work, and read the design analysis in `./visune-design` (skillui output) before deciding styles.
- `./visune-design` is a **reference, not this project's design system**: it is an analysis of visune.io. Its own `CLAUDE.md` and `DESIGN.md` say to match that site exactly; ignore that instruction. The palette is the one the user chooses, and the Saans fonts in `visune-design/fonts/` are commercial and must not be shipped without a license.
- **Do not invent data**: no testimonials, legal details, emails, or phone numbers. Leave a clear marker (`[PENDIENTE: ...]`) and tell the user.
- **Do not change the prices** in `SPEC.md` section 6 unless the user asks.
- Make small, verifiable changes. Split large tasks and state the plan first.

## Code conventions

Page content is built with Elementor Free, which generates its own markup. These conventions apply to the theme's PHP and CSS and to the CSS classes and IDs assigned to Elementor elements; within Elementor, pick the HTML tag of each container and heading so the semantic rules below still hold.

- Semantic HTML5 (`header`, `main`, `section`, `nav`, `footer`), one `h1` per page, correct heading hierarchy.
- Modern CSS with custom properties (`:root`) for colors and spacing. Flexbox or Grid. No frameworks unless decided otherwise.
- **Mobile-first**: base styles for mobile, `@media (min-width: ...)` for larger screens.
- Accessibility: sufficient contrast, `alt` on images, `label` on every field, visible focus, keyboard-usable controls.
- Class names lowercase with hyphens (`.hero-cta`).
- All user-facing text in **Spanish and Catalan**; no strings left in a single language.
- Local SEO: `title`, `meta description`, Open Graph, and `LocalBusiness` structured data per language, mentioning the Vallès Occidental and main municipalities.

## Security (mandatory)

- Validate and sanitize all form input **on the server**, never only in the browser.
- Verify the captcha on the server before sending the email.
- CSRF protection (nonce in WordPress) and rate limiting against spam.
- Attachments: images only (JPG, PNG, WebP), limit size and count, check the real MIME type, rename files, never execute or serve them from uncontrolled public paths.
- Escape all output (`esc_html`, `esc_attr`, etc.) and use prepared statements for any database access.
- Never commit keys, passwords, or tokens. Use environment variables or `wp-config.php` kept out of version control.
- Security headers (CSP, X-Content-Type-Options, Referrer-Policy) and mandatory HTTPS.

## Legal (Spain / EU)

- Legal notice (Aviso legal), Privacy policy, and Cookie policy, linked from the footer.
- The cookie banner must not load analytics or third parties before consent.
- The form includes a privacy policy acceptance checkbox.

## Expected project structure

```
/
├── CLAUDE.md
├── SPEC.md
├── PROGRESS.md
├── PRODUCT.md                (impeccable: durable product context)
├── DESIGN.md                 (impeccable: design system)
├── SkillsIncluidas.txt
├── visune-design/            (design analysis, read-only)
├── .claude/                  (skills, agents, hooks)
├── docker-compose.yml        (local WordPress: web on 8082, Mailpit on 8026)
├── provision/                (WP-CLI provisioning, idempotent)
├── dev/mu-plugins/           (development only, not deployed)
└── wp-content/themes/manitas-valles/   (custom theme)
```

The site is **WordPress + Elementor Free** (no Pro widgets); there is no static HTML version.

## Skills layout

- `.claude/skills/<name>/SKILL.md` is the entry point of each skill. Some have companion files (`RECIPES.md`, `API.md`, `AUDIT.md`, `STANDARDS.md`, `PICKER.md`, `PLAN-TEMPLATE.md`).
- Most skills are pre-installed Claude Code skills built around Emil Kowalski's motion/UI philosophy (`animate`, `review-animations`, `improve-animations`, `find-animation-opportunities`, `emil-design-eng`, `apple-design`, `mobile-native`, `ask-sonner`, `pick-ui-library`, `prototype`, and others). `pick-ui-library`, `prototype`, and `review-animations` are manual-invocation only.
- `taste-skill` was installed from `github.com/leonxlnx/taste-skill`.
- `impeccable` (v4.3.1) was installed from `github.com/pbakaus/impeccable` via `npx impeccable install`. Treat its contents as vendored. Prefer re-running the installer over hand-editing.
- `graphify` is **not** in this repo. It is installed globally under `~/.claude/skills/graphify/`, and `~/.claude/CLAUDE.md` makes `/graphify` load that skill first. A safer install path was chosen deliberately: only the official PyPI package `graphifyy` from Graphify-Labs, never the alternate manual install that pulls `SKILL.md` from a different repo (see `SkillsIncluidas.txt`).

## The impeccable skill

`impeccable` is the largest piece and is the one with executable machinery:

- **Engine CLI**: `.claude/skills/impeccable/scripts/impeccable` (`impeccable.cmd` on Windows shells without `sh`). It is a launcher for a self-contained per-platform binary at `scripts/bin/<platform>/`. That directory is **git-ignored** (`.gitignore`) and re-downloaded on first run, so do not commit it.
- **Setup step**: before design work, run `.claude/skills/impeccable/scripts/impeccable context` once per session from the project root. It loads `PRODUCT.md`, `DESIGN.md`, and the surface brief. If it fails, read those files directly and do not invent missing context.
- **Project context files**: impeccable expects `PRODUCT.md` (durable product context, created by `init`) and `DESIGN.md` (design system, created by `document`) at the repository root. Neither exists yet. Create `PRODUCT.md` from `SPEC.md` sections 1 and 4, and `DESIGN.md` only after the palette is chosen, combining it with the `./visune-design` analysis. Do not duplicate content that already lives in `SPEC.md`: link to it.
- **Commands** (`craft`, `shape`, `init`, `document`, `extract`, `critique`, `audit`, `polish`, `bolder`, `quieter`, `distill`, `harden`, `onboard`, `animate`, `colorize`, `typeset`, `layout`, `delight`, `overdrive`, `clarify`, `adapt`, `optimize`, `live`) each have a playbook in `impeccable/reference/<command>.md`. `SKILL.md` holds the routing table (`craft` is a deprecated alias for an ordinary new-work request). Read `reference/craft-floor.md` before any UI edit.
- `reference/` also holds non-command material: `routing.md`, `new-work.md`, `doctor.md`, `hooks.md`, `operate.md`, `visualize.md`, and native variants (`ios.md`, `android.md`, `audit.native.md`, `adapt.native.md`).
- **`animate` overlap**: there is both a standalone `animate` skill (Emil Kowalski, builds motion from scratch) and an `impeccable animate` command (`reference/animate.md`). Use the standalone skill for motion-only work, and `impeccable animate` when the task is part of a broader impeccable design pass.
- **Subagents**: `.claude/agents/impeccable-*.md` (asset-producer, documenter, finish-reviewer, manual-edit-applier). They are part of the impeccable install.

### Hooks (`.claude/settings.local.json`)

- `PostToolUse` on `Edit|Write` runs `impeccable hook`, a fast design check on UI files.
- `Stop` runs `impeccable hook` again as a full-rule deep pass at session end.
- Both use `"shell": "bash"` and run `sh "$CLAUDE_PROJECT_DIR/.claude/skills/impeccable/scripts/impeccable" hook`, no-op'ing silently (`[ -f ... ] || exit 0` guard) if the launcher is missing. They call the launcher through `sh` because it may lack the executable bit after a clone. The hooks were originally PowerShell (`"shell": "powershell"` calling `scripts\impeccable.cmd hook`) for a Windows machine without Git Bash; this checkout is adapted to Linux. If `/impeccable hooks on`, `update`, or a reinstall rewrites `settings.local.json`, re-check that both hooks still carry `"shell": "bash"` and the `sh` command above.
- The first run downloads the engine binary into `~/.impeccable/bin/<version>/` (see the launcher). The per-edit hook has a 5 s timeout, so that first download can time out. Run `sh .claude/skills/impeccable/scripts/impeccable engine-probe` once in a terminal to fetch it up front.
- When testing by hand, pipe the JSON event to the hook command and set `IMPECCABLE_HOOK_LOG=<path>` to see why a run was skipped.

## Environment notes

- This checkout runs on Linux (Ubuntu) with zsh/bash. The template was originally written on Windows 11 with PowerShell, so some older notes about `.cmd` launchers and `git.exe` do not apply here.
- Nothing in this repo is a build artifact except `impeccable/scripts/bin/`. Everything else is authored or vendored content.
