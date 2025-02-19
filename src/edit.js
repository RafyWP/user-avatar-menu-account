/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * Edit component for the 'User Avatar & Menu Account' block.
 *
 * @param {Object} props - The component props.
 * @param {Object} props.attributes - Block attributes.
 * @param {Function} props.setAttributes - Function to update block attributes.
 * @returns {JSX.Element} The rendered edit component.
 */
import {
	useBlockProps,
	InspectorControls
} from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl,
	RangeControl,
	TextControl,
	ColorPalette
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { getColorObjectByColorValue } from '@wordpress/block-editor';

const Edit = ( { attributes, setAttributes } ) => {
	const { size, radius, isAvatar, prefix, color, isMyAccountLink, customLink, linkTarget } = attributes;
	const displayName = 'Jhon Doe';
	const containerProps = {
		...useBlockProps(),
		style: { display: 'flex', alignItems: 'center', gap: '.5em', color },
	};
	const mysteryManUrl = `https://secure.gravatar.com/avatar/?d=mm&s=${ size }`;

	const settings = useSelect( ( select ) => select( 'core/block-editor' ).getSettings() || {}, [] );
	const themeColors = settings.colors || [];
	const customColors = settings.customColors || [];
	const allColors = [ ...themeColors, ...customColors ];

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Avatar', 'user-avatar-menu-account' ) } initialOpen={ true }>
					<label>{ __( 'Size', 'user-avatar-menu-account' ) }</label>
					<RangeControl
						value={ size }
						onChange={ ( newSize ) => setAttributes( { size: newSize } ) }
						min={ 8 }
						max={ 128 }
						step={ 1 }
					/>
					<ToggleControl
						label={ __( 'Enable User Avatar', 'user-avatar-menu-account' ) }
						checked={ isAvatar === 'yes' }
						onChange={ ( newIsAvatar ) => setAttributes( { isAvatar: newIsAvatar ? 'yes' : 'no' } ) }
					/>
					{ isAvatar === 'yes' && <label>{ __( 'Avatar Radius', 'user-avatar-menu-account' ) }</label> }
					{ isAvatar === 'yes' && (
						<RangeControl
							value={ radius }
							onChange={ ( newRadius ) => setAttributes( { radius: newRadius } ) }
							min={ 0 }
							max={ 64 }
							step={ 1 }
						/>
					) }
				</PanelBody>
				<PanelBody title={ __( 'Style', 'user-avatar-menu-account' ) } initialOpen={ false }>
					<p>{ __( 'Text & Icon Color', 'user-avatar-menu-account' ) }</p>
					<ColorPalette
						colors={ allColors }
						value={ color }
						onChange={ ( newColor ) => {
							const colorObject = getColorObjectByColorValue( allColors, newColor );
							setAttributes( {
								color: newColor,
								colorSlug: colorObject ? colorObject.slug : '',
							} );
						} }
						disableCustomColors={ false }
						clearable={ true }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Text & Link', 'user-avatar-menu-account' ) } initialOpen={ false }>
					<label>{ __( 'Prefix', 'user-avatar-menu-account' ) }</label>
					<TextControl
						value={ prefix }
						onChange={ ( newPrefix ) => setAttributes( { prefix: newPrefix } ) }
					/>
					<ToggleControl
						label={ __( 'WooCommerce "My Account" Link', 'user-avatar-menu-account' ) }
						checked={ isMyAccountLink }
						onChange={ ( newIsMyAccountLink ) => setAttributes( { isMyAccountLink: newIsMyAccountLink } ) }
					/>
					{ ! isMyAccountLink && <label>{ __( 'Custom Link', 'user-avatar-menu-account' ) }</label> }
					{ ! isMyAccountLink && (
						<TextControl
							value={ customLink }
							placeholder="https://"
							onChange={ ( newLink ) => setAttributes( { customLink: newLink } ) }
						/>
					) }
					<ToggleControl
						label={ __( 'Open in new Window', 'user-avatar-menu-account' ) }
						checked={ linkTarget === '_blank' }
						onChange={ ( newLinkTarget ) =>
							setAttributes( { linkTarget: newLinkTarget ? '_blank' : '_self' } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...containerProps }>
				{ isAvatar === 'no' && (
					<svg
						width={ size }
						height={ size }
						fill="none"
						stroke="currentColor"
						strokeWidth="1.5"
						viewBox="0 0 24 24"
						xmlns="http://www.w3.org/2000/svg"
						aria-hidden="true"
						focusable="false"
					>
						<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
						<path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
						<path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
					</svg>
				) }
				{ isAvatar === 'yes' && mysteryManUrl && (
					<img
						src={ mysteryManUrl }
						width={ size }
						height={ size }
						style={ { borderRadius: `${ radius }px` } }
						alt={ __( 'User Avatar', 'user-avatar-menu-account' ) }
					/>
				) }
				<div>
					<span style={ { fontSize: '16px' } }>{ prefix }</span>
					<span style={ { fontSize: '16px', fontWeight: 'bold' } }>{ displayName }</span>
				</div>
			</div>
		</>
	);
};

export default Edit;
