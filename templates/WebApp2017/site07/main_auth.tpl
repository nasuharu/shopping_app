{$title}

<br>
<br>

{$message}

[ <A href="{$SCRIPT_NAME}?type=logout">ログアウト</A> ]

<br>
<form name="shopping" method="post" action="main.php">
<BR>
<INPUT type="hidden" name="type" value="shopping">
<INPUT type="submit" value="商品選択">
<br>
</form>


<br>
<form name="cart" method="post" action="main.php">
<br>
<input type="hidden" name="type" value="cart">
<input type="submit" value="カートへ">
<br>
</form>




<br>
<br>
<form name="delete_member" method="post" action="main.php">
<br>
<INPUT type="hidden" name="type" value="delete_member">
<INPUT type="submit" value="退会">
<br>
</form>


<form name="change_password" method="post" action="main.php">
<br>
<INPUT type="hidden" name="type" value="change_password">
<INPUT type="submit" value="パスワード変更">
<br>
</form>
