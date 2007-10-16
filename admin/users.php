<?php include('header.php');?>
<div class="container">
<hr>
<div class="column span-24 first" id="welcome">
<?php
$currentuser = User::identify();
if ( ! $currentuser )
{
	die;
}
if ( isset( $result ) ) {
	switch( $result ) {
		case 'success':
			echo '<p class="update">' . $username;
			_e(' has been created!');
			echo '</p>';
			break;
	}
}
?>
<h1>User Management</h1>
<p>Add, edit and remove users from your site from this interface.</p>
<h3><strong>Users</strong></h3>
<ul>
<?php
foreach ( User::get_all() as $user )
{
	if ( $user->username == $currentuser->username )
	{
		$url = Url::get( 'admin', 'page=user' );
	}
	else
	{
		$url = Url::get( 'userprofile', array( 'page' => 'user', 'user' => $user->username ) );
	}
	echo '<li>';
	echo '<a href="' . $url . '">' . $user->username . '</a> <em>(Last login: ' . $user->info->authenticate_time . ')</em><br>';
	echo Posts::count_by_author( $user->id, Post::status('published') ) . ' published posts, ' . Posts::count_by_author( $user->id, Post::status('draft') ) . ' pending drafts, and ' . Posts::count_by_author( $user->id, Post::status('private') ) . ' private posts.';
	echo '</li>';
}
?>
</ul>

<?php
if ( isset( $settings['error'] ) && ( '' != $settings['error'] ) )
{
	echo "<p><strong>" . $settings['error'] . "</strong></p>";
}
?>
<form method="post" action="">
<h3><strong>Add a new user</strong></h3>
<p>Username: <input type="text" size="40" name="username" value="<?php echo ( isset( $settings['username'] ) ) ? $settings['username'] : ''; ?>"></p>
<p>Email: <input type="text" size="40" name="email" value="<?php echo ( isset( $settings['email'] ) ) ? $settings['email'] : ''; ?>"></p>
<p>Password (twice to confirm):</p>
<p><input type="password" size="40" name="pass1"></p>
<p><input type="password" size="40" name="pass2"></p>
<p><input type="hidden" name="action" value="newuser"></p>
<p><input type="submit" value="Add User"></p>
</form>
</div>
</div>
<?php include('footer.php');?>
