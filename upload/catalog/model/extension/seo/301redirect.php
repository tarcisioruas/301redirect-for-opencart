<?php
class ModelExtensionSeo301redirect extends Model {
	public function getRedirectByOrigin($url_from) 
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "301redirect WHERE url_from = '" . $this->db->escape($url_from) . "'");
		return $query->row;
	}
}
