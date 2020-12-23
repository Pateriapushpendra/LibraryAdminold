
// Filter the books.
$("#filter_books").on("keyup", function() {
	var value = $(this).val().toLowerCase();
	$("#books tr ").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});
});

// Issue or return activity for a book.
$( '.issue_book' ).off( 'click' ).on( 'click', function () {
	var strUserEmail 	= '';
	var intBookId 		= $(this).data('book_id');
	var strActionType 	= $(this).data('action');
	var boolValidEmailId = true;
	if( 'Issue' == strActionType ) { 
		strUserEmail = prompt("Please enter email address of the issuer:");
		if ( null == strUserEmail ) 
			return false;
	
		var strPatternEmail  = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
		boolValidEmailId = strPatternEmail.test( strUserEmail );
	}

	if (true == boolValidEmailId ) {
		$.ajax({
			url: strHandleIssueOrReturnBook,
			method: 'POST',
			data: 'book_id=' + intBookId + '&user_email=' + strUserEmail + '&action=' + strActionType,
			success: function ( strResponse ) {
				var strResponse = $.parseJSON( strResponse );
				if (true == strResponse.status) { 
					alert( strResponse.message );
					location.reload();
				} else {
					alert( strResponse.message );
				}
			}
		});
	}

});
