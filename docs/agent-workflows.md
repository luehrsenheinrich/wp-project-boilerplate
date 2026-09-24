# Agent workflows for this boilerplate

These project-specific notes adapt the useful block and plugin guidance from the unmerged `add/agent-skills` branch. They describe the implementation in this repository; do not copy generic WordPress scaffolds over the existing build and bootstraps.

## Add or change a block

1. Decide which behavior remains useful if the theme changes. Put registration and rendering behavior in `plugin/`; put appearance in `theme/src/css/`.
2. Put metadata in `plugin/blocks/<name>/block.json`. `plugin/inc/Blocks/Blocks.php` discovers each immediate block directory at `init`. Its render callback loads `template.php` from that directory when present, otherwise it returns saved content.
3. Import editor registration code from `plugin/admin/src/js/blocks.js`. Webpack writes the editor bundle and dependency manifest into `plugin/admin/dist/`; `Blocks.php` enqueues those assets. Preserve the existing WordPress dependency extraction setup.
4. For dynamic markup, escape output and use `get_block_wrapper_attributes()` so core block supports work. Check editor and frontend behavior with `npm run build` and the WordPress environment.
5. Add a focused PHP test when registration, render output or a helper changes. Run `npm run check` and `npm test`.

The general `@wordpress/create-block` scaffold is a reference, not a drop-in project layout here. Inspect the existing webpack entries and PHP registration before using generated code.

## Add or change plugin functionality

1. Keep `plugin/lhpbpp.php` small. Place a component in `plugin/inc/`, wire it through the existing container and WordPress hooks, and keep theme dependencies out of the plugin.
2. For REST routes, document parameters and permission callbacks. Validate input and check capabilities before changing data. Escape output at rendering boundaries.
3. Put presentation-only code in the theme. The theme can consume plugin services through the existing container, but plugin behavior should remain available when the theme is switched.
4. Test the changed behavior in `plugin/tests/` and run `npm run check` plus `npm test`.

## Releases and dependency changes

Update the relevant manifest and lockfile together. The root Composer project, theme and plugin each have their own lockfile. `npm start` does not install dependencies. CI and `npm run release` package production dependencies in isolated directories, verify runtime autoloaders and built assets, and reject development files. Review each major dependency update for config or runtime changes before merging it.
