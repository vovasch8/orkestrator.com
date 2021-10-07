
<?php include_once "template/header.php";?>

<div class="container">
    <h5 class="text-center">ДЛЯ ПРОДОЛЖЕНИЯ РАБОТЫ, НЕОБХОДИМО  ВЫБРАТЬ МАТЕРИАЛ</h5>

    <form action="#" method="post" class="mt-1 form-machine">
        <div class="container text-center">
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="orange-message-block">
                        1. Отсканируйте свой персональный штрихкод, любым свободным ТСД.
                    </div>
                </div>
                <div class="col-md-4">
                    <img id="pointer-1" height="150" width="150" src="/layout/image/pointer.png" alt="Pointer right">
                </div>
                <div class="col-md-4">
                    <div class="white-message-block" >
                        2. На данный ТСД прийдет задача на получение необходимого материала на складе.
                    </div>
                </div>
            </div>
            <img id="non-vis-img" height="150" width="150" src="/layout/image/pointer.png" alt="Pointer">
            <div class="row mt-5 margin-row">
                <div class="col-md-4 mt-5">
                    <div class="white-message-block">
                        3. Отсканируйте необходимый материал на складе
                    </div>
                </div>
                <div class="col-md-4">
                    <img id="pointer-2" height="150" width="150" src="/layout/image/pointer.png" alt="Pointer Bottom Left">
                </div>
                <div class="col-md-4 mt-5">
                    <div class="orange-message-block">
                        ОЖИДАЕМ СКАНИРОВАНИЯ
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <h6 class="text-center mt-4">ОТСКАНИРОВАНО</h6>
                <h5 class="text-center text-orange">Штрипс 0,23*87 RAL 9003</h5>
                <button id="btn-nal" class="btn mt-4 mb-5">ПЕРЕЙТИ К НАЛАДКЕ</button>
            </div>

        </div>
    </form>
</div>

<?php include_once "template/footer.php";?>
