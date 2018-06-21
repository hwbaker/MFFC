<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Warehouse</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
</head>

<body >

<br>
<table width="100%" border="1px">
    <tr>
        <td>仓库标识</td>
        <td>仓库</td>
    </tr>

    <?php

    foreach ($ware as $item) {
        echo "<tr>";
        echo "<td>{$item['warehouse_id']}</td>";
        echo "<td>{$item['name']}</td>";
        echo "</tr>";
    }
    ?>

</table>

</body>
</html>




