<?php
class ModelExtensionSeo301redirect extends Model {

	public function addRedirect($data) 
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "301redirect SET url_from = '" . $this->db->escape($data['url_from']) . "', url_to = '" . $this->db->escape($data['url_to']) . "'");

		$redirect_id = $this->db->getLastId();
		
		return $redirect_id;
	}

	public function editRedirect($redirect_id, $data) 
	{
		$this->db->query("UPDATE " . DB_PREFIX . "301redirect SET url_from = '" . $this->db->escape($data['url_from']) . "', url_to = '" . $this->db->escape($data['url_to']) . "' WHERE redirect_id = '" . (int)$redirect_id . "'");
	}

	public function deleteRedirect($redirect_id) 
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "301redirect WHERE redirect_id = '" . (int)$redirect_id . "'");
	}

	public function getRedirect($redirect_id) 
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "301redirect WHERE redirect_id = '" . (int)$redirect_id . "'");
		return $query->row;
	}

	public function existsUrlFrom($url_from) 
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "301redirect WHERE url_from = '" . $this->db->escape($url_from) . "'");
		return $query->row['total'] > 0;
	}
	

	public function getRedirects($data = array()) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "301redirect";

		if (isset($data['sort'])) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY redirect_id";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
		
	}

	public function getTotalRedirects() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "301redirect");

		return $query->row['total'];
	}

	public function install() {
		$create_table_sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX .
		"301redirect` ( `redirect_id` int(11) NOT NULL AUTO_INCREMENT, `url_from` varchar(150) NOT NULL, `url_to` varchar(150) NOT NULL, PRIMARY KEY (`redirect_id`) )
		ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		$this->db->query($create_table_sql);
	}

	public function uninstall() {
		$delete_table_sql = "DROP TABLE IF EXISTS `" . DB_PREFIX . "301redirect`";
		$this->db->query($delete_table_sql);		
	}
}