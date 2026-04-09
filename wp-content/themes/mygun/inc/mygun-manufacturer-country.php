<?php
/**
 * Manufacturer country: choices (WooCommerce countries + Georgian labels), helpers.
 *
 * @package mygun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Georgian names for common ISO2 codes (lowercase). Others fall back to English from WC.
 *
 * @return array<string, string>
 */
function mygun_country_ka_overrides() {
	return array(
		'ge' => 'საქართველო',
		'us' => 'აშშ',
		'gb' => 'დიდი ბრიტანეთი',
		'ru' => 'რუსეთი',
		'ua' => 'უკრაინა',
		'tr' => 'თურქეთი',
		'de' => 'გერმანია',
		'fr' => 'საფრანგეთი',
		'it' => 'იტალია',
		'es' => 'ესპანეთი',
		'pl' => 'პოლონეთი',
		'cz' => 'ჩეხეთი',
		'sk' => 'სლოვაკეთი',
		'at' => 'ავსტრია',
		'ch' => 'შვეიცარია',
		'nl' => 'ნიდერლანდები',
		'be' => 'ბელგია',
		'se' => 'შვედეთი',
		'no' => 'ნორვეგია',
		'fi' => 'ფინეთი',
		'dk' => 'დანია',
		'ro' => 'რუმინეთი',
		'bg' => 'ბულგარეთი',
		'hu' => 'უნგრეთი',
		'rs' => 'სერბეთი',
		'hr' => 'ხორვატია',
		'ba' => 'ბოსნია და ჰერცეგოვინა',
		'al' => 'ალბანეთი',
		'mk' => 'ჩრდილოეთი მაკედონია',
		'gr' => 'საბერძნეთი',
		'il' => 'ისრაელი',
		'cn' => 'ჩინეთი',
		'jp' => 'იაპონია',
		'kr' => 'სამხრეთი კორეა',
		'in' => 'ინდოეთი',
		'au' => 'ავსტრალია',
		'ca' => 'კანადა',
		'mx' => 'მექსიკა',
		'br' => 'ბრაზილია',
		'ar' => 'არგენტინა',
		'za' => 'სამხრეთ აფრიკის რესპუბლიკა',
		'eg' => 'ეგვიპტე',
		'sa' => 'საუდის არაბეთი',
		'ae' => 'არაბთა გაერთიანებული საამიროები',
		'ir' => 'ირანი',
		'iq' => 'ერაყი',
		'sy' => 'სირია',
		'pk' => 'პაკისტანი',
		'af' => 'ავღანეთი',
		'kz' => 'ყაზახეთი',
		'uz' => 'უზბეკეთი',
		'tm' => 'თურქმენეთი',
		'az' => 'აზერბაიჯანი',
		'am' => 'სომხეთი',
		'by' => 'ბელარუსი',
		'md' => 'მოლდოვა',
		'lt' => 'ლიტვა',
		'lv' => 'ლატვია',
		'ee' => 'ესტონეთი',
		'ie' => 'ირლანდია',
		'pt' => 'პორტუგალია',
		'is' => 'ისლანდია',
		'cy' => 'კვიპროსი',
		'mt' => 'მალტა',
		'lu' => 'ლუქსემბურგი',
		'si' => 'სლოვენია',
		'me' => 'მონტენეგრო',
		'xk' => 'კოსოვო',
	);
}

/**
 * Minimal list if WooCommerce is not available (slug => en/ka, ka defaults to en).
 *
 * @return array<string, array{en:string,ka:string}>
 */
function mygun_manufacturer_country_fallback_list() {
	$en_list = array(
		'ge' => 'Georgia',
		'us' => 'United States',
		'gb' => 'United Kingdom',
		'ru' => 'Russia',
		'ua' => 'Ukraine',
		'tr' => 'Turkey',
		'de' => 'Germany',
		'fr' => 'France',
		'it' => 'Italy',
		'es' => 'Spain',
		'at' => 'Austria',
		'ch' => 'Switzerland',
		'be' => 'Belgium',
		'nl' => 'Netherlands',
		'se' => 'Sweden',
		'no' => 'Norway',
		'fi' => 'Finland',
		'dk' => 'Denmark',
		'pl' => 'Poland',
		'cz' => 'Czech Republic',
		'cn' => 'China',
		'jp' => 'Japan',
		'kr' => 'South Korea',
		'il' => 'Israel',
		'ca' => 'Canada',
		'au' => 'Australia',
		'br' => 'Brazil',
		'in' => 'India',
		'pk' => 'Pakistan',
		'af' => 'Afghanistan',
		'iq' => 'Iraq',
		'ir' => 'Iran',
		'sa' => 'Saudi Arabia',
		'ae' => 'United Arab Emirates',
		'eg' => 'Egypt',
		'za' => 'South Africa',
		'ar' => 'Argentina',
		'mx' => 'Mexico',
		'hu' => 'Hungary',
		'ro' => 'Romania',
		'bg' => 'Bulgaria',
		'rs' => 'Serbia',
		'hr' => 'Croatia',
		'az' => 'Azerbaijan',
		'am' => 'Armenia',
		'by' => 'Belarus',
		'md' => 'Moldova',
		'kz' => 'Kazakhstan',
	);
	$out = array();
	foreach ( $en_list as $slug => $en ) {
		$out[ $slug ] = array( 'en' => $en, 'ka' => $en );
	}
	return $out;
}

/**
 * WooCommerce i18n/countries.php with gettext bypass so names stay English (not current locale).
 *
 * @return array<string, string> Uppercase ISO2 => English label.
 */
function mygun_wc_countries_english_untranslated() {
	$path = '';
	if ( function_exists( 'WC' ) && WC() ) {
		$path = WC()->plugin_path() . '/i18n/countries.php';
	} elseif ( defined( 'WC_PLUGIN_FILE' ) ) {
		$path = dirname( WC_PLUGIN_FILE ) . '/i18n/countries.php';
	}
	if ( '' === $path || ! is_readable( $path ) ) {
		return array();
	}
	$filter = static function ( $translated, $text, $domain ) {
		return ( 'woocommerce' === $domain ) ? $text : $translated;
	};
	add_filter( 'gettext', $filter, 10, 3 );
	$countries = include $path;
	remove_filter( 'gettext', $filter, 10 );
	return is_array( $countries ) ? $countries : array();
}

/**
 * All manufacturer country options, sorted by English name. Keys are lowercase ISO2.
 *
 * @return array<string, array{en:string,ka:string}>
 */
function mygun_manufacturer_country_choices() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$overrides = mygun_country_ka_overrides();
	$raw       = array();

	$wc_en     = mygun_wc_countries_english_untranslated();
	$localized = array();
	if ( class_exists( 'WooCommerce' ) && function_exists( 'WC' ) && WC() && WC()->countries ) {
		$localized = WC()->countries->get_countries();
	}

	if ( ! empty( $wc_en ) ) {
		foreach ( $wc_en as $code => $en_name ) {
			$slug = strtolower( sanitize_text_field( (string) $code ) );
			if ( '' === $slug || strlen( $slug ) !== 2 ) {
				continue;
			}
			$up = strtoupper( $slug );
			$loc = isset( $localized[ $up ] ) ? $localized[ $up ] : $en_name;
			$raw[ $slug ] = array(
				'en' => wp_strip_all_tags( html_entity_decode( (string) $en_name, ENT_QUOTES, 'UTF-8' ) ),
				'ka' => isset( $overrides[ $slug ] ) ? $overrides[ $slug ] : wp_strip_all_tags( html_entity_decode( (string) $loc, ENT_QUOTES, 'UTF-8' ) ),
			);
		}
	}

	if ( empty( $raw ) ) {
		$raw = mygun_manufacturer_country_fallback_list();
		foreach ( $raw as $slug => $pair ) {
			if ( isset( $overrides[ $slug ] ) ) {
				$raw[ $slug ]['ka'] = $overrides[ $slug ];
			}
		}
	} else {
		foreach ( array_keys( $raw ) as $slug ) {
			if ( isset( $overrides[ $slug ] ) ) {
				$raw[ $slug ]['ka'] = $overrides[ $slug ];
			}
		}
	}

	uasort(
		$raw,
		static function ( $a, $b ) {
			return strcasecmp( $a['en'], $b['en'] );
		}
	);

	$cache = $raw;
	return $cache;
}

/**
 * @param string $slug Lowercase ISO2.
 * @param string $lang ka|en
 */
function mygun_manufacturer_country_label( $slug, $lang = 'ka' ) {
	$slug = strtolower( sanitize_text_field( (string) $slug ) );
	if ( '' === $slug ) {
		return '';
	}
	$choices = mygun_manufacturer_country_choices();
	if ( ! isset( $choices[ $slug ] ) ) {
		return '';
	}
	$key = 'en' === $lang ? 'en' : 'ka';
	return $choices[ $slug ][ $key ];
}

/**
 * @param string $slug Lowercase ISO2.
 */
function mygun_manufacturer_country_is_valid_slug( $slug ) {
	$slug = strtolower( sanitize_text_field( (string) $slug ) );
	return '' !== $slug && isset( mygun_manufacturer_country_choices()[ $slug ] );
}
