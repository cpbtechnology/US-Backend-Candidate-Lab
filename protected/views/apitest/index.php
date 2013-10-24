<?php
?>

<P><a href="/apitest/list">List</a></P>
<HR>
<P>
Create:
<form action="/apitest/create" method=POST>
    Title: <Input type=text name="title">
    Note: <Input type=text name="description">
<input type="submit" value="Create">
</form>
</P>
<HR>
<P>
Read:
<form action="/apitest/read" method=POST>
    Note Id: <Input type=text name="id">
<input type="submit" value="Read">
</form>
</P>
<HR>
<P>
Update:
<form action="/apitest/update" method=POST>
    Note Id: <Input type=text name="id">
    Title: <Input type=text name="title">
    Note: <Input type=text name="description">
<input type="submit" value="Update">
</form>
</P>
<HR>
<P>
Delete:
<form action="/apitest/delete" method=POST>
    Note Id: <Input type=text name="id">
<input type="submit" value="Delete">
</form>
</P>

