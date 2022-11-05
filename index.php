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
    if (isset($_GET['Submit'])) {
        $seach_result1 = array_flip(search($films, $_GET['Search']));
        $seach_result2 = array_intersect_key($films, $seach_result1);
        if ($_GET['sort'] === "producer")
            usort($seach_result2, "cmp_producer");
        if ($_GET['sort'] === "year")
            usort($seach_result2, "cmp_year");
        if ($_GET['sort'] === "name")
            usort($seach_result2, "cmp_name");
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
        header("Location:" . $_SERVER['PHP_SELF']);
        ob_end_clean();
        exit;
    }
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET" style="display:block;margin:20px;text-align:center;">
        <input type="text" name="Search" size="20" placeholder="Название фильма" style="margin:5px;color:green;background-color:lightgreen;font-size:40px;"><br>
        <input type="submit" name="Submit" size="50" style="margin:5px;font-size:40px;background-color:lightgreen;cursor:pointer;"><br>
        <input type="submit" name="Clear" size="50" value="Заново" style="margin:5px;font-size:40px;background-color:lightgreen;cursor:pointer;"><br>
    </form>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET" style="">
        <div style="margin-left:40%"><input type="radio" id="radio1" name="sort" value="producer" checked><label>Сортировка по ФИ автора</label ><br>
        <input type="radio" id="radio2" name="sort" value="year"><label for="radio2">Сортировка по году выпуска</label><br>
        <input type="radio" id="radio3" name="sort" value="name"><label for="radio3">Сортировка по названию фильма</label></div><br>
    </form>
</body>

</html>