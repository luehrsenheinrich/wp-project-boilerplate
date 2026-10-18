// Executed in the editor so Core serializes valid, current block markup.
module.exports = function createLayoutContent() {
	const { createBlock: b, serialize } = wp.blocks;
	const p = (t) => b('core/paragraph', { content: t });

	const img = (anchor, align) =>
		b('core/image', {
			url:
				location.origin +
				'/wp-content/themes/theme/img/block-patterns/placeholder_000.png',
			alt: 'Layout test image',
			sizeSlug: 'full',
			linkDestination: 'none',
			anchor,
			...(align ? { align } : {}),
		});
	const group = (
		anchor,
		align,
		children,
		padding,
		layout = 'constrained',
		extra = {},
	) =>
		b(
			'core/group',
			{
				anchor,
				...(align ? { align } : {}),
				layout: { type: layout },
				backgroundColor: 'gray-100',
				...(padding ? { style: { spacing: { padding } } } : {}),
				...extra,
			},
			children,
		);
	const full = (id) =>
		group(id, 'full', [p('Full fills its immediate parent.')]);
	const blocks = [b('core/audio', {})];
	for (const align of [undefined, 'wide', 'full']) {
		const key = align || 'normal';
		blocks.push(img('image-' + key, align));
		blocks.push(
			group('group-' + key, align, [
				p('Ordinary group with protected text and image edges.'),
				img('inner-image-' + key),
				group('nested-wide-' + key, 'wide', [p('Wide child')]),
				full('nested-full-' + key),
				img('full-image-' + key, 'full'),
			]),
		);
		blocks.push(
			b(
				'core/cover',
				{
					anchor: 'cover-' + key,
					...(align ? { align } : {}),
					overlayColor: 'gray-700',
					isUserOverlayColor: true,
					layout: { type: 'constrained' },
				},
				[p('Cover content'), full('cover-child-' + key)],
			),
		);
	}
	blocks.push(
		group(
			'group-full-flow',
			'full',
			[
				p('Flow text spans all available space.'),
				group('flow-wide', 'wide', [p('Wide in flow')]),
				full('flow-full'),
				group('flow-reader', undefined, [p('Constrained reader in full Flow')]),
			],
			undefined,
			'default',
		),
	);
	for (const stack of [true, false])
		blocks.push(
			b(
				'core/columns',
				{ anchor: 'columns-' + stack, align: 'wide', isStackedOnMobile: stack },
				[
					b('core/column', {}, [
						img('float-left-' + stack, 'left'),
						p('Text beside float. '.repeat(8)),
						img('float-right-' + stack, 'right'),
						p('Text beside float. '.repeat(8)),
						full('column-full-' + stack),
					]),
					b('core/column', {}, [p('Neighbouring column')]),
				],
			),
		);
	blocks.push(
		group('zero', 'wide', [p('Explicit zero.'), img('zero-full', 'full')], {
			top: '0',
			right: '0',
			bottom: '0',
			left: '0',
		}),
	);
	blocks.push(
		group(
			'asymmetric',
			'wide',
			[
				p('Asymmetric padding, gap and margin.'),
				img('asym-normal'),
				img('asym-full', 'full'),
			],
			{
				top: 'var:preset|spacing|l',
				right: 'var:preset|spacing|s',
				bottom: 'var:preset|spacing|s',
				left: 'var:preset|spacing|l',
			},
			'constrained',
			{
				style: {
					spacing: {
						padding: {
							top: 'var:preset|spacing|l',
							right: 'var:preset|spacing|s',
							bottom: 'var:preset|spacing|s',
							left: 'var:preset|spacing|l',
						},
						blockGap: 'var:preset|spacing|l',
						margin: {
							top: 'var:preset|spacing|l',
							bottom: 'var:preset|spacing|s',
						},
					},
				},
			},
		),
	);
	blocks.push(
		group('outer', 'full', [
			p('Outer'),
			group('inner', 'full', [
				p('Inner'),
				img('inner-normal'),
				img('inner-full', 'full'),
			]),
		]),
	);

	// Keep classic markup as source: HTML block content is local-only in Core 7.1.
	return (
		serialize(blocks) +
		'<div class="wp-caption aligncenter" style="width:800px"><img src="' +
		location.origin +
		'/wp-content/themes/theme/img/block-patterns/placeholder_000.png" alt="Classic caption test"/><p class="wp-caption-text">Classic caption</p></div><figure class="wp-block-audio"><audio controls></audio></figure>'
	);
};
