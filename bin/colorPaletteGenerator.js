const { get } = require('lodash');
const { Rule, Declaration } = require('postcss');

/**
 * Generate the stylesheet needed for a color palette element.
 *
 * @param {Object} element The element to generate the stylesheet for.
 * @param {Object} meta    The metadata for the generator.
 * @return {Object}       The AST representing the stylesheet.
 */
function colorPaletteGenerator(element, meta) {
	const stylesheet = [];

	for (let className in get(meta, 'classes', {})) {
		const prop = get(meta, 'classes', {})[className];
		className = className.replace('$slug', element.slug);

		const rule = new Rule({ selector: className });
		rule.append(
			new Declaration({ prop, value: get(element, meta.valueKey) })
		);

		// Generate a set of variables to use down the line
		rule.append(
			new Declaration({
				prop: '--current-' + prop,
				value: get(element, meta.valueKey),
			})
		);

		// Do we have hover rules?
		if (get(element, 'hover', false)) {
			rule.append(
				new Declaration({
					prop: '--current-hover-' + prop,
					value: get(element, 'hover'),
				})
			);
		}

		if (get(element, 'contrast', false)) {
			rule.append(
				new Declaration({
					prop: '--current-contrast-' + prop,
					value: get(element, 'contrast'),
				})
			);
		}

		stylesheet.push(rule);
	}

	return stylesheet;
}

module.exports = colorPaletteGenerator;
