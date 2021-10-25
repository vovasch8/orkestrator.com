<div class="table-responsive">
    <table class="table table-bordered  table-striped mt-3">
        <thead>
        <tr>
            <td colspan="5">Дата</td>
            <?php if($sort_date == 'day'){
                echo '<td colspan="3" >' . date("d.m") . '</td>';
            }elseif ($sort_date == 'week'){
                $date = strtotime('monday this week');
                for($i = 0; $i < 7; $i++){
                    echo '<td colspan="3" >' . date("d.m", $date) . '</td>';
                    $date =  strtotime('+1 day', $date);
                }
            }elseif($sort_date == 'month'){
                $count_day_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));
                $month = date('m');
                for($i = 1; $i <= $count_day_month; $i++){
                    if($i < 10){
                        echo '<td colspan="3" >'. '0' . $i. '.'. $month .'</td>';
                    }else{
                        echo  '<td colspan="3" >'. $i. '.'. $month .'</td>';
                    }
                }
            }?>
        </tr>
        <tr>
            <td colspan="4">Старт<br>Финиш</td>
            <td class="v-col" colspan="1">Часы</td>
            <?php if($sort_date == 'day'){
                echo '<td colspan="3" ></td>';
            }elseif ($sort_date == 'week'){
                for($i = 0; $i < 7; $i++){
                    echo '<td colspan="3" ></td>';
                }
            }elseif($sort_date == 'month'){
                for($i = 0; $i < 31; $i++){
                    echo  '<td colspan="3" ></td>';
                }
            }?>
        </tr>
        </thead>
        <tbody>
                <?php if($sort_date == 'day'){
                    $cur = 0;
                    foreach ($user_work_time as $user) {
                        echo "<tr>";
                        echo "<td colspan='5'>" . $users[$cur]['u_fname'] . ' ' . $users[$cur]['u_sname'] . "</td>";
                        $day = strtotime(date('Y-m-d'));
                        echo '<td colspan="2">' . $user[date('Y-m-d', $day)][0] . '<br>' . $user[date('Y-m-d', $day)][1] . '</td>';
                        echo '<td class="v-col" colspan="1">' . abs((int)$user[date('Y-m-d', $day)][0] - (int)$user[date('Y-m-d', $day)][1]) . '</td>';
                        echo '</tr>';
                        $cur++;
                    }
                }elseif ($sort_date == 'week'){
                    $cur = 0;
                    foreach ($user_work_time as $user) {
                        echo "<tr>";
                        echo "<td colspan='5'>" . $users[$cur]['u_fname'] . ' ' . $users[$cur]['u_sname'] . "</td>";
                        $day = strtotime('monday this week');
                        while ($day <= strtotime('sunday this week')) {
                            if (isset($user[date('Y-m-d', $day)])) {
                                echo '<td colspan="2">' . $user[date('Y-m-d', $day)][0] . '<br>' . $user[date('Y-m-d', $day)][1] . '</td>';
                                echo '<td class="v-col" colspan="1">' . abs((int)$user[date('Y-m-d', $day)][0] - (int)$user[date('Y-m-d', $day)][1]) . '</td>';
                            } else {
                                echo '<td colspan="2"><br></td>';
                                echo '<td class="v-col" colspan="1"></td>';
                            }
                            $day = strtotime('+1 day', $day);
                        }
                        echo '</tr>';
                        $cur++;
                    }
                }elseif($sort_date == 'month'){
                    $cur = 0;
                    foreach ($user_work_time as $user){
                        echo "<tr>";
                        echo "<td colspan='5'>". $users[$cur]['u_fname']. ' '. $users[$cur]['u_sname']."</td>";
                        $day = strtotime('first day of this month');
                        $count_day_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));
                        for($i = 0; $i < $count_day_month; $i++){
                            if(isset($user[date('Y-m-d',$day)])){

                                echo '<td colspan="2">' .$user[date('Y-m-d',$day)][0] . '<br>' .$user[date('Y-m-d',$day)][1].'</td>';
                                echo '<td class="v-col" colspan="1">'. abs((int)$user[date('Y-m-d',$day)][0] -  (int)$user[date('Y-m-d',$day)][1]) .'</td>';
                            }else{
                                echo '<td colspan="2"><br></td>';
                                echo '<td class="v-col" colspan="1"></td>';
                            }
                            $day =  strtotime('+1 day', $day);
                        }
                        echo '</tr>';
                        $cur++;
                    }
                }?>
        </tbody>
    </table>
</div>
