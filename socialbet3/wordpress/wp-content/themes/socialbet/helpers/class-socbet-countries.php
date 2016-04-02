<?php
/**
 * List of countries and states
 *
 * @version 1.0
 */

class Socbet_Countries {

	/** @var array Array of countries */
	public $countries;
	/** @var array Array of states */
	public $states;


	public function __construct() {
		global $states;

		$this->countries = array(
			'AF' => __( 'Afghanistan', 'socialbet' ),
			'AX' => __( '&#197;land Islands', 'socialbet' ),
			'AL' => __( 'Albania', 'socialbet' ),
			'DZ' => __( 'Algeria', 'socialbet' ),
			'AD' => __( 'Andorra', 'socialbet' ),
			'AO' => __( 'Angola', 'socialbet' ),
			'AI' => __( 'Anguilla', 'socialbet' ),
			'AQ' => __( 'Antarctica', 'socialbet' ),
			'AG' => __( 'Antigua and Barbuda', 'socialbet' ),
			'AR' => __( 'Argentina', 'socialbet' ),
			'AM' => __( 'Armenia', 'socialbet' ),
			'AW' => __( 'Aruba', 'socialbet' ),
			'AU' => __( 'Australia', 'socialbet' ),
			'AT' => __( 'Austria', 'socialbet' ),
			'AZ' => __( 'Azerbaijan', 'socialbet' ),
			'BS' => __( 'Bahamas', 'socialbet' ),
			'BH' => __( 'Bahrain', 'socialbet' ),
			'BD' => __( 'Bangladesh', 'socialbet' ),
			'BB' => __( 'Barbados', 'socialbet' ),
			'BY' => __( 'Belarus', 'socialbet' ),
			'BE' => __( 'Belgium', 'socialbet' ),
			'PW' => __( 'Belau', 'socialbet' ),
			'BZ' => __( 'Belize', 'socialbet' ),
			'BJ' => __( 'Benin', 'socialbet' ),
			'BM' => __( 'Bermuda', 'socialbet' ),
			'BT' => __( 'Bhutan', 'socialbet' ),
			'BO' => __( 'Bolivia', 'socialbet' ),
			'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'socialbet' ),
			'BA' => __( 'Bosnia and Herzegovina', 'socialbet' ),
			'BW' => __( 'Botswana', 'socialbet' ),
			'BV' => __( 'Bouvet Island', 'socialbet' ),
			'BR' => __( 'Brazil', 'socialbet' ),
			'IO' => __( 'British Indian Ocean Territory', 'socialbet' ),
			'VG' => __( 'British Virgin Islands', 'socialbet' ),
			'BN' => __( 'Brunei', 'socialbet' ),
			'BG' => __( 'Bulgaria', 'socialbet' ),
			'BF' => __( 'Burkina Faso', 'socialbet' ),
			'BI' => __( 'Burundi', 'socialbet' ),
			'KH' => __( 'Cambodia', 'socialbet' ),
			'CM' => __( 'Cameroon', 'socialbet' ),
			'CA' => __( 'Canada', 'socialbet' ),
			'CV' => __( 'Cape Verde', 'socialbet' ),
			'KY' => __( 'Cayman Islands', 'socialbet' ),
			'CF' => __( 'Central African Republic', 'socialbet' ),
			'TD' => __( 'Chad', 'socialbet' ),
			'CL' => __( 'Chile', 'socialbet' ),
			'CN' => __( 'China', 'socialbet' ),
			'CX' => __( 'Christmas Island', 'socialbet' ),
			'CC' => __( 'Cocos (Keeling) Islands', 'socialbet' ),
			'CO' => __( 'Colombia', 'socialbet' ),
			'KM' => __( 'Comoros', 'socialbet' ),
			'CG' => __( 'Congo (Brazzaville)', 'socialbet' ),
			'CD' => __( 'Congo (Kinshasa)', 'socialbet' ),
			'CK' => __( 'Cook Islands', 'socialbet' ),
			'CR' => __( 'Costa Rica', 'socialbet' ),
			'HR' => __( 'Croatia', 'socialbet' ),
			'CU' => __( 'Cuba', 'socialbet' ),
			'CW' => __( 'Cura&Ccedil;ao', 'socialbet' ),
			'CY' => __( 'Cyprus', 'socialbet' ),
			'CZ' => __( 'Czech Republic', 'socialbet' ),
			'DK' => __( 'Denmark', 'socialbet' ),
			'DJ' => __( 'Djibouti', 'socialbet' ),
			'DM' => __( 'Dominica', 'socialbet' ),
			'DO' => __( 'Dominican Republic', 'socialbet' ),
			'EC' => __( 'Ecuador', 'socialbet' ),
			'EG' => __( 'Egypt', 'socialbet' ),
			'SV' => __( 'El Salvador', 'socialbet' ),
			'GQ' => __( 'Equatorial Guinea', 'socialbet' ),
			'ER' => __( 'Eritrea', 'socialbet' ),
			'EE' => __( 'Estonia', 'socialbet' ),
			'ET' => __( 'Ethiopia', 'socialbet' ),
			'FK' => __( 'Falkland Islands', 'socialbet' ),
			'FO' => __( 'Faroe Islands', 'socialbet' ),
			'FJ' => __( 'Fiji', 'socialbet' ),
			'FI' => __( 'Finland', 'socialbet' ),
			'FR' => __( 'France', 'socialbet' ),
			'GF' => __( 'French Guiana', 'socialbet' ),
			'PF' => __( 'French Polynesia', 'socialbet' ),
			'TF' => __( 'French Southern Territories', 'socialbet' ),
			'GA' => __( 'Gabon', 'socialbet' ),
			'GM' => __( 'Gambia', 'socialbet' ),
			'GE' => __( 'Georgia', 'socialbet' ),
			'DE' => __( 'Germany', 'socialbet' ),
			'GH' => __( 'Ghana', 'socialbet' ),
			'GI' => __( 'Gibraltar', 'socialbet' ),
			'GR' => __( 'Greece', 'socialbet' ),
			'GL' => __( 'Greenland', 'socialbet' ),
			'GD' => __( 'Grenada', 'socialbet' ),
			'GP' => __( 'Guadeloupe', 'socialbet' ),
			'GT' => __( 'Guatemala', 'socialbet' ),
			'GG' => __( 'Guernsey', 'socialbet' ),
			'GN' => __( 'Guinea', 'socialbet' ),
			'GW' => __( 'Guinea-Bissau', 'socialbet' ),
			'GY' => __( 'Guyana', 'socialbet' ),
			'HT' => __( 'Haiti', 'socialbet' ),
			'HM' => __( 'Heard Island and McDonald Islands', 'socialbet' ),
			'HN' => __( 'Honduras', 'socialbet' ),
			'HK' => __( 'Hong Kong', 'socialbet' ),
			'HU' => __( 'Hungary', 'socialbet' ),
			'IS' => __( 'Iceland', 'socialbet' ),
			'IN' => __( 'India', 'socialbet' ),
			'ID' => __( 'Indonesia', 'socialbet' ),
			'IR' => __( 'Iran', 'socialbet' ),
			'IQ' => __( 'Iraq', 'socialbet' ),
			'IE' => __( 'Republic of Ireland', 'socialbet' ),
			'IM' => __( 'Isle of Man', 'socialbet' ),
			'IL' => __( 'Israel', 'socialbet' ),
			'IT' => __( 'Italy', 'socialbet' ),
			'CI' => __( 'Ivory Coast', 'socialbet' ),
			'JM' => __( 'Jamaica', 'socialbet' ),
			'JP' => __( 'Japan', 'socialbet' ),
			'JE' => __( 'Jersey', 'socialbet' ),
			'JO' => __( 'Jordan', 'socialbet' ),
			'KZ' => __( 'Kazakhstan', 'socialbet' ),
			'KE' => __( 'Kenya', 'socialbet' ),
			'KI' => __( 'Kiribati', 'socialbet' ),
			'KW' => __( 'Kuwait', 'socialbet' ),
			'KG' => __( 'Kyrgyzstan', 'socialbet' ),
			'LA' => __( 'Laos', 'socialbet' ),
			'LV' => __( 'Latvia', 'socialbet' ),
			'LB' => __( 'Lebanon', 'socialbet' ),
			'LS' => __( 'Lesotho', 'socialbet' ),
			'LR' => __( 'Liberia', 'socialbet' ),
			'LY' => __( 'Libya', 'socialbet' ),
			'LI' => __( 'Liechtenstein', 'socialbet' ),
			'LT' => __( 'Lithuania', 'socialbet' ),
			'LU' => __( 'Luxembourg', 'socialbet' ),
			'MO' => __( 'Macao S.A.R., China', 'socialbet' ),
			'MK' => __( 'Macedonia', 'socialbet' ),
			'MG' => __( 'Madagascar', 'socialbet' ),
			'MW' => __( 'Malawi', 'socialbet' ),
			'MY' => __( 'Malaysia', 'socialbet' ),
			'MV' => __( 'Maldives', 'socialbet' ),
			'ML' => __( 'Mali', 'socialbet' ),
			'MT' => __( 'Malta', 'socialbet' ),
			'MH' => __( 'Marshall Islands', 'socialbet' ),
			'MQ' => __( 'Martinique', 'socialbet' ),
			'MR' => __( 'Mauritania', 'socialbet' ),
			'MU' => __( 'Mauritius', 'socialbet' ),
			'YT' => __( 'Mayotte', 'socialbet' ),
			'MX' => __( 'Mexico', 'socialbet' ),
			'FM' => __( 'Micronesia', 'socialbet' ),
			'MD' => __( 'Moldova', 'socialbet' ),
			'MC' => __( 'Monaco', 'socialbet' ),
			'MN' => __( 'Mongolia', 'socialbet' ),
			'ME' => __( 'Montenegro', 'socialbet' ),
			'MS' => __( 'Montserrat', 'socialbet' ),
			'MA' => __( 'Morocco', 'socialbet' ),
			'MZ' => __( 'Mozambique', 'socialbet' ),
			'MM' => __( 'Myanmar', 'socialbet' ),
			'NA' => __( 'Namibia', 'socialbet' ),
			'NR' => __( 'Nauru', 'socialbet' ),
			'NP' => __( 'Nepal', 'socialbet' ),
			'NL' => __( 'Netherlands', 'socialbet' ),
			'AN' => __( 'Netherlands Antilles', 'socialbet' ),
			'NC' => __( 'New Caledonia', 'socialbet' ),
			'NZ' => __( 'New Zealand', 'socialbet' ),
			'NI' => __( 'Nicaragua', 'socialbet' ),
			'NE' => __( 'Niger', 'socialbet' ),
			'NG' => __( 'Nigeria', 'socialbet' ),
			'NU' => __( 'Niue', 'socialbet' ),
			'NF' => __( 'Norfolk Island', 'socialbet' ),
			'KP' => __( 'North Korea', 'socialbet' ),
			'NO' => __( 'Norway', 'socialbet' ),
			'OM' => __( 'Oman', 'socialbet' ),
			'PK' => __( 'Pakistan', 'socialbet' ),
			'PS' => __( 'Palestinian Territory', 'socialbet' ),
			'PA' => __( 'Panama', 'socialbet' ),
			'PG' => __( 'Papua New Guinea', 'socialbet' ),
			'PY' => __( 'Paraguay', 'socialbet' ),
			'PE' => __( 'Peru', 'socialbet' ),
			'PH' => __( 'Philippines', 'socialbet' ),
			'PN' => __( 'Pitcairn', 'socialbet' ),
			'PL' => __( 'Poland', 'socialbet' ),
			'PT' => __( 'Portugal', 'socialbet' ),
			'QA' => __( 'Qatar', 'socialbet' ),
			'RE' => __( 'Reunion', 'socialbet' ),
			'RO' => __( 'Romania', 'socialbet' ),
			'RU' => __( 'Russia', 'socialbet' ),
			'RW' => __( 'Rwanda', 'socialbet' ),
			'BL' => __( 'Saint Barth&eacute;lemy', 'socialbet' ),
			'SH' => __( 'Saint Helena', 'socialbet' ),
			'KN' => __( 'Saint Kitts and Nevis', 'socialbet' ),
			'LC' => __( 'Saint Lucia', 'socialbet' ),
			'MF' => __( 'Saint Martin (French part)', 'socialbet' ),
			'SX' => __( 'Saint Martin (Dutch part)', 'socialbet' ),
			'PM' => __( 'Saint Pierre and Miquelon', 'socialbet' ),
			'VC' => __( 'Saint Vincent and the Grenadines', 'socialbet' ),
			'SM' => __( 'San Marino', 'socialbet' ),
			'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'socialbet' ),
			'SA' => __( 'Saudi Arabia', 'socialbet' ),
			'SN' => __( 'Senegal', 'socialbet' ),
			'RS' => __( 'Serbia', 'socialbet' ),
			'SC' => __( 'Seychelles', 'socialbet' ),
			'SL' => __( 'Sierra Leone', 'socialbet' ),
			'SG' => __( 'Singapore', 'socialbet' ),
			'SK' => __( 'Slovakia', 'socialbet' ),
			'SI' => __( 'Slovenia', 'socialbet' ),
			'SB' => __( 'Solomon Islands', 'socialbet' ),
			'SO' => __( 'Somalia', 'socialbet' ),
			'ZA' => __( 'South Africa', 'socialbet' ),
			'GS' => __( 'South Georgia/Sandwich Islands', 'socialbet' ),
			'KR' => __( 'South Korea', 'socialbet' ),
			'SS' => __( 'South Sudan', 'socialbet' ),
			'ES' => __( 'Spain', 'socialbet' ),
			'LK' => __( 'Sri Lanka', 'socialbet' ),
			'SD' => __( 'Sudan', 'socialbet' ),
			'SR' => __( 'Suriname', 'socialbet' ),
			'SJ' => __( 'Svalbard and Jan Mayen', 'socialbet' ),
			'SZ' => __( 'Swaziland', 'socialbet' ),
			'SE' => __( 'Sweden', 'socialbet' ),
			'CH' => __( 'Switzerland', 'socialbet' ),
			'SY' => __( 'Syria', 'socialbet' ),
			'TW' => __( 'Taiwan', 'socialbet' ),
			'TJ' => __( 'Tajikistan', 'socialbet' ),
			'TZ' => __( 'Tanzania', 'socialbet' ),
			'TH' => __( 'Thailand', 'socialbet' ),
			'TL' => __( 'Timor-Leste', 'socialbet' ),
			'TG' => __( 'Togo', 'socialbet' ),
			'TK' => __( 'Tokelau', 'socialbet' ),
			'TO' => __( 'Tonga', 'socialbet' ),
			'TT' => __( 'Trinidad and Tobago', 'socialbet' ),
			'TN' => __( 'Tunisia', 'socialbet' ),
			'TR' => __( 'Turkey', 'socialbet' ),
			'TM' => __( 'Turkmenistan', 'socialbet' ),
			'TC' => __( 'Turks and Caicos Islands', 'socialbet' ),
			'TV' => __( 'Tuvalu', 'socialbet' ),
			'UG' => __( 'Uganda', 'socialbet' ),
			'UA' => __( 'Ukraine', 'socialbet' ),
			'AE' => __( 'United Arab Emirates', 'socialbet' ),
			'GB' => __( 'United Kingdom (UK)', 'socialbet' ),
			'US' => __( 'United States (US)', 'socialbet' ),
			'UY' => __( 'Uruguay', 'socialbet' ),
			'UZ' => __( 'Uzbekistan', 'socialbet' ),
			'VU' => __( 'Vanuatu', 'socialbet' ),
			'VA' => __( 'Vatican', 'socialbet' ),
			'VE' => __( 'Venezuela', 'socialbet' ),
			'VN' => __( 'Vietnam', 'socialbet' ),
			'WF' => __( 'Wallis and Futuna', 'socialbet' ),
			'EH' => __( 'Western Sahara', 'socialbet' ),
			'WS' => __( 'Western Samoa', 'socialbet' ),
			'YE' => __( 'Yemen', 'socialbet' ),
			'ZM' => __( 'Zambia', 'socialbet' ),
			'ZW' => __( 'Zimbabwe', 'socialbet' )
		);

		// set states to blank array for countries that dont support states
		$states = array(
			'AF' => array(),
			'AT' => array(),
			'BE' => array(),
			'BI' => array(),
			'CZ' => array(),
			'DE' => array(),
			'DK' => array(),
			'EE' => array(),
			'FI' => array(),
			'FR' => array(),
			'IS' => array(),
			'IL' => array(),
			'KR' => array(),
			'NL' => array(),
			'NO' => array(),
			'PL' => array(),
			'PT' => array(),
			'SG' => array(),
			'SK' => array(),
			'SI' => array(),
			'LK' => array(),
			'SE' => array(),
			'VN' => array(),
		);

		foreach( $this->countries as $countryCode => $name ) {
			if ( ! array_key_exists($countryCode, $states) && file_exists(get_template_directory() . '/helpers/states/' . $countryCode . '.php') ) {
				include( get_template_directory() . '/helpers/states/' . $countryCode . '.php' );
			}
		}
		unset($name);
		unset($countryCode);

		$this->states = $states;
	}


	/**
	 * Get the states based on a country.
	 *
	 * @access public
	 * @param string $cc country code
	 * @return array of states
	 */
	public function get_states( $cc ) 
	{
		return ( isset( $this->states[ $cc ] ) ) ? $this->states[ $cc ] : false;
	}


	/**
	 * Outputs the list of countries and states for use in dropdown boxes.
	 *
	 * @access public
	 * @param string $selected_country (default: '')
	 * @param string $selected_state (default: '')
	 * @param bool $escape (default: false)
	 * @return void
	 */
	public function country_dropdown_options( $selected_country = '', $selected_state = '', $escape = false ) {
		asort( $this->countries );

		if ( empty( $selected_country ) ) {
			echo '';
			return;
		}

		if ( $states =  $this->get_states($selected_country) ) {
			foreach ($states as $state_key=>$state_value) {
				echo '<option value="'.$state_key.'"';
				if ( $selected_state==$state_key ) echo ' selected="selected"';
				echo '>'. ( $escape ? esc_js($state_value) : $state_value ) .'</option>';
			}
		}
	}
}