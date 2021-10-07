<?php include_once "template/header.php";?>

<div class="container">
    <div name="MyForm"  class="form-machine adjustment-form">
        <h6 class="text-center">ДЛЯ ЗАПУСКА ЗАДАЧИ НАЖМИТЕ <span class="green-span">СТАРТ</span></h6>
        <div class="row mb-3 mt-4">
            <div class="task-container col-md-12 col-lg-9">
                <div class="row mt-4">
                    <div class="col-md-6 col-sm-6">ЗАДАЧА: <span>1854</span></div>
                    <div class="col-md-6 col-sm-6">ВНИМАНИЕ! ЭТО ГРУППОВАЯ ЗАДАЧА</div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-5 col-sm-12">
                        <span class="">Грильято Класичний Повздовжній</span>
                    </div>
                    <div class="col-md-3 col-sm-4 col-12">
                        <span class="">9х40х600</span>
                    </div>
                    <div class="col-md-2 col-sm-4 col-12">
                        <span class="">RAL 9003</span>
                    </div>
                    <div class="col-md-2 col-sm-4 col-12">
                        <span class="">1100</span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 text-end col-sm-12 btn-center-align btn-circle-lg o-1">
                <button id="start" class="btn btn-circle btn-circle-green mt-2" onclick="Start()">СТАРТ</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="o-2">
                    <p class="p-item p-start">ВРЕМЯ СТАРТА</p>
                    <p id="start-time" class="time-size">00:00:00</p>
                </div>
                <div class="">
                    <p class="p-item p-go-time">ПРОШЛО ВРЕМЕНИ</p>
                    <p id="timer" class="time-size">00:00:00</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div>
                    <p class="p-item p-product-made">ИЗГОТОВЛЕННО</p>
                    <p class="var-size">235</p>
                </div>
                <div>
                    <p class="p-item p-product-remain">ОСТАЛОСЬ</p>
                    <p class="var-size">865</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 text-end col-sm-12 btn-center-align btn-circle-lg o-1">
                <button id="pause" class="btn btn-circle btn-circle-orange  mt-5 btn-margin-lg" onclick="Pause()">ПАУЗА</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <p class="p-item p-standart">ЭТАЛОН</p>
                <p class="time-size time-standart">01:15:00</p>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <p class="p-item p-product-all">ВСЕГО</p>
                <p class="var-size">1100</p>
            </div>
            <div class="col-lg-4 col-md-12 text-end col-sm-12 btn-center-align btn-circle-lg">
                <button class="btn btn-circle btn-circle-red " onclick="Stop()">СТОП</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <button id="btn-nal" class="btn mt-4 mb-5">ЗАВЕРШИТЬ ЗАДАЧУ</button>
        </div>
    </div>
</div>

<script src="/layout/js/timer.js"></script>
<?php include_once "template/footer.php";?>
