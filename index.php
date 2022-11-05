<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <?php
    include "array_library.php";

    echo "<table>";
    echo "<tr><th>Режиссёр</th><th>Фильмы</th><th>Год выпуска</th></tr>";
    function cmp_producer($a, $b)
    {
        return ($a['producer'] <=> $b['producer']);
    }
    function cmp_name($a, $b)
    {
        return ($a['name'] <=> $b['name']);
    }
    function cmp_year($a, $b)
    {
        return ($a['year'] <=> $b['year']);
    }
    function output($value1, $key1)
    {
        echo "<tr>";
        foreach ($value1 as $key1 => $value2) {
            echo "<td>$value2</td>";
            if (isset($_GET['Radio2'])) {
                usort($value1, "cmp_year");
            }
            if (isset($_GET['Radio3'])) {
                usort($value1, "cmp_name");
            }
        }
        echo "</tr>";
    }
    if (isset($_GET['Submit'])) {
        $seach_result1 = array_flip(search($films, $_GET['Search']));
        $seach_result2 = array_intersect_key($films, $seach_result1);
        if (isset($_GET['Radio1'])) {
            usort($seach_result2, "cmp_producer");
        }
        array_walk($seach_result2, "output");
    }
    echo "</table>\n";

    function search($films, $data)
    {
        $result = array();
        foreach ($films as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                if (strstr($value1['name'], $data)) {
                    $result[] = $key1;
                }
            }
        }
        if (count($result) == 0) {
            print "По вашему запросу ничего не найдено(";
        }
        return array_unique($result);
    }
    if (isset($_GET['Clear'])) {
        // unset($$_GET);
        ob_end_clean();
        header("Location:" . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">
        <input type="text" name="Search" size="20"><br>
        <input type="submit" name="Submit" size="50"><br>
        <input type="submit" name="Clear" size="50" value="Заново"><br>
        <input type="radio" id="radio1" name="Radio1"><label for="radio1">Сортировка по ФИ автора</label><br>
        <input type="radio" id="radio2" name="Radio1"><label for="radio2">Сортировка по году выпуска</label><br>
        <input type="radio" id="radio3" name="Radio1"><label for="radio3">Сортировка по названию фильма</label><br>
    </form>
</body>

</html>