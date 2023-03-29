/**
 * WordPress dependencies.
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody } from '@wordpress/components';
import IconSelectControl from '../../admin/src/js/components/icon-select-control';
import Icon from '../../admin/src/js/components/icon';

const Edit = (props) => {
	const { attributes, setAttributes } = props;
	const { icon } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'lhpbpp')}>
					<p>{__('This is a demo block.', 'lhpbpp')}</p>
					<IconSelectControl
						value={icon}
						onChange={(value) => setAttributes({ icon: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				{icon && (
					<div className="icon">
						<Icon slug={icon} />
					</div>
				)}
				<p>{__('This is a demo block.', 'lhpbpp')}</p>
			</div>
		</>
	);
};

export default Edit;
