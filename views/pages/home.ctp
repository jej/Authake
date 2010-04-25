<h2>Welcome to Authake test page</h2>

<p><em><a href="http://conseil-recherche-innovation.net/authake">Authake help and contribution page</a></em></p><br/>

<?php

if ($authak3->isLogged()) {
    echo "<i>Logged as <strong>".$authak3->getLogin()."</strong> in group(s) <strong>".implode(', ', $authak3->getGroupNames())."</strong></i><br/><br/>";
    
    echo $html->link("Admin page", "/authake")."<br/>";
    echo $html->link("Profile", "/authake/user/")."<br/>";
    echo $html->link("Logout", "/authake/user/logout")."<br/>";
} else {
    echo $html->link("Login", "/authake/user/login")."<br/>";
    echo $html->link("Register", "/authake/user/register")."<br/>";
    echo $html->link("Confirm registration", "/authake/user/confirmregister")."<br/>";
}
        
?>

<h3>Demo users</h3>
<ul>
    <li>admin/admin : Administrator</li>
    <li>acluser/acluser : ACL manager (can see user/groups/rules, later will edit/delete)</li>
    <li>otheruser/otheruser : a test user in group 'Other test group'</li>
    <li>simpleuser/simpleuser : a test user with no groups (guest)</li>
</ul>
<?php        

echo "<h3>Some tests...</h3>";
echo $html->link("List rules", "/authake/rules/index")." (allowed to anybody)<br/>";
echo $html->link("List users", "/authake/users/index")." (allowed to ACL managers)<br/>";
echo $html->link("View user n°1", "/authake/users/view/1")." (idem)<br/>";
echo $html->link("Edit user n°1", "/authake/users/edit/1")." (Administrator only)<br/>";

?>