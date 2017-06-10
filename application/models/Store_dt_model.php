<?php
 class store_dt extends MY_Model implements DatatableModel{
    	
		public function appendToSelectStr() {
				return NULL;
		}
    	
		public function fromTableStr() {
			return 'store s';
		}
    
	    public function joinArray(){
	    	return NULL;
	    }
	    
    	public function whereClauseArray(){
    		return NULL;
    	}
   }
  ?>
