<?php 

class ImageResizer{
		public $file_name;
		public $tmp_name;
		public $dir_path;

		//Set variables
		public function __construct($file_name,$tmp_name,$dir_path){
			$this->tmp_name = $tmp_name;
			$this->dir_path = $dir_path;
			$this->getImageInfo();
			
			switch($this->file_type){
				case 1:
					$this->file_name = $file_name.'.gif';
					break;
				case 2:
					$this->file_name = $file_name.'.jpg';
					break;
				case 3:
					$this->file_name = $file_name.'.png';
					$image = imagecreatefrompng($this->file_name);
					break;
				case 4:
					$this->file_name = $file_name.'.bmp';
				default:
					$this->file_name = $file_name.'.'.pathinfo($tmp_name, PATHINFO_EXTENSION);
			}
			
			$this->moveImage();
		}
		//Move the uploaded image to the new directory and rename
		public function moveImage(){
				if(!is_dir($this->dir_path)){
					mkdir($this->dir_path,0777,true);
				}
				if(move_uploaded_file($this->tmp_name,$this->dir_path.$this->file_name)){
					$this->setFileName($this->dir_path.$this->file_name);
				}
		 }

		//Define the new filename
		public function setFileName($file_name){
			$this->file_name = $file_name;
			return $this->file_name;
		}

		//Resize the image function with new max height and width
		public function resizeImage($max_height,$max_width){
			$this->max_height = $max_height;
			$this->max_width = $max_width;

			if($this->height > $this->width){
				$ratio = $this->height / $this->max_height;
				$new_height = $this->max_height;
				$new_width = ($this->width / $ratio);
			}
			elseif($this->height < $this->width){
				$ratio = ($this->width / $this->max_width);
				$new_width = $this->max_width;
				$new_height = ($this->height / $ratio);
			}
			else{
				$new_width = $this->max_width;
				$new_height = $this->max_height;
			}

			$thumb = imagecreatetruecolor($new_width, $new_height);

			switch($this->file_type){
				case 1:
					$image = imagecreatefromgif($this->file_name);
					break;
				case 2:
					$image = imagecreatefromjpeg($this->file_name);
					break;
				case 3:
					$image = imagecreatefrompng($this->file_name);
					break;
				case 4:
					$image = imagecreatefromwbmp($this->file_name);
			}

			imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);

			switch($this->file_type){
				case 1:
					imagegif($thumb,$this->file_name);
					break;
				case 2:
					imagejpeg($thumb,$this->file_name,100);
					break;
				case 3:
					imagepng($thumb,$this->file_name,0);
					break;
				case 4:
					imagewbmp($thumb,$this->file_name);
			}

			imagedestroy($image);
			imagedestroy($thumb);
		}

		public function getImageInfo(){
			list($width, $height, $type) = getimagesize($this->tmp_name);
			$this->width = $width;
			$this->height = $height;
			$this->file_type = $type;

		}

		public function showResizedImage(){
			echo "<img src='".$this->file_name." />";
		}


		public function onSuccess(){
			header("location: index.php");
		}

	}
?>