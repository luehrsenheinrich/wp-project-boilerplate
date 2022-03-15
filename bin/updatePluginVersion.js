const fs = require('fs');
const pkg = require('../package.json');

fs.readFile(`./plugin/${pkg.slug}.php`, (err, data) => {
    if (err) {
        console.error(err);
        return;
    }

    // Find the file doc comment.
    const fileDocRegex = /<\?php\s(\/\*(?:[^*]|\n|(?:\*(?:[^\/]|\n)))*\*\/)\s/;
    const versionRowRegex = /[\s?]\*[\s?]Version:[\s?]\d.\d.\d/;

    const uppercaseSlug = pkg.slug.toUpperCase();

    // Find the version constant.
    const versionRegex = new RegExp("define\\( '" + uppercaseSlug + "P_VERSION', '(.*)' \\);");

    // Extract the existing file doc comment.
    const fileDocComment = data.toString().match(fileDocRegex)[0];

    // Build the new version row.
    const newVersionRow = ` * Version: ${pkg.version}`;

    // Replace the existing version row.
    let newData = data.toString().replace(versionRowRegex, newVersionRow);

    // Create a new version constant.
    const newVersionConstant = `define( '${uppercaseSlug}P_VERSION', '${pkg.version}' );`;

    // Replace the version constant.
    newData = newData.replace(versionRegex, newVersionConstant);

    // Write the new content to the file.
    fs.writeFile(`./plugin/${pkg.slug}.php`, newData, (err) => {
        console.log( `Plugin version in ${pkg.slug}.php updated.` );
        if (err) {
            console.error(err);
            return;
        }
    });
});

