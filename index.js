( function( wp ) {
	var registerBlockType = wp.blocks.registerBlockType;
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var PanelBody = wp.components.PanelBody;
	var ToggleControl = wp.components.ToggleControl;
	var RangeControl = wp.components.RangeControl;
	var TextControl = wp.components.TextControl;
	var ColorPalette = wp.components.ColorPalette;
	var { getColorObjectByColorValue } = wp.editor || wp.blockEditor;

	registerBlockType( 'rafy/user-avatar-menu-account', {
		icon: el('svg', { 
			width: 24,
			height: 24,
			viewBox: "0 0 24 24",
			xmlns: "http://www.w3.org/2000/svg",
			ariaHidden: "true",
			focusable: "false"
		}, 
			el('path', { 
				d: "M7.25 16.437a6.5 6.5 0 1 1 9.5 0V16A2.75 2.75 0 0 0 14 13.25h-4A2.75 2.75 0 0 0 7.25 16v.437Zm1.5 1.193a6.47 6.47 0 0 0 3.25.87 6.47 6.47 0 0 0 3.25-.87V16c0-.69-.56-1.25-1.25-1.25h-4c-.69 0-1.25.56-1.25 1.25v1.63ZM4 12a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm10-2a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z", 
				'fill-rule': 'evenodd',
				'clip-rule': 'evenodd'
			})
		),

		attributes: {
			size: {
				type: 'number',
				default: 32,
			},
			radius: {
				type: 'number',
				default: 16,
			},
			isAvatar: {
				type: 'string',
				default: 'yes',
			},
			prefix: {
				type: 'string',
				default: '',
			},
			color: {
				type: 'string',
				default: '#000000'
			},
			isMyAccountLink: {
				type: 'boolean',
				default: true,
			},
			customLink: {
				type: 'string',
				default: '',
			},
			linkTarget: {
				type: 'string',
				default: '_self',
			}
		},

		edit: function( props ) {
			var { size, radius, isAvatar, prefix, color, isMyAccountLink, customLink, linkTarget } = props.attributes;
			var displayName = 'Jhon Doe';

			var containerProps = Object.assign({}, useBlockProps(), { 
				style: { display: 'flex', alignItems: 'center', gap: '.5em', color: color } 
			});

			var mysteryManUrl = "https://secure.gravatar.com/avatar/?d=mm&s=" + size;

			const settings = wp.data.select('core/block-editor')?.getSettings();
			const themeColors = settings?.colors || [];
			const customColors = settings?.customColors || [];
			const allColors = [...themeColors, ...customColors];

			return [
				el( InspectorControls, {}, 
					el( PanelBody, {
						title: __( 'Avatar', 'user-avatar-menu-account' ),
						initialOpen: true
					},
						el( 'label', {}, __( 'Size', 'user-avatar-menu-account' ) ),
						el( RangeControl, {
							value: size,
							onChange: ( newSize ) => props.setAttributes( { size: newSize } ),
							min: 8,
							max: 128,
							step: 1
						} ),

						el( ToggleControl, {
							label: __( 'Enable User Avatar', 'user-avatar-menu-account' ),
							checked: isAvatar === 'yes',
							onChange: ( new_isAvatar ) => {
								console.log(isAvatar);
								props.setAttributes({
									isAvatar: new_isAvatar ? 'yes' : 'no'
							})}
						} ),

						isAvatar === 'yes' && 
						el( 'label', {}, __( 'Avatar Radius', 'user-avatar-menu-account' ) ),

						isAvatar === 'yes' && 
						el( RangeControl, {
							value: radius,
							onChange: ( newRadius ) => props.setAttributes( { radius: newRadius } ),
							min: 0,
							max: 64,
							step: 1
						} )
					),

					el( PanelBody, {
						title: __( 'Style', 'user-avatar-menu-account' ),
						initialOpen: false
					},
						el( 'p', {}, __( 'Text & Icon Color', 'user-avatar-menu-account' ) ),
						el( ColorPalette, {
							colors: allColors,
							value: color,
							onChange: (newColor) => {
								const colorObject = getColorObjectByColorValue(allColors, newColor);
								props.setAttributes({
									color: newColor,
									colorSlug: colorObject ? colorObject.slug : ''
								});
							},
							disableCustomColors: false,
							clearable: true
						})
					),

					el( PanelBody, {
						title: __( 'Text & Link', 'user-avatar-menu-account' ),
						initialOpen: false
					},
						el( 'label', {}, __( 'Prefix', 'user-avatar-menu-account' ) ),
						el( TextControl, {
							value: prefix,
							onChange: ( newPrefix ) => props.setAttributes( { prefix: newPrefix } )
						} ),
						
						el( ToggleControl, {
							label: __( 'WooCommerce "My Account" Link', 'user-avatar-menu-account' ),
							checked: isMyAccountLink,
							onChange: ( new_isMyAccountLink ) => props.setAttributes( { isMyAccountLink: new_isMyAccountLink } )
						} ),

						!isMyAccountLink && 
						el( 'label', {}, __( 'Custom Link', 'user-avatar-menu-account' ) ),
						
						!isMyAccountLink && 
						el( TextControl, {
							value: customLink,
							placeholder: 'https://',
							onChange: ( newLink ) => props.setAttributes( { customLink: newLink } )
						} ),
						
						el( ToggleControl, {
							label: __( 'Open in new Window', 'user-avatar-menu-account' ),
							checked: linkTarget === '_blank',
							onChange: ( new_linkTarget ) => props.setAttributes({
								linkTarget: new_linkTarget ? '_blank' : '_self'
							})
						} )
					)
				),

				el( 'div', containerProps,
					isAvatar === 'no' && 
					el('svg', { 
						width: size,
						height: size,
						fill: "none",
						stroke: "currentColor",
						strokeWidth: "1.5",
						viewBox: "0 0 24 24",
						xmlns: "http://www.w3.org/2000/svg",
						ariaHidden: "true",
						focusable: "false"
					}, 
						el('path', { d: "M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" }),
						el('path', { d: "M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" }),
						el('path', { d: "M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" })
					),

					isAvatar === 'yes' && mysteryManUrl && 
					el('img', { 
						src: mysteryManUrl, 
						width: size, 
						height: size,
						style: { borderRadius: `${radius}px` }
					}),
					
					el( 'div', {},
						el( 'span', { style: { fontSize: '16px' } }, prefix ),
						el( 'span', { style: { fontSize: '16px', fontWeight: 'bold' } }, displayName )
					)
				)
			];
		}
	} );
}(
	window.wp
) );
