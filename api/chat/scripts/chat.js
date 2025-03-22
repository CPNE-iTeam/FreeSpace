fetch("../api/me_user.php").then(async r => {
    let response = await r.json()
    console.log(response);

    if (!response.logged) {
        document.location.href = "/login.html"
    }
});

var chat_user_id = null;

function send() {
    let message = document.getElementById("message").value;
    let formData = new FormData();
    formData.append("message", message);
    formData.append("to", chat_user_id);

    fetch("../api/chat/send_message.php", {
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
        loadChat(chat_user_id);
    });
}

function loadChat(user_id) {
    document.getElementById("chat").style.display = "block";
    chat_user_id = user_id;
    let formData = new FormData();
    formData.append("contact", user_id);
    fetch("../api/chat/conversation.php", {
        method: "POST",
        body: formData
    }).then(async r => {
        let response = await r.json()
        console.log(response);
        let messages = response.messages;
        let html = "";
        for (let message of messages) {
            html += `<div><b>${message.from_user.username}</b>: ${message.message}</div><br>`;
        }

        document.getElementById("messages").innerHTML = html;
    });
}



setInterval(() => {
    if (chat_user_id != null) {
        loadChat(chat_user_id);
    }
}, 1000);