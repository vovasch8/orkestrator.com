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
