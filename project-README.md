# Project README template

Replace this file with the new project's README after creating a repository from the boilerplate. Keep the checklist below until every identity has been updated.

## Customization checklist

1. Choose a lowercase project slug without spaces. Search for `lhpbp`, `LHPBP`, `lhpbpp`, `lhpbpt`, `WpMunich` and `wp-project-boilerplate`; update names, namespaces, text domains, constants and package metadata consistently.
2. Rename `plugin/lhpbpp.php` to `plugin/<slug>p.php`. Check references in the plugin test bootstrap, `phpcs.xml`, `webpack.config.js`, `.wp-env.json`, update URLs and any deployment configuration.
3. Replace plugin and theme headers, authorship, descriptions and URLs with approved project details. Replace `plugin/readme.txt` with the actual plugin description.
4. Configure GitHub repository secrets and the release destination, or remove the update-server deployment from `.github/workflows/release.yml`. Update `release-please-config.json` and the release artifact names if the packaging scheme changes.
5. Refresh the lockfile metadata after renaming: run `npm install --package-lock-only`, then `composer update --lock --no-install --no-scripts` in the root, `theme/` and `plugin/` directories. Commit all four lockfiles with their manifests.
6. Run `npm run setup`, `npm run check`, `npm start`, `npm test` and `npm run release`. Confirm both ZIP names, extracted top-level directories and plugin/theme activation in WordPress.
7. Replace this checklist with the project's purpose, setup, architecture, support contacts and deployment procedure. Rename this file to `README.md` after removing the boilerplate README.

## Architecture to preserve

The plugin carries functionality and reusable block behavior. The theme is a classic PHP theme enhanced with `theme.json` and block-editor features. Keep this separation while customizing; document any deliberate exception.
