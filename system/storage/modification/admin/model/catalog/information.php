<?php
class ModelCatalogInformation extends Model {
	public function addInformation($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', date_added = NOW(), date_modified = NOW(), status = '" . (int)$data['status'] . "'");

		$information_id = $this->db->getLastId();

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', header = '" . $this->db->escape($value['header']) . "', short_description = '" . $this->db->escape($value['short_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
			}
		}


		if (!empty($data['user_id'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_user SET information_id = '" . (int)$information_id . "', user_id = '" . (int)$data['user_id'] . "'");
		}

		if (isset($data['information_attribute'])) {
			foreach ($data['information_attribute'] as $information_attribute) {
				if ($information_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "information_attribute WHERE information_id = '" . (int)$information_id . "' AND attribute_id = '" . (int)$information_attribute['attribute_id'] . "'");

					foreach ($information_attribute['information_attribute_description'] as $language_id => $information_attribute_description) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "information_attribute WHERE information_id = '" . (int)$information_id . "' AND attribute_id = '" . (int)$information_attribute['attribute_id'] . "' AND language_id = '" . (int)$language_id . "'");

						$this->db->query("INSERT INTO " . DB_PREFIX . "information_attribute SET information_id = '" . (int)$information_id . "', attribute_id = '" . (int)$information_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($information_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "information SET image = '" . $this->db->escape($data['image']) . "' WHERE information_id = '" . (int)$information_id . "'");
		}

		if (isset($data['information_image'])) {
			foreach ($data['information_image'] as $information_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_image SET information_id = '" . (int)$information_id . "', image = '" . $this->db->escape($information_image['image']) . "', sort_order = '" . (int)$information_image['sort_order'] . "'");
			}
		}

		if (isset($data['information_category'])) {
			foreach ($data['information_category'] as $category_id) {
				if (!empty($data['main_category']) && $data['main_category'] == (int)$category_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_category SET information_id = '" . (int)$information_id . "', category_id = '" . (int)$category_id . "', main_category = '1'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_category SET information_id = '" . (int)$information_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
		}

		if (isset($data['information_filter'])) {
			foreach ($data['information_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_filter SET information_id = '" . (int)$information_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['information_related'])) {
			foreach ($data['information_related'] as $information_related) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "information_related WHERE information_id = '" . (int)$information_id . "' AND related_id = '" . (int)$information_related['information_id'] . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_related SET information_id = '" . (int)$information_id . "', related_id = '" . (int)$information_related['information_id'] . "', route = '" . (int)$information_related['route'] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "information_related WHERE information_id = '" . (int)$information_related['information_id'] . "' AND related_id = '" . (int)$information_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_related SET information_id = '" . (int)$information_related['information_id'] . "', related_id = '" . (int)$information_id . "', route = '" . (int)$information_related['route'] * -1 . "'");
			}
		}

		if (isset($data['product_related'])) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "information_product_related WHERE information_id = '" . (int)$information_id . "'");

			foreach ($data['product_related'] as $product_related) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_product_related SET information_id = '" . (int)$information_id . "', product_id = '" . (int)$product_related['product_id'] . "', route = '" . (int)$product_related['route'] . "'");
			}
		}
        
		// SEO URL
		if (isset($data['information_seo_url'])) {
			foreach ($data['information_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}
		
		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_layout SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('information');

		return $information_id;
	}

	public function editInformation($information_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "information SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', date_added = '" . $this->db->escape($data['date_added']) . "',  date_modified = NOW(), status = '" . (int)$data['status'] . "' WHERE information_id = '" . (int)$information_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_description SET information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', header = '" . $this->db->escape($value['header']) . "', short_description = '" . $this->db->escape($value['short_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_user WHERE information_id = '" . (int)$information_id . "'");

		if (!empty($data['user_id'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_user SET information_id = '" . (int)$information_id . "', user_id = '" . (int)$data['user_id'] . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_attribute WHERE information_id = '" . (int)$information_id . "'");

		if (!empty($data['information_attribute'])) {
			foreach ($data['information_attribute'] as $information_attribute) {
				if ($information_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "information_attribute WHERE information_id = '" . (int)$information_id . "' AND attribute_id = '" . (int)$information_attribute['attribute_id'] . "'");

					foreach ($information_attribute['information_attribute_description'] as $language_id => $information_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "information_attribute SET information_id = '" . (int)$information_id . "', attribute_id = '" . (int)$information_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($information_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "information SET image = '" . $this->db->escape($data['image']) . "' WHERE information_id = '" . (int)$information_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_image WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_image'])) {
			foreach ($data['information_image'] as $information_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_image SET information_id = '" . (int)$information_id . "', image = '" . $this->db->escape($information_image['image']) . "', sort_order = '" . (int)$information_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_category WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_category'])) {
			foreach ($data['information_category'] as $category_id) {
				if (!empty($data['main_category']) && $data['main_category'] == (int)$category_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_category SET information_id = '" . (int)$information_id . "', category_id = '" . (int)$category_id . "', main_category = '1'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_category SET information_id = '" . (int)$information_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_filter WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_filter'])) {
			foreach ($data['information_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_filter SET information_id = '" . (int)$information_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_related WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_related WHERE related_id = '" . (int)$information_id . "'");

		if (isset($data['information_related'])) {
			foreach ($data['information_related'] as $information_related) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "information_related WHERE information_id = '" . (int)$information_id . "' AND related_id = '" . (int)$information_related['information_id'] . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_related SET information_id = '" . (int)$information_id . "', related_id = '" . (int)$information_related['information_id'] . "', route = '" . (int)$information_related['route'] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "information_related WHERE information_id = '" . (int)$information_related['information_id'] . "' AND related_id = '" . (int)$information_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_related SET information_id = '" . (int)$information_related['information_id'] . "', related_id = '" . (int)$information_id . "', route = '" . (int)$information_related['route'] * -1 . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_product_related WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_related) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_product_related SET information_id = '" . (int)$information_id . "', product_id = '" . (int)$product_related['product_id'] . "', route = '" . (int)$product_related['route'] . "'");
			}
		}
        
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'information_id=" . (int)$information_id . "'");

		if (isset($data['information_seo_url'])) {
			foreach ($data['information_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (trim($keyword)) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_to_layout` WHERE information_id = '" . (int)$information_id . "'");

		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "information_to_layout` SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('information');
	}


	public function copyInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$information_id . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data['information_attribute'] = $this->getInformationAttributes($information_id);
			$data['information_description'] = $this->getInformationDescriptions($information_id);
			$data['information_filter'] = $this->getInformationFilters($information_id);
			$data['information_image'] = $this->getInformationImages($information_id);
			$data['information_related'] = $this->getInformationRelated($information_id);
			$data['product_related'] = $this->getProductRelated($information_id);
			$data['information_category'] = $this->getInformationCategories($information_id);
			$data['main_category'] = $this->getMainCategory($information_id);
			$data['information_layout'] = $this->getInformationLayouts($information_id);
			$data['information_store'] = $this->getInformationStores($information_id);
			$data['user_id'] = $this->getInformationUser($information_id);

			$this->addInformation($data);
		}
	}
        
	public function deleteInformation($information_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_description` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_to_store` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_to_layout` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'information_id=" . (int)$information_id . "'");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_attribute` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_filter` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_image` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_related` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_related` WHERE related_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_product_related` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_to_category` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "information_to_user` WHERE information_id = '" . (int)$information_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "review` WHERE information_id = '" . (int)$information_id . "'");
        

		$this->cache->delete('information');
	}

	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getInformations($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";


		if (!empty($data['filter_name'])) {
			$sql .= " AND id.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_viewed'])) {
			$sql .= " AND i.viewed LIKE '" . $this->db->escape($data['filter_viewed']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND i.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY i.information_id";
        
			$sort_data = array(
				'id.title',

				'i.viewed',
				'i.status',
        
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
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
		} else {
			$information_data = $this->cache->get('information.' . (int)$this->config->get('config_language_id'));

			if (!$information_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$information_data = $query->rows;

				$this->cache->set('information.' . (int)$this->config->get('config_language_id'), $information_data);
			}

			return $information_data;
		}
	}

	public function getInformationDescriptions($information_id) {
		$information_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_description_data[$result['language_id']] = array(
				'title'            => $result['title'],

				'header'            => $result['header'],
				'short_description' => $result['short_description'],
				'tag'               => $result['tag'],
        
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $information_description_data;
	}

	public function getInformationStores($information_id) {
		$information_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_store_data[] = $result['store_id'];
		}

		return $information_store_data;
	}

	public function getInformationSeoUrls($information_id) {
		$information_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'information_id=" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $information_seo_url_data;
	}

	public function getInformationLayouts($information_id) {
		$information_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $information_layout_data;
	}


	public function getInformationUser($information_id) {
		$query = $this->db->query("SELECT user_id FROM " . DB_PREFIX . "information_to_user WHERE information_id = '" . (int)$information_id . "'");

		return $query->row['user_id'];
	}

	public function getInformationsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_category i2c ON (i.information_id = i2c.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2c.category_id = '" . (int)$category_id . "' ORDER BY id.title ASC");

		return $query->rows;
	}

	public function getInformationCategories($information_id) {
		$information_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_category WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_category_data[] = $result['category_id'];
		}

		return $information_category_data;
	}

	public function getMainCategory($information_id) {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "information_to_category WHERE information_id = '" . (int)$information_id . "' AND main_category = '1'");

		if ($query->row) {
			return $query->row['category_id'];
		} else {
			return '';
		}
	}

	public function getInformationFilters($information_id) {
		$information_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_filter WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_filter_data[] = $result['filter_id'];
		}

		return $information_filter_data;
	}

	public function getInformationAttributes($information_id) {
		$information_attribute_data = array();

		$information_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "information_attribute WHERE information_id = '" . (int)$information_id . "' GROUP BY attribute_id");

		foreach ($information_attribute_query->rows as $information_attribute) {
			$information_attribute_description_data = array();

			$information_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_attribute WHERE information_id = '" . (int)$information_id . "' AND attribute_id = '" . (int)$information_attribute['attribute_id'] . "'");

			foreach ($information_attribute_description_query->rows as $information_attribute_description) {
				$information_attribute_description_data[$information_attribute_description['language_id']] = array('text' => $information_attribute_description['text']);
			}

			$information_attribute_data[] = array(
				'attribute_id'                  => $information_attribute['attribute_id'],
				'information_attribute_description' => $information_attribute_description_data
			);
		}

		return $information_attribute_data;
	}

	public function getInformationImages($information_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_image WHERE information_id = '" . (int)$information_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	
	public function getInformationRelated($information_id) {
		$information_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_related WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$information_related_data[] = array(
				'information_id' => $result['related_id'],
				'route'          => $result['route']
            );
		}

		return $information_related_data;
	}

	public function getProductRelated($information_id) {
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_product_related WHERE information_id = '" . (int)$information_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = array(
				'product_id' => $result['product_id'],
				'route'      => $result['route']
            );
		}

		return $product_related_data;
	}

	public function getTotalInformationsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalInformationsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}
        
	
	public function getTotalInformations($data = array()) {
        
		
		$sql = "SELECT COUNT(DISTINCT i.information_id) AS total FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id)";

		$sql .= " WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND id.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_viewed']) && $data['filter_viewed'] !== '') {
			$sql .= " AND i.viewed = '" . (int)$data['filter_viewed'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND i.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
        

		return $query->row['total'];
	}

	public function getTotalInformationsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}