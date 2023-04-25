<?php

namespace Lotus\Shared;

final class Helper
{
	public static function meta_seo(int $id, string $type, string $seo)
	{
		if (function_exists('YoastSEO') && $seo == "allow") {
			$meta_helper = YoastSEO()->classes->get(\Yoast\WP\SEO\Surfaces\Meta_Surface::class);
			$meta = $type == 'post'
				? $meta_helper->for_post($id)
				: $meta_helper->for_term($id);
			return $meta->get_head()->json;
		}
		return [];
	}

	public static function image_uri($uri)
	{
		if (!$uri) {
			return '';
		}
		return preg_replace('/^(http:\/\/|https:\/\/).*\/wp-content/', base_uri('wp-content'), $uri);
	}

	public static function except($target, array $keys)
	{
		foreach ($keys as $key) {
			if (is_object($target)) {
				unset($target->{$key});
			}
			if (is_array($target)) {
				unset($target[$key]);
			}
		}

		return $target;
	}

	public static function autowrap($text, $br = true)
	{
		$pre_tags = [];
		if (trim($text) === '') {
			return '';
		}
		$text = $text . "\n";

		if (strpos($text, '<pre') !== false) {
			$text_parts = explode('</pre>', $text);
			$last_part  = array_pop($text_parts);
			$text       = '';
			$i          = 0;
			foreach ($text_parts as $text_part) {
				$start = strpos($text_part, '<pre');
				if (false === $start) {
					$text .= $text_part;
					continue;
				}
				$name              = "<pre wp-pre-tag-$i></pre>";
				$pre_tags[$name] = substr($text_part, $start) . '</pre>';

				$text .= substr($text_part, 0, $start) . $name;
				$i++;
			}

			$text .= $last_part;
		}
		$text = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $text);
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		$text = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n\n$1", $text);
		$text = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $text);
		$text = preg_replace('!(<hr\s*?/?>)!', "$1\n\n", $text);
		$text = str_replace(array("\r\n", "\r"), "\n", $text);

		if (strpos($text, '<option') !== false) {
			$text = preg_replace('|\s*<option|', '<option', $text);
			$text = preg_replace('|</option>\s*|', '</option>', $text);
		}

		if (strpos($text, '</object>') !== false) {
			$text = preg_replace('|(<object[^>]*>)\s*|', '$1', $text);
			$text = preg_replace('|\s*</object>|', '</object>', $text);
			$text = preg_replace('%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $text);
		}

		if (strpos($text, '<source') !== false || strpos($text, '<track') !== false) {
			$text = preg_replace('%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $text);
			$text = preg_replace('%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $text);
			$text = preg_replace('%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $text);
		}

		if (strpos($text, '<figcaption') !== false) {
			$text = preg_replace('|\s*(<figcaption[^>]*>)|', '$1', $text);
			$text = preg_replace('|</figcaption>\s*|', '</figcaption>', $text);
		}

		$text = preg_replace("/\n\n+/", "\n\n", $text);
		$paragraphs = preg_split('/\n\s*\n/', $text, -1, PREG_SPLIT_NO_EMPTY);
		$text = '';
		foreach ($paragraphs as $paragraph) {
			$text .= '<p>' . trim($paragraph, "\n") . "</p>\n";
		}
		$text = preg_replace('|<p>\s*</p>|', '', $text);
		$text = preg_replace('!<p>([^<]+)</(div|address|form)>!', '<p>$1</p></$2>', $text);
		$text = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $text);
		$text = preg_replace('|<p>(<li.+?)</p>|', '$1', $text);
		$text = preg_replace('|<p><blockquote([^>]*)>|i', '<blockquote$1><p>', $text);
		$text = str_replace('</blockquote></p>', '</p></blockquote>', $text);
		$text = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', '$1', $text);
		$text = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $text);

		if ($br) {
			$text = str_replace(array('<br>', '<br/>'), '<br />', $text);
			$text = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $text);
			$text = str_replace('<WPPreserveNewline />', "\n", $text);
		}

		$text = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', '$1', $text);
		$text = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $text);
		$text = preg_replace("|\n</p>$|", '</p>', $text);
		if (!empty($pre_tags)) {
			$text = str_replace(array_keys($pre_tags), array_values($pre_tags), $text);
		}

		if (false !== strpos($text, '<!-- wpnl -->')) {
			$text = str_replace(array(' <!-- wpnl --> ', '<!-- wpnl -->'), "\n", $text);
		}

		return $text;
	}

	public static function sanitize_url(string $link): string
	{
		$slug = str_replace(home_url(), '', $link);
		preg_match('/^(.+?)\/*?$/', $slug, $output);
		return $output[1];
	}

	public static function SQLValuesFromArray(array $target)
	{
		$output = "";
		foreach (array_values($target) as $value) {
			$output .= "'" . addslashes($value) . "', ";
		}
		return substr($output, 0, -2);
	}

	public static function keysFromArray(array $target)
	{
		return implode(",", array_keys($target));
	}

	public static function SQLInsertEntity(array $target)
	{
		return (object) [
			"keys"   => self::keysFromArray($target),
			"values" => self::SQLValuesFromArray($target)
		];
	}

	public static function SQLUpdateEntity(array $target)
	{
		$output = "";
		foreach ($target as $key => $value) {
			if (!is_numeric($value)) {
				$output .= "`{$key}` = '" . addslashes($value) . "', ";
			} else {
				$output .= "`{$key}` = $value, ";
			}
		}
		return substr($output, 0, -2);
	}
	public static function poster($id)
	{
		return !empty($id) ? get_the_post_thumbnail_url($id) : '';
	}
}
