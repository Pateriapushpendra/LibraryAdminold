<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class books extends CI_Model {

	// Fetch all active books with current status.
	function fetchAciveBooks() {

		$strSql = '
			SELECT
				tb.id,
				tb.book_title,
				tb.book_auther,
				tb.purchased_on,
				tbl.user_id,
				CASE 
					WHEN tbl.returned_on = "0000-00-00 00:00:00" THEN NULL 
					ELSE tbl.returned_on 
				END AS returned_on
			FROM 
				tbl_books tb
				LEFT JOIN tbl_book_logs tbl ON tbl.id = (SELECT MAX(tbl2.id) FROM tbl_book_logs tbl2 WHERE tbl2.book_id = tb.id)
			WHERE 
				tb.book_status = 1
			order by 
				tb.id
		';
		
		$query = $this->db->query( $strSql );

		return $query->result_array();
	}
	
	// Issue the book.
	public function insertBookLog( $intBookId, $strUserEmail ) {
		
		$strsqlUserData = "SELECT 
						id 
					FROM 
						tbl_users
					WHERE 
						lower(user_email) = lower('$strUserEmail')
				";

		$arrmixuserDetails = $this->db->query( $strsqlUserData )->result_array();

		if ( !empty( $arrmixuserDetails ) ) {
			$intUserId = $arrmixuserDetails[0]['id'];
			$strSqlInsertUserLog = "INSERT INTO tbl_book_logs (book_id, user_id, issued_on ) VALUES($intBookId, $intUserId, NOW() )";
			return ( $this->db->query( $strSqlInsertUserLog ) );
		}
	}
	
	// Return the book.
	function updateBookLog( $intBookId ) {
		if ( false == is_int( $intBookId ) ) return false;

		$strSql = '	UPDATE 
						tbl_book_logs
					SET
						returned_on = NOW()
					WHERE 
						book_id = ?
				';

		return $this->db->query( $strSql, [ $intBookId ] );
	}

}

?>