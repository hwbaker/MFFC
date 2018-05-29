<table width="100%" border="1px">
    <tr>
        <td>名称</td>
        <td>标识</td>
    </tr>
<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/5/29
 * Time: 14:40
 */

foreach ($company as $item) {
    echo "<tr>";
    echo "<td>{$item->system_name}</td>";
    echo "<td>{$item->short_name}</td>";
    echo "</tr>";
}
?>

</table>