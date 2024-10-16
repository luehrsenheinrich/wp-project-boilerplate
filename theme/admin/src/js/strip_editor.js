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
	unregisterBlockStyle,
	store as blocksStore,
} from '@wordpress/blocks';

import { select } from '@wordpress/data';

/**
 * Retrieves all styles for a specified block type.
 *
 * This function queries the block styles for a given block type,
 * making it easy to access all registered styles for the specified block.
 *
 * @param {string} blockName The name of the block to retrieve styles from (e.g., 'core/quote').
 * @return {Array} An array of block styles for the specified block type.
 */
function getBlockStyles(blockName) {
	const { getBlockStyles: retrieveBlockStyles } = select(blocksStore);
	return retrieveBlockStyles(blockName) || [];
}

/**
 * Unregisters all styles for a specified block type.
 *
 * This function removes all registered styles of the given block type,
 * except the default style (if defined as `isDefault: true`). This is useful
 * for simplifying the editor interface by removing alternative options while retaining
 * the primary block style.
 *
 * @param {string} blockName The name of the block to unregister styles from (e.g., 'core/quote').
 */
function removeAllBlockStyles(blockName) {
	const styles = getBlockStyles(blockName);

	// Unregister each style for the specified block type.
	for (const style of styles) {
		if (!style.isDefault) {
			unregisterBlockStyle(blockName, style.name);
		}
	}
}

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
	removeAllBlockStyles('core/quote');
});
