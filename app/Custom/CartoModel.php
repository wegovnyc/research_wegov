<?php
Namespace App\Custom;

class CartoModel
{
	function __construct($entry, $key)
	{
		$this->carto = new Carto($entry, $key);
		//print_r([$entry, $key]);
	}

	function orgs()
	{
		$dd = $this->carto->req('SELECT * FROM wegov_orgs ORDER BY name');
		return $this->map($dd);
	}

	function org($id)
	{
		$dd = $this->carto->req("SELECT * FROM wegov_orgs WHERE id = {$id}");
		return $this->map($dd)[0] ?? [];
	}
	
	function dataset($name)
	{
		$dd = $this->carto->req("SELECT * FROM data_sources WHERE \"Name\" LIKE '{$name}'");
		return $this->map($dd)[0] ?? [];
	}
	
	function map($dd)
	{
		foreach ($dd as $i=>$d)
			foreach (['Logo', 'tags'] as $f)
				if ($d[$f] ?? null)
					$dd[$i][$f] = json_decode(str_replace(['""', '""'], ['"', "'"], $d[$f]), true);
		return $dd;
	}
	
	function url($sql)
	{
		return $this->carto->url($sql);
	}
}