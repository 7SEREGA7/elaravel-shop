<?php
class ControllerExtensionModuleContainer3 extends Controller {
	public function index($setting) {
		$this->load->model('setting/module');

		$data['newProduct'] = $this->load->controller('extension/module/latest', $this->model_setting_module->getModule(58));
		$data['actions'] = $this->load->controller('extension/module/featured', $this->model_setting_module->getModule(59));

		return $this->load->view('extension/module/container3', $data);
	}
}