define(['jquery', 'i18n', 'helpers'], function($, __, helpers){
    return {
        start: function(){

			//meta data dialog
			var commentContainer = $("#comment-form-container");
			if (commentContainer) {

				
				
				$("#comment-editor").click(function(){
					var commentContainer = $(this).parents('td');
					if($('.comment-area', commentContainer).length === 0){

						var commentArea = $("<textarea id='comment-area'></textarea>");
						var commentField = $('span#comment-field', commentContainer);
						commentArea.val(commentField.html())
									.width(parseInt(commentContainer.width()) - 5)
									.height(parseInt(commentContainer.height()));
						commentField.empty();
						commentArea.bind('keypress blur' , function(event){
							if(event.type === 'keypress'){
								if (event.which !== '13') {
									return true;
								}
								event.preventDefault();
							}
							$.ajax({
								url: helpers._url('saveMetadata', 'TalkPage', 'taoTalk'),
								type: "POST",
								data: {comment: $(this).val(), uri: $('#uri').val(), classUri:$('#classUri').val() },
								dataType: 'json',
								success: function(response){
									if (response.saved) {
										// Remove text-area that was receiving the content of the new comment.
										commentArea.remove();
										
										// Add a new row to the comments table with the newly created comment within.
										var newRow = $('<tr></tr>');
										newRow.append('<td class="first">' + response.date + '</td>');
										newRow.append('<td>' + response.author + '</td>');
										newRow.append('<td class="last">' + response.text + '</td>');
										$('#meta-addition').before(newRow);
									}
								}
							});
						});
						commentContainer.prepend(commentArea);
					}
				});
			}
        }
    };
});