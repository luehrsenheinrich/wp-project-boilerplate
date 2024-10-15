/**
 * Strip Editor
 *
 * A JavaScript module to simplify and customize the WordPress block editor.
 * This script removes or disables specific editor elements, blocks, and settings
 * to create a streamlined editing experience, aligning with the theme's visual
 * and functional design requirements.
 */

import domReady from '@wordpress/dom-ready';
import {
	unregisterBlockVariation,
	getBlockVariations,
} from '@wordpress/blocks';

/**
 * Unregisters all variations for a specified block type.
 *
 * This function removes all registered variations of the given block type,
 * except the default variation (if defined as `isDefault: true`). This is useful
 * for simplifying the editor interface by removing alternative options while retaining
 * the primary block variation.
 *
 * @param {string} blockName The name of the block to unregister variations from (e.g., 'core/group').
 */
function removeAllBlockVariations(blockName) {
	const variations = getBlockVariations(blockName);

	// Unregister each variation for the specified block type.
	for (const variation of variations) {
		if (!variation.isDefault) {
			unregisterBlockVariation(blockName, variation.name);
		}
	}
}

domReady(() => {
	removeAllBlockVariations('core/group');
});
