<?php
class ControllerExtensionModuleContainer extends Controller {
	public function index($setting) {
		$this->load->model('setting/module');

		$data['bestDeals'] = $this->load->controller('extension/module/featured', $this->model_setting_module->getModule(44));

		return $this->load->view('extension/module/container', $data);
	}
}