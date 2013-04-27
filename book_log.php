<?

	class BookLogPager extends Pager{
		private $sql ;
		public $from ;
		public $to ;
		public $titles ;
		public function __construct($user_id,$page,$title){
			$this -> sql = "
				select u1.email,u2.email, tt.titles from 
				(
				     select b.devote_user_id,b.borrow_user_id ,
				     GROUP_CONCAT(bd.title SEPARATOR ',' ) titles,
				     bd.borrow_id 
				     from borrow b left join 
				          (
				          	select bk.title,bdetail.borrow_id,bk.id 
				          	from borrow_detail bdetail 
				          	left join book bk on bdetail.book_id = bk.id 
				          )
				     bd on b.id = bd.borrow_id group by bd.borrow_id
				) tt 
				left join user u1 on tt.devote_user_id = u1.id 
				left join user u2 on tt.borrow_user_id = u2.id ;
			";
			parent::__construct($this-> sql,$page,$title);
		}
		public function next(){
			$row = $this -> db -> fetch_row($this -> result);
			if ($row){
				$this -> from = $row[0] ;
				$this -> to = $row[1] ;
				$this -> titles = $row[2] ;
				return true;
			}else return false;
		}

	}

?>