# Agent guide

This repository is a reusable WordPress project template. Read the files you change and preserve the separation between plugin functionality and theme presentation. The companion plugin must load before the theme.

## Map

- `plugin/lhpbpp.php` boots the plugin; `plugin/inc/` contains its container, components, REST code and block registration.
- `theme/functions.php` boots the classic theme; `theme/inc/`, PHP templates and `theme.json` control presentation and editor support.
- `plugin/admin/src/`, `theme/admin/src/` and `theme/src/` are editable asset sources. Webpack writes ignored `dist/` output.
- Root manifests, scripts and `.github/` are editable when the task concerns setup, dependencies, testing or releases. Keep all three Composer lockfiles and the npm lockfile consistent with their manifests.

## Commands

Use Node 24.18+, npm 11.16+, PHP 8.4 and Composer 2. Run `npm run setup` after cloning. Run `npm run check` for source changes. Start Docker and run `npm start` before `npm test`. Run `npm run release` after build, dependency or packaging changes; it verifies both ZIPs. `npm run verify` performs lint, both PHPUnit suites and release checks after WordPress has started.

Do not edit generated `dist/`, `vendor/`, `node_modules/` or archives. Avoid `npm install` to set up a checkout; use `npm ci` so the lockfile remains authoritative. Do not run `npm run env:init` for routine tests: it downloads optional plugins and demo content.

## When changing WordPress behavior

Follow [docs/agent-workflows.md](docs/agent-workflows.md). Add a focused test for PHP behavior, check escaping and permissions at the boundary, and verify that a theme change does not silently take ownership of plugin data. For a new project, update every `lhpbp` identity and test bootstrap path using the [project checklist](project-README.md).
