<!-- Modal Remove Item -->
			<div id="removeItemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">×</a>
	              <h3>Remove Item</h3>
	        </div>
				<div>
					<form class="removeItem">
					<fieldset>
					<div class="modal-body">
						<ul class="nav nav-list" id="input">
							<li class="nav-header">Enter Product Code</li>
							<li><input class="input-xlarge" value="" type="text" name="prodCode"></li>
						</ul>
            <div class="alert alert-success" role="alert" id="itemRemoveSuccess" style="display:none;">
              Item has been successfully removed!
            </div>
            <div class="alert alert-danger" role="alert" id="itemRemoveFail" style="display:none;">
              Oops, something is wrong, please try again
            </div>
					</div>
					</fieldset>
					</form>
				</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="submit2">Remove Item</button>
				<a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
			</div>
			</div>
			</div>
		</div>

		<script>
		$(document).ready(function () {
			$('#submit2').click(function(e){
				console.log("in onclick");
				e.preventDefault();
				e.stopPropagation();
				removeFromDB();
			});
		});
		function removeFromDB() {
					console.log("were in");
					$.ajax({
						type: "POST",
					url: "/phpClasses/removeItem.php",
          dataType: 'HTML',
					data: $('form.removeItem').serialize(),
						success: function(data){
							//alert(data);
							console.log($('form.removeItem').serialize());
							if(data){
                console.log(data);
                $( '#input' ).hide();
                $('#itemRemoveSuccess').show();
                $('#itemRemoveFail').hide();
                //$("#removeItemModal").modal('hide').delay(10000);
                setTimeout(function() { $("#removeItemModal").modal('hide'); }, 3000);
                setTimeout(function() { location.reload(); }, 3000);
              }

              else{
                $('#itemRemoveFail').show();
             }

						},
					error: function(){
						alert("failure");
						console.log($('form.removeItem').serialize());
						console.log("failed");
					}

					});

		}