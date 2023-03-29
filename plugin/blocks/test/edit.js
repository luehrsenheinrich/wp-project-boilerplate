/**
 * WordPress dependencies.
 */
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * External dependencies.
 */
import classNames from 'classnames';

/**
 * Internal dependencies.
 */
import IconSelectControl from '../../admin/src/js/components/icon-select-control';

export default function Edit({ attributes, setAttributes }) {
	const { level, text, icon } = attributes;

	const Heading = `h${level}`;

	const textWrapperClasses = classNames(
		'section-heading__text-wrapper',
		`is-style-colored-angle-heading`
	);

	const textClasses = classNames('section-heading__text');
console.log({icon});
	return (
		<>
			<InspectorControls group="block">
				<PanelRow>
					<p>Lorem Ipsum</p>
				</PanelRow>
				<IconSelectControl
					label={__('Icon', 'jitmp')}
					value={icon}
					onChange={(value) => {
						console.log({value});
						setAttributes({ icon: value });
					}}
				/>
			</InspectorControls>
			<Heading
				{...useBlockProps({
					className: classNames(
						'tdl-section-heading has-no-margin-bottom',
					),
				})}
			>
				<span className={textWrapperClasses}>
					<RichText
						className={textClasses}
						tagName={`span`}
						allowedFormats={[]}
						value={text}
						onChange={(value) => setAttributes({ text: value })}
						placeholder={__('Section Heading…', 'jitmp')}
						onReplace={() => {}}
						onSplit={() => {}}
					/>
				</span>
			</Heading>
		</>
	);
}
