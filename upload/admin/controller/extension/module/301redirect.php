<?php
class ControllerExtensionModule301redirect extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/301redirect');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seo/301redirect');

		$this->getList();
	}
	
	public function add() {
		$this->load->language('extension/module/301redirect');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seo/301redirect');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_seo_301redirect->addRedirect($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	
	public function edit() {
		$this->load->language('extension/module/301redirect');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seo/301redirect');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_seo_301redirect->editRedirect($this->request->get['redirect_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	
	public function delete() {

		$this->load->language('extension/module/301redirect');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/seo/301redirect');
		

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $redirect_id) {
				$this->model_extension_seo_301redirect->deleteRedirect($redirect_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	
	
	protected function getForm() {
		$this->load->language('extension/module/301redirect');

		$data = [];

		$data['text_form'] = !isset($this->request->get['redirect_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		}

		if (isset($this->error['url_from'])) {
			$data['error_url_from'] = $this->error['url_from'];
		}

		if (isset($this->error['url_to'])) {
			$data['error_url_to'] = $this->error['url_to'];
		}

		

		$url = '';

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
			'href' => $this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['redirect_id'])) {
			$data['action'] = $this->url->link('extension/module/301redirect/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/301redirect/edit', 'user_token=' . $this->session->data['user_token'] . '&redirect_id=' . $this->request->get['redirect_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['redirect_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$redirect_info = $this->model_extension_seo_301redirect->getRedirect($this->request->get['redirect_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		

		if (isset($this->request->post['url_from'])) {
			$data['url_from'] = $this->request->post['url_from'];
		} elseif (!empty($redirect_info)) {
			$data['url_from'] = $redirect_info['url_from'];
		} else {
			$data['url_from'] = '';
		}

		if (isset($this->request->post['url_to'])) {
			$data['url_to'] = $this->request->post['url_to'];
		} elseif (!empty($redirect_info)) {
			$data['url_to'] = $redirect_info['url_to'];
		} else {
			$data['url_to'] = '';
		}

		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/seo/301redirect_form', $data));
	}

	protected function validateForm() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/301redirect')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('design/seo_url');

		$this->request->post['url_from'];
		$this->request->post['url_to'];

		if (empty($this->request->post['url_from'])) {
			$this->error['url_from'] = $this->language->get('error_url_from_empty');
		}

		if (empty($this->request->post['url_to'])) {
			$this->error['url_to'] = $this->language->get('error_url_to_empty');
		}

		if ($this->model_extension_seo_301redirect->existsUrlFrom($this->request->post['url_from'])) {
			$this->error['url_from'] = $this->language->get('error_url_from_exists');
		}

		if ($this->model_extension_seo_301redirect->existsUrlFrom($this->request->post['url_from'])) {
			$this->error['url_from'] = $this->language->get('error_url_from_exists');
		}

		$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($this->request->post['url_to']);
		if (count($seo_urls) == 0) {
			$this->error['url_from'] = $this->language->get('error_url_to_dont_exists');
		}

		return !$this->error;
	}
	

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	

	protected function getList() {

		$this->load->language('extension/module/301redirect');

		$this->load->model('setting/setting');
		$data['module_301redirect_status'] = $this->model_setting_setting->getSettingValue('module_301redirect_status');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$data['module_301redirect_status'] = $this->request->post['module_301redirect_status'];
			$this->model_setting_setting->editSetting('module_301redirect', $this->request->post);
		}


		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'redirect_id';
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

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/module/301redirect/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/301redirect/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['redirects'] = [];

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$redirects_total = $this->model_extension_seo_301redirect->getTotalRedirects();

		$results = $this->model_extension_seo_301redirect->getRedirects($filter_data);

		foreach ($results as $result) {

			$data['redirects'][] = array(
				'redirect_id'	 => $result['redirect_id'],
				'url_from'       => $result['url_from'],
				'url_to'         => $result['url_to'],
				'edit'           => $this->url->link('extension/module/301redirect/edit', 'user_token=' . $this->session->data['user_token'] . '&redirect_id=' . $result['redirect_id'] . $url, true)
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
			$data['selected'] = [];
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_url_from'] = $this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_url_from' . $url, true);
		$data['sort_url_to'] = $this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_url_to' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $redirects_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/301redirect', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($redirects_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($redirects_total - $this->config->get('config_limit_admin'))) ? $redirects_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $redirects_total, ceil($redirects_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/seo/301redirect_list', $data));
	}

	public function install() {

			$this->load->model('extension/seo/301redirect');
			$this->model_extension_seo_301redirect->install();

			$this->load->model('setting/extension');
			$this->model_setting_extension->install('module', '301redirect');
	}

	public function uninstall() {

		$this->load->model('extension/seo/301redirect');
		$this->model_extension_seo_301redirect->uninstall();

		$this->load->model('setting/extension');
		$this->model_setting_extension->uninstall('module', '301redirect');

		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('module_301redirect');
	}
}