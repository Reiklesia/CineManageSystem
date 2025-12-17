<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../helper/sort.php';

final class SortTest extends TestCase
{
	public function testSortNonPermisRetombeSurDefaut(): void
	{
		[$sort, $dir] = normaliserTri('hack', 'desc', ['id', 'titre'], 'id');
		$this->assertSame('id', $sort);
		$this->assertSame('desc', $dir);
	}

	public function testDirInvalideDevientAsc(): void
	{
		[$sort, $dir] = normaliserTri('titre', 'nimportequoi', ['id', 'titre'], 'id');
		$this->assertSame('titre', $sort);
		$this->assertSame('asc', $dir);
	}
}
