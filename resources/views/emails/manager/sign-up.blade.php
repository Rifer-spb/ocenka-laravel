<div>Здравствуйте!</div>
<br/>
<div>Вы были успешно зарегистрированы на сайте {{ $appName }}</div>
<br/>
<div>Ваши данные для входа:</div>
<br/>
<div>Логин: {{ $username }}</div>
<div>Пароль: {{ $password }}</div>
<br/>
<div>Для подтверждения e-mail адреса перейдите по ссылке:</div>
<div><a href="{{ $verifyLink }}">{{ $verifyLink }}</a></div>
