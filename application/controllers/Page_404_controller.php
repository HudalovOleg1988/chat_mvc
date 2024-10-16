<?php

	class Page_404_controller extends Controller {

		public function index() {

			$this->view("page_404",$this->data);

		}

	}

?>