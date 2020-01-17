<?php

/*
  Plugin Name: Custom Registration
  Plugin URI: http://code.tutsplus.com
  Description: Updates user rating based on number of posts.
  Version: 1.0
  Author: Agbonghama Collins
  Author URI: http://tech4sky.com
 */

/*данный блок отвечает за внесение параметров в базу данных и переназначение переменных wordpress*/

function custom_registration_function() {
    if (isset($_POST['submit'])) {
        registration_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['website'],
        $_POST['fname'],
        $_POST['lname'],
        $_POST['nickname'],
        $_POST['bio'],
        $_POST['organization'],
        $_POST['organizationtype'],
        $_POST['city']
		);
		
		// sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio, $organization;
        $username	= 	sanitize_user($_POST['username']);
        $password 	= 	esc_attr($_POST['password']);
        $email 		= 	sanitize_email($_POST['email']);
        $website 	= 	esc_url($_POST['website']);
        $first_name = 	sanitize_text_field($_POST['fname']);
        $last_name 	= 	sanitize_text_field($_POST['lname']);
        $nickname 	= 	sanitize_text_field($_POST['nickname']);
        $bio 		= 	esc_textarea($_POST['bio']);
        $organization = esc_attr($_POST['organization']);
        $organizationtype =  esc_attr($_POST['organizationtype']);
        $city = esc_attr($_POST['city']);

		// call @function complete_registration to create the user
		// only when no WP_error is found
        complete_registration(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $bio,
        $organization,
        $organizationtype,
        $city
		);
    }

    registration_form(
    	$username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $bio,
        $organization,
        $organizationtype,
        $city
		);
}

/*в этом блоке формирется форма для вывода во frontend*/

function registration_form( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio, $organization, $organizationtype, $city  ) {
    echo '
    <style>
	div {
		margin-bottom:2px;
	}
	
	input{
		margin-bottom:4px;
	}
	</style>
	';

    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
	
	<label for="organizationtype">Выберите тип организации</label>
    <select name="organizationtype" id="organizationtype" value="' . (isset($_POST['organizationtype']) ? $organizationtype : null) . '">
        <option value="">ООО</option>
        <option value="1">ПАО</option>
        <option value="2">АО</option>
        <option value="3">УП</option>
        <option value="4">ТОО</option>
        <option value="5">Нек. орг.</option>
        <option value="6">Общ. орг.</option>
        <option value="7">Фонд</option>
        <option value="8">Гос. корп.</option>
        <option value="9">ИП</option>
        <option value="10">ОАО</option>
        <option value="11">ЗАО</option>
        <option value="12">Другое</option>
    </select>

	<div>
	<label for="organization">Название организации <strong>*</strong></label>
	<input type="text" name="organization" value="' . (isset($_POST['organization']) ? $organization : null) . '">
	</div>

	<div>
	<label for="city">Город / населенный пункт <strong>*</strong></label>
	<select name="city" id="city" value="' . (isset($_POST['city']) ? $city : null) . '">
	<option value="">Алнаши</option>
	<option value="1">Балезино</option>
	<option value="2">Большой Зетым</option>
	<option value="3">Вавож</option>
	<option value="4">Воткинск</option>
	<option value="5">Глазов</option>
	<option value="6">Грахово</option>
	<option value="7">Дебесы</option>
	<option value="8">Ершовка</option>
	<option value="9">Завьялово</option>
	<option value="10">Засеково</option>
	<option value="11">Игра</option>
	<option value="12">Ижевск</option>
	<option value="13">Камбарка</option>
	<option value="14">Каракулино</option>
	<option value="15">Кез</option>
	<option value="16">Кизнер</option>
	<option value="17">Кильмезь</option>
	<option value="18">Киясово</option>
	<option value="19">Красногорское</option>
	<option value="20">Малая Пурга</option>
	<option value="21">Можга</option>
	<option value="22">Пирогово</option>
	<option value="23">Сарапул</option>
	<option value="24">Селты</option>
	<option value="25">Сигаево</option>
	<option value="26">Сюмси</option>
	<option value="27">Ува</option>
	<option value="28">Хохряки</option>
	<option value="29">Шаркан</option>
	<option value="30">Юкаменское</option>
	<option value="31">Якшур-Бодья</option>
	<option value="32">Яр</option>
	</select>

	<div>
	<label for="firstname">Имя</label>
	<input type="text" name="fname" value="' . (isset($_POST['fname']) ? $first_name : null) . '">
	</div>

	<div>
	<label for="website">Фамилия</label>
	<input type="text" name="lname" value="' . (isset($_POST['lname']) ? $last_name : null) . '">
	</div>

	<div>
	<label for="email">Электронная почта <strong>*</strong></label>
	<input type="text" name="email" value="' . (isset($_POST['email']) ? $email : null) . '">
	</div>

	<div>
	<label for="username">Телефон (логин) <strong>*</strong></label>
	<input type="text" name="username" value="' . (isset($_POST['username']) ? $username : null) . '">
	</div>
	
	<div>
	<label for="password">Придумайте пароль <strong>*</strong></label>
	<input type="password" name="password" value="' . (isset($_POST['password']) ? $password : null) . '">
	</div>
	
	<div>
	<label for="website">Адрес сайта (если есть)</label>
	<input type="text" name="website" value="' . (isset($_POST['website']) ? $website : null) . '">
	</div>

	<input type="submit" name="submit" value="Register"/>
	</form>
	';
}

/*здесь прописываются дополнительные функции типа проверки на правильность заполнения, количество символов и прочее*/

function registration_validation( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio, $organization, $organizationtype, $city )  {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
        $reg_errors->add('field', 'Важные поля не были заполнены');
    }

    if ( strlen( $username ) < 4 ) {
        $reg_errors->add('username_length', 'Номер телефона слишком короткий');
    }

    if ( username_exists( $username ) )
        $reg_errors->add('user_name', 'Извините, такой номер телефона уже существует');

    if ( !validate_username( $username ) ) {
        $reg_errors->add('username_invalid', 'Вы не ввели номер телефона');
    }

    if ( strlen( $password ) < 5 ) {
        $reg_errors->add('password', 'Пароль должен содержать не менее 5 символов');
    }

    if ( !is_email( $email ) ) {
        $reg_errors->add('email_invalid', 'Не введен адрес электронной почты');
    }

    if ( email_exists( $email ) ) {
        $reg_errors->add('email', 'такой адрес электронной почты уже существует');
    }
    
    if ( !empty( $website ) ) {
        if ( !filter_var($website, FILTER_VALIDATE_URL) ) {
            $reg_errors->add('website', 'Website is not a valid URL');
        }
    }

	/*это вывод ошибок при вводе, после проверки*/
    if ( is_wp_error( $reg_errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div>';
            echo '<strong>ОШИБКА!</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }
}

/*Это вывод переменных в саму систему управления сайтом*/

function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio, $organization, $organizationtype, $city;
    if ( count($reg_errors->get_error_messages()) < 1 ) {
        $userdata = array(
        'user_login'	=> 	$username,
        'user_email' 	=> 	$email,
        'user_pass' 	=> 	$password,
        'user_url' 		=> 	$website,
        'first_name' 	=> 	$first_name,
        'last_name' 	=> 	$last_name,
        'nickname' 		=> 	$nickname,
        'description' 	=> 	$bio,
        'organization'  =>  $organization,
        'organizationtype' => $organizationtype,
        'city' => $city,
		);
        $user = wp_insert_user( $userdata );
        /*эта строка может перенаправить клиента в личный кабинет, и сообщить что он успешно зарегистрировалсяна сайте*/
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
          header('Location:http://newcoder.ru/cat/web/');
          exit;
	}
}


/*это шоркод для вставки кода на нужную страницу*/

// Register a new shortcode: [cr_custom_registration]
add_shortcode('cr_custom_registration', 'custom_registration_shortcode');

// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}
