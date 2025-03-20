fetch("../api/user.php").then(async r => {
    let response = await r.json()
    console.log(response);

    if (!response.logged) {
        document.location.href = "/login.html"
    }
});