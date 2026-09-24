# Agent workflows for this boilerplate

## Why the boundary matters

The Block Editor is our content composition tool, not our site designer. Editors should be able to rearrange approved blocks and layouts without making design-system decisions. PHP templates and theme styles define the site; the plugin owns content behavior that should survive a theme switch. Keep the Site Editor out of this project workflow. When a layout needs to be reusable but editable, prefer an unlocked theme pattern. Use `contentOnly` or block locking only for a component whose structure is intentionally fixed.

These project-specific notes adapt the useful block and plugin guidance from the unmerged `add/agent-skills` branch. They describe the implementation in this repository; do not copy generic WordPress scaffolds over the existing build and bootstraps.

## Add or change a block

1. Decide which behavior remains useful if the theme changes. Put registration and rendering behavior in `plugin/`; put appearance in `theme/src/css/`.
2. Put metadata in `plugin/blocks/<name>/block.json`. `plugin/inc/Blocks/Blocks.php` discovers each immediate block directory at `init`. Its render callback loads `template.php` from that directory when present, otherwise it returns saved content.
3. Import editor registration code from `plugin/admin/src/js/blocks.js`. Declare the registered `lhpbpp-blocks` handle as `editorScript` in metadata. Webpack writes that bundle and its dependency manifest into `plugin/admin/dist/`; WordPress loads it in the editor. Preserve the dependency extraction setup.
4. For dynamic markup, escape output and use `get_block_wrapper_attributes()` so core block supports work. Register appearance in the theme with `wp_enqueue_block_style()` so it loads only when the block is rendered. `editorial-note` is the working example.
5. Add a focused PHP test when registration, render output or a helper changes. Run `npm run check`, `npm test` and `npm run test:e2e` for editor or frontend behavior.

The general `@wordpress/create-block` scaffold is a reference, not a drop-in project layout here. Inspect the existing webpack entries and PHP registration before using generated code.

## Add or change plugin functionality

1. Keep `plugin/lhpbpp.php` small. Place a component in `plugin/inc/`, wire it through the existing container and WordPress hooks, and keep theme dependencies out of the plugin.
2. For REST routes, document parameters and permission callbacks. Validate input and check capabilities before changing data. Escape output at rendering boundaries.
3. Put presentation-only code in the theme. The theme can consume plugin services through the existing container, but plugin behavior should remain available when the theme is switched.
4. Test the changed behavior in `plugin/tests/` and run `npm run check` plus `npm test`.

## Releases and dependency changes

Update the relevant manifest and lockfile together. The root Composer project, theme and plugin each have their own lockfile. `npm start` does not install dependencies. CI and `npm run release` package production dependencies in isolated directories, verify runtime autoloaders and built assets, and reject development files. Review each major dependency update for config or runtime changes before merging it.
