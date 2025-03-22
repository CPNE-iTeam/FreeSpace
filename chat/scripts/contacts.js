
function loadContacts() {
    fetch("../api/chat/contacts.php").then(async r => {
        let response = await r.json()
        console.log(response);
        let contacts = response.contacts;
        let html = "";
        for (let contact of contacts) {
            html += `<li><a href='#' onclick='loadChat(${contact.id})'>@${contact.username}</a></li>`;
        }

        document.getElementById("contacts").innerHTML = html;
    });

}


function newChat() {
    let username = document.getElementById("newChat").value;
    let formData = new FormData();
    formData.append("username", username);

    fetch("../api/user.php", {
        method: "POST",
        body: formData
    }).then(async r => {
        let response = await r.json()
        console.log(response);
        if (!response.success) {
            alert(response.error);
        } else {
            loadChat(response.user.id);

        }
    });
}

loadContacts();