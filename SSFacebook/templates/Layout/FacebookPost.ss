<div id="FBContent" class="typography">
	<% control FbData %>
	<div class="FBmessage">
		<!-- img src="$icon"/ -->
		<div class="FBAuthor">
		<% control from %>
		<a href="http://www.facebook.com/$id/">
			<img src="https://graph.facebook.com/$id/picture"/>
		</a>
		<p> $name
		<% end_control %>
				el $created_time </p>
		</div>
		 <div class="FBMessageBody">
			<a href="$link" ><img src="$picture"/></a>
			$message
		 </div>
		 
		 <div class="likes">
			Me Gusta: 
			<% control likes %>
			$count
			<% end_control %>
		 </div>
		 
		 
			
			
		 
		 <div class="comentarios">
		
		 <% control comments %>
			<% control data %>
				<div class="comentario">
					
					
						<% control from %>
							<a href="http://www.facebook.com/$id/">
								<img src="https://graph.facebook.com/$id/picture"/>
							</a>
						<div><p> $name
						<% end_control %>
						el $created_time </p>
						<p>$message</p>
						</div>
					 
				</div>
			 <% end_control %>
		 <% end_control %>
		 </div>
		 <div class="FBActions">
		 <% control actions %>
			 
				<a href="$link">$name </a>
			 
		<% end_control %>
		</div>
	</div>
	<% end_control %>
</div>