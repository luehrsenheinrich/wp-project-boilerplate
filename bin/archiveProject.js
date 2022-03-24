/**
 * External Dependencies
 */
const fs = require('fs');
const archiver = require('archiver');

const createArchive = (path, srcPath, slug) => {
    const output = fs.createWriteStream(path + '/' + slug + '.zip');
}
