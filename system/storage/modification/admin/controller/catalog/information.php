<?php
class ControllerCatalogInformation extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/information');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/information');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/information');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/information');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_information->addInformation($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/information');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/information');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_information->editInformation($this->request->get['information_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/information');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/information');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $information_id) {
				$this->model_catalog_information->deleteInformation($information_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}


	public function copy() {
		$this->load->language('catalog/information');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/information');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $information_id) {
				$this->model_catalog_information->copyInformation($information_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}
        
	protected function getList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_viewed'])) {
			$filter_viewed = $this->request->get['filter_viewed'];
		} else {
			$filter_viewed = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}
        
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id.title';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/information/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/information/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['copy'] = $this->url->link('catalog/information/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
        

		$data['informations'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),

			'filter_name'	  => $filter_name,
			'filter_viewed'	  => $filter_viewed,
			'filter_status'   => $filter_status,
        
			'limit' => $this->config->get('config_limit_admin')
		);

		
		$information_total = $this->model_catalog_information->getTotalInformations($filter_data);

		$this->load->model('tool/image');

		$data['user_token'] = $this->session->data['user_token'];
        

		$results = $this->model_catalog_information->getInformations($filter_data);

		foreach ($results as $result) {

			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
        
			$data['informations'][] = array(

				'image'          => $image,
                'status'         => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'viewed'         => $result['viewed'],
        
				'information_id' => $result['information_id'],
				'title'          => $result['title'],
				'sort_order'     => $result['sort_order'],
				'edit'           => $this->url->link('catalog/information/edit', 'user_token=' . $this->session->data['user_token'] . '&information_id=' . $result['information_id'] . $url, true)
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . '&sort=i.sort_order' . $url, true);

		$data['sort_viewed'] = $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . '&sort=i.viewed' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . '&sort=i.status' . $url, true);
        

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $information_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($information_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($information_total - $this->config->get('config_limit_admin'))) ? $information_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $information_total, ceil($information_total / $this->config->get('config_limit_admin')));


		$data['filter_name'] = $filter_name;
		$data['filter_viewed'] = $filter_viewed;
		$data['filter_status'] = $filter_status;
        
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/information_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['information_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_viewed'])) {
			$url .= '&filter_viewed=' . urlencode(html_entity_decode($this->request->get['filter_viewed'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
        

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['information_id'])) {
			$data['action'] = $this->url->link('catalog/information/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/information/edit', 'user_token=' . $this->session->data['user_token'] . '&information_id=' . $this->request->get['information_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['information_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$information_info = $this->model_catalog_information->getInformation($this->request->get['information_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['information_description'])) {
			$data['information_description'] = $this->request->post['information_description'];
		} elseif (isset($this->request->get['information_id'])) {
			$data['information_description'] = $this->model_catalog_information->getInformationDescriptions($this->request->get['information_id']);
		} else {
			$data['information_description'] = array();
		}

		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		if (isset($this->request->post['information_store'])) {
			$data['information_store'] = $this->request->post['information_store'];
		} elseif (isset($this->request->get['information_id'])) {
			$data['information_store'] = $this->model_catalog_information->getInformationStores($this->request->get['information_id']);
		} else {
			$data['information_store'] = array(0);
		}


		if (isset($this->request->get['information_id'])) {
			$data['information_id'] = $this->request->get['information_id'];
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($information_info)) {
			$data['date_available'] = $information_info['date_available'];
		} else {
			$data['date_available'] = date('Y-m-d H:i:s');
		}

		if (isset($this->request->post['date_end'])) {
			$data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($information_info)) {
			$data['date_end'] = $information_info['date_end'];
		} else {
			$data['date_end'] = '2100-01-01 00:00:00';
		}

		if (isset($this->request->post['date_added'])) {
			$data['date_added'] = $this->request->post['date_added'];
		} elseif (!empty($information_info)) {
			$data['date_added'] = $information_info['date_added'];
		} else {
			$data['date_added'] = date('Y-m-d H:i:s');
		}
        
		if (isset($this->request->post['bottom'])) {
			$data['bottom'] = $this->request->post['bottom'];
		} elseif (!empty($information_info)) {
			$data['bottom'] = $information_info['bottom'];
		} else {
			$data['bottom'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($information_info)) {
			$data['status'] = $information_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($information_info)) {
			$data['sort_order'] = $information_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		

		// User
		$this->load->model('user/user');
		$this->load->model('user/user_group');

		$user_groups = $this->model_user_user_group->getUserGroups();

		foreach ($user_groups as $group) {
			$users = array();

			$users = $this->model_user_user->getUsersByGroup($group['user_group_id']);

			if ($users) {
				$data['user_groups'][] = array(
					'name'  => $group['name'],
					'users' => $users
				);
			}
		}

		if (isset($this->request->post['user_id'])) {
			$data['user_id'] = $this->request->post['user_id'];
		} elseif (!empty($information_info)) {
			$data['user_id'] = $this->model_catalog_information->getInformationUser($this->request->get['information_id']);
		} else {
			$data['user_id'] = $this->user->getId();
		}

		// Manufacturer
		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($information_info)) {
			$data['manufacturer_id'] = $information_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($information_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($information_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['information_category'])) {
			$categories = $this->request->post['information_category'];
		} elseif (isset($this->request->get['information_id'])) {
			$categories = $this->model_catalog_information->getInformationCategories($this->request->get['information_id']);
		} else {
			$categories = array();
		}

		$data['information_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['information_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		if (isset($this->request->post['main_category'])) {
			$data['main_category'] = $this->request->post['main_category'];
		} elseif (isset($this->request->get['information_id']) && $categories) {
			$data['main_category'] = $this->model_catalog_information->getMainCategory($this->request->get['information_id']);
		} else {
			$data['main_category'] = '';
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['information_filter'])) {
			$filters = $this->request->post['information_filter'];
		} elseif (isset($this->request->get['information_id'])) {
			$filters = $this->model_catalog_information->getInformationFilters($this->request->get['information_id']);
		} else {
			$filters = array();
		}

		$data['information_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['information_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['information_attribute'])) {
			$information_attributes = $this->request->post['information_attribute'];
		} elseif (isset($this->request->get['information_id'])) {
			$information_attributes = $this->model_catalog_information->getInformationAttributes($this->request->get['information_id']);
		} else {
			$information_attributes = array();
		}

		$data['information_attributes'] = array();

		foreach ($information_attributes as $information_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($information_attribute['attribute_id']);

			if ($attribute_info) {
				$data['information_attributes'][] = array(
					'attribute_id'                  => $information_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'information_attribute_description' => $information_attribute['information_attribute_description']
				);
			}
		}

		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($information_info)) {
			$data['image'] = $information_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($information_info) && is_file(DIR_IMAGE . $information_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($information_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Images
		if (isset($this->request->post['information_image'])) {
			$information_images = $this->request->post['information_image'];
		} elseif (isset($this->request->get['information_id'])) {
			$information_images = $this->model_catalog_information->getInformationImages($this->request->get['information_id']);
		} else {
			$information_images = array();
		}

		$data['information_images'] = array();

		foreach ($information_images as $information_image) {
			if (is_file(DIR_IMAGE . $information_image['image'])) {
				$image = $information_image['image'];
				$thumb = $information_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['information_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $information_image['sort_order']
			);
		}

		// Information Related
		if (isset($this->request->post['information_related'])) {
			$informations = $this->request->post['information_related'];
		} elseif (isset($this->request->get['information_id'])) {
			$informations = $this->model_catalog_information->getInformationRelated($this->request->get['information_id']);
		} else {
			$informations = array();
		}

		$data['information_relateds'] = array();

		foreach ($informations as $information_related) {
			$related_info = $this->model_catalog_information->getInformation($information_related['information_id']);

			if ($related_info) {
				$data['information_relateds'][] = array(
					'information_id' => $related_info['information_id'],
					'title'          => $related_info['title'],
                    'route'          => $information_related['route']
				);
			}
		}
        
		// Product Related
		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['information_id'])) {
			$products = $this->model_catalog_information->getProductRelated($this->request->get['information_id']);
		} else {
			$products = array();
		}

		$data['product_relateds'] = array();

        $this->load->model('catalog/product');

		foreach ($products as $product_related) {
			$related_info = $this->model_catalog_product->getProduct($product_related['product_id']);

			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name'],
                    'route'      => $product_related['route']
				);
			}
		}
        
		if (isset($this->request->post['information_seo_url'])) {
			$data['information_seo_url'] = $this->request->post['information_seo_url'];
		} elseif (isset($this->request->get['information_id'])) {
			$data['information_seo_url'] = $this->model_catalog_information->getInformationSeoUrls($this->request->get['information_id']);
		} else {
			$data['information_seo_url'] = array();
		}
		
		if (isset($this->request->post['information_layout'])) {
			$data['information_layout'] = $this->request->post['information_layout'];
		} elseif (isset($this->request->get['information_id'])) {
			$data['information_layout'] = $this->model_catalog_information->getInformationLayouts($this->request->get['information_id']);
		} else {
			$data['information_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/information_form', $data));
	}


	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/information');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_information->getInformations($filter_data);

			foreach ($results as $result) {
				if (isset($this->request->get['information_id']) && $this->request->get['information_id'] == $result['information_id']) {
					continue;
				}
        
				$json[] = array(
					'information_id' => $result['information_id'],
					'title'          => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
        
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['information_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 1) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 1) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if ($this->request->post['information_seo_url']) {
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['information_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}						
						
						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['information_id']) || ($seo_url['query'] != 'information_id=' . $this->request->get['information_id']))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
							}
						}
					}
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');

		foreach ($this->request->post['selected'] as $information_id) {
			if ($this->config->get('config_account_id') == $information_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}

			if ($this->config->get('config_checkout_id') == $information_id) {
				$this->error['warning'] = $this->language->get('error_checkout');
			}

			if ($this->config->get('config_affiliate_id') == $information_id) {
				$this->error['warning'] = $this->language->get('error_affiliate');
			}

			if ($this->config->get('config_return_id') == $information_id) {
				$this->error['warning'] = $this->language->get('error_return');
			}

			$store_total = $this->model_setting_store->getTotalStoresByInformationId($information_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}
		}

		return !$this->error;
	}
}