/* eslint-disable no-console */

const https = require('node:https');
const fs = require('node:fs');

/**
 * Load the default theme schema.
 */
https.get('https://schemas.wp.org/trunk/theme.json', (res) => {
	let body = '';

	res.on('data', (chunk) => {
		body += chunk;
	});

	res.on('end', () => {
		if (res.statusCode === 200) {
			try {
				/**
				 * @see https://schemas.wp.org/trunk/theme.json
				 */
				const themeJsonSchema = JSON.parse(body);

				const fileContent = JSON.stringify(themeJsonSchema, null, 2);

				fs.writeFile('./schemas/theme.json', fileContent, (error) => {
					if (error) {
						console.error(error);
					} else {
						console.log('Theme schema updated.');
					}
				});
			} catch (error) {
				console.error('Error parsing JSON:', error);
			}
		} else {
			console.error(`HTTP error: ${res.statusCode}`);
		}
	});
}).on('error', (err) => {
	console.error('Request error:', err);
});
