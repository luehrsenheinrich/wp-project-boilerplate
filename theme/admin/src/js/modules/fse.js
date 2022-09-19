/**
 * This module is used to fix behavior associated with FSE in Gutenberg.
 */

import { unregisterBlockVariation } from '@wordpress/blocks';
import { addFilter } from '@wordpress/hooks';
import domReady from '@wordpress/dom-ready';

domReady(() => {
	// Disable some block variations as they rely on non semantic inline css.
	unregisterBlockVariation('core/group', 'group-row');
	unregisterBlockVariation('core/group', 'group-stack');
});

/**
 * @type {string[]} Array of block names that should be excluded from the layout settings.
 */
const haystack = ['core/group'];

addFilter(
	'blocks.registerBlockType',
	'lh/fseFixes/layoutSettings',
	(settings, name) => {
		if (!haystack.includes(name)) {
			return settings;
		}

		const newSettings = {
			...settings,
			supports: {
				...(settings.supports || {}),
				layout: {
					...(settings.supports.layout || {}),
					allowEditing: false,
					allowSwitching: false,
					allowInheriting: true,
				},
				__experimentalLayout: {
					...(settings.supports.__experimentalLayout || {}),
					allowEditing: false,
					allowSwitching: false,
					allowInheriting: true,
				},
			},
		};
		return newSettings;
	},
	20
);

addFilter(
	'blocks.getBlockAttributes',
	'lh/fseFixes',
	(attributes, blockType) => {
		if (!haystack.includes(blockType.name)) {
			return attributes;
		}

		attributes = {
			...attributes,
			layout: {
				inherit: true,
			},
		};

		return attributes;
	}
);
