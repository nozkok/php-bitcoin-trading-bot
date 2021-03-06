<?php
include("inc/header.php");
?>
<section id="main">
    <section id="content">
        <div class="container">

            <div class="mini-charts">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-cyan">
                            <div class="clearfix">
                                <div class="chart stats-bar"></div>
                                <div class="count">
                                    <small>Total Balance</small>
                                    <h2>
                                        <?php
                                        $stmt = $dbh->prepare("select * from total_btc order by id desc limit 1");
                                        $stmt->execute();
                                        $row = $stmt->fetch();
                                        $lastAmount = $row['amount'];
                                        echo $lastAmount;
                                        ?>
                                        BTC</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-lightgreen">
                            <div class="clearfix">
                                <div class="chart stats-line"></div>
                                <div class="count">
                                    <small>Profit Today</small>
                                    <h2>
                                        <?php
                                        $stmt = $dbh->prepare("select * from total_btc where date > (NOW() - INTERVAL 1 DAY) order by id asc limit 1");
                                        $stmt->execute();
                                        $row = $stmt->fetch();
                                        $yesterdaysAmount = $row['amount'];
                                        if($yesterdaysAmount == ""){
                                            $yesterdaysAmount = 0;
                                        }
                                        echo cikarmaBtc($lastAmount,$yesterdaysAmount);
                                        ?>
                                        BTC</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-orange">
                            <div class="clearfix">
                                <div class="chart stats-line"></div>
                                <div class="count">
                                    <small>Profit Last 7 Days</small>
                                    <h2>
                                        <?php
                                        $stmt = $dbh->prepare("select * from total_btc where date > (NOW() - INTERVAL 7 DAY) order by id asc limit 1");
                                        $stmt->execute();
                                        $row = $stmt->fetch();
                                        $lastWeekAmount = $row['amount'];
                                        if($lastWeekAmount == ""){
                                            $lastWeekAmount = 0;
                                        }
                                        echo cikarmaBtc($lastAmount,$lastWeekAmount);
                                        ?>
                                        BTC</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-bluegray">
                            <div class="clearfix">
                                <div class="chart stats-line-2"></div>
                                <div class="count">
                                    <small>Profit Last 30 Days</small>
                                    <h2>
                                        <?php
                                        $stmt = $dbh->prepare("select * from total_btc where date > (NOW() - INTERVAL 30 DAY) order by id asc limit 1");
                                        $stmt->execute();
                                        $row = $stmt->fetch();
                                        $lastMonthAmount = $row['amount'];
                                        if($lastMonthAmount == ""){
                                            $lastMonthAmount = 0;
                                        }
                                        echo cikarmaBtc($lastAmount,$lastMonthAmount);
                                        ?>
                                        BTC</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <!-- Recent Items -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Balances <small>Your current balances</small></h2>
                        </div>
                        <?php
                        $balances = $polo->get_balances();

                        ?>

                        <div class="card-body m-t-0">
                            <table class="table table-inner table-vmiddle">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Coin</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach($balances as $key=>$value){
                                if($value > 0) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $key;?></td>
                                        <td><?php echo $value;?></td>
                                    </tr>
                                <?php }} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <!-- Recent Items -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Last Activities <small>Your last Buy/Sell Activities</small></h2>
                        </div>

                        <div class="card-body m-t-0">
                            <table class="table table-inner table-vmiddle">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Notification</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stmt = $dbh->prepare("select * from notifications order by id desc limit 10");
                                $stmt->execute();
                                $i = 0;
                                while ($row = $stmt->fetch()) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $row['text'];?></td>
                                        <td><?php echo $row['date'];?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <!-- Recent Items -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Your Rules <small>Your Buy/Sell Rules</small></h2>
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
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stmt = $dbh->prepare("select * from rules");
                                $stmt->execute();
                                while ($rules = $stmt->fetch()) {
                                    $time = $rules['time'];
                                    if($time < 60){
                                        $time = $time." mins";
                                    }elseif($time % 1440 == 0){
                                        $time = ($time/1440)." day";
                                    }elseif($time % 60 == 0){
                                        $time = ($time/60)." hours";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $rules['id'];?></td>
                                        <td><?php echo $rules['coin'];?></td>
                                        <td><?php if($rules['buy_type'] == 1){echo "Dump";}elseif($rules['buy_type'] == 2){echo "Pump";} ?></td>
                                        <td><?php echo $time;?></td>
                                        <td><?php echo $rules['buy_percent'];?></td>
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
<?php
include("inc/footer.php");
?>
