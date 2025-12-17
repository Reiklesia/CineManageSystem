<?php

function normaliserTri(string $sort, string $dir, array $allowed, string $defaut): array
{
	if (!in_array($sort, $allowed, true)) {
		$sort = $defaut;
	}

	$dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';

	return [$sort, $dir];
}
