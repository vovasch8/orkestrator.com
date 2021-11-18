<?php include_once "template/header.php";?>

<?php include_once "template/admin-sidebar.php"?>

    <div id="admin-content" class="container">
        <h5 class="text-center mt-5">Управление рабочими сменами</h5>

        <div  class="row mt-5 justify-content-center">
            <div id="left-week-triangle" class="triangle-left col-lg-2"></div>
            <div id="week-blocks" class="col-lg-8 text-center">
            <?php for($i = $_SESSION['pointer']-1; $i < $_SESSION['pointer'] + 2; $i++):?>
                <?php $symbol = ''; if($i >= 0){ $symbol = '+';}?>
                <div class="week-block text-center <?php if($i == $_SESSION['pointer']){echo "active-week";} ?>">
                    <span><b><?php echo date('W',strtotime('sunday this week ' . $symbol . $i . ' week'));?></b></span><br>
                    <span class="text-center">
                        <?php echo date('d',strtotime('monday this week '. $symbol . $i . ' week'));?> -
                        <?php echo date('d',strtotime('sunday this week '. $symbol . $i . ' week')); ?>
                        <?php echo $month[date('m',strtotime('sunday this week '. $symbol . $i . ' week')) - 1].'<br>';?>
                        <?php echo date('Y',strtotime('monday this week ' . $symbol . $i . ' week'));?>
                    </span>
                </div>
            <?php endfor;?>
            </div>
            <div id="right-week-triangle" class="triangle-right col-lg-2 "></div>
        </div>
        <div id="day-blocks" class="row text-center justify-content-center">
            <div id="cur_date" class="date-block col-sm-12"><?php echo "<span date='".date("Y-m-d")."' >". date("d-m")."</span>";?></div>
            <?php $day = strtotime('monday this week');
                while ($day <= strtotime('sunday this week')) :?>
                    <div id="<?php echo $en_days[date("N", $day)];?>" class="day-block <?php if(date("d") == date('d', $day)){ echo "active-day";} ?>">
                        <?php echo $days[date("N", $day)];  ?></div>
                <?php $day = strtotime('+1 day', $day);
            endwhile;?>
        </div>
        <hr>

        <div class="row justify-content-center">
            <div class="shift col-lg-5 col-md-12">
                <div class="row">
                    <h6 class="text-center col-sm-4 col-md-6 col-6 mt-3">Дневная смена</h6>
                    <div id="day-menu" class="col-sm-8 col-md-6 col-6 mt-2">
                        <div class="dropdown">
                            <button onclick="dropDayShift()" class="dropbtn btn b-v">V</button>
                            <div id="DropdownDay" class="dropdown-content">
                                <a onclick="checkAllDay()" href="#all">Выбрать все</a>
                                <a onclick="changeShifts()" href="#change_shift">Поменять смены местами</a>
                                <a onclick="transferToNextWeek()" href="#copy_week">Перенести смены на другую неделю</a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button onclick="dropDayAdd()" class="dropbtn btn b-add">+</button>
                            <div id="DropdownDayAdd" class="dropdown-content">
                                <?php foreach ($usersFromProduction as $user):?>
                                <a onclick="addUserDay(this)" class="user-day" id="ud-<?php echo $user['u_id'];?>"><?php echo $user['u_fname'] . ' ' . $user['u_sname'];?></a>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <button onclick="dayDel()" class="btn b-del">-</button>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="form-check ms-3">
                        <ul id="day-shift">
                            <?php foreach ($dayUsers as $d_user): ?>
                                <li id='li-ud-<?php echo $d_user['u_id'];?>'>
                                    <input class="form-check-input night-check" type="checkbox" id="nс-ud-<?php echo $d_user['u_id']; ?>">
                                    <label class="form-check-label" id="l-ud-<?php echo $d_user['u_id'];?>" for="nc-ud-<?php echo $d_user['u_id'];?>"><?php echo $d_user['u_fname'] . " " . $d_user['u_sname'];?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 pt-5 pb-5 text-center">
                <div id="triangle-copy-left" onclick="copyToDayShift()" class="triangle-left "></div>
                <div id="triangle-copy-right" onclick="copyToNightShift()" class="triangle-right "></div>
                <div id="changer"></div>
            </div>
            <div class="shift col-lg-5 col-md-12">
                <div class="row">
                    <h6 class="text-center col-sm-4 col-md-6 col-6 mt-3">Ночная смена</h6>
                    <div id="night-menu" class="col-sm-8 col-md-6 col-6 mt-2">
                        <div class="dropdown">
                            <button onclick="dropNightShift()" class="dropbtn btn b-v">V</button>
                            <div id="DropdownNight" class="dropdown-content">
                                <a onclick="checkAllNight()" href="#all">Выбрать все</a>
                                <a onclick="changeShifts()" href="#change_shift">Поменять смены местами</a>
                                <a onclick="transferToNextWeek()" href="#copy_week">Перенести смены на другую неделю</a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button onclick="dropNightAdd()" class="dropbtn btn b-add">+</button>
                            <div id="DropdownNightAdd" class="dropdown-content">
                                <?php foreach ($usersFromProduction as $user):?>
                                    <a onclick="addUserNight(this)" class="user-night" id="un-<?php echo $user['u_id'];?>"><?php echo $user['u_fname'] . ' ' . $user['u_sname'];?></a>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <button onclick="nightDel()" class="btn b-del">-</button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-check ms-3">
                        <ul id="night-shift">
                            <?php foreach ($nightUsers as $n_user): ?>
                                <li id='li-un-<?php echo $n_user['u_id'];?>'>
                                    <input class="form-check-input night-check" type="checkbox" id="nс-un-<?php echo $n_user['u_id']; ?>">
                                    <label class="form-check-label" id="l-un-<?php echo $n_user['u_id'];?>" for="nc-un-<?php echo $n_user['u_id'];?>"><?php echo $n_user['u_fname'] . " " . $n_user['u_sname'];?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="save-block" class="row justify-content-center mt-3">
            <div class="text-center">
                <input class="form-check-input d-inline-block" id="save-week" type="checkbox">
                <label class="form-check-label d-inline-block" for="save-week">Сохранить график к концу недели</label>
            </div>
            <button onclick="saveShifts()" class="btn btn-orange btn-save">Сохранить</button>
        </div>
        <br>
        <div class="row mb-3">
            <div class="text-center" id="message"></div>
        </div>
    </div>


    <script src="/layout/js/work_shift.js"></script>
    <script src="/layout/js/work_shift_ajax.js"></script>
<?php include_once "template/footer.php";
