import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import metadata from '../../../../blocks/editorial-note/block.json';

registerBlockType(metadata, {
	edit: function Edit({ attributes, setAttributes }) {
		return (
			<aside {...useBlockProps({ className: 'lhpbpp-editorial-note' })}>
				<RichText
					tagName="div"
					className="lhpbpp-editorial-note__content"
					value={attributes.content || ''}
					onChange={(content) => setAttributes({ content })}
					placeholder={__('Add editorial context…', 'lhpbpp')}
				/>
			</aside>
		);
	},
	save() {
		return null;
	},
});
