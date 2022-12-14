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
        }
        echo "</tr>";
    }
    if (isset($_GET["Submit"])) {
        $arr = search($films, $_GET["Search"]);
        if ($_GET['sort'] === "producer") {
            usort($arr, "cmp_producer");
        }
        if ($_GET['sort'] === "year") {
            usort($arr, "cmp_year");
        }
        if ($_GET['sort'] === "name") {
            usort($arr, "cmp_name");
        }
        array_walk($arr, "output");
    }

    // if (isset($_GET['Submit2'])) {
        // if ($_GET['sort'] === "producer") {
        //     usort($arr, "cmp_producer");
        // }
        // if ($_GET['sort'] === "year") {
        //     usort($arr, "cmp_year");
        // }
        // if ($_GET['sort'] === "name") {
        //     usort($arr, "cmp_name");
        // }
    // }
    echo "</table>\n";

    function search($films, $data)
    {
        $result = array();
        foreach ($films as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                if (strstr($value1[$key2], $data)) {
                    $result[] = $key1;
                }
            }
        }
        if (count($result) == 0) {
            print "<p>По вашему запросу ничего не найдено(</p>";
        }
        // return array_unique($result);
        return array_intersect_key($films, array_flip(array_unique($result)));
    }
    if (isset($_GET['Clear'])) {
        ob_end_clean();
        header("Location:" . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
    <form id="form1" action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">
        <input type="text" name="Search" size="20" placeholder="Название фильма"><br>
        <input type="submit" name="Submit" size="50"><br>
        <input type="submit" name="Clear" size="50" value="Заново"><br>
    <!-- </form> -->
    <!-- <form id="form2" action="<?= $_SERVER['PHP_SELF'] ?>" method="GET"> -->
        <input type="radio" id="radio1" name="sort" value="producer" checked><label>Сортировка по ФИ автора</label><br>
        <input type="radio" id="radio2" name="sort" value="year"><label for="radio2">Сортировка по году выпуска</label><br>
        <input type="radio" id="radio3" name="sort" value="name"><label for="radio3">Сортировка по названию фильма</label><br>
        <!-- <input type="submit" name="Submit2" size="50" value="Сортировка"><br> -->
    </form>
</body>

</html>