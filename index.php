<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>TEST!</title>
		<link rel="stylesheet" type="text/css" href="style.css" >
    </head>

    <body class="background">
        <form action="" method="post">
		
		<div class="img"> 
		<img src = "s1200.jpg" width = "600px" height = "400px" >
		</div>
		<div class="input">
			<input type="text" name="name"  placeholder="Имя"><br><br>
			<textarea type="text" name= "message" class="mescom" placeholder="Комментарий"></textarea>
			<input type="submit" name="button" class="inputcom" value="Добавить комментарий">
		</div>
-		</br>
		</form>
	
    </body>

</html>

<?php
require "libs/rb.php";//подключение к библиотеке
	R::setup('mysql:host=localhost;dbname=test','root','');
	
	$link=mysqli_connect('localhost', 'root', '', 'test');//подключение к библиотеке
	if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
	}
	/*else {
    print("Соединение установлено успешно");
	}*/
	
	$sql = "SELECT * FROM koments ORDER BY id DESC";//формирование запроса на выборку в обратном порядке
	$result = mysqli_query($link, $sql);
if (isset($_GET['del']))//обработка кнопки удаления	
{
	$id = $_GET['del'];
		$sql = "DELETE FROM koments WHERE id=$id";//удаление по id
		mysqli_query($link, $sql) or die(mysql_error($link));//
		$sql = "SELECT * FROM koments ORDER BY id DESC";
		$result = mysqli_query($link, $sql);//формирование таблиц
}
	
if (isset($_POST['button']))//обработка кнопки добавления комментария
	{
		$koments = R::dispense('koments');
		$koments->name=$_POST['name'];
		$koments->message=$_POST['message'];
		$koments->datas=date("Дата d.m.Y Время H:i:s");
	
		R::store($koments);//запись в таблицу

		$sql = "SELECT * FROM koments ORDER BY id DESC";
		$result = mysqli_query($link, $sql);
	}
?>
<table>
	<?php
		while ($row = mysqli_fetch_array($result)) 
		{
			$komenname = "Имя: " . $row['name'];
			$komenmassage = "Комментарий: " . $row['message'];
			$komenmasdata = "" . $row['datas'] . "<br>";
			$komenmasid = $row['id'];
			?>
				
        <tr>
			<div class="output">
				<input type = 'hidden' name = 'id' value = "<?php echo $komenmasid; ?>">
				<div class="name"> 
							<a id='outputname'> <?php echo $komenname; ?> </a> 
							<b id='outputdata'> <?php echo $komenmasdata; ?> </b>
				</div>
				</br>
				<div class="message">
					<a id='outputmassage'> <?php echo $komenmassage; ?></a>
					<a class="butdel" href="index.php?del=<?=$row['id'] ?>">X</a>	
				</div>
				</br>
			</div>
		</tr>
	<?php } ?>
</table>
	 

		
		