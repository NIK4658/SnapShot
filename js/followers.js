import { showUsers } from "./utils.js";

let url = new URL(window.location.href);
getUserFollowers(url.searchParams.get("username"));

function getUserFollowers(username) {
    $.post("./post_requests_handler.php", { getUserFollowers: true, username: username }, function (users) {
        const followersContainer = document.getElementById("people-page");
        showUsers(users, followersContainer);
    }, "json");
}
