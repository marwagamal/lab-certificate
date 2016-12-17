<?php 

class Model_graduates extends CI_Model{
	
	public function get_graduate_data($id)
	{
		$this->db->select('name, email, lab_no');
		$this->db->where('id',$id);
		$query = $this->db->get('graduates');
		if($query)
		{
			return $query->result();
		}
		{
			return false;
		}
	}
	
	public function list_graduates_by_name($name)
	{
		$this->db->like('name',$name);
		$this->db->select('name, id');
		$query = $this->db->get('graduates');
		if($query)
		{
			header('Content-type: text/html');
			$result = $query->result();
			if(count($result) > 0)
			{
				$html = "<div>
				<script>
				jQuery('#result-search ul li').click(function() {
       					var studentid = this.id;
       					jQuery.ajax({ url:'http://es-labs.esy.es/index.php/graduates_api/get_student_image', data: {id: studentid}, type: 'get', success: function(output) {  var image =  jQuery('#result-search').append(output);jQuery('#student-list').remove(); }});
});
				</script>";
				$html .= '<ul id="student-list">';
				foreach($result as $row)
				{
					$html .= '<li id="' . $row->id . '">' . $row->name . '</li>';
				}
				$html .= '</ul></div>';
			}
			else
			{
				$html = "No Data Found";
			}
			return $html;
		}
		{
			return false;
		}	
	}
	
	public function get_graduate_image($id)
	{
		$this->db->select('name, lab_no');
		$this->db->where('id',$id);
		$query = $this->db->get('graduates');
		if($query)
		{
			$result = $query->result();
			$fullname = $result[0]->name;
			$lab_no = $result[0]->lab_no;
			
			// Create image from file
			$imgPath = UPLOAD_DIR . 'CERTIFICATE_small.jpg';
			$image = imagecreatefromjpeg($imgPath);
		    	
		    	// Text propoerties
		    	$color = imagecolorallocate($image, 0, 0, 0);
		    	$fontSize = 7;
		    	$x = 150;
		    	$y = 180;
		    	
		    	// Add the student name to the image
		    	imagestring($image, $fontSize, $x, $y, $fullname, $color);
		    	imagestring($image, 2, 100, 362, $lab_no, $color);
		    	
		    	// Set the content type header - in this case image/jpeg
			header("Content-Type: image/jpg");
		    	ob_start();
		    	// Save the image
		    	imagejpeg($image, NULL, 100);
		    	
		    	// Free up memory
			imagedestroy($image);
			
			$i = ob_get_clean();

			return "<img src='data:image/jpeg;base64," . base64_encode( $i )."'>"; //saviour line!
		}
		{
				return false;
		}
	}


}
