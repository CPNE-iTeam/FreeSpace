fetch("../api/user.php").then(async r => {
    let response = await r.json()
    console.log(response);

    if (!response.logged) {
        document.location.href = "/login.html"
    }
});

function send() {
    let message = document.getElementById("message").value;
    let formData = new FormData();
    formData.append("message", message);

    fetch("../api/chat/send_global_message.php", {
        method: "POST",
        body: formData
    }).then(async r => {
        let response = await r.json()
        console.log(response);
        if (!response.success) {
            alert(response.error);
        } else {
            document.getElementById("message").value = "";
        }
        loadMessages();
    });
}

function loadMessages() {
    fetch("../api/chat/get_global_messages.php").then(async r => {
        let response = await r.json()
        console.log(response);
        let messages = response.messages;
        let html = "";
        for (let message of messages) {
            html += `<div><b>${message.sender}</b>: ${message.message}</div><br>`;
        }

        document.getElementById("messages").innerHTML = html;
    });
}

setInterval(loadMessages, 1000);