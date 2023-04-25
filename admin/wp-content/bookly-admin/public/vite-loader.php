<?php

function get_manifest()
{
	$manifest = json_decode(file_get_contents(__DIR__ . "./../dist/manifest.json"), true);

	return $manifest ?? [];
}

function vite(string $filename, $key = 'file')
{
	$manifest = get_manifest();

	$ManifestFile = isset($manifest[$filename]) ? $manifest[$filename] : ['file' => 'assets/main.ts'];

	echo "http://localhost/lotus/admin/wp-content/bookly-admin/dist/" . vite_resolver($ManifestFile[$key]);
}

function vite_resolver($file)
{
	return is_array($file) ? $file[0] : $file;
}

include_once(__DIR__ . "/index.php");
