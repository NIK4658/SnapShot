import { showUsers } from "./utils.js";

let url = new URL(window.location.href);
getUserFollowing(url.searchParams.get("username"));

function getUserFollowing(username) {
    $.post("./post_requests_handler.php", { getUserFollowing: true, username: username }, function (users) {
        const followingContainer = document.getElementById("people-page");
        showUsers(users, followingContainer);
    }, "json");
}