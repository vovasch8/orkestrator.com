<?php include_once "template/header.php";?>

<div class="container">
    <div name="MyForm"  class="form-machine adjustment-form">
        <h6 class="text-center">ДЛЯ ЗАПУСКА ПРОЦЕССА НАЛАДКИ НАЖМИТЕ <span class="green-span">СТАРТ</span></h6>
        <div class="row">
            <div class="col-md-6 col-sm-12 o-2">
                <p class="p-item p-start">ВРЕМЯ СТАРТА</p>
                <p id="start-time" class="time-size">00:00:00</p>
            </div>
            <div class="col-md-6 text-end col-sm-12 btn-center-align o-1">
                <button id="start" class="btn btn-circle btn-circle-green" onclick="Start()">СТАРТ</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <p class="p-item p-go-time">ПРОШЛО ВРЕМЕНИ</p>
                <p id="timer" class="time-size">00:00:00</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <p class="p-item p-standart">ЭТАЛОН</p>
                <p class="time-size time-standart">01:15:00</p>
            </div>
            <div class="col-md-6 text-end col-sm-12 btn-center-align">
                <button class="btn btn-circle btn-circle-red" onclick="Stop()">СТОП</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <button id="btn-nal" class="btn mt-4 mb-5">ЗАКОНЧИТЬ НАЛАДКУ</button>
        </div>
    </div>
</div>

<script src="/layout/js/timer.js"></script>
<?php include_once "template/footer.php";?>
