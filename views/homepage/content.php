<script>
	var new_items = 0;
	var page_title = "DemonBuddy Reporter - <?php echo $title;?>";
	$(document).ready(function(){
		//update_stash_logs();
		$(".newItem").live('click', function(){
			$(this).hide();
			new_items--;
			if(new_items > 0){
				document.title = '(' + new_items + ') ' + page_title;
			}else{
				document.title = page_title;
			}
		});
	});
	
	setInterval(update_stash,10000);
	
	function update_stash(){
		$.ajax({
			dataType: "json",
			url: "<?php echo $this->config->item('base_url');?>report/ajax_get_items/" + last_item_id,
			success: function(data) {
				for(x in data){
					console.log(data[x]);
					html = 	'<div class="genericContainer">';
					html += 	'<div class="item">';
					html +=			'<div class="newItem"><img src="<?php echo $this->config->item('base_url');?>includes/images/new-item.png" title="New Item" style="height: 18px"/></div>';
					html +=			'<div class="name">';
					html +=				'<span class="' + ((data[x].legendary == 1) ? 'legendary' : 'rare') + '">';
					if(data[x].legendary == 1){
						html +=			'<a href="http://us.battle.net/d3/en/item/' + data[x].url_name + '" target="_blank">';
					}
					html +=					data[x].item_name;
					if(data[x].legendary == 1){
						html +=			'</a>';
					}
					html +=				'</span>';
					html +=			'</div>';
					html += 			'<div class="stats">';
					for( i in data[x].stats){
						html += 			'<div class="stat">' + data[x].stats[i].stat_name + ": " + data[x].stats[i].value + '</div>';
					}
					html +=				'</div>';
					html += 			'<div class="clearFix"></div>';
					html += 			'<div class="other">';
					html +=				'<div class="slot">Found By: <span style="color:' + data[x].color + '">' + data[x].character_name + ' (' + data[x].class + ')</span></div>';
					html +=				'<div class="slot">Slot: ' + data[x].slot_name + '</div>';
					html +=				'<div class="type">Type: ' + data[x].type_name + '</div>';
					html +=	 			'<div class="score">Score: ' + data[x].score + '</div>';
					html += 				'<div>Found: ' + data[x].date_added + '</div>';
					html +=			'</div>';
					html +=			'<div class="clearFix"></div>';
					html +=		'</div>';
					html +=	'</div>';
					
					$(".items").prepend(html);
					
					last_item_id = data[x].item_id;
					last_item_found = data[x].date_added
					console.log("added item id: " + last_item_id);
					item_count++;
					new_items++;
				}
				if(data.length > 0){
					document.title = '(' + new_items + ') ' + page_title;
					$("#item_count").html(item_count);
					$("#time_since").html(last_item_found);
				}
			}
		});
	}
</script>
<style>
	.genericContainer {
		border: 1px solid black;
		padding: 10px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		background-image: url('<?php echo $this->config->item('base_url');?>includes/images/transBG.png');
		-webkit-box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, .3);
		box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, .3);
		margin-bottom: 10px;
	}
	
	.characterName {
		font-size: 2.0em;
	}

	.items .item .name {
		font-size: 1.50em;
		font-weight: bold;
		margin-bottom: 5px;
	}
	
	.items .item .name .legendary a{
		color: #bf642f;
		text-decoration: none;
	}
	.items .item .border .stats{
		padding-top: 5px;
	}
	.items .item .border .stats h4 {
		padding-bottom: 0px;
	}
	
	.item {
		color: #6969ff;
		position: relative;
	}
	
	.other {
		padding-top: 5px;
		color: #ACACAC;
	}
	
	.count {
		font-size: 2.0em;
	}
	
	.newItem {
		position: absolute;
		right: 25px;
		top: 3px;
	}
	
	.stats, .other {
		display: inline-block;
	}
	
	.stats .stat {
		display: inline-block;
		padding-right: 10px;
	}
	
	.other div {
		display: inline-block;
		padding-right: 10px;
	}
	
	.item .name {
		display: inline-block;
		padding-right: 10px;
	}
</style>
<div class="genericContainer">
	<div class="count">
		<span class="left">Items Found Today: <span id="item_count"><?php echo $item_count;?></span></span>
		<span class="right">Last item... <span id="time_since"><?php echo date("h:i:sA", $last_item_found);?></span></span>
	</div>
	<div class="clearFix"></div>
</div>
<div>
	<div>
		<div class="genericContainer items">
			<?php echo $item_html;?>
		</div>
	</div>
</div>
<script>
	<!-- SAVE LAST ITEM ID HERE -->
	var last_item_id = <?php echo $last_item_id;?>;
	var last_item_found = <?php echo $last_item_found;?>;
	var item_count = <?php echo $item_count;?>;
</script>