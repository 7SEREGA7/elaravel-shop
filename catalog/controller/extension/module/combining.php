<?php
class ControllerExtensionModuleCombining extends Controller {
	public function index($setting) {
		$this->load->model('setting/module');
		$data['special'] = $this->load->controller('extension/module/special', $this->model_setting_module->getModule(50));
		$data['features'] = $this->load->controller('extension/module/featured', $this->model_setting_module->getModule(28));
		$data['onSale'] = $this->load->controller('extension/module/featured', $this->model_setting_module->getModule(52));
		$data['topRated'] = $this->load->controller('extension/module/featured', $this->model_setting_module->getModule(51));
		
		return $this->load->view('extension/module/combining', $data);
	}
}