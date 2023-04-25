<?php

namespace Lotus\Shared\Database;

/**
 * class only for PHPdoc (do not include)
 */

final class TableCollection
{
	public $prefix;
	public $posts 			= 'wp_posts';
	public $postmeta 		= 'wp_postmeta';
	public $terms			= 'wp_terms';
	public $term_taxonomy 	= 'wp_term_taxonomy';
	public $term_relations  = 'wp_term_relationships';
	public $termmeta		= 'wp_termmeta';
	public $options			= 'wp_options';
	public $users			= 'wp_users';
	public $usermeta		= 'wp_usermeta';
	public $comments		= 'wp_commnets';
	public $commentmeta		= 'wp_commnentmeta';
	public $links			= 'wp_links';
}
