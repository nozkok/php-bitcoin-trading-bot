<?php
	include("inc/header.php");
?>

<section id="main">
    <section id="content">
        <div class="container">
			
            <div class="row">
                <div class="col-sm-12">
                    <!-- Recent Items -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Your Rules <small>Your Buy/Sell Rules</small></h2>
                            <ul class="actions">
                                <li>
                                    <a href="newrule.php">
                                        <i class="zmdi zmdi-edit"></i>
									</a>
								</li>
							</ul>
						</div>
						
                        <div class="card-body m-t-0">
                            <table class="table table-inner table-vmiddle">
                                <thead>
									<tr>
										<th>ID</th>
										<th>Coin</th>
										<th>Buy Type</th>
										<th>Time</th>
										<th>Buy %</th>
										<th>Sell on Profit (%)</th>
										<th>Stop Loss (%)</th>
										<th>Actions</th>
									</tr>
								</thead>
                                <tbody>
									<?php
										$stmt = $dbh->prepare("select * from rules order by id desc");
										$stmt->execute();
										$i = 0;
										while ($rules = $stmt->fetch()) {
											$i++;
										?>
										<tr>
											<td><?php echo $i;?></td>
											<td><?php echo $rules['coin'];?></td>
											<td><?php if($rules['buy_type'] == 1){echo "Dump";}elseif($rules['buy_type'] == 2){echo "Pump";} ?></td>
											<td><?php echo $rules['time'];?></td>
											<td><?php echo $rules['buy_percent'];?></td>
											<td><?php echo $rules['sell_on_profit'];?></td>
											<td><?php echo $rules['stop_loss'];?></td>
											<td>
												<a href="javascript:;" onclick="setRuleStatus(<?php echo $rules['status'];?>,<?php echo $rules['id'];?>); return false;" class="btn btn-<?php if($rules['status'] == 1){echo "warning";}else{echo "success";} ?>">
													<i class="zmdi zmdi-<?php if($rules['status'] == 1){echo "pause";}else{echo "play";} ?>"></i>
												</a>
												<a href="javascript:;" onclick="deleteRule(<?php echo $rules['id'];?>); return false;" class="btn btn-danger">
													<i class="zmdi zmdi-delete"></i>
												</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<script>
	function setRuleStatus(status,id){
		$.post('inc/data.php?type=setRuleStatus',{status: status,id:id},function(r){
			location.reload();
		});
	}
	function deleteRule(id){
		$.post('inc/data.php?type=deleteRule',{id:id},function(r){
			location.reload();
		});
	}
</script>
<?php
	include("inc/footer.php");
?>
