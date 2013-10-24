<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i>API Interface</i></h1>

<?php
	// Are they logged in?
	if( Yii::app()->user->isGuest )
	{
		// Nope
?>
<p><a href="/user/login">Login</a> or <a href="/user/registration">Register</a> to have access to this amazing system.</p>
<?php
	}
	else
	{
		// Yep
?>
<p>OK <B><?php echo Yii::app()->user->name; ?></B>a, now you can do some <a href="/apitest">testing</a> or review your <a href="/user/profile">profile</a>.</p>
<?php
	}
?>
