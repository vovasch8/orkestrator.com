<?php include_once "template/header.php";?>

<?php include_once "template/admin-sidebar.php"?>


    <div id="admin-content" class="container">
        <h5 class="text-center mt-5">Управление пользователями</h5>
        <a href="/admin/add-user"><button class="btn btn-orange">Добавить пользователя</button></a>


        <div class="justify-content-center row">
            <div class="table-responsive">
                <table class="table  table-bordered mt-3">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Email</th>
                        <th scope="col">Карта</th>
                        <th scope="col">Редактирование</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user):?>
                    <tr>
                        <th scope="row"><?php echo $user['u_id'];?></th>
                        <td><?php echo $user['u_fname'];?></td>
                        <td><?php echo $user['u_sname'];?></td>
                        <td><?php echo $user['u_email'];?></td>
                        <td><?php echo $user['u_card'];?></td>
                        <td><a href="<?php echo 'edit-user/' .$user['u_id'];?>">Редактировать</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include_once "template/footer.php";
