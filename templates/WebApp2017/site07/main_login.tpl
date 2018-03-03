{$message}
<BR>
<BR>
{$title}

<FORM name="nameform" method="post" action="main.php">
<BR>

メールアドレス
<BR>
<INPUT type="text" name="username" value="">
<BR>
<BR>

パスワード
<BR>
<INPUT type="text" name="password" value="">
<BR>
<BR>

<INPUT type="hidden" name="type" value="authenticate">
<INPUT type="submit" value="ログイン">
</FORM>


<BR>
<BR>
<BR>

<FORM name="registration" method="post" action="main.php">
<BR>

<INPUT type="hidden" name="type" value="registration">
<INPUT type="submit" value="新規登録">
</FORM>