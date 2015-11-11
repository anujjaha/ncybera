<?php
class Paper_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
    public $table = "paper_details";
	
	public function get_paper_rate($paper_gram,$paper_size,$paper_qty) {
		$query = "select paper_gram,paper_amount from $this->table
					WHERE
					$paper_qty between paper_qty_min AND paper_qty_max
					AND paper_gram = '$paper_gram'
					AND paper_size = '$paper_size'
					order by id desc LIMIT 1;
				 ";
		$result = $this->db->query($query);
		$rows =$result->num_rows();
		if($rows > 0) {
			return $result->row();
		} else {
			$query = "select paper_gram,paper_amount from $this->table
					WHERE paper_qty_max = (select MAX(paper_qty_max) from $this->table 
					WHERE paper_gram = '$paper_gram' AND paper_size = '$paper_size')";
			$result = $this->db->query($query);	 
			return $result->row();
		}
		return false;
	}
}
