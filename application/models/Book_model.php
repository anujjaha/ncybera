<?php
class Book_model extends CI_Model {


	public function __construct()
    {
                parent::__construct();
    }
  
    public $table = "book_manager";
  	
	public function getAllBooks() 
	{
		return $this->db->select('*, customer.mobile as customer_mobile,  book_manager.id as book_id')->from($this->table)
				->join('user_meta','user_meta.user_id = book_manager.created_by','left')
				->join('customer','customer.id = book_manager.customer_id','left')
				->get()->result_array();
	}

	public function create($data = array())
	{
		if(count($data))
		{
			return $this->db->insert($this->table, $data);
		}
	}

	public function getBookInfoByCutomerId($customerId)
	{
		$this->db->select('count(id) as count')->from($this->table);
		$this->db->where('customer_id', $customerId);
		$query = $this->db->get();
		return $query->row()->count;
	}

	public function deleteBook($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
		return true;
	}

}
