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

## Content layout and spacing

The PHP loop renders `the_content()` once inside `.entry-content.is-layout-constrained.has-global-padding` and uses `wp_link_pages()` for native content pagination. The header uses the same Core layout classes. Keep Core's global and block layout styles enabled. Do not target generated `wp-container-*` IDs or add blanket negative margins to Wide/Full blocks.

`theme/theme.json` references `--content-width` and `--wide-width`; `theme/src/css/vars/_content-width.css` is their responsive source in both frontend and editor. Breakpoints remain in the existing breakpoint tokens/custom media. Mobile widths use `100%` of the available parent context.

| Viewport | Content limit | Wide limit |
| --- | --- | --- |
| Below 768 px | Available parent width | Available parent width |
| 768–959 px | `--bp-sm` (768 px) | `--bp-sm` (768 px) |
| 960–1199 px | 10/12 of `--bp-md` (800 px) | `--bp-md` (960 px) |
| From 1200 px | 8/12 of `--bp-lg` (800 px) | `--bp-lg` (1200 px) |

Core's **Constrained** layout limits normal and Wide children to the configured widths, bounded by the local parent. **Flow** leaves its children at the available width. Full means the available local parent, including inside a column. Put a Constrained Group inside a full Flow surface when its text needs a reading width. Core applies the root gutter through `has-global-padding` and generates the nested Full compensation/reset rules. Columns use Core's 782 px stacking breakpoint and respect “Stack on mobile”. Classical left/right images remain floats, limited to the smaller of half the parent and half the reading width; Center images, caption shortcodes and native media remain contained.

Ordinary Groups and Covers get default vertical padding from `--grid-gutter-height` and horizontal padding from `--grid-gutter-width` through `theme.json`. They do not require a pattern or a background color. Explicit zero, asymmetric padding and saved block values override these defaults. Padding protects a surface's inside edges, block gap separates its children, and margin separates the surface from its neighbours. A Full child may intentionally reach the surface edge. Avoid global `.has-background` padding, which overrides these distinctions.

Core normally generates individual Full compensation from explicit block attributes. The Styles component also passes the resolved Group default padding from `wp_get_global_styles()` to `wp_get_layout_style()`. Its shared low-specificity rule loads in frontend and editor; individual Core layout rules retain precedence. Do not add frontend-only padding attributes or copy negative-margin formulas into CSS.

Editors keep native layout, padding, margin and gap controls. The regular spacing choices are XS, S, M, L, XL, 2XL, 3XL and 4XL (12, 24, 32, 48, 72, 96, 120 and 144 px with the default gutter tokens). Core's Default and None states mean inherited theme spacing and explicit zero respectively. Keep the old `small`, `medium`, `large` and Core numeric preset variables registered. The editor exposes older presets additionally when the current document references them, including escaped serialized block attributes. Do not rename Core labels or replace its controls.

`npm run test:e2e` covers page/post geometry at 320, 390, 767, 768, 959, 960, 1199, 1200 and 1440 px: nested Groups, images, Covers, Flow/Constrained, floats, both Columns stacking modes, default/zero/asymmetric padding, gap, margin and classical media. PHPUnit checks shared default CSS, legacy preset compatibility, single content execution and pagination. For an acceptance run, also import the complete [official Theme Unit Test Data](https://github.com/WordPress/theme-test-data), visit every published post/page and all `<!--nextpage-->` routes at those widths, and check draft/scheduled previews and password protection separately. Keep imported status values unchanged. Chromium geometry checks and selected screenshots do not replace Firefox/Safari, screen-reader, external-embed or every-pixel manual review.

Core references: [layout settings](https://developer.wordpress.org/themes/global-settings-and-styles/settings/layout/), [root padding aware alignments](https://developer.wordpress.org/themes/global-settings-and-styles/settings/use-root-padding-aware-alignments/), [spacing controls](https://developer.wordpress.org/themes/global-settings-and-styles/settings/spacing/).
