
<?php include_once "template/header.php";?>

<div class="container">

    <h5 class="text-center">ДЛЯ ПРОДОЛЖЕНИЯ РАБОТЫ, НЕОБХОДИМО ВЫБРАТЬ СТАНОК</h5>
    <h6 class="text-center">Выберите станок из списка или отсканируйте штрих-код станка</h6>

    <div class="container text-center">
        <form id="choice_stand" action="#" method="post" class="form-machine mt-5">
            <ul class="nav nav-tabs border">
                <li class="nav-item active-tab">
                    <a class="nav-link" aria-current="page" href="#" onclick="tab_choice_stand()">ВЫБРАТЬ СТАНОК</a>
                </li>
                <li  class="nav-item nav-grey">
                    <a class="nav-link" href="#" onclick="tab_scan_stand()">СКАНИРОВАТЬ</a>
                </li>
            </ul>
            <div class="row justify-content-center">
                <div class="col-md-12 col-sm-12 pt-5 ps-5 pe-5 border-right">
                    <label for="select-machine">ВЫБЕРИТЕ СТАНОК</label>
                    <select name="machines" id="select-machine" class="form-select">
                        <option>Станок 1</option>
                        <option>Станок 2</option>
                        <option>Станок 3</option>
                    </select>
                </div>
                <button class="btn btn-grey mt-5">ВОЙТИ</button>
            </div>

        </form>

        <form id="scan_stand" action="#" method="post" class="form-machine mt-5">
            <ul class="nav nav-tabs border">
                <li class="nav-item nav-grey">
                    <a class="nav-link" aria-current="page" href="#" onclick="tab_choice_stand()">ВЫБРАТЬ СТАНОК</a>
                </li>
                <li class="nav-item active-tab">
                    <a class="nav-link " href="#" onclick="tab_scan_stand()">СКАНИРОВАТЬ</a>
                </li>
            </ul>
            <div class="row justify-content-center">
                <div class="col-md-12 col-sm-12 text-center pt-5 ps-5 pe-5">
                    <p for="btn-scan">ШТРИХКОД СТАНКА</p>
                    <button id="btn-scan" class="btn btn-grey">СКАНИРОВАТЬ</button>
                    <br>
                    <label class="mt-3 text-start" for="input-id-machine">ID СТАНКА</label>
                    <br>
                    <input id="input-id-machine" type="text"  class="form-control">
                </div>
                <button class="btn btn-grey mt-5">ВОЙТИ</button>
            </div>
        </form>
    </div>

</div>

<script src="/layout/js/tabs.js"></script>
<?php include_once "template/footer.php";?>