<?php
class ControllerExtensionModuleBanner extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/javascript/jquery/swiper/css/swiper.min.css');
		$this->document->addStyle('catalog/view/javascript/jquery/swiper/css/opencart.css');
		$this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.js');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'description' => $result['description'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		$template = 'banner';
		// print_r($setting['template']);

		// if($setting['template'] == 0){
			// $template = 'banner';
		// } elseif($setting['template'] == 1){
		// 	$template = 'banner2';
		// } elseif($setting['template'] == 2){
		// 	$template = 'banner3';
		// } elseif($setting['template'] == 3){
		// 	$template = 'banner4';
		// }

		return $this->load->view('extension/module/' . $template, $data, 'banner_id');

		// return $this->load->view('extension/module/banner', $data, 'banner_id');
	}
}