<?php
include_once ROOT . "/components/DB.php";

class Shift
{
    public static function saveShift($ids, $date, $shift){
        // З'єднання з базою даних
        $db = Db::getConnection();

        //Видаляэмо всі записи даного дня
        $sql = "DELETE FROM work_shift WHERE date = '" . $date . "' AND shift = '" .  $shift . "' ";
        $db->query($sql);

        //Додаємо працівників до зміни
        for($i = 0; $i < count($ids); $i++){
            $sql = "INSERT INTO work_shift VALUES (:u_id, :date, :shift)";

            $result = $db->prepare($sql);
            $result->bindParam(':u_id', $ids[$i], PDO::PARAM_STR);
            $result->bindParam(':date', $date, PDO::PARAM_STR);
            $result->bindParam(':shift', $shift, PDO::PARAM_STR);

            $result->execute();
        }
        return true;
    }

    public static function changeShift($user_ids, $shift, $date){
        // З'єднання з базою даних
        $db = Db::getConnection();

        $sql = "UPDATE work_shift SET shift = :shift WHERE id_user IN(".implode(",", $user_ids).") AND date = :date";

        $result = $db->prepare($sql);
        $result->bindParam(':date', $date, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function getUsersFromShift($shift, $date){
        // З'єднання з БД
        $db = Db::getConnection();

        $sql = 'SELECT * FROM work_shift WHERE date = :date AND shift = :shift';

        $result = $db->prepare($sql);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':shift', $shift, PDO::PARAM_STR);
        $result->execute();

        $users = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $users[$i]['id_user'] = $row['id_user'];
            $users[$i]['date'] = $row['date'];
            $users[$i]['shift'] = $row['shift'];
            $i++;
        }

        return $users;
    }

}