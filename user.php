<?php
	class User {
		private $current_gif_link;
		private $current_gif_id;
		private $current_gif_title;

		public function getGifID() {
			return $current_gif_id;
		}
		public function getGifLink() {
			return $this->$current_gif_link;	
		}
		public function getGifTitle() {
			return $this->$current_gif_title;
		}
		public function setCurrentGif($gif_link, $gif_title, $gif_id) {
			$this->$current_gif_link 	= $gif_link;
			$this->$current_gif_title = $gif_title;
			$this->$current_gif_id		= $gif_id;	
		}
	}
?>
