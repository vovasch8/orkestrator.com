<?php include_once "template/header.php";?>

<div class="container">
    <h5 class="text-center">ДЛЯ НАЧАЛА РАБОТЫ НАД ЗАКАЗОМ НАЖМИТЕ КНОПКУ <span id="text-go">ПРИСТУПИТЬ</span></h5>

    <form action="#" method="post" class="form-order mt-1">
        <div class="container order-container">
            <div class="row">
                <div class="col-md-4">ЗАДАЧА: <span>1854</span></div>
                <div class="col-md-4 border-start border-end">ОПЕРАТОР: <span>С. Кадзима</span></div>
                <div class="col-md-4">ПОРУЧИЛ: <span>С. Веденеев</span></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">АРТИКУЛ:</div>
                <div class="col-sm-9">12190034020006</div>
            </div>
            <div class="row">
                <div class="col-sm-3">ПРОДУКТ:</div>
                <div class="col-sm-9">Грильято Класичний Повздовжній</div>
            </div>
            <div class="row">
                <div class="col-sm-3">ВЫСОТА:</div>
                <div class="col-sm-9">9</div>
            </div>
            <div class="row">
                <div class="col-sm-3">ШИРИНА:</div>
                <div class="col-sm-9">40</div>
            </div>
            <div class="row">
                <div class="col-sm-3">ДЛИНА:</div>
                <div class="col-sm-9">600</div>
            </div>
            <div class="row">
                <div class="col-sm-3">ЦВЕТ:</div>
                <div class="col-sm-9">RAL 9003</div>
            </div>
            <div class="row">
                <div class="col-sm-3">КОЛИЧЕСТВО:</div>
                <div class="col-sm-9">18 000</div>
            </div>
            <div class="row">
                <div class="col-sm-3">МАТЕРИАЛ:</div>
                <div class="col-sm-9">Штрипс 0,23*87 RAL 9003</div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-2">
                <div class="col-md-9 col-5 text-start">
                    <button class="btn btn-grey mt-1">ОТЛОЖИТЬ</button>
                    <button class="btn btn-grey mt-1">СЛЕДУЮЩЕЕ</button>
                </div>
                <div class="col-md-3 col-7 text-end mt-1">
                    <button id="btn-order" class="btn">ПРИСТУПИТЬ</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include_once "template/footer.php";?>
