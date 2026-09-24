/** Catch CSS that still contains PostCSS-only imports or custom media. */
const fs = require('node:fs');
const path = require('node:path');
const { globSync } = require('glob');

const root = path.resolve(__dirname, '..');
const files = globSync('theme/dist/css/*.css', { cwd: root });
if (!files.length) {
	throw new Error('No compiled theme CSS found');
}
for (const file of files) {
	const css = fs.readFileSync(path.join(root, file), 'utf8');
	if (/@import\s+["']|@media\s*\(--[\w-]+\s*\)/.test(css)) {
		throw new Error(`${file} contains an unresolved PostCSS import or custom media query`);
	}
}
if (!fs.readFileSync(path.join(root, 'theme/dist/css/vars.min.css'), 'utf8').includes('--color-primary-500')) {
	throw new Error('Theme design tokens are missing from compiled CSS');
}
console.log(`Verified ${files.length} compiled theme CSS files`);
