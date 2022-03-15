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

fs.readFile('./theme/functions.php', (err, data) => {
    if (err) {
        console.error(err);
        return;
    }

    // Generate the uppercase slug.
    const uppercaseSlug = pkg.slug.toUpperCase();

    // Find the version constant.
    const versionRegex = new RegExp("define\\( '" + uppercaseSlug + "T_VERSION', '(.*)' \\);");

    // Extract the existing version constant.
    const versionConstant = data.toString().match(versionRegex)[0];

    // Build the new version constant.
    const newVersionConstant = `define( '${uppercaseSlug}T_VERSION', '${pkg.version}' );`;

    // Replace the existing version constant.
    let newData = data.toString().replace(versionRegex, newVersionConstant);

    // Write the new content to the file.
    fs.writeFile('./theme/functions.php', newData, (err) => {
        console.log( 'Theme version in functions.php updated.' );
        if (err) {
            console.error(err);
            return;
        }
    });

});
