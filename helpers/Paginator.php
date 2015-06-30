<?php
namespace helpers;

class Paginator
{
	/**
	 * Total mount of target.
	 * @var integer
	 */
	public $Total;

	public $PerPage;

	public $TotalPage;

	public $TargetPage;

	/**
	 * Tell this class: total column mount, per page mount, target page.
	 * @param integer  $total
	 * @param integer  $per_page
	 * @param integer  $target_page
	 */
	public function __construct($total, $per_page, $target_page = 1)
	{
		$this->Total = $total;
		$this->PerPage = $per_page;
		$this->TotalPage = $this->getTotalPage($this->Total, $per_page);
		$this->TargetPage = $this->validateTargetPage($target_page);
	}

	private function getTotalPage($total, $per_page)
	{
		try {
			if (!is_numeric($total) || !is_numeric($per_page))
				throw new Exception("Paginator->getTotalPage()'s params should be numeric.");
			$pages = ceil($total / $per_page);
			return $pages;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	private function validateTargetPage($target_page)
	{
		if (is_numeric($target_page)) {
			if ($this->TotalPage != 0)
				$page = ($target_page > $this->TotalPage) ? $this->redirectPage() : $target_page;
			else
				$page = 1;
		} else
			$this->redirectPage();
		return $page;
	}

	/**
	 * Count target page's offset columns then return medoo's limit command params.
	 * @return array [offset, per_page]
	 */
	public function getPageSet()
	{
		$offset = $this->PerPage * ($this->TargetPage - 1);
		return [$offset, $this->PerPage];
	}

	/**
	 * If the given page was not numeric or was string, redirect to page 1.
	 * @return string js: redirect page
	 * p.s. I'm confused why header() not working......
	 */
	private function redirectPage()
	{
		$page = 'page=' . $_GET['page'];
		$request = str_replace($page, "page=$this->TotalPage", $_SERVER['REQUEST_URI']);
		$url = 'http://' . $_SERVER['SERVER_NAME'] . $request;
		echo "<script>window.location.replace('$url');</script>";
		exit;
	}

	/**
	 * Get paginator-view's setting.
	 * @return array  $set[
	 *         			  'first' => string,
	 *         		      'prev_ten' => string,
	 *         		      'next_ten' => string,
	 *         		      'prev' => string,
	 *         		      'next' => string,
	 *         		      'final' => string,
	 *         		      'pages' => array,
	 *         		  ]
	 */
	public function getWidgetSet()
	{
		$current_page = $this->TargetPage;
		if ($current_page % 10 == 0)
			$final_page = $current_page;
		else
			$final_page = ceil($current_page / 10) * 10;
		if ($final_page >= $this->TotalPage) {
			$start_page = $final_page - 9;
			$final_page = $this->TotalPage;
		} else
			$start_page = $final_page - 9;
		$prev = $current_page == 1 ? 1 : $current_page - 1;
		$next = $current_page == $this->TotalPage ? $current_page : $current_page + 1;
		$prev_ten = ($start_page - 10 > 0) ? $start_page-10 : $start_page;
		$next_ten = ($final_page + 1 > $this->TotalPage) ? $final_page : $final_page + 1;
		$pages = [];
		for ($i=$start_page; $i<=$final_page; $i++)
			$pages[$i] = $i;
		$pages = $this->rearrangeLinks($pages);
		$set = [
			'first' => 1,
			'prev_ten' => $prev_ten,
			'next_ten' => $next_ten,
			'prev' => $prev,
			'next' => $next,
			'final' => $this->TotalPage,
		];
		$set = $this->rearrangeLinks($set);
		$set['pages'] = $pages;
		return $set;
	}

	/**
	 * Detect uri then combine it with page number.
	 * @param  array  $links
	 * @return array  $links
	 */
	private function rearrangeLinks(array $links)
	{
		$uri = $_SERVER['REQUEST_URI'];
		foreach ($links as $idx=>$l) {
			if (strpos($_SERVER['REQUEST_URI'], 'page=') !== false)
				$links[$idx] = str_replace('page='.$_GET['page'], "page=$l", $uri);
			else
				$links[$idx] = empty($_GET) ? $uri . "?page=$l" : $uri . "&page=$l";
		}
		return $links;
	}
}
