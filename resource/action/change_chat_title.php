<?php
	/*!
	  \file
	  \brief Скрипт изменения названия чата его хостом
	*/
	
	// Подключение ядра
	include($_SERVER["DOCUMENT_ROOT"]."/core.php");
	
	// Получение текущего пользователя
	$user_data = userData();
	$user = $user_data["id"];
	if(!$user) exit("Ошибка авторизации!");
	
	// Проверка остальных параметров
	$id = treat(intval($_POST["id"]));
	if(!$id) exit("Некорректно указан чат!");
	$name = treat(strval($_POST["name"]));
	
	// Проверка на соответствие пользователя его правам в чате
	$checksel = DB::query("SELECT id_chat FROM chat WHERE id_chat=%d AND id_user=%d", [$id, $user]);
	$check = mysqli_fetch_array($checksel);
	if(!$check["id_chat"]) exit("Ошибка запроса!");
	
	DB::update("chat", ["%s:Name" => $name], ["id_chat=%d AND id_user=%d", [$id, $user]]);