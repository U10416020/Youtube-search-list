<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Youtube search</title>
    </head>
    <body>       
        <form action = "searchList.php" method="get">
            <div>
                關鍵字:<input name="query" value='周杰倫 官方' type="text"/>
            </div>
            <br>
            <div>
            顯示數量/頁(<=50):<input name="number" value=5 type="text"/>     
            </div>
            <br>
            <input name="submit" type="submit" value="search">
        </form>        
    </body>
</html>



