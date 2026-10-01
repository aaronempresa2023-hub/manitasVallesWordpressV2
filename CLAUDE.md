# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this repository is

`ProyectoBaseWeb` is a **base/starter workspace for web frontend work, not an application**. It contains no source code, `package.json`, build system, linter, or tests. Its content is a set of Claude Code skills under `.claude/skills/` plus hooks wired up in `.claude/settings.local.json`. Actual web projects are expected to be built on top of it, so there are currently no build, lint, or test commands.

`SkillsIncluidas.txt` (Spanish) is the human-maintained inventory of every installed skill: origin, version, and purpose. Update it whenever a skill is added, removed, or upgraded.

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
- **Commands** (`craft`, `shape`, `init`, `document`, `extract`, `critique`, `audit`, `polish`, `bolder`, `quieter`, `distill`, `harden`, `onboard`, `animate`, `colorize`, `typeset`, `layout`, `delight`, `overdrive`, `clarify`, `adapt`, `optimize`, `live`) each have a playbook in `impeccable/reference/<command>.md`. `SKILL.md` holds the routing table (`craft` is a deprecated alias for an ordinary new-work request). Read `reference/craft-floor.md` before any UI edit.
- `reference/` also holds non-command material: `routing.md`, `new-work.md`, `doctor.md`, `hooks.md`, `operate.md`, `visualize.md`, and native variants (`ios.md`, `android.md`, `audit.native.md`, `adapt.native.md`).
- **`animate` overlap**: there is both a standalone `animate` skill (Emil Kowalski, builds motion from scratch) and an `impeccable animate` command (`reference/animate.md`). Use the standalone skill for motion-only work, and `impeccable animate` when the task is part of a broader impeccable design pass.
- **Subagents**: `.claude/agents/impeccable-*.md` (asset-producer, documenter, finish-reviewer, manual-edit-applier). They are part of the impeccable install.
- **Project context files**: impeccable expects `PRODUCT.md` (durable product context, created by `init`) and `DESIGN.md` (design system, created by `document`) at the repository root of the web project. Neither exists yet.

### Hooks (`.claude/settings.local.json`)

- `PostToolUse` on `Edit|Write` runs `impeccable hook`, a fast design check on UI files.
- `Stop` runs `impeccable hook` again as a full-rule deep pass at session end.
- Both use `"shell": "bash"` and run `sh "$CLAUDE_PROJECT_DIR/.claude/skills/impeccable/scripts/impeccable" hook`, no-op'ing silently (`[ -f ... ] || exit 0` guard) if the launcher is missing. They call the launcher through `sh` because it may lack the executable bit after a clone. The hooks were originally PowerShell (`"shell": "powershell"` calling `scripts\impeccable.cmd hook`) for a Windows machine without Git Bash; this checkout is adapted to Linux. If `/impeccable hooks on`, `update`, or a reinstall rewrites `settings.local.json`, re-check that both hooks still carry `"shell": "bash"` and the `sh` command above.
- The first run downloads the engine binary into `~/.impeccable/bin/<version>/` (see the launcher). The per-edit hook has a 5 s timeout, so that first download can time out. Run `sh .claude/skills/impeccable/scripts/impeccable engine-probe` once in a terminal to fetch it up front.
- When testing by hand, pipe the JSON event to the hook command and set `IMPECCABLE_HOOK_LOG=<path>` to see why a run was skipped.

## Environment notes

- This checkout runs on Linux (Ubuntu) with zsh/bash. The template was originally written on Windows 11 with PowerShell, so some older notes about `.cmd` launchers and `git.exe` do not apply here.
- Nothing in this repo is a build artifact except `impeccable/scripts/bin/`. Everything else is authored or vendored content.
