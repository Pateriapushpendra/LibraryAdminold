<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Library Admin</title>
      <link rel="stylesheet" href="asset/library.css">
   </head>
   <body class="body-bg">
      <div id="container">
         <h1><span class="font-35px">&#128218;</span> <span class="font-35px">L</span>ibrary<span class="font-35px">A</span>dmin</h1>
         <div id="body">
			<div class="filter"> 	
				<input id="filter_books" placeholder="Enter Book Detail or status to search the book." />
			</div>
            <table id="books">
               <thead>
                  <tr>
                     <th id="serial">#</th>
                     <th>Title</th>
                     <th>Auther</th>
                     <th>Purchased On</th>
                     <th>Available</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody id="list_books">
				   <?php if( !empty( $books ) ) { $intCounter = 0; foreach( $books as $arrmixbook ) { $intCounter++; ?>
						<tr>
							<td class="text-center"><?php echo $intCounter;?></td>
							<td class="book_title"><?php echo  ( is_string( $arrmixbook[ 'book_title' ] ) ) ? $arrmixbook[ 'book_title' ] : '-'; ?></td>
							<td class="book_auther"><?php echo ( is_string( $arrmixbook[ 'book_auther' ] ) ) ? $arrmixbook[ 'book_auther' ] : '-'; ?></td>
							<td class="text-center"><?php echo ( is_string( $arrmixbook[ 'purchased_on' ] ) ) ? date( 'd-m-Y', strtotime( $arrmixbook[ 'purchased_on' ] ) ) : '-'; ?></td>
							<td class="text-center">
								<?php echo ( !is_null( $arrmixbook[ 'user_id' ] ) && is_null( $arrmixbook[ 'returned_on' ] ) ) ? '<span style="color:red">Not Available</span>' : '<span style="color:green">Available</span>';?>
								
								</td>
							<td class="text-center">
								<button class="issue_book" data-action="<?php echo ( !is_null( $arrmixbook[ 'user_id' ] ) && is_null( $arrmixbook[ 'returned_on' ] ) ) ? 'Return' : 'Issue'; ?>" data-book_id="<?php echo $arrmixbook['id']; ?>"><?php echo ( !is_null( $arrmixbook[ 'user_id' ] ) && is_null( $arrmixbook[ 'returned_on' ] ) ) ? 'RETURN' : 'ISSUE' ?></button> 
							</td>
						</tr>
					<?php }  } else { 
						echo '<tr><td colspan="6" class="text-center"> No Record Found.</td></tr>'; 
					} ?>
               </tbody>
            </table>
         </div>
         <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
      </div>
	  <div id="referance_urls" data-url_issuereturnbook="<?php echo base_url( 'LibraryController/handleIssueOrReturnBook' ) ?>" hidden></div>

	<script src="asset/3.4.1_jquery.min.js"></script>
	<script src="asset/library.js"></script>	
	<script>
		var strHandleIssueOrReturnBook = $( '#referance_urls' ).data( 'url_issuereturnbook' );
	</script>
   </body>
</html>