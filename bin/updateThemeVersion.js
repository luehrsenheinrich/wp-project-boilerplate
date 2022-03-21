/**
 * We need to update the theme version in the main theme files.
 * This is done by reading the theme files, finding the lines that
 * contains the version number, and replacing it with the new version.
 */

const fs = require('fs');
const pkg = require('../package.json');

fs.readFile(`./theme/style.css`, (err, data) => {
    if (err) {
        console.error(err);
        return;
    }

    // Find the style header.
    const styleHeaderRegex = /\/\*(?:[^*]|\n|(?:\*(?:[^\/]|\n)))*\*\//;

    // Find the version row.
    const versionRowRegex = /[\s?]\*[\s?]Version:[\s?]\d.\d.\d/;

    // Extract the existing style header.
    const styleHeader = data.toString().match(styleHeaderRegex)[0];

    // Build the new version row.
    const newVersionRow = ` * Version: ${pkg.version}`;

    // Build the new style header.
    const newStyleHeader = styleHeader.replace(versionRowRegex, newVersionRow);

    // Replace the existing style header.
    let newData = data.toString().replace(styleHeaderRegex, newStyleHeader);

    // Write the new content to the file.
    fs.writeFile('./theme/style.css', newData, (err) => {
        console.log( 'Theme version in style.css updated.' );
        if (err) {
            console.error(err);
            return;
        }
    });
});
