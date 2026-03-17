# AGENTS.md

Use `.github/copilot-instructions.md` as the canonical project guidance.

The available skills live in `.agents/skills/`; treat that folder as the source of truth.

In practice:

- follow the routing and guardrails in `.github/copilot-instructions.md`
- check `.agents/skills/` before assuming a skill exists
- keep business logic in `plugin/` and presentation in `theme/`
- use the installed skills by name when the task matches them
