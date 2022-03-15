const fs = require('fs');

fs.readFile('./plugin/lhpbp.php', (err, data) => {
    if (err) {
        console.error(err);
        return;
    }

    const pkg = require('./../package.json');

    // Find the file doc comment.
    const regex = /<\?php\s(\/\*(?:[^*]|\n|(?:\*(?:[^\/]|\n)))*\*\/)\s/;

    // Create a new file doc comment.
    const newFileDocComment = `<?php
/**
 * The main file of the plugin.
 *
 * @package ${pkg.name}
 *
 * Plugin Name: ${pkg.title}
 * Plugin URI: ${pkg.authorUrl}
 * Description: ${pkg.description}
 * Author: ${pkg.author}
 * Author URI: ${pkg.authorUrl}
 * Version: ${pkg.version}
 * Text Domain: ${pkg.name}p
 * Domain Path: /languages
 */
`;

    // Replace the file doc comment.
    const newData = data.toString().replace(regex, newFileDocComment);

    // Write the new content to the file.
    fs.writeFile('./plugin/lhpbp.php', newData, (err) => {
        if (err) {
            console.error(err);
            return;
        }
    });

    console.log(data.toString().replace(regex, newFileDocComment));
});

