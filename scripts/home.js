
fetch("api/user.php").then(async r => {
    let response = await r.json()
    console.log(response);

    if (response.logged) {
        document.getElementById("welcome").innerText = "Welcome, " + response.username + "!";
        let els = document.getElementsByClassName("not-logged")
        for (let i = 0; i < els.length; i++) {
            els[i].style.display = "none";
        }
        let els2 = document.getElementsByClassName("logged")
        for (let i = 0; i < els2.length; i++) {
            els2[i].style.display = "block";
        }
    } else {
        let els = document.getElementsByClassName("not-logged")
        for (let i = 0; i < els.length; i++) {
            els[i].style.display = "block";
        }
        let els2 = document.getElementsByClassName("logged")
        for (let i = 0; i < els2.length; i++) {
            els2[i].style.display = "none";
        }
    }
});

async function logout() {
    await fetch("api/logout.php");
    window.location.reload()
}