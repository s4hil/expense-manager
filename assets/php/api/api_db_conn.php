<?php
	class db extends SQLite3
	{
		function __construct()
		{
			$this->open('../db.sqlite');
		}
	}
	$db = new db();
?>