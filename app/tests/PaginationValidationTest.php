<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../helper/sort.php';

final class PaginationTest extends TestCase
{
	public function testPageCouranteSous1Devient1(): void
	{
		$r = calcPagination(100, 10, 0);
		$this->assertSame(1, $r['pageCourante']);
	}

	public function testPageCouranteTropGrandeEstRamenee(): void
	{
		$r = calcPagination(25, 10, 99); // 3 pages
		$this->assertSame(3, $r['pageCourante']);
	}

	public function testOffsetEstCorrect(): void
	{
		$r = calcPagination(100, 10, 3);
		$this->assertSame(20, $r['offset']); // (3-1)*10
	}
}
