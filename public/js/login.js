let condition = true;
function showPassword()
{
    if(condition)
    {
        document.getElementById("motdepasse").setAttribute("type", "text");
        document.getElementById("icon-login").setAttribute("class", "position-absolute mdi mdi-eye");
        condition = false;
    }
    else
    {
        document.getElementById("motdepasse").setAttribute("type", "password");
        document.getElementById("icon-login").setAttribute("class", "position-absolute mdi mdi-eye-off");
        condition = true;
    }
}