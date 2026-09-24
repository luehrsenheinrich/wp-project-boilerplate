/** Build release archives from isolated production installations. */
const fs = require('node:fs');
const os = require('node:os');
const path = require('node:path');
const { execFileSync } = require('node:child_process');
const { globSync } = require('glob');
const ignore = require('ignore');
const { slug } = require('../package.json');

const root = path.resolve(__dirname, '..');
const archiveDir = path.join(root, 'archives');

async function createArchive(component, suffix) {
	const { ZipArchive } = await import('archiver');
	const source = path.join(root, component);
	const stagingRoot = fs.mkdtempSync(path.join(os.tmpdir(), 'lhpbp-release-'));
	const staging = path.join(stagingRoot, component);
	const ignores = ignore().add(
		'/vendor/\n/tests/\n/phpunit.xml\n/.phpunit.cache/\n/.distignore\n.DS_Store'
	);
	const distignore = path.join(source, '.distignore');
	if (fs.existsSync(distignore)) {
		ignores.add(fs.readFileSync(distignore, 'utf8'));
	}

	try {
		fs.cpSync(source, staging, {
			recursive: true,
			filter: (entry) => {
				const relative = path.relative(source, entry).split(path.sep).join('/');
				return !relative || !ignores.ignores(relative);
			},
		});
		execFileSync(
			'composer',
			['install', '--no-dev', '--prefer-dist', '--no-interaction', '--optimize-autoloader'],
			{ cwd: staging, stdio: 'inherit' }
		);

		fs.mkdirSync(archiveDir, { recursive: true });
		const destination = path.join(archiveDir, `${slug}${suffix}.zip`);
		await new Promise((resolve, reject) => {
			const output = fs.createWriteStream(destination);
			const archive = new ZipArchive({ zlib: { level: 9 } });
			output.on('close', resolve);
			output.on('error', reject);
			archive.on('error', reject);
			archive.pipe(output);
			for (const file of globSync('**/*', { cwd: staging, nodir: true, dot: true })) {
				if (/^vendor\/.+\/(tests?|docs?|examples?)(\/|$)|^vendor\/.+\/(phpunit\.xml|\.phpunit\.cache)(\/|$)/.test(file)) {
					continue;
				}
				archive.file(path.join(staging, file), { name: `${slug}${suffix}/${file}` });
			}
			archive.finalize();
		});
		console.log(`Created ${destination}`);
	} finally {
		fs.rmSync(stagingRoot, { recursive: true, force: true });
	}
}

(async () => {
	await createArchive('plugin', 'p');
	await createArchive('theme', 't');
})().catch((error) => {
	console.error(error);
	process.exitCode = 1;
});
