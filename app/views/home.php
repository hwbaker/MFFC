<table width="100%" border="1px">
    <tr>
        <td>仓库标识</td>
        <td>仓库</td>
    </tr>
<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/5/29
 * Time: 14:40
 */

foreach ($ware as $item) {
    echo "<tr>";
    echo "<td>{$item['warehouse_id']}</td>";
    echo "<td>{$item['name']}</td>";
    echo "</tr>";
}
?>

</table>