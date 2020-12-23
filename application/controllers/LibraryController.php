<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibraryController extends CI_Controller {

	public function index() {
		$this->displayBooks();
	}
	
	// Function displayBooks is used for displaying the list of books.
	public function displayBooks() {
		$arrmixBooks[ 'books' ] = $this->books->fetchAciveBooks();
		$this->load->view( 'view_books', $arrmixBooks );
	}
	
	// Issue or return actions on a book.
	public function handleIssueOrReturnBook() {
		$intBookId 		= ( int ) ( $_POST['book_id'] );
		$strUserEmail 	= trim( ( $_POST['user_email'] ) );
		$strActionType 	= trim( ( $_POST['action'] ) );
		$strResponse 	= false;
		$strSuccessMessage = ( 'Issue' == $strActionType ) ? 'Book Issued.' : 'Book Returned.';

		if( false == empty( $intBookId ) ) {
			$strResponse = ( 'Issue' == $strActionType ) ? $this->books->insertBookLog( $intBookId, $strUserEmail ) : $this->books->updateBookLog( $intBookId );
		}

		echo json_encode( [ 'status' => $strResponse, 'message' => ( $strResponse ) ? $strSuccessMessage : 'Unable to '. $strActionType . '. Please try again.'] );
	}

}
 