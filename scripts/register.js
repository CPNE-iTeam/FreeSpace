
function register() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    let formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);
    fetch("api/register.php",
        {
            method: "POST",
            body: formData
        }
    ).then(async r => {
        let response = await r.json()
        console.log(response);

        if (response.success) {
            window.location.href = "index.html";
        } else {
            alert(response.error);
        }
    })
    return false;
}