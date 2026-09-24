/** Verify the contents of both release ZIPs before upload. */
const path = require('node:path');
const { execFileSync } = require('node:child_process');
const { slug } = require('../package.json');

for (const [suffix, required] of [
	['p', ['vendor/autoload.php', `${slug}p.php`, 'admin/dist/js/blocks.min.js', 'admin/dist/css/style.min.css']],
	['t', ['vendor/autoload.php', 'style.css', 'dist/css/base.min.css', 'dist/js/script.min.js']],
]) {
	const archive = path.resolve(__dirname, '..', 'archives', `${slug}${suffix}.zip`);
	const prefix = `${slug}${suffix}/`;
	const archiveEntries = execFileSync('unzip', ['-Z1', archive], { encoding: 'utf8' })
		.trim()
		.split('\n');
	if (archiveEntries.some((entry) => !entry.startsWith(prefix))) {
		throw new Error(`${archive} contains files outside ${prefix}`);
	}
	const entries = archiveEntries.map((entry) => entry.slice(prefix.length));
	execFileSync('unzip', ['-tqq', archive]);
	for (const item of required) {
		if (!entries.some((entry) => entry.startsWith(item))) {
			throw new Error(`${archive} is missing ${item}`);
		}
	}
	const forbidden = entries.filter((entry) =>
		/^(tests|src|node_modules|admin\/src|\.phpunit\.cache)(\/|$)|(^|\/)(phpunit\.xml|\.distignore|\.DS_Store)$|^vendor\/(bin|phpunit|sebastian|yoast)\/|^vendor\/.+\/(tests?|docs?|examples?)(\/|$)/.test(entry)
	);
	if (forbidden.length) {
		throw new Error(`${archive} contains development files: ${forbidden.slice(0, 5).join(', ')} (${forbidden.length} total)`);
	}
	console.log(`Verified ${archive} (${entries.length} files)`);
}
