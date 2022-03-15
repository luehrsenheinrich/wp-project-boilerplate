const fs = require('fs');
const { version } = require('os');
const pkg = require('../package.json');

fs.readFile(`./plugin/${pkg.slug}.php`, (err, data) => {
    if (err) {
        console.error(err);
        return;
    }

    // Find the file doc comment.
    const fileDocRegex = /<\?php\s(\/\*(?:[^*]|\n|(?:\*(?:[^\/]|\n)))*\*\/)\s/;

    const uppercaseSlug = pkg.slug.toUpperCase();

    // Find the version constant.
    const versionRegex = new RegExp("define\\( '" + uppercaseSlug + "P_VERSION', '(.*)' \\);");

    // Create a new file doc comment.
    const newFileDocComment = `<?php
/**
 * The main file of the plugin.
 *
 * @package ${pkg.slug}
 *
 * Plugin Name: ${pkg.title}
 * Plugin URI: ${pkg.authorUrl}
 * Description: ${pkg.description}
 * Author: ${pkg.author}
 * Author URI: ${pkg.authorUrl}
 * Version: ${pkg.version}
 * Text Domain: ${pkg.slug}p
 * Domain Path: /languages
 */
`;

    // Replace the file doc comment.
    let newData = data.toString().replace(fileDocRegex, newFileDocComment);

    // Create a new version constant.
    const newVersionConstant = `define( '${uppercaseSlug}P_VERSION', '${pkg.version}' );`;

    // Replace the version constant.
    newData = newData.replace(versionRegex, newVersionConstant);

    // Write the new content to the file.
    fs.writeFile('./plugin/lhpbp.php', newData, (err) => {
        if (err) {
            console.error(err);
            return;
        }
    });
});

