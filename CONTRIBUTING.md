# Contributing

Changes to theme, plugin, tooling, tests and documentation are welcome when they improve the reusable boilerplate. Keep client-specific features in client repositories.

## Development

1. Create a branch from current `main`.
2. Use Node 24.18+, npm 11.16+, PHP 8.4, Composer 2 and Docker.
3. Run `npm run setup` once, then `npm start` for WordPress and `npm run watch` while editing.
4. Run `npm run check` for every code change. Run `npm test` for PHP behavior and `npm run test:e2e` for editor or frontend behavior. Run `npm run release` when changing dependencies, build configuration or packaging.

The PHPUnit suites run in `wp-env`'s test container. `npm start` must complete first. The plugin test bootstrap loads `plugin/lhpbpp.php`; the theme test bootstrap activates that plugin and the `theme` directory. Keep these paths in sync when customizing a new project.

## Editorial model

The Block Editor is where editors compose content. It is deliberately not where they design the site. Keep page structure in PHP templates and give editors a curated set of blocks, layout variations, and design presets. Group, Columns, and Cover are available for composition; arbitrary colors, font sizes, spacing values, and page widths are not. The Site Editor is outside this workflow. An unlocked pattern is a starting point for an editor; use content-only editing or locking only for a deliberately fixed component.

## Project conventions

- Put reusable functionality, data, REST routes and block registration in `plugin/`. Put templates, `theme.json`, layout and styles in `theme/`.
- Add a block's `block.json` under `plugin/blocks/<block-name>/`; the plugin's `Blocks` component discovers it. Import its editor code from `plugin/admin/src/js/blocks.js`. The PHP renderer uses `<block-name>/template.php` when present. Use `editorial-note` as the complete reference. Keep its visual CSS in the theme.
- Keep user input validation, escaping, capability checks and nonces close to the affected WordPress action. Use WordPress APIs for persistence and output.
- Edit source files, not generated `dist/` output. Include meaningful tests for behavior changes.
- Changes to root configuration and `.github/` are allowed when necessary. Explain their effect in the PR.
- Do not commit `vendor/`, `node_modules/`, local WordPress files or release ZIPs.

## Pull requests

Use a Conventional Commit style PR title such as `fix: correct theme bootstrap` or `docs: clarify project setup`. Describe the user-visible behavior, test commands and any manual checks. CI runs lint, the development build, both PHPUnit suites, Playwright editor tests and production ZIP verification. Major dependency updates require individual review; Dependabot patch updates may auto-merge only after required checks pass.

## Releases

Release Please owns version changes in `package.json`, `plugin/lhpbpp.php` and `theme/style.css`. Do not run an npm version command to rewrite or stage the repository. `npm run release` only builds and packages the versions already recorded in those files. The release workflow is responsible for publishing and deploying artifacts.
