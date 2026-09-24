# WordPress Project Boilerplate

An agency template for projects that need a classic WordPress theme with selected block-editor features and a companion plugin. The plugin owns functionality and data; the theme owns templates, styles, and presentation. Both ship as separate ZIP files.

## Why this is a hybrid theme

We use the Block Editor because it gives editors exceptional freedom to compose content. We do not ask editors to design the website. The theme defines the visual system and page templates; the plugin provides reusable content functionality. Editors can arrange content and choose supported layouts within those design rules. We intentionally do not use the Site Editor for this workflow.

In practice, editors can combine text, media, Group, Columns, Cover, and project blocks. The theme supplies curated colors, type, spacing, and widths. Developers own PHP templates, the header, and the footer. This is a project choice, not a claim that every WordPress site should work this way.

## Requirements

- Node.js 24.18 or newer within the 24.x line, and npm 11.16 or newer
- PHP 8.4 and Composer 2
- Docker for `@wordpress/env` and PHPUnit integration tests
- `unzip` for release archive verification

The local WordPress environment is pinned to WordPress 7.1.2 and PHP 8.4 in `.wp-env.json`. Its default site is `http://localhost` (port 80), with the standard `admin` / `password` development credentials. Set `WP_ENV_PORT` if port 80 is occupied.

## Start a project

1. Use this repository as a GitHub template and clone the new repository.
2. Run `npm run setup` to install all three Composer lockfiles and the npm lockfile, then build assets. Start Docker before the next step.
3. Run `npm start` to start WordPress, activate the hybrid theme, and ensure the local REST rewrite rules; run `npm run watch` in a second terminal while editing.
4. Follow the [project customization checklist](project-README.md) to replace boilerplate identities and turn that file into the new project's README.

`npm start` starts WordPress and prepares the local theme and rewrite rules. It never changes dependencies or the lockfiles. `npm run env:init` is an optional demo-content setup that downloads third-party plugins and sample content; it is not required for normal development or tests.

## Structure

| Location | Responsibility |
| --- | --- |
| `plugin/` | Plugin entry point, dependency container, business logic, REST API, block registration and rendering |
| `theme/` | Classic PHP templates, `theme.json`, editor supports, styles and frontend assets |
| `plugin/admin/src/`, `theme/admin/src/`, `theme/src/` | Source assets compiled by webpack into `admin/dist/` or `dist/` |
| `bin/` | Project setup and release scripts |
| `.github/workflows/` | CI, release, and dependency automation |

This is a **hybrid theme**: classic PHP templates remain the page structure, while `theme.json` and selected editor capabilities enhance block editing. Put content models and reusable behavior in the plugin. Put block appearance in the theme. See [agent workflows](docs/agent-workflows.md) for the current block registration path.

## Everyday commands

| Command | Purpose |
| --- | --- |
| `npm run setup` | Clean npm install, install root/theme/plugin Composer dependencies, build assets |
| `npm start` / `npm stop` | Start or stop the pinned WordPress environment |
| `npm run watch` | Rebuild changed assets |
| `npm run check` | Lint PHP, JavaScript and CSS; build development assets |
| `npm test` | Run plugin and theme PHPUnit suites in `wp-env` (Docker required) |
| `npm run test:e2e` | Run Chromium editor and frontend tests after `npx playwright install chromium` |
| `npm run verify` | Lint, PHPUnit, editor tests, build production assets, package and verify ZIPs |
| `npm run release` | Build and verify production ZIPs in `archives/` |

`npm run release` installs production Composer dependencies in temporary staging directories. It leaves your development `vendor/` directories intact. The archives contain compiled assets and runtime code, and exclude tests, source assets and dev-only packages.

## Changes and releases

Read [CONTRIBUTING.md](CONTRIBUTING.md) for contribution and validation rules. Use Conventional Commits. Release Please updates the project, plugin and theme versions, creates a release PR, and publishes a GitHub release after that PR is merged. The release workflow verifies and uploads ZIPs, then deploys them to the configured update server. It needs the repository's existing release secrets; a template consumer must configure or remove that deployment for their own project.

Repository-specific guidance for coding agents is in [AGENTS.md](AGENTS.md). The existing `add/agent-skills` branch was reviewed; relevant block and plugin practices are distilled in [docs/agent-workflows.md](docs/agent-workflows.md).
